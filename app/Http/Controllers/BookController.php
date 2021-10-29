<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        return Inertia::render('Books/Index', [
            'books' => Book::query()->select('id', 'title', 'price', 'cover')->get()
        ]);
    }

    public function show(Book $book)
    {
        return Inertia::render('Books/Show', compact('book'));
    }
}
