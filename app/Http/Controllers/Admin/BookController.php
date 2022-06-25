<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Books/Index', [
            'books' => Book::query()
                ->latest()
                ->paginate(10)
                ->through(fn ($book) => [
                    'id' => $book->id,
                    'title' => $book->title,
                    'excerpt' => $book->excerpt,
                    'author' => $book->author,
                    'price' => $book->price,
                    'cover' => $book->cover,
                    'stock_count' => $book->stock_count
                ])
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
        $validated['cover'] = $request->file('cover')->store('covers');

        Book::create($validated);

        return Redirect::route('admin.books.index');
    }

    public function edit(Book $book)
    {
        return Inertia::render('Admin/Books/Edit', [
            'categories' => Category::all(),
            'book' => $book
        ]);
    }

    public function update(Book $book, UpdateBookRequest $request)
    {
        $validated = $request->validated();

        DB::transaction(function () use ($book, $request, $validated) {
            $validated['slug'] = Str::slug($request->title . '_' . uniqid());

            if ($request->hasFile('cover')) {
                Storage::delete($book->cover);

                $validated['cover'] = $request->file('cover')->store('covers');
            }

            $book->update($validated);
        });

        return Redirect::route('admin.books.index');
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return Redirect::route('admin.books.index');
    }
}
