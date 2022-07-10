<?php

namespace App\Http\Controllers;

use App\Models\Book;

class SearchController extends Controller
{
    public function __invoke()
    {
        return Book::query()
            ->when(request('searchQuery'), function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->orderBy('title')
            ->limit(6)
            ->select(['slug', 'title', 'author', 'cover_photo_path'])
            ->get();
    }
}
