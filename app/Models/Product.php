<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    protected $fillable = [
        'category_id',
        'name',
        'description',
        'price',
        'image',
        'size',
        'color',
        'stock',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function getImageUrlAttribute(): string
    {
        if (empty($this->image)) {
            return 'https://placehold.co/400x400?text=No+Image';
        }

        if (str_starts_with($this->image, 'http://') || str_starts_with($this->image, 'https://')) {
            return $this->image;
        }

        if (str_contains($this->image, '/')) {
            return asset('storage/' . ltrim($this->image, '/'));
        }

        if (file_exists(public_path('storage/images/products/' . $this->image))) {
            return asset('storage/images/products/' . $this->image);
        }

        if (file_exists(public_path('storage/products/' . $this->image))) {
            return asset('storage/products/' . $this->image);
        }

        return asset('storage/' . $this->image);
    }
}