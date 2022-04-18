<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
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
                        $query->where($column, $value);
                    }
                })
                ->when(request('sort'), function ($query, $sort) {
                    foreach ($sort as $column => $direction) {
                        $query->orderBy($column, $direction);
                    }
                    // $query->orderBy('created_at', 'desc')
                    //     ->orderBy('price', 'desc');
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
            'booksCount' => count(Book::all()),
            'categories' => Category::all(),
            'sorting' => request('sort'),
            'filters' => request('filter')
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
