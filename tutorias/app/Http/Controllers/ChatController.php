<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $conversations = Conversation::with(['lastMessage.sender', 'student', 'tutor'])
            ->forUser($user->id)
            ->orderByDesc('last_message_at')
            ->get()
            ->map(function ($c) use ($user) {
                $c->other = $c->otherUser($user->id);
                $c->unread = $c->unreadCount($user->id);
                return $c;
            });

        return view('chat.index', compact('conversations'));
    }

    public function show(Conversation $conversation)
    {
        $user = auth()->user();
        abort_if($conversation->student_id !== $user->id && $conversation->tutor_id !== $user->id, 403);

        $conversation->load(['student', 'tutor']);

        $messages = $conversation->messages()->with('sender')->oldest()->get();

        $conversation->messages()->where('sender_id', '!=', $user->id)->where('read', false)->update(['read' => true]);

        return view('chat.show', compact('conversation', 'messages'));
    }

    public function storeMessage(Request $request, Conversation $conversation)
    {
        $user = auth()->user();
        abort_if($conversation->student_id !== $user->id && $conversation->tutor_id !== $user->id, 403);

        $request->validate(['message' => 'required|string|max:2000']);

        $msg = $conversation->messages()->create([
            'sender_id' => $user->id,
            'message' => $request->message,
        ]);

        $conversation->update(['last_message_at' => now()]);

        $receiverId = $conversation->student_id === $user->id
            ? $conversation->tutor_id
            : $conversation->student_id;

        Notification::create([
            'user_id' => $receiverId,
            'type' => 'chat',
            'title' => 'Nuevo mensaje',
            'message' => "{$user->name} te ha enviado un mensaje.",
            'related_id' => $conversation->id,
            'related_type' => Conversation::class,
        ]);

        if ($request->wantsJson()) {
            return response()->json([
                'id' => $msg->id,
                'message' => $msg->message,
                'sender_id' => $msg->sender_id,
                'created_at' => $msg->created_at->format('H:i'),
            ]);
        }

        return back();
    }

    public function start(User $user)
    {
        $auth = auth()->user();
        abort_if(!in_array($user->role, ['tutor', 'estudiante']), 404);

        $studentId = $auth->role === 'estudiante' ? $auth->id : $user->id;
        $tutorId = $auth->role === 'tutor' ? $auth->id : $user->id;

        $conversation = Conversation::firstOrCreate(
            ['student_id' => $studentId, 'tutor_id' => $tutorId],
            ['last_message_at' => now()]
        );

        return redirect()->route('chat.show', $conversation);
    }

    public function unreadCount()
    {
        $user = auth()->user();
        $count = Conversation::forUser($user->id)->get()->sum(fn($c) => $c->unreadCount($user->id));

        return response()->json(['count' => $count]);
    }

    public function poll(Conversation $conversation, Request $request)
    {
        $user = auth()->user();
        abort_if($conversation->student_id !== $user->id && $conversation->tutor_id !== $user->id, 403);

        $afterId = $request->get('after', 0);

        $messages = $conversation->messages()
            ->with('sender')
            ->where('id', '>', $afterId)
            ->oldest()
            ->get();

        $conversation->messages()
            ->where('sender_id', '!=', $user->id)
            ->where('read', false)
            ->update(['read' => true]);

        return response()->json($messages->map(fn($m) => [
            'id' => $m->id,
            'message' => $m->message,
            'sender_id' => $m->sender_id,
            'sender_name' => $m->sender->name,
            'created_at' => $m->created_at->format('H:i'),
        ]));
    }
}
