@extends('layout.app')

@section('content')

<div class="d-flex justify-content-center align-items-center flex-column">
    <h1 class="mb-4">Registrar Nuevo Sitio</h1>

    <div class="card p-4 shadow" style="width: 50%;">
        <form action="{{ route('sitios.store') }}" id="FormRegistro" method="post" enctype="multipart/form-data">
            @csrf

            <label><b>Nombre:</b></label>
            <input type="text" name="nombre" id="nombre" class="form-control" required> <br>

            <label><b>Descripción:</b></label>
            <textarea name="descripcion" id="descripcion" class="form-control"></textarea> <br>

            <label><b>Categoría:</b></label>
            <input type="text" name="categoria" id="categoria"  class="form-control" required> <br>

            <label><b>Imagen:</b></label>
            <input type="file" name="imagen" id="imagen" class="form-control"> <br>

      <div class="" id="mapa_cliente" style="border:1px solid black; height:250px;
            width:100%"> </div>
            <button type="submit" class="btn btn-success">Guardar</button>
        </form>
    </div>
</div>



<script>
    $("#imagen").fileinput({
        language: "es",
        allowedFileExtensions: ["png", "jpg", "jpeg"],
        showCaption: false,
        dropZoneEnabled: true,
        showClose: false
    });
</script>


<script>
    
    $("#FormRegistro").validate({
        rules: {
            nombre: {
                required: true,
                min: 2,
                max: 100
            },
            descripcion: {
                required: true,
                min: 10,
                max: 1000
            },
            categoria: {
                required: true
            },
            //observaciones: {
            //    required: true,
            //    min: 10,
            //    max: 100
//
            //},
            imagen: {
                required: true,
                extension: "jpg|jpeg|png|gif"
            }
        },
        messages: {
            nombre: {
                required: "El nombre del sitio turístico es requerido",
                min: "El nombre del sitio turístico no puede tener nemos de 2 letras",
                max: "El nombre del sitio turístico no puede tenre más de 100 letras"
            },
            descripcion: {
                required: "La descripción del sitio turístico es requerido",
                min: "La descripción del sitio turístico no puede tener menos de 10 letra",
                max: "La descripción del sitio turístico no puede tener más de 1000 letras"
            },
            categoria: {
                required: "La categoria del sitio turístico es requerido"

            },
            //observaciones: {
            //    required: "La observación del sitio turístico es requerido",
            //    min: "La observación del sitio turístico no puede tener menos de 10 letras",
            //    max: "La observación del sitio turístico no puede tener más de 1000 letras."
            //},
            imagen: {
                required: "Debe subir la imagen del sitio turísticos",
                extension: "Solo se permiten imágenes: jpg, jpeg, png, gif"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>

@endsection
