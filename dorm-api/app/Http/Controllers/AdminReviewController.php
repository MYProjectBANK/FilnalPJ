<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;

class AdminReviewController extends Controller
{
    // GET /api/admin/reviews/pending
    public function pending()
    {
        $reviews = Review::where('status', 'pending')
            ->with('user', 'dorm')
            ->get();

        return response()->json($reviews);
    }

    // PUT /api/admin/reviews/{id}/approve
    public function approve($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->status = 'approved';
        $review->save();

        return response()->json(['message' => 'Review approved', 'review' => $review]);
    }

    // PUT /api/admin/reviews/{id}/reject
    public function reject($id)
    {
        $review = Review::find($id);
        if (!$review) {
            return response()->json(['message' => 'Review not found'], 404);
        }

        $review->status = 'rejected';
        $review->save();

        return response()->json(['message' => 'Review rejected', 'review' => $review]);
    }
}
