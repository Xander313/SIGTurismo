<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Sitio;

class SitioController extends Controller
{
    public function index()
    {
        session()->forget(['success', 'error']); 
        $sitios = Sitio::all();
        return view('Sitios.index', compact('sitios'));
    }


    public function mapa(Request $request)
    {
        $valorBusqueda = $request->input('buscar'); 
        $tipoBusqueda = $request->input('tipoBusqueda');

        if ($tipoBusqueda === "categoria") {
            $sitios = Sitio::where('categoria', $valorBusqueda)->get();
        } elseif ($tipoBusqueda === "nombre") {
            $sitios = Sitio::where('nombre', 'LIKE', "%{$valorBusqueda}%")->get(); 
        } else {
            $sitios = collect(); 
        }

        if ($sitios->isEmpty()) {
            session()->flash('error', strip_tags('No se encontraron sitios con la búsqueda seleccionada.'));
        } else {
            session()->flash('success', strip_tags('Sitios encontrados correctamente.'));
        }

        return view('Sitios.mapa', compact('sitios', 'valorBusqueda', 'tipoBusqueda'));
    }

    public function maparapido()
    {
        $sitios = Sitio::all(); 
        return view('Sitios.maparapido', compact('sitios'));
    }

    public function galeria()
    {
        $sitios = Sitio::whereNotNull('imagen')->take(10)->get();
        return view('Sitios.galeria', compact('sitios'));
    }

    public function create()
    {
        return view('Sitios.nuevositio');
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
            $request->file('imagen')->move(public_path('imagen/'), $nombreArchivo);
            $datos['imagen'] = 'imagen/' . $nombreArchivo; // Ruta relativa a public
        }


        Sitio::create($datos);
        return redirect()->route('sitios.index')->with('success', 'Sitio creado correctamente.');
    }

    public function edit(string $id)
    {
        $sitio = Sitio::findOrFail($id);
        return view('Sitios.editarsitio', compact('sitio'));
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

        // Si se sube una nueva imagen, eliminar la anterior y guardar la nueva
        if ($request->hasFile('imagen')) {
            if ($sitio->imagen && file_exists(public_path($sitio->imagen))) {
                unlink(public_path($sitio->imagen)); // Borra la imagen anterior
            }

            $nombreArchivo = time() . '_' . $request->file('imagen')->getClientOriginalName();
            $request->file('imagen')->move(public_path('imagen/'), $nombreArchivo);
            $datos['imagen'] = 'imagen/' . $nombreArchivo;
        }

        $sitio->update($datos);
        return redirect()->route('sitios.index')->with('success', 'Sitio actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $sitio = Sitio::findOrFail($id);

        // Si el sitio tiene imagen, eliminarla del servidor
        if ($sitio->imagen && file_exists(public_path($sitio->imagen))) {
            unlink(public_path($sitio->imagen));
        }

        $sitio->delete();
        return redirect()->route('sitios.index')->with('success', 'Sitio eliminado correctamente.');
    }

}
