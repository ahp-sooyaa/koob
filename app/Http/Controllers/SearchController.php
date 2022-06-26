<?php

namespace App\Http\Controllers;

use App\Models\Book;

class SearchController extends Controller
{
    public function __invoke()
    {
        $search = request('searchQuery');
        return Book::query()
            ->when(request('searchQuery'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->orderBy('title')
            ->limit(6)
            ->select(['cover', 'title', 'author'])
            ->get();
    }
}
