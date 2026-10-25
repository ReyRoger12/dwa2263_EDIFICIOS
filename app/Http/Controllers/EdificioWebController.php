<?php

namespace App\Http\Controllers;

use App\Models\Edificio;
use Illuminate\Http\Request;

class EdificioWebController extends Controller
{
    public function index()
    {
        $edificios = Edificio::withCount('aulas')->orderBy('nombre')->get();

        return view('edificio.listado', compact('edificios'));
    }

    public function create()
    {
        return view('edificio.agregar');
    }

    public function store(Request $request)
    {
        Edificio::create($this->validateEdificio($request));

        return redirect()
            ->route('panel.edificios.index')
            ->with('success', 'Edificio agregado correctamente.');
    }

    public function edit(int $id)
    {
        $edificio = Edificio::find($id);

        if (! $edificio) {
            return redirect()
                ->route('panel.edificios.index')
                ->with('error', 'El edificio solicitado ya no existe.');
        }

        return view('edificio.modificar', compact('edificio'));
    }

    public function update(Request $request, int $id)
    {
        $edificio = Edificio::find($id);

        if (! $edificio) {
            return redirect()
                ->route('panel.edificios.index')
                ->with('error', 'El edificio que intentas actualizar ya no existe.');
        }

        $edificio->update($this->validateEdificio($request));

        return redirect()
            ->route('panel.edificios.index')
            ->with('success', 'Edificio actualizado correctamente.');
    }

    public function destroy(int $id)
    {
        $edificio = Edificio::find($id);

        if (! $edificio) {
            return redirect()
                ->route('panel.edificios.index')
                ->with('error', 'El edificio ya había sido eliminado.');
        }

        $nombre = $edificio->nombre;
        $edificio->delete();

        return redirect()
            ->route('panel.edificios.index')
            ->with('success', "El edificio {$nombre} fue eliminado.");
    }

    private function validateEdificio(Request $request): array
    {
        return $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
        ], [
            'nombre.required' => 'Escribe el nombre del edificio.',
        ]);
    }
}
