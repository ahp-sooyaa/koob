<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\OrderStatusUpdated;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function index()
    {
        return Inertia::render('Admin/Orders/Index', [
            'orders' => Order::query()->with('user')->latest()->get()
        ]);
    }

    public function show(Order $order)
    {
        return Inertia::render('Admin/Orders/Show', [
            'order' => $order->load('books')
        ]);
    }

    public function edit(Order $order)
    {
        return Inertia::render('Admin/Orders/Edit', [
            'order' => $order->load('user')
        ]);
    }

    public function update(Order $order, Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'email' => ['required', 'string'],
            'total' => ['required', 'numeric'],
            'status' => ['required'],
            'created_at' => ['required']
        ]);

        if ($order->status != $request->status) {
            // send mail to customer about order status update
            Mail::to($order->user->email)->send(new OrderStatusUpdated($order));
        }

        $order->update($request->except('name', 'email'));
        $order->user->update($request->only('name', 'email'));

        return Redirect::route('admin.orders.edit', $order->id)->with('message', 'Updated order successfully');
    }
}
