<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

class BookController extends Controller
{
    public function index()
    {
        return Inertia::render('Books/Index', [
            'books' => Book::all()
        ]);
    }
}
