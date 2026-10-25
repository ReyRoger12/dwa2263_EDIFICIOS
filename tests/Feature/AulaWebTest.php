<?php

namespace Tests\Feature;

use App\Models\Aula;
use App\Models\Edificio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AulaWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_crear_actualizar_y_eliminar_un_aula(): void
    {
        $edificio = Edificio::create(['nombre' => 'Edificio C']);

        $this->post('/aulas', [
            'nombre' => 'C4',
            'capacidad' => 30,
            'wifi' => 1,
            'edificio_id' => $edificio->id,
        ])->assertRedirect(route('aulas.index'));

        $aula = Aula::firstOrFail();

        $this->put("/aulas/{$aula->id}", [
            'nombre' => 'C5',
            'capacidad' => 35,
            'edificio_id' => $edificio->id,
        ])->assertRedirect(route('aulas.index'));

        $this->assertDatabaseHas('aulas', [
            'id' => $aula->id,
            'nombre' => 'C5',
            'capacidad' => 35,
            'wifi' => false,
            'edificio_id' => $edificio->id,
        ]);

        $this->delete("/aulas/{$aula->id}")
            ->assertRedirect(route('aulas.index'));

        $this->assertDatabaseMissing('aulas', ['id' => $aula->id]);
    }

    public function test_maneja_un_aula_que_ya_no_existe(): void
    {
        $this->delete('/aulas/999')
            ->assertRedirect(route('aulas.index'))
            ->assertSessionHas('error', 'El aula ya había sido eliminada.');

        $this->get('/aulas/999/edit')
            ->assertRedirect(route('aulas.index'))
            ->assertSessionHas('error', 'El aula solicitada ya no existe.');
    }

    public function test_valida_los_datos_del_aula(): void
    {
        $this->post('/aulas', [
            'nombre' => '',
            'capacidad' => 0,
            'edificio_id' => 999,
        ])->assertSessionHasErrors(['nombre', 'capacidad', 'edificio_id']);

        $this->assertDatabaseCount('aulas', 0);
    }
}
