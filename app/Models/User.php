<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'provider_type',
        'phone',
        'bio',
        'avatar',
        'is_verified',
        'is_active',
        'latitude',
        'longitude',
        'certification',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_verified' => 'boolean',
            'is_active' => 'boolean',
            'latitude' => 'decimal:8',
            'longitude' => 'decimal:8',
        ];
    }

    // Role check helpers
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isPetOwner(): bool
    {
        return $this->role === 'pet_owner';
    }

    public function isServiceProvider(): bool
    {
        return $this->role === 'service_provider';
    }

    public function isVet(): bool
    {
        return $this->isServiceProvider() && $this->provider_type === 'veterinarian';
    }

    public function isGroomer(): bool
    {
        return $this->isServiceProvider() && $this->provider_type === 'groomer';
    }

    public function isPetSitter(): bool
    {
        return $this->isServiceProvider() && $this->provider_type === 'pet_sitter';
    }

    public function isSeller(): bool
    {
        return $this->isServiceProvider() && $this->provider_type === 'seller';
    }

    // Relationships
    public function pets()
    {
        return $this->hasMany(Pet::class, 'user_id');
    }

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function services()
    {
        return $this->hasMany(Service::class, 'provider_id');
    }

    public function products()
    {
        return $this->hasMany(Product::class, 'seller_id');
    }

    public function schedules()
    {
        return $this->hasMany(ProviderSchedule::class, 'user_id');
    }

    public function bookingsAsOwner()
    {
        return $this->hasMany(Booking::class, 'pet_owner_id');
    }

    public function bookingsAsProvider()
    {
        return $this->hasMany(Booking::class, 'provider_id');
    }

    public function reviewsAsOwner()
    {
        return $this->hasMany(Review::class, 'pet_owner_id');
    }

    public function reviewsAsProvider()
    {
        return $this->hasMany(Review::class, 'provider_id');
    }

    public function medicalRecordsAsVet()
    {
        return $this->hasMany(MedicalRecord::class, 'vet_id');
    }
}
