<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Cart;
use App\Models\User;
use App\Models\Order;
use App\Models\Coupon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::factory()->create([
            'name' => 'aung htet paing',
            'email' => 'apaing894@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => '',
        ]);

        Book::factory(10)->create();
        Coupon::factory(10)->create();
        // $orders = Order::factory(10)->create();

        // foreach ($orders as $order) {
        //     foreach ($books as $book) {
        //         $order->books()->attach($book->id, ['quantity' => rand(1, 10)]);
        //     }
        // }
        // Cart::factory(10)->create();
    }
}
