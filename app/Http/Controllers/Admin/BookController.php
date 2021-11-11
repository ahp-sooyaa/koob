<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Books/Index', [
            'books' => Book::query()->select('id', 'title', 'author', 'price', 'cover')->get()
        ]);
    }

    // public function show(Book $book)
    // {
    //     return Inertia::render('Admin/Books/Show', compact('book'));
    // }

    public function create()
    {
        return Inertia::render('Admin/Books/Create', ['categories' => Category::all()]);
    }

    public function store(StoreBookRequest $request)
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($request->title . '_' . uniqid());
        $validated['cover'] = '/' . $request->file('cover')->store('covers');

        Book::create($validated);

        return Redirect::route('admin.books.index');
    }
}
