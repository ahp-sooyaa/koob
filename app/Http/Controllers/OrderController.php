<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\User;
use Inertia\Inertia;
use App\Models\Order;
use App\Models\Address;
use Illuminate\Http\Request;
use App\Notifications\OrderPlaced;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Notifications\CustomerOrderPlaced;
use Illuminate\Support\Facades\Notification;

class OrderController extends Controller
{
    public function index()
    {
        $ordersCount = Auth::user()->orders()->count();
        $orders = Order::query()
            ->where('user_id', Auth::id())
            ->when(request('search'), function ($query, $search) {
                $query->where(function ($query) use ($search) {
                    $query
                        ->where('id', $search)
                        ->orWhereHas('books', function ($query) use ($search) {
                            $query->where('title', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(5);

        return Inertia::render('Settings/Orders/Index', [
            'orders' => $orders,
            'ordersCount' => $ordersCount,
            'search' => request('search'),
        ]);
    }

    public function show(Order $order)
    {
        abort_if($order->user_id != Auth::id(), 404);

        return Inertia::render('Settings/Orders/Show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contact_name' => ['required', 'string'],
            'contact_email' => ['required', 'email'],
            'amount' => ['required', 'numeric'],
            'payment_method_id' => ['required', 'string'],
            'address_id' => ['required', 'numeric'],
        ]);

        foreach (json_decode($request->input('cart'), true) as $item) {
            $book = Book::find($item['id']);

            if ($book->stock_count < $item['quantity']) {
                return response()->json(['message' => 'Sorry! Some items in your cart are not available.'], 422);
            }
        }

        try {
            $payment = Auth::user()->charge(
                $request->input('amount'),
                $request->input('payment_method_id')
            );
        } catch (\Exception $e) {
            Log::debug($e->getMessage());

            return response()->json(['message' => $e->getMessage()], 422);
        }

        $order = Auth::user()->orders()
            ->create([
                // 'email' => $request->input('email'), this should save because user can fill different email in contact information section and that email will be useless if we don't save and we can't send mail to that address and we can only send mail to user registered email
                'transaction_id' => $payment->id,
                'total' => $payment->amount,
                'address_id' => $request->input('address_id'),
            ]);

        foreach (json_decode($request->input('cart'), true) as $item) {
            $order->books()
                ->attach($item['id'], ['quantity' => $item['quantity']]);

            $book = Book::find($item['id']);
            $book->update([
                'stock_count' => $book->stock_count - $item['quantity'],
            ]);
        }

        session()->forget('cart');
        Cart::where('user_id', Auth::id())->delete();

        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new OrderPlaced($order));
        Notification::send(Auth::user(), new CustomerOrderPlaced($order));

        if (session('coupon')) {
            Auth::user()->coupons()->where('code', session('coupon')->code)->first()->pivot->update(['isApplied' => true]);

            session()->forget('coupon');
        }

        return $order;
    }
}
