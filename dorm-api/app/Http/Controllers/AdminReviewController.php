<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;

class AdminReviewController extends Controller
{
    // GET /api/admin/reviews/pending
public function pending()
{
$reviews = Review::where('status', 'pending')
    ->with([
        'user:id,fullname',
        'dorm:id,name',
    ])
    ->get();


    return response()->json($reviews);
}


    // PUT /api/admin/reviews/{id}/approve
    public function approve($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['status' => false, 'message' => 'Review not found'], 404);
        }

        if ($review->status !== 'pending') {
            return response()->json(['status' => false, 'message' => 'Review already processed'], 400);
        }

        $review->update([
            'status' => 'approved',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Review approved',
            'review' => $review
        ]);
    }

    // PUT /api/admin/reviews/{id}/reject
    public function reject($id)
    {
        $review = Review::find($id);

        if (!$review) {
            return response()->json(['status' => false, 'message' => 'Review not found'], 404);
        }

        if ($review->status !== 'pending') {
            return response()->json(['status' => false, 'message' => 'Review already processed'], 400);
        }

        $review->update([
            'status' => 'rejected',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Review rejected',
            'review' => $review
        ]);
    }
}
