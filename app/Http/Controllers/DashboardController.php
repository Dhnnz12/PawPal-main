<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Order;
use App\Models\User;
use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->route('admin.dashboard');
        } elseif ($user->isServiceProvider()) {
            return redirect()->route('provider.dashboard');
        } else {
            return redirect()->route('owner.dashboard');
        }
    }

    public function ownerDashboard()
    {
        $user = Auth::user();
        
        // Eager load pets and bookings
        $pets = $user->pets;
        $bookings = Booking::with(['provider', 'pet', 'service'])
            ->where('pet_owner_id', $user->id)
            ->orderBy('booking_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();
            
        $orders = Order::with(['items.product'])
            ->where('pet_owner_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        $addresses = $user->addresses;

        return view('owner.dashboard', compact('pets', 'bookings', 'orders', 'addresses'));
    }

    public function providerDashboard()
    {
        $user = Auth::user();

        // Providers need their schedule and bookings
        $schedules = $user->schedules()->orderBy('day_of_week')->get();
        
        $bookings = Booking::with(['petOwner', 'pet', 'service', 'address'])
            ->where('provider_id', $user->id)
            ->orderBy('booking_date', 'desc')
            ->orderBy('start_time', 'desc')
            ->get();

        $services = $user->services;
        $products = $user->products;

        return view('provider.dashboard', compact('schedules', 'bookings', 'services', 'products'));
    }

    public function adminDashboard()
    {
        // Admin views unverified providers and transactions overview
        $pendingProviders = User::where('role', 'service_provider')
            ->where('is_verified', false)
            ->get();

        $allUsers = User::orderBy('created_at', 'desc')->get();
        $allBookings = Booking::with(['petOwner', 'provider', 'service'])->orderBy('created_at', 'desc')->get();
        $allOrders = Order::with(['petOwner', 'items.product'])->orderBy('created_at', 'desc')->get();

        // Statistics for dashboard
        $totalUsers = User::count();
        $totalBookings = Booking::count();
        $totalTransactions = Order::sum('total_amount') ?? 0;
        $totalPets = Pet::count();

        return view('admin.dashboard', compact('pendingProviders', 'allUsers', 'allBookings', 'allOrders', 'totalUsers', 'totalBookings', 'totalTransactions', 'totalPets'));
    }
}
