<?php

namespace Database\Seeders;

use App\Models\Book;
use App\Models\Category;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
        // Order::factory(10)->create();

        // this is for situation when factory is not work like in production
        // DB::table('users')->insert([
        //     [
        //         'name' => 'Aung',
        //         'email' => 'admin@admin.com',
        //         'password' => bcrypt('password'),
        //         'role' => 'admin',
        //         'created_at' => NOW(),
        //         'updated_at' => NOW()
        //     ],
        //     [
        //         'name' => 'Jane Doe',
        //         'email' => 'jane@example.com',
        //         'password' => bcrypt('password'),
        //         'role' => null,
        //         'created_at' => NOW(),
        //         'updated_at' => NOW()
        //     ],
        // ]);

        // DB::table('categories')->insert([
        //     [
        //         'name' => 'category 1',
        //         'created_at' => NOW(),
        //         'updated_at' => NOW()
        //     ],
        //     [
        //         'name' => 'category 2',
        //         'created_at' => NOW(),
        //         'updated_at' => NOW()
        //     ],
        //     [
        //         'name' => 'category 3',
        //         'created_at' => NOW(),
        //         'updated_at' => NOW()
        //     ],
        // ]);

        // DB::table('books')->insert([
        //     [
        //         'category_id' => '1',
        //         'slug' => 'title-slug',
        //         'title' => 'title',
        //         'author' => 'author',
        //         'excerpt' => 'excerpt',
        //         'price' => '12345',
        //         'cover' => '/images/cover.png',
        //         'created_at' => NOW(),
        //         'updated_at' => NOW()
        //     ],
        //     [
        //         'category_id' => '2',
        //         'slug' => 'title-slug',
        //         'title' => 'title2',
        //         'author' => 'author',
        //         'excerpt' => 'excerpt',
        //         'price' => '12345',
        //         'cover' => '/images/cover.png',
        //         'created_at' => NOW(),
        //         'updated_at' => NOW()
        //     ],
        //     [
        //         'category_id' => '3',
        //         'slug' => 'title-slug',
        //         'title' => 'title3',
        //         'author' => 'author',
        //         'excerpt' => 'excerpt',
        //         'price' => '12345',
        //         'cover' => '/images/cover.png',
        //         'created_at' => NOW(),
        //         'updated_at' => NOW()
        //     ],
        // ]);
    }
}
