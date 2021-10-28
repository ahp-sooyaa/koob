<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    const SHIPPING = 0;
    const DELIVERED = 1;

    public function books()
    {
        return $this->belongsToMany(Book::class)->withPivot('quantity');
    }
}
