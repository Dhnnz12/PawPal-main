<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id',
        'provider_type',
        'name',
        'description',
        'price',
        'duration_minutes',
    ];

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }
}
