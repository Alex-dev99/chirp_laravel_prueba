<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ChirpController extends Controller
{
    public function index()
    {
        $chirps = Chirp::with('user')->latest()->get();
        return view('chirps.index', compact('chirps'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $request->user()->chirps()->create($validated);

        return redirect()->route('chirps.index');
    }

    public function edit(Chirp $chirp)
    {
        Gate::authorize('update', $chirp);
        return view('chirps.edit', compact('chirp'));
    }

    public function update(Request $request, Chirp $chirp)
    {
        Gate::authorize('update', $chirp);

        $validated = $request->validate([
            'message' => 'required|string|max:255',
        ]);

        $chirp->update($validated);

        return redirect()->route('chirps.index');
    }

    public function destroy(Chirp $chirp)
    {
        Gate::authorize('delete', $chirp);
        $chirp->delete();

        return redirect()->route('chirps.index');
    }
}
