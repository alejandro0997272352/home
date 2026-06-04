<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Models\TutorProfile;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = Review::with(['appointment.tutor', 'appointment.student', 'appointment.subject', 'user']);

        if ($request->get('filtro') === 'pendientes') {
            $query->where('aprobado', false);
        } elseif ($request->get('filtro') === 'aprobadas') {
            $query->where('aprobado', true);
        }

        $reviews = $query->latest()->paginate(20);

        return view('admin.reviews.index', compact('reviews'));
    }

    public function approve(Review $review)
    {
        $review->update([
            'aprobado' => true,
            'moderated_at' => now(),
            'moderated_by' => auth()->id(),
        ]);

        $profile = TutorProfile::firstOrCreate(
            ['user_id' => $review->appointment->tutor_id],
            ['user_id' => $review->appointment->tutor_id]
        );
        $profile->syncStats();

        return back()->with('success', 'Review aprobada correctamente.');
    }

    public function destroy(Review $review)
    {
        $tutorId = $review->appointment->tutor_id;
        $review->delete();

        $profile = TutorProfile::where('user_id', $tutorId)->first();
        if ($profile) {
            $profile->syncStats();
        }

        return back()->with('success', 'Review eliminada correctamente.');
    }
}
