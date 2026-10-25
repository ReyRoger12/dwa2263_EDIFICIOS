<?php

namespace App\Http\Controllers;

use App\Models\Aula;
use App\Models\Edificio;
use Illuminate\Http\Request;

class AulaController extends Controller
{
    public function index()
    {
        $aulas = Aula::with('edificio')->orderBy('nombre')->get();
        $edificios = Edificio::withCount('aulas')->orderBy('nombre')->get();

        return view('aula.listado', compact('aulas', 'edificios'));
    }

    public function create()
    {
        $edificios = Edificio::orderBy('nombre')->get();

        return view('aula.agregar', compact('edificios'));
    }

    public function store(Request $request)
    {
        $datos = $this->validateAula($request);
        $datos['wifi'] = $request->boolean('wifi');

        Aula::create($datos);

        return redirect()
            ->route('aulas.index')
            ->with('success', 'Aula agregada correctamente.');
    }

    public function edit(int $id)
    {
        $aula = Aula::find($id);

        if (! $aula) {
            return redirect()
                ->route('aulas.index')
                ->with('error', 'El aula solicitada ya no existe.');
        }

        $edificios = Edificio::orderBy('nombre')->get();

        return view('aula.modificar', compact('aula', 'edificios'));
    }

    public function update(Request $request, int $id)
    {
        $aula = Aula::find($id);

        if (! $aula) {
            return redirect()
                ->route('aulas.index')
                ->with('error', 'El aula que intentas actualizar ya no existe.');
        }

        $datos = $this->validateAula($request);
        $datos['wifi'] = $request->boolean('wifi');
        $aula->update($datos);

        return redirect()
            ->route('aulas.index')
            ->with('success', 'Aula actualizada correctamente.');
    }

    public function destroy(int $id)
    {
        $aula = Aula::find($id);

        if (! $aula) {
            return redirect()
                ->route('aulas.index')
                ->with('error', 'El aula ya había sido eliminada.');
        }

        $nombre = $aula->nombre;
        $aula->delete();

        return redirect()
            ->route('aulas.index')
            ->with('success', "El aula {$nombre} fue eliminada.");
    }

    private function validateAula(Request $request): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
            'capacidad' => ['required', 'integer', 'min:1', 'max:500'],
            'wifi' => ['nullable', 'boolean'],
            'edificio_id' => ['required', 'exists:edificios,id'],
        ], [
            'nombre.required' => 'Escribe el nombre del aula.',
            'capacidad.required' => 'Indica la capacidad del aula.',
            'capacidad.integer' => 'La capacidad debe ser un número entero.',
            'capacidad.min' => 'La capacidad debe ser mayor a cero.',
            'capacidad.max' => 'La capacidad no puede ser mayor a 500.',
            'edificio_id.required' => 'Selecciona un edificio.',
            'edificio_id.exists' => 'El edificio seleccionado ya no existe.',
        ]);
    }
}
