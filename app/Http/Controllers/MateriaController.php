<?php

namespace App\Http\Controllers;

use App\Http\Requests\MateriaRequest;
use App\Models\Materia;
use Illuminate\Http\RedirectResponse;
use Inertia\Inertia;
use Inertia\Response;

class MateriaController extends Controller
{
    /**
     * Display a listing of the materias.
     */
    public function index(): Response
    {
        return Inertia::render('materias/Index', [
            'materias' => Materia::query()->orderBy('nombre')->get(),
        ]);
    }

    /**
     * Show the form for creating a new materia.
     */
    public function create(): Response
    {
        return Inertia::render('materias/Create');
    }

    /**
     * Store a newly created materia.
     */
    public function store(MateriaRequest $request): RedirectResponse
    {
        $materia = Materia::create($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Materia creada.']);

        return to_route('materias.show', $materia);
    }

    /**
     * Display the specified materia.
     */
    public function show(Materia $materia): Response
    {
        return Inertia::render('materias/Show', [
            'materia' => $materia,
        ]);
    }

    /**
     * Show the form for editing the specified materia.
     */
    public function edit(Materia $materia): Response
    {
        return Inertia::render('materias/Edit', [
            'materia' => $materia,
        ]);
    }

    /**
     * Update the specified materia.
     */
    public function update(MateriaRequest $request, Materia $materia): RedirectResponse
    {
        $materia->update($request->validated());

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Materia actualizada.']);

        return to_route('materias.show', $materia);
    }

    /**
     * Remove the specified materia.
     */
    public function destroy(Materia $materia): RedirectResponse
    {
        $materia->delete();

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Materia eliminada.']);

        return to_route('materias.index');
    }
}
