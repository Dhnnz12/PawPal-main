<?php

namespace App\Http\Controllers;

use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    public function index()
    {
        $addresses = Auth::user()->addresses()->get();
        return view('owner.addresses.index', compact('addresses'));
    }

    public function show(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        return view('owner.addresses.show', compact('address'));
    }

    public function create()
    {
        return view('owner.addresses.create');
    }

    public function edit(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }
        return view('owner.addresses.edit', compact('address'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'label' => 'required|string|max:255',
            'address_line' => 'required|string',
            'city' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_primary' => 'nullable|boolean',
        ]);

        $userId = Auth::id();
        $isPrimary = $request->boolean('is_primary');

        if ($isPrimary) {
            // Unset other primary addresses
            Address::where('user_id', $userId)->update(['is_primary' => false]);
        } else {
            // If this is the first address, make it primary
            $exists = Address::where('user_id', $userId)->exists();
            if (!$exists) {
                $isPrimary = true;
            }
        }

        Address::create([
            'user_id' => $userId,
            'label' => $request->label,
            'address_line' => $request->address_line,
            'city' => $request->city,
            'latitude' => $request->latitude ?? -6.2088,
            'longitude' => $request->longitude ?? 106.8456,
            'is_primary' => $isPrimary,
        ]);

        return redirect()->route('addresses.index')->with('success', 'Alamat berhasil ditambahkan!');
    }

    public function update(Request $request, Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'label' => 'required|string|max:255',
            'address_line' => 'required|string',
            'city' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
            'is_primary' => 'nullable|boolean',
        ]);

        $userId = Auth::id();
        $isPrimary = $request->boolean('is_primary');

        if ($isPrimary) {
            Address::where('user_id', $userId)->update(['is_primary' => false]);
        } else {
            if (!Address::where('user_id', $userId)->where('is_primary', true)->where('id', '!=', $address->id)->exists()) {
                $isPrimary = true;
            }
        }

        $address->update([
            'label' => $request->label,
            'address_line' => $request->address_line,
            'city' => $request->city,
            'latitude' => $request->latitude ?? $address->latitude,
            'longitude' => $request->longitude ?? $address->longitude,
            'is_primary' => $isPrimary,
        ]);

        return redirect()->route('addresses.index')->with('success', 'Alamat berhasil diperbarui!');
    }

    public function destroy(Address $address)
    {
        if ($address->user_id !== Auth::id()) {
            abort(403);
        }

        $address->delete();

        // Ensure at least one primary remains if any exist
        $userId = Auth::id();
        if (!Address::where('user_id', $userId)->where('is_primary', true)->exists()) {
            $first = Address::where('user_id', $userId)->first();
            if ($first) {
                $first->update(['is_primary' => true]);
            }
        }

        return back()->with('success', 'Alamat berhasil dihapus!');
    }
}

