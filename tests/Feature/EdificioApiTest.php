<?php

namespace Tests\Feature;

use App\Models\Aula;
use App\Models\Edificio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EdificioApiTest extends TestCase
{
    use RefreshDatabase;

    public function test_el_crud_de_edificios_funciona(): void
    {
        $respuesta = $this->postJson('/api/edificios', [
            'nombre' => 'Edificio C',
        ]);

        $respuesta
            ->assertCreated()
            ->assertJsonPath('nombre', 'Edificio C');

        $edificioId = $respuesta->json('id');

        $this->getJson('/api/edificios')
            ->assertOk()
            ->assertJsonPath('0.nombre', 'Edificio C');

        $this->putJson("/api/edificios/{$edificioId}", [
            'nombre' => 'Edificio C Modificado',
        ])->assertOk()
            ->assertJsonPath('nombre', 'Edificio C Modificado');

        $this->deleteJson("/api/edificios/{$edificioId}")
            ->assertOk()
            ->assertJsonPath('mensaje', 'Edificio eliminado correctamente');

        $this->assertDatabaseMissing('edificios', ['id' => $edificioId]);
    }

    public function test_muestra_las_aulas_del_edificio(): void
    {
        $edificio = Edificio::create(['nombre' => 'Edificio C']);
        $aula = new Aula(['nombre' => 'C4']);
        $aula->capacidad = 30;
        $aula->wifi = true;
        $edificio->aulas()->save($aula);

        $this->getJson("/api/edificios/{$edificio->id}")
            ->assertOk()
            ->assertJsonPath('aulas.0.nombre', 'C4')
            ->assertJsonPath('aulas.0.edificio_id', $edificio->id);
    }

    public function test_el_nombre_del_edificio_es_obligatorio(): void
    {
        $this->postJson('/api/edificios', [])
            ->assertUnprocessable()
            ->assertJsonValidationErrors('nombre');
    }
}
