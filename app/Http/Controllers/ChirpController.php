<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Inertia\Inertia;
use Inertia\Response as InertiaResponse;

class ChirpController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): InertiaResponse
    {
        return Inertia::render('Chirps/Index', [
            'chirpsList' => Chirp::with('user:id,name')->orderByDesc("id")->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): Response
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {

        $validated = $request->validate([
            "message" => 'required|string|max:255',
        ]);

        $request->user()->chirps()->create($validated);

        return redirect(route('chirps.index'));

    }

    /**
     * Display the specified resource.
     */
    public function show(Chirp $chirp): Response
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Chirp $chirp): Response
    {
        //
    }

    /**
     * Update the specified resource in storage.
     * @throws AuthorizationException
     */
    public function update(Request $request, Chirp $chirp): RedirectResponse
    {
        $this->authorize("update", $chirp);

        $validated = $request->validate([
            "message" => 'required|string|max:255',
        ]);

        $chirp->update($validated);

        return redirect(route('chirps.index'));
    }

    /**
     * Remove the specified resource from storage.
     * @throws AuthorizationException
     */
    public function destroy(Chirp $chirp): RedirectResponse
    {
        $this->authorize("delete", $chirp);

        $chirp->delete();

        return redirect(route('chirps.index'));
    }
}
