<?php

namespace App\Providers;

use App\Models\Booking;
use App\Models\MedicalRecord;
use App\Models\Pet;
use App\Models\Service;
use App\Policies\BookingPolicy;
use App\Policies\MedicalRecordPolicy;
use App\Policies\PetPolicy;
use App\Policies\ServicePolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        Pet::class => PetPolicy::class,
        Booking::class => BookingPolicy::class,
        Service::class => ServicePolicy::class,
        MedicalRecord::class => MedicalRecordPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Define gates for role-based access
        Gate::define('access-admin', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('access-provider', function ($user) {
            return $user->isServiceProvider();
        });

        Gate::define('access-owner', function ($user) {
            return $user->isPetOwner();
        });
    }
}
