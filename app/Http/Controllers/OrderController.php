<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use App\Models\User;
use App\Notifications\CustomerOrderPlaced;
use App\Notifications\OrderPlaced;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Inertia\Inertia;

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

        return Inertia::render('Orders/Index', [
            'orders' => $orders,
            'ordersCount' => $ordersCount,
            'search' => request('search')
        ]);
    }

    public function show(Order $order)
    {
        abort_if($order->user_id != Auth::id(), 404);

        return Inertia::render('Orders/Show', compact('order'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'contact_name' => ['required', 'string'],
            'contact_email' => ['required', 'email'],
        ]);

        // check order quantity are more than available stock here
        // or check this in addToCart before add to cart
        // $user = User::firstOrCreate(
        //     [
        //         'email' => $request->input('email')
        //     ],
        //     [
        //         'password' => Hash::make(Str::random(12)),
        //         'name' => $request->input('first_name') . ' ' . $request->input('last_name')
        //     ]
        // );

        try {
            // Auth::user()->createOrGetStripeCustomer();

            // if (! Auth::user()->hasDefaultPaymentMethod()) {
            //     Auth::user()->updateDefaultPaymentMethod($request->payment_method_id);
            // }

            // $payment = Auth::user()->invoiceFor('description', $request->input('amount')); 
            $payment = Auth::user()->charge(
                $request->input('amount'),
                $request->input('payment_method_id')
            );
            // $payment = $payment->asStripePaymentIntent();
        } catch (\Exception $e) {
            Log::debug($e->getMessage());
            return response()->json(['message' => $e->getMessage()], 500);
        }

        Log::debug($payment);
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

            // product or book stock quantities should decrease here
            // SQLSTATE[22003]: Numeric value out of range: 1264 Out of range value for column 'stock_count' at row 1 (SQL: update `books` set `stock_count` = -1, `books`.`updated_at` = 2022-04-03 05:26:57 where `id` = 3)"
            $book = Book::find($item['id']);
            $book->update([
                'stock_count' => $book->stock_count - $item['quantity']
            ]);
        }

        session()->forget('cart');
        Cart::where('user_id', auth()->id())->delete();

        // Mail::send(new OrderPlaced($order));
        $admins = User::where('role', 'admin')->get();
        Notification::send($admins, new OrderPlaced($order));
        Notification::send(Auth::user(), new CustomerOrderPlaced($order));

        if (session('coupon')) {
            // auth()->user()->coupons()->attach(session('coupon')->id);
            auth()->user()->coupons()->where('code', session('coupon')->code)->first()->pivot->update(['isApplied' => true]);

            session()->forget('coupon');
        }

        return $order;
    }
}
