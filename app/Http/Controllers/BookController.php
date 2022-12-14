<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\Review;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        return Inertia::render('Books/Index', [
            'books' => Book::query()
                ->filter(Request::only(['search', 'category']))
                ->sort(Request::query('sort', 'created_at,asc'))
                ->paginate(5)
                ->withQueryString()
                ->through(fn($book) => [
                    'id' => $book->id,
                    'slug' => $book->slug,
                    'title' => $book->title,
                    'price' => $book->price,
                    'cover_url' => $book->cover_url,
                    'stock_count' => $book->stock_count,
                ]),
            'booksCount' => Book::count(),
            'categories' => Category::select(['slug', 'name'])->get(),
            'sorting' => Request::query('sort', 'created_at,asc'),
            'filters' => Request::only(['search', 'category']),
        ]);
    }

    public function show(Book $book)
    {
        $previousPurchasedOrder = Order::where('user_id', auth()->id())
            ->whereHas('books', function ($query) use ($book) {
                $query->where('books.id', $book->id);
            })->latest()->first();

        $reviews = Review::query()
            ->where([
                ['approved_at', '!=', null],
                ['book_id', $book->id],
            ])
            ->when(Auth::user(), function($query) {
                $query->orWhere('user_id', Auth::id());
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
        
        return Inertia::render('Books/Show', compact(
            'book',
            'previousPurchasedOrder',
            'reviews',
            'ratings',
        ));
    }
}
