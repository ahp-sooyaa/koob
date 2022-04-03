<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('user_id', auth()->id())->latest()->get();
        return Inertia::render('Orders/Index', compact('orders'));
    }

    public function show(Order $order)
    {
        return Inertia::render('Orders/Show', compact('order'));
    }
}
