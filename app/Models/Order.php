<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory;
   protected $table = 'orders'; // Trỏ đúng bảng orders chính

    protected $fillable = [
        'user_id', 'total_price', 'status', 'receiver_name', 'phone', 'address'
    ];
    // Một đơn hàng có nhiều chi tiết đơn hàng
    public function orderDetails() {
    return $this->hasMany(OrderDetail::class, 'order_id', 'id');
}

public function user() {
    return $this->belongsTo(User::class, 'user_id', 'id');
}

    protected function casts(): array
    {
        return [
            'total_price' => 'decimal:2',
        ];
    }


    public function details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
