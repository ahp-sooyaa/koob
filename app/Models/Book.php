<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class Book extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = [
        'cover_url'
    ];

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCoverUrlAttribute()
    {
        return Storage::url($this->cover_photo_path);
    }

    public function scopeFilter($query, array $filters)
    {
        $query->when($filters['search'] ?? false, function ($query, $search) {
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%$search%")
                ->orWhere('excerpt', 'like', "%$search%");
            });
        });

        $query->when($filters['category'] ?? false, function ($query, $category) {
            $query->whereHas('category', function ($query) use ($category) {
                $query->where('slug', $category);
            });
        });
    }

    public function scopeSort($query, string $sort)
    {
        $column = explode(',', $sort)[0];
        $direction = explode(',', $sort)[1];

        $query->when($sort, function ($query) use ($column, $direction) {
            $query->orderBy($column, $direction);
        });
    }
}
