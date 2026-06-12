<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_owner_id',
        'provider_id',
        'pet_id',
        'service_id',
        'booking_date',
        'start_time',
        'status',
        'total_price',
        'address_id',
        'notes',
        'completion_notes',
    ];

    public function petOwner()
    {
        return $this->belongsTo(User::class, 'pet_owner_id');
    }

    public function provider()
    {
        return $this->belongsTo(User::class, 'provider_id');
    }

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function medicalRecord()
    {
        return $this->hasOne(MedicalRecord::class);
    }
}
