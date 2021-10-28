<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;
use Inertia\Inertia;

class CheckoutController extends Controller
{
    public function index()
    {
        if (session('cart')) {
            return Inertia::render('Checkout');
        } else {
            return Redirect::route('books.index');
        }
    }

    public function store(Request $request)
    {
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
                    ->attach($item['id'], ['quantity' => $item['quantity']]);
            }

            // after order store destroy cart session
            session()->forget('cart');

            // product or book stock quantities should decrease here

            /**
             * mail send or notify
             * Mail::send(new OrderPlaced($order));
             */

            // coupon here or not

            return $order;
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function thankyou(Order $order)
    {
        return Inertia::render('Thankyou', ['order' => $order->load('books')]);
    }
}
