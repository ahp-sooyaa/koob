<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function index(Book $book)
    {
        $reviews = Review::query()
            ->where('book_id', $book->id)
            ->when(Auth::user() && !Auth::user()->is_admin, function($query) {
                $query->where(function($query) {
                    $query->where('approved_at', '!=', null)
                        ->orWhere('user_id', Auth::id());
                });
            })
            ->when(!Auth::user(), function($query) {
                $query->where('approved_at', '!=', null);
            })
            ->with('user')
            ->latest()
            ->get();

        $ratings = Review::query()
            ->select('book_id', 'approved_at', 'rating')
            ->where([
                ['approved_at', '!=', null],
                ['book_id', $book->id],
            ])
            ->get()
            ->groupBy('rating')
            ->map(function($item, $key) {
                return $item->count();
            });

        return response()->json([
            'reviews' => $reviews,
            'ratings' => $ratings,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required',
            'review' => 'required',
            'rating' => 'required',
        ]);

        $review = Auth::user()->reviews()->create($validated);

        return response()->json([
            // 'review' => $review,
            'message' => 'Successfully submitted your review & rating.'
        ]);
    }

    public function update(Request $request, Review $review)
    {
        $validated = $request->validate([
            'book_id' => 'required',
            'review' => 'required',
            'rating' => 'required',
        ]);

        $review->update($validated);

        return response()->json([
            'message' => 'Successfully updated your review & rating.'
        ]);
    }

    public function destroy(Review $review)
    {
        $review->delete();

        return response()->json([
            'message' => 'Successfully deleted your review & rating.'
        ]);
    }

    public function approve(Review $review)
    {
        $review->update(['approved_at' => now()]);

        return response()->json([
            'message' => 'Successfully approved review.'
        ]);
    }
}
