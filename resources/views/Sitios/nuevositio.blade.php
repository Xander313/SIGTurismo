@extends('layout.app')

@section('contenido')
<div class="d-flex justify-content-center align-items-center flex-column">
    <h1 class="mb-4">Registrar Nuevo Sitio</h1>

    <div class="card p-4 shadow" style="width: 50%;">
        <form action="{{ route('sitios.store') }}" method="post" enctype="multipart/form-data">
            @csrf

            <label><b>Nombre:</b></label>
            <input type="text" name="nombre" class="form-control" required> <br>

            <label><b>Descripción:</b></label>
            <textarea name="descripcion" class="form-control"></textarea> <br>

            <label><b>Categoría:</b></label>
            <input type="text" name="categoria" class="form-control" required> <br>

            <label><b>Imagen:</b></label>
            <input type="file" name="imagen" class="form-control"> <br>

            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
</div>
@endsection
