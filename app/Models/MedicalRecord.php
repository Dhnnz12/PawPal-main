<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MedicalRecord extends Model
{
    use HasFactory;

    protected $fillable = [
        'pet_id',
        'vet_id',
        'booking_id',
        'visit_date',
        'diagnosis',
        'treatment',
        'recommendation',
        'notes',
        'pdf_path',
    ];

    protected $casts = [
        'visit_date' => 'date',
    ];

    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    public function vet()
    {
        return $this->belongsTo(User::class, 'vet_id');
    }

    public function booking()
    {
        return $this->belongsTo(Booking::class);
    }
}
