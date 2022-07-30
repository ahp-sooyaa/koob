<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\User;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Dashboard/Index', [
            'booksCount' => Book::count(),
            'ordersCount' => Order::whereStatus(Order::DELIVERED)->get()->count(),
            'usersCount' => User::count(),
        ]);
    }
}
