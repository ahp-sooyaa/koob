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
                    'cover_url' => $book->cover_url,
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
        $request->validated();

        $attributes = $request->except('cover_photo');
        $attributes['slug'] = Str::slug($request->title . '-' . uniqid());
        $attributes['cover_photo_path'] = $request->file('cover_photo')->store('cover-photos');

        Book::create($attributes);

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
                Storage::delete($book->cover_photo_path);

                $validated['cover_photo_path'] = $request->file('cover')->store('cover-photos');
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
