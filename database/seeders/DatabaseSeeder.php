<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Cart;
use App\Models\Order;
use App\Models\SaveForLater;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

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
            'email' => 'aunghtetpaing.mtkn@gmail.com',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
            'remember_token' => Str::random(10),
            'role' => 'admin',
        ]);
        Book::factory(10)->create();
        Order::factory(10)->create();
        Cart::factory(10)->create();
//        SaveForLater::factory(10)->create();
    }
}
