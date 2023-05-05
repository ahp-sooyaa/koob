<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Category;
use Illuminate\Support\Facades\Request;

class BookController extends Controller
{
    public function index()
    {
        return Inertia::render('Books/Index', [
            'books' => Book::query()
                ->with('promotions')
                ->filter(Request::only(['search', 'category']))
                ->sort(Request::query('sort', 'created_at,asc'))
                ->paginate(5)
                ->withQueryString()
                ->through(fn ($book) => [
                    'id' => $book->id,
                    'slug' => $book->slug,
                    'title' => $book->title,
                    'price' => $book->price,
                    'cover_url' => $book->cover_url,
                    'stock_count' => $book->stock_count,
                    'promotion' => $book->promotions->first()?->only([
                        'id',
                        'is_percentage_discount',
                        'discount_amount',
                        'starts_at',
                        'ends_at',
                    ]),
                ]),
            'booksCount' => Book::count(),
            'categories' => Category::select(['slug', 'name'])->get(),
            'sorting' => Request::query('sort', 'created_at,asc'),
            'filters' => Request::only(['search', 'category']),
        ]);
    }

    public function show(Book $book)
    {
        $previousPurchasedOrder = Order::query()
            ->where('user_id', auth()->id())
            ->whereHas('books', function ($query) use ($book) {
                $query->where('books.id', $book->id);
            })
            ->latest()
            ->first();

        return Inertia::render('Books/Show', [
            'book' => [
                'id' => $book->id,
                'title' => $book->title,
                'excerpt' => $book->excerpt,
                'price' => $book->price,
                'cover_url' => $book->cover_url,
                'stock_count' => $book->stock_count,
                'promotion' => $book->promotions->first()?->only([
                    'id',
                    'is_percentage_discount',
                    'discount_amount',
                    'starts_at',
                    'ends_at',
                ]),
            ],
            'previousPurchasedOrder' => $previousPurchasedOrder,
        ]);
    }
}
