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
        $monthlyUsers = User::query()
            ->whereYear('created_at', date('Y'))
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('m'))
            ->sortBy(fn($item, $key) => $key)
            ->mapWithKeys(fn($item, $key) => [(int)$key => $item->count()]);

        $monthlyOrders = Order::query()
            ->whereYear('created_at', date('Y'))
            ->get()
            ->groupBy(fn($item) => $item->created_at->format('m'))
            ->sortBy(fn($item, $key) => $key)
            ->mapWithKeys(fn ($item, $key) => [
                (int)$key => [
                    'Orders' => $item->count(),
                    'Amount' => $item->sum(fn($item) => $item->total),
                ]
            ]);

        foreach (range(1, 12) as $month) {
            if ($monthlyOrders->has($month)) {
                $userDataSets[$month - 1] = $monthlyUsers[$month];
                $orderDataSets[$month - 1] = $monthlyOrders[$month]['Orders'];
                $saleDataSets[$month - 1] = $monthlyOrders[$month]['Amount'];
            } else {
                $userDataSets[$month - 1] = $month > (int)date('m') ? null : 0;
                $orderDataSets[$month - 1] = $month > (int)date('m') ? null : 0;
                $saleDataSets[$month - 1] = $month > (int)date('m') ? null : 0;
            }
        }

        return Inertia::render('Admin/Dashboard/Index', [
            'booksCount' => Book::count(),
            'ordersCount' => Order::whereStatus(Order::DELIVERED)->get()->count(),
            'usersCount' => User::count(),
            'userDataSets' => $userDataSets,
            'orderDataSets' => $orderDataSets,
            'saleDataSets' => $saleDataSets,
        ]);
    }
}
