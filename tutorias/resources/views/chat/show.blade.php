@extends('layouts.app')

@section('title', 'Chat con ' . $conversation->otherUser(auth()->id())->name)

@push('styles')
<style>
.chat-container { display: flex; flex-direction: column; height: calc(100vh - 160px); }
.chat-messages { flex: 1; overflow-y: auto; padding: 16px; }
.msg { max-width: 75%; margin-bottom: 12px; padding: 10px 14px; border-radius: 16px; word-wrap: break-word; animation: slideUp 0.2s ease-out; }
.msg-own { background: linear-gradient(135deg, #4f46e5, #6366f1); color: white; margin-left: auto; border-bottom-right-radius: 4px; }
.msg-other { background: #f1f5f9; color: #1e293b; margin-right: auto; border-bottom-left-radius: 4px; }
.dark .msg-other { background: #1e293b; color: #e2e8f0; }
.msg-time { font-size: 10px; opacity: 0.7; margin-top: 4px; }
.chat-input { border-top: 1px solid #e5e7eb; padding: 12px 16px; }
.dark .chat-input { border-top-color: #374151; }
</style>
@endpush

@section('content')
<div class="mb-4">
    <a href="{{ route('chat.index') }}" class="text-sm text-gray-500 dark:text-gray-400 hover:text-indigo-600 dark:hover:text-indigo-400 transition-colors">
        <i class="fas fa-arrow-left mr-1"></i> Volver a mensajes
    </a>
</div>

<div class="card-hover glass-card rounded-xl shadow-md overflow-hidden chat-container">
    <div class="p-4 border-b border-gray-100 dark:border-gray-700 bg-white/50 dark:bg-gray-800/50 flex items-center gap-3 flex-shrink-0">
        @php $other = $conversation->otherUser(auth()->id()); @endphp
        @if($other->foto_perfil)
            <img src="{{ $other->foto_url }}" class="w-10 h-10 rounded-full object-cover">
        @else
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 dark:from-indigo-900/50 dark:to-purple-900/50 flex items-center justify-center">
                <i class="fas fa-user text-indigo-500"></i>
            </div>
        @endif
        <div>
            <h2 class="font-semibold text-gray-900 dark:text-gray-100">{{ $other->name }}</h2>
            <p class="text-xs text-gray-500 dark:text-gray-400">{{ ucfirst($other->role) }}</p>
        </div>
    </div>

    <div class="chat-messages" id="chatMessages">
        @foreach($messages as $msg)
            <div class="msg {{ $msg->sender_id === auth()->id() ? 'msg-own' : 'msg-other' }}" data-id="{{ $msg->id }}">
                <p class="text-sm">{{ $msg->message }}</p>
                <p class="msg-time">{{ $msg->created_at->format('H:i') }}</p>
            </div>
        @endforeach
    </div>

    <div class="chat-input flex-shrink-0">
        <form id="chatForm" class="flex gap-3">
            @csrf
            <input type="text" name="message" id="messageInput" placeholder="Escribe un mensaje..." required autocomplete="off"
                class="flex-1 px-4 py-2.5 border border-gray-300 dark:border-gray-600 rounded-xl focus:ring-2 focus:ring-indigo-500 transition-all bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100">
            <button type="submit" class="btn-ripple px-4 py-2.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white rounded-xl hover:from-indigo-700 hover:to-purple-700 transition-all shadow-md">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
const conversationId = {{ $conversation->id }};
const userId = {{ auth()->id() }};
let lastMessageId = {{ $messages->last()->id ?? 0 }};
const chatMessages = document.getElementById('chatMessages');

function scrollToBottom() {
    chatMessages.scrollTop = chatMessages.scrollHeight;
}

document.getElementById('chatForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const input = document.getElementById('messageInput');
    const msg = input.value.trim();
    if (!msg) return;
    input.disabled = true;

    fetch('{{ route('chat.store', $conversation) }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Accept': 'application/json',
        },
        body: JSON.stringify({ message: msg }),
    })
    .then(r => r.json())
    .then(data => {
        const div = document.createElement('div');
        div.className = 'msg msg-own';
        div.dataset.id = data.id;
        div.innerHTML = `<p class="text-sm">${escapeHtml(data.message)}</p><p class="msg-time">${data.created_at}</p>`;
        chatMessages.appendChild(div);
        lastMessageId = data.id;
        scrollToBottom();
        input.value = '';
        input.disabled = false;
        input.focus();
    })
    .catch(() => { input.disabled = false; });
});

function pollMessages() {
    fetch('{{ route('chat.poll', $conversation) }}?after=' + lastMessageId, {
        headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
    })
    .then(r => r.json())
    .then(data => {
        data.forEach(msg => {
            if (msg.sender_id !== userId) {
                const div = document.createElement('div');
                div.className = 'msg msg-other';
                div.dataset.id = msg.id;
                div.innerHTML = `<p class="text-sm">${escapeHtml(msg.message)}</p><p class="msg-time">${msg.created_at}</p>`;
                chatMessages.appendChild(div);
                if (msg.id > lastMessageId) lastMessageId = msg.id;
            }
        });
        if (data.length) scrollToBottom();
    });
}

function escapeHtml(text) {
    const d = document.createElement('div');
    d.textContent = text;
    return d.innerHTML;
}

scrollToBottom();
setInterval(pollMessages, 3000);
</script>
@endpush
