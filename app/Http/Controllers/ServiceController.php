<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller
{
    public function index()
    {
        if (Auth::user()->isAdmin()) {
            return redirect()->route('admin.services.index');
        }
        $services = Auth::user()->services()->get();
        return view('provider.services.index', compact('services'));
    }

    public function show(Service $service)
    {
        if (!Auth::user()->isAdmin() && $service->provider_id !== Auth::id()) {
            abort(403);
        }
        return view('provider.services.show', compact('service'));
    }

    public function create()
    {
        return view('provider.services.create');
    }

    public function edit(Service $service)
    {
        if (!Auth::user()->isAdmin() && $service->provider_id !== Auth::id()) {
            abort(403);
        }
        return view('provider.services.edit', compact('service'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'provider_type' => 'required|string|in:groomer,veterinarian',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        Service::create([
            'provider_id' => null, // clinic-wide service
            'provider_type' => $request->provider_type,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil ditambahkan ke katalog!');
    }

    public function update(Request $request, Service $service)
    {
        if (!Auth::user()->isAdmin() && $service->provider_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'provider_type' => 'required|string|in:groomer,veterinarian',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'duration_minutes' => 'required|integer|min:1',
        ]);

        $service->update([
            'name' => $request->name,
            'provider_type' => $request->provider_type,
            'description' => $request->description,
            'price' => $request->price,
            'duration_minutes' => $request->duration_minutes,
        ]);

        return redirect()->route('admin.services.index')->with('success', 'Layanan berhasil diperbarui!');
    }

    public function destroy(Service $service)
    {
        if (!Auth::user()->isAdmin() && $service->provider_id !== Auth::id()) {
            abort(403);
        }

        $service->delete();

        return back()->with('success', 'Layanan berhasil dihapus dari katalog!');
    }
}

