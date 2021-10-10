<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
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
        // User::factory(1)->create();
        // Category::factory(10)->create();
        Book::factory(10)->create();
        Order::factory(10)->create();
    }
}
