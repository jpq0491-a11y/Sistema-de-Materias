<?php

namespace App\Http\Controllers;

use App\Http\Requests\MateriaRequest;
use App\Models\Materia;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
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
            'materias' => Materia::query()->with('horarios')->orderBy('nombre')->get(),
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
        $materia = DB::transaction(function () use ($request): Materia {
            $materia = Materia::create($request->safe()->except('horarios'));
            $materia->horarios()->createMany($request->validated('horarios', []));

            return $materia;
        });

        Inertia::flash('toast', ['type' => 'success', 'message' => 'Materia creada.']);

        return to_route('materias.show', $materia);
    }

    /**
     * Display the specified materia.
     */
    public function show(Materia $materia): Response
    {
        return Inertia::render('materias/Show', [
            'materia' => $materia->load('horarios'),
        ]);
    }

    /**
     * Show the form for editing the specified materia.
     */
    public function edit(Materia $materia): Response
    {
        return Inertia::render('materias/Edit', [
            'materia' => $materia->load('horarios'),
        ]);
    }

    /**
     * Update the specified materia.
     */
    public function update(MateriaRequest $request, Materia $materia): RedirectResponse
    {
        DB::transaction(function () use ($request, $materia): void {
            $materia->update($request->safe()->except('horarios'));
            $materia->horarios()->delete();
            $materia->horarios()->createMany($request->validated('horarios', []));
        });

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
