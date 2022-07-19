<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaveForLater extends Model
{
    use HasFactory;

    protected $table = 'save_for_later_items';

    protected $guarded = [];

    protected $with = ['book'];

    public function book()
    {
        return $this->belongsTo(Book::class);
    }
}
