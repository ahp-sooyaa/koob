<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
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

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'address' => ['required', 'string'],
            'city' => ['required', 'string'],
            'state' => ['required', 'string'],
            'zip_code' => ['required'],
        ]);

        // check order quantity are more than avaliable stock here
        // or check this in addToCart before add to cart
        $user = User::firstOrCreate(
            [
                'email' => $request->input('email')
            ],
            [
                'password' => Hash::make(Str::random(12)),
                'name' => $request->input('first_name') . ' ' . $request->input('last_name')
            ]
        );

        try {
            $payment = $user->charge(
                $request->input('amount'),
                $request->input('payment_method_id')
            );

            $payment = $payment->asStripePaymentIntent();

            $order = $user->orders()
                ->create([
                    'transaction_id' => $payment->charges->data[0]->id,
                    'total' => $payment->charges->data[0]->amount,
                    'address' => $request->input('address'),
                    'city' => $request->input('city'),
                    'state' => $request->input('state'),
                    'zip_code' => $request->input('zip_code')
                ]);

            foreach (json_decode($request->input('cart'), true) as $item) {
                $order->books()
                    ->attach($item['book_id'], ['quantity' => $item['quantity']]);

                // product or book stock quantities should decrease here
                // SQLSTATE[22003]: Numeric value out of range: 1264 Out of range value for column 'stock_count' at row 1 (SQL: update `books` set `stock_count` = -1, `books`.`updated_at` = 2022-04-03 05:26:57 where `id` = 3)"
                $book = Book::find($item['book_id']);
                $book->update([
                    'stock_count' => $book->stock_count - $item['quantity']
                ]);
            }

            // after order store destroy cart data from database
            // session()->forget('cart');  we don't need this anymore bcuz user must login before checkout
            Cart::where('user_id', auth()->id())->delete();

            /**
             * mail send or notify
             * Mail::send(new OrderPlaced($order));
             */

            // coupon here or not
            if (session('coupon')) {
                // auth()->user()->coupons()->attach(session('coupon')->id);
                auth()->user()->coupons()->where('code', session('coupon')->code)->first()->pivot->update(['isApplied' => true]);

                session()->forget('coupon');
            }

            return $order;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
