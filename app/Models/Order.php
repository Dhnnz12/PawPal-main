<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_owner_id',
        'status',
        'total_amount',
        'shipping_address',
        'payment_proof',
    ];

    public function petOwner()
    {
        return $this->belongsTo(User::class, 'pet_owner_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'pet_owner_id');
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
