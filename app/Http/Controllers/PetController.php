<?php

namespace App\Http\Controllers;

use App\Models\Pet;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PetController extends Controller
{
    public function index()
    {
        $pets = Auth::user()->pets()->get();
        return view('owner.pets.index', compact('pets'));
    }

    public function show(Pet $pet)
    {
        if ($pet->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        return view('owner.pets.show', compact('pet'));
    }

    public function create()
    {
        return view('owner.pets.create');
    }

    public function edit(Pet $pet)
    {
        if ($pet->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }
        return view('owner.pets.edit', compact('pet'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'photo' => 'nullable|image|max:2048',
            'health_notes' => 'nullable|string',
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('pets', 'public');
        }

        Pet::create([
            'user_id' => Auth::user()->isAdmin() ? (Auth::id()) : Auth::id(), // Owner is always current auth for pet owners
            'name' => $request->name,
            'type' => $request->type,
            'breed' => $request->breed,
            'age' => $request->age,
            'weight' => $request->weight,
            'photo' => $photoPath,
            'health_notes' => $request->health_notes,
        ]);

        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.pets.index')->with('success', 'Profil hewan berhasil ditambahkan!');
        }

        return redirect()->route('pets.index')->with('success', 'Profil hewan berhasil ditambahkan!');
    }

    public function update(Request $request, Pet $pet)
    {
        // Ensure owner owns the pet, or is admin
        if ($pet->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'breed' => 'nullable|string|max:255',
            'age' => 'required|integer|min:0',
            'weight' => 'nullable|numeric|min:0',
            'photo' => 'nullable|image|max:2048',
            'health_notes' => 'nullable|string',
        ]);

        $data = [
            'name' => $request->name,
            'type' => $request->type,
            'breed' => $request->breed,
            'age' => $request->age,
            'weight' => $request->weight,
            'health_notes' => $request->health_notes,
        ];

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($pet->photo) {
                Storage::disk('public')->delete($pet->photo);
            }
            $data['photo'] = $request->file('photo')->store('pets', 'public');
        }

        $pet->update($data);

        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.pets.index')->with('success', 'Profil hewan berhasil diperbarui!');
        }

        return redirect()->route('pets.index')->with('success', 'Profil hewan berhasil diperbarui!');
    }

    public function destroy(Pet $pet)
    {
        if ($pet->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        if ($pet->photo) {
            Storage::disk('public')->delete($pet->photo);
        }

        $pet->delete();

        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.pets.index')->with('success', 'Profil hewan berhasil dihapus!');
        }

        return redirect()->route('pets.index')->with('success', 'Profil hewan berhasil dihapus!');
    }
}
