<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        Review::create([
            'user_id' => Auth::id(),
            'book_id' => $request->bookId,
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return response()->json([
            'message' => 'success'
        ]);
    }
}
