<?php

use App\Models\Horario;
use App\Models\Materia;
use Inertia\Testing\AssertableInertia as Assert;

test('the index lists materias', function () {
    Materia::factory()->count(3)->create();

    $this->get(route('materias.index'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('materias/Index')
            ->has('materias', 3)
        );
});

test('the create page can be rendered', function () {
    $this->get(route('materias.create'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page->component('materias/Create'));
});

test('a materia can be stored', function () {
    $response = $this->post(route('materias.store'), [
        'nombre' => 'Programación Web',
        'creditos' => 8,
        'profesor' => 'Ana López',
    ]);

    $materia = Materia::sole();

    $response->assertRedirect(route('materias.show', $materia));

    expect($materia->only(['nombre', 'creditos', 'profesor']))->toBe([
        'nombre' => 'Programación Web',
        'creditos' => 8,
        'profesor' => 'Ana López',
    ]);
});

test('storing a materia requires valid data', function () {
    $this->post(route('materias.store'), [
        'nombre' => '',
        'creditos' => 0,
        'profesor' => '',
    ])->assertSessionHasErrors(['nombre', 'creditos', 'profesor']);

    expect(Materia::count())->toBe(0);
});

test('a materia can be stored with its horarios', function () {
    $this->post(route('materias.store'), [
        'nombre' => 'Programación Web',
        'creditos' => 8,
        'profesor' => 'Ana López',
        'horarios' => [
            ['dia' => 3, 'hora_inicio' => '10:00', 'hora_fin' => '12:00'],
            ['dia' => 1, 'hora_inicio' => '08:00', 'hora_fin' => '10:00'],
        ],
    ])->assertSessionHasNoErrors();

    expect(Materia::sole()->horarios->map->only(['dia', 'hora_inicio', 'hora_fin'])->all())->toBe([
        ['dia' => 1, 'hora_inicio' => '08:00', 'hora_fin' => '10:00'],
        ['dia' => 3, 'hora_inicio' => '10:00', 'hora_fin' => '12:00'],
    ]);
});

test('horarios require a valid day and an end time after the start time', function () {
    $this->post(route('materias.store'), [
        'nombre' => 'Programación Web',
        'creditos' => 8,
        'profesor' => 'Ana López',
        'horarios' => [
            ['dia' => 8, 'hora_inicio' => '12:00', 'hora_fin' => '10:00'],
        ],
    ])->assertSessionHasErrors(['horarios.0.dia', 'horarios.0.hora_fin']);

    expect(Materia::count())->toBe(0);
});

test('the show page displays the materia', function () {
    $materia = Materia::factory()->create();

    $this->get(route('materias.show', $materia))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('materias/Show')
            ->where('materia.id', $materia->id)
            ->has('materia.horarios', 0)
        );
});

test('the edit page can be rendered', function () {
    $materia = Materia::factory()->create();

    $this->get(route('materias.edit', $materia))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('materias/Edit')
            ->where('materia.id', $materia->id)
        );
});

test('a materia can be updated', function () {
    $materia = Materia::factory()->create();

    $this->put(route('materias.update', $materia), [
        'nombre' => 'Bases de Datos',
        'creditos' => 6,
        'profesor' => 'Luis Pérez',
    ])->assertRedirect(route('materias.show', $materia));

    expect($materia->fresh()->only(['nombre', 'creditos', 'profesor']))->toBe([
        'nombre' => 'Bases de Datos',
        'creditos' => 6,
        'profesor' => 'Luis Pérez',
    ]);
});

test('a materia can be deleted', function () {
    $materia = Materia::factory()->create();

    $this->delete(route('materias.destroy', $materia))
        ->assertRedirect(route('materias.index'));

    $this->assertModelMissing($materia);
});

test('updating a materia replaces its horarios', function () {
    $materia = Materia::factory()->has(Horario::factory()->count(2))->create();

    $this->put(route('materias.update', $materia), [
        'nombre' => $materia->nombre,
        'creditos' => $materia->creditos,
        'profesor' => $materia->profesor,
        'horarios' => [
            ['dia' => 5, 'hora_inicio' => '14:00', 'hora_fin' => '16:00'],
        ],
    ])->assertRedirect(route('materias.show', $materia));

    expect($materia->horarios()->get()->map->only(['dia', 'hora_inicio', 'hora_fin'])->all())->toBe([
        ['dia' => 5, 'hora_inicio' => '14:00', 'hora_fin' => '16:00'],
    ]);
});

test('updating a materia without horarios removes them', function () {
    $materia = Materia::factory()->has(Horario::factory())->create();

    $this->put(route('materias.update', $materia), [
        'nombre' => $materia->nombre,
        'creditos' => $materia->creditos,
        'profesor' => $materia->profesor,
    ])->assertRedirect(route('materias.show', $materia));

    expect($materia->horarios()->count())->toBe(0);
});
