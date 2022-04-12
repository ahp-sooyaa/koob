<?php

namespace App\Http\Controllers;

use App\Models\Book;
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
                ->paginate(5)
                ->withQueryString()
                ->through(fn ($book) => [
                    'id' => $book->id,
                    'title' => $book->title,
                    'price' => $book->price,
                    'cover' => $book->cover,
                    'stock_count' => $book->stock_count
                ]),
            'booksCount' => count(Book::all())
            // 'filters' => [
            //     'search' => request('search')
            // ]
        ]);
    }

    public function show(Book $book)
    {
        return Inertia::render('Books/Show', compact('book'));
    }
}
