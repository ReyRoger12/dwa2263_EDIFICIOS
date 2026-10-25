<?php

namespace Tests\Feature;

use App\Models\Aula;
use App\Models\Edificio;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EdificioWebTest extends TestCase
{
    use RefreshDatabase;

    public function test_puede_administrar_edificios_desde_el_menu(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee(route('panel.edificios.index'));

        $this->post('/edificios', ['nombre' => 'Edificio C'])
            ->assertRedirect(route('panel.edificios.index'));

        $edificio = Edificio::firstOrFail();

        $this->put("/edificios/{$edificio->id}", ['nombre' => 'Edificio C Norte'])
            ->assertRedirect(route('panel.edificios.index'));

        $this->assertDatabaseHas('edificios', [
            'id' => $edificio->id,
            'nombre' => 'Edificio C Norte',
        ]);

        $this->delete("/edificios/{$edificio->id}")
            ->assertRedirect(route('panel.edificios.index'));

        $this->assertDatabaseMissing('edificios', ['id' => $edificio->id]);
    }

    public function test_al_eliminar_un_edificio_tambien_elimina_sus_aulas(): void
    {
        $edificio = Edificio::create(['nombre' => 'Edificio C']);
        $aula = Aula::create([
            'nombre' => 'C4',
            'capacidad' => 30,
            'wifi' => true,
            'edificio_id' => $edificio->id,
        ]);

        $this->delete("/edificios/{$edificio->id}")
            ->assertRedirect(route('panel.edificios.index'));

        $this->assertDatabaseMissing('aulas', ['id' => $aula->id]);
    }

    public function test_controla_edificios_inexistentes_y_valida_el_nombre(): void
    {
        $this->delete('/edificios/999')
            ->assertRedirect(route('panel.edificios.index'))
            ->assertSessionHas('error', 'El edificio ya había sido eliminado.');

        $this->post('/edificios', [])
            ->assertSessionHasErrors('nombre');
    }
}
