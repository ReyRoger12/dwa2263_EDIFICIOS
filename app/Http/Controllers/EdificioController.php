<?php

namespace App\Http\Controllers;

use App\Models\Edificio;
use Illuminate\Http\Request;

class EdificioController extends Controller
{
    public function index()
    {
        return response()->json(Edificio::with('aulas')->get());
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
        ]);

        $edificio = Edificio::create($datos);

        return response()->json($edificio, 201);
    }

    public function show(Edificio $edificio)
    {
        return response()->json($edificio->load('aulas'));
    }

    public function update(Request $request, Edificio $edificio)
    {
        $datos = $request->validate([
            'nombre' => ['required', 'string', 'max:255'],
        ]);

        $edificio->update($datos);

        return response()->json($edificio);
    }

    public function destroy(Edificio $edificio)
    {
        $edificio->delete();

        return response()->json([
            'mensaje' => 'Edificio eliminado correctamente',
        ]);
    }
}
