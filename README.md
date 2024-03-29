# Koob

[![CI](https://github.com/ahp-sooyaa/koob/actions/workflows/dusk.yml/badge.svg)](https://github.com/ahp-sooyaa/koob/actions/workflows/dusk.yml)

Koob (Book) is ecommerce bookstore project for personal portfolio that's built by laravel 8, Vue3, Inertia. User can add book to cart, checkout the books in the cart.

## Demo
Link - [https://koobdemo.site/](https://koobdemo.site/)
![preview](Doc/pika-1682477435106-1x.png)

## Installation

First you need to clone and then copy .env.example to .env and setup stripe key, database, db:seed, install dependencies, compile vue.

### Step 1

Clone the repo

```zsh
git clone https://github.com/ahp-sooyaa/koob.git
cd koob
cp .env.example .env
php artisan key:generate
```

### Step 2

Setup stripe key

```zsh
STRIPE_KEY=PASTE_KEY_HERE
STRIPE_SECRET=PASTE_SECRET_HERE
```

### Step 3

Setup database & add new database "koob" or as you like

```zsh
DB_DATABASE=koob
DB_USERNAME=root
DB_PASSWORD=
```

Run migration & seeder

```zsh
php artisan migrate 
php artisan db:seed
```

### Step 4

Install dependencies

```zsh
composer install 
npm install
npm run dev
```

### Step 5

> You need to use laravel valet in order to visit Koob.test otherwise run ```php artisan serve``` and visit may be ```http://localhost:8000```

Visit [Koob.test/books](Koob.test/books). Right now that is the home page of Koob. Choose your book, add to cart, checkout the order and all done.

## Contributing

Do not hesitate to contribute to the project by adapting or adding features ! Bug reports or pull requests are welcome.
