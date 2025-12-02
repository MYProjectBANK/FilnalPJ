<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Dorm;

class ReviewController extends Controller
{
    // POST /api/reviews
    public function store(Request $request)
    {
        $user = $request->user();

        $request->validate([
            'dorm_id' => 'required|exists:dorms,id',
            'comment' => 'required|string',
        ]);

        $review = Review::create([
            'user_id' => $user->id,
            'dorm_id' => $request->dorm_id,
            'comment' => $request->comment,
        ]);

        return response()->json([
            'message' => 'Review added',
            'review' => $review
        ]);
    }

    // PUT /api/reviews/{id}
    public function update(Request $request, $id)
    {
        $user = $request->user();
        $review = Review::where('id', $id)->where('user_id', $user->id)->first();

        if (!$review) {
            return response()->json(['message' => 'Review not found or unauthorized'], 404);
        }

        $request->validate([
            'rating' => 'sometimes|integer|min:1|max:5',
            'comment' => 'sometimes|string',
        ]);

        $review->update($request->only(['rating', 'comment']));

        return response()->json([
            'message' => 'Review updated',
            'review' => $review
        ]);
    }

    // DELETE /api/reviews/{id}
    public function destroy(Request $request, $id)
    {
        $user = $request->user();
        $review = Review::where('id', $id)->where('user_id', $user->id)->first();

        if (!$review) {
            return response()->json(['message' => 'Review not found or unauthorized'], 404);
        }

        $review->delete();

        return response()->json(['message' => 'Review deleted']);
    }

    // GET /api/reviews/{dorm_id}
    public function list($dorm_id)
    {
        $reviews = Review::where('dorm_id', $dorm_id)
            ->with('user:id,fullname') // ดึงชื่อผู้รีวิว
            ->get();

        return response()->json($reviews);
    }
}
