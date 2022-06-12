<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        return Inertia::render('Books/Index', [
            'books' => Book::query()
                ->when(request('search'), function ($query, $search) {
                    $query->where('title', 'like', "%{$search}%");
                })
                ->when(request('filter'), function ($query, $filter) {
                    // equal filter is only available now
                    foreach ($filter as $column => $value) {
                        if ($value != null) {
                            $query->where($column, $value);
                        }
                    }
                })
                ->when(request('sort'), function ($query, $sort) {
                    foreach ($sort as $column => $direction) {
                        if ($direction != null) {
                            $query->orderBy($column, $direction);
                        }
                    }
                })
                ->paginate(5)
                ->withQueryString()
                ->through(fn ($book) => [
                    'id' => $book->id,
                    'title' => $book->title,
                    'price' => $book->price,
                    'cover' => $book->cover,
                    'stock_count' => $book->stock_count,
                    'available_stock_count' => $book->available_stock_count
                ]),
            'categories' => Category::all(),
            'sorting' => request('sort'),
            'filters' => request('filter'),
            'search' => request('search')
        ]);
    }

    public function show(Book $book)
    {
        $previousPurchasedOrder = Order::where('user_id', auth()->id())
            ->whereHas('books', function ($query) use ($book) {
                $query->where('books.id', $book->id);
            })->latest()->first();

        return Inertia::render('Books/Show', compact('book', 'previousPurchasedOrder'));
    }
}
