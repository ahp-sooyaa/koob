<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot('isApplied');
    }

    public function isApplied()
    {
        if ($this->users()->where('user_id', auth()->id())->exists()) {
            return $this->users()->where('user_id', auth()->id())->first()->pivot->isApplied;
        }

        $this->users()->attach(auth()->id(), ['isApplied' => false]);
        return false;
    }
}
