<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sitio;

class SitioController extends Controller
{
    public function index()
    {
        $sitios = Sitio::all();
        return view('Sitios.index', compact('sitios'));
    }

    public function mapa()
    {
        $sitios = Sitio::all();
        return view('sitios.mapa', compact('sitios'));
    }

    public function create()
    {
        return view('sitios.nuevositio');
    }

    public function store(Request $request)
    {
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        // Subir imagen
        if ($request->hasFile('imagen')) {
            $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(resource_path('img/'), $nombreArchivo);
            $datos['imagen'] = 'resources/img/' . $nombreArchivo;
        }

        Sitio::create($datos);
        return redirect()->route('sitios.index')->with('message', 'Sitio creado correctamente.');
    }

    public function edit(string $id)
    {
        $sitio = Sitio::findOrFail($id);
        return view('sitios.editarsitio', compact('sitio'));
    }

    public function update(Request $request, string $id)
    {
        $sitio = Sitio::findOrFail($id);
        
        $datos = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'categoria' => 'required|string|max:255',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'latitud' => 'required|numeric',
            'longitud' => 'required|numeric',
        ]);

        // Subir nueva imagen
        if ($request->hasFile('imagen')) {
            $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(resource_path('img/'), $nombreArchivo);
            $datos['imagen'] = 'resources/img/' . $nombreArchivo;
        }

        $sitio->update($datos);
        return redirect()->route('sitios.index')->with('message', 'Sitio actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        Sitio::findOrFail($id)->delete();
        return redirect()->route('sitios.index')->with('message', 'Sitio eliminado correctamente.');
    }
}
