@extends('layout.app')

@section('content')

<div class="d-flex justify-content-center align-items-center flex-column">
    <h1 class="mb-4">Registrar Nuevo Sitio Rápido</h1>

    <div class="card p-4 shadow" style="width: 70%;">
        <form action="{{ route('sitios.store') }}" id="FormRapid" method="post" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:10px;">
            @csrf

            <label><b>Nombre:</b></label>
            <input type="text" name="nombre" id="nombre" class="form-control" required>

            <label><b>Descripción:</b></label>
            <textarea name="descripcion" id="descripcion" class="form-control"></textarea>

            <label><b>Categoría:</b></label>
            <select name="categoria" id="categoria" class="form-control">
                <option value="cultural" selected>Cultural</option>
                <option value="natural">Natural</option>
                <option value="historico">Histórico</option>
                <option value="arquitectonico">Arquitectónico</option>
                <option value="gastronomico">Gastronómico</option>
                <option value="aventura">Aventura</option>
            </select>

            <label><b>Imagen:</b></label>
            <input type="file" name="imagen" id="imagen" class="form-control"> 

            <label><b>Latitud:</b></label>
            <input readonly type="text" name="latitud" id="latitud" class="form-control" value="{{ old('latitud', $lat ?? '') }}">

            <label><b>Longitud:</b></label>
            <input readonly type="text" name="longitud" id="longitud" class="form-control" value="{{ old('longitud', $lng ?? '') }}">

            <br>

            <div class="text-center">
                <a href="{{ route('sitios.index') }}" class="btn btn-outline-danger">
                    <i class="fa fa-times"></i> Cancelar
                </a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-outline-success">
                    <i class="fa fa-save"></i> Guardar
                </button>
            </div>
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
    $.validator.setDefaults({
        ignore: []
    });

    $("#FormRapid").validate({
        rules: {
            nombre: {
                required: true,
                minlength: 2,
                maxlength: 100
            },
            descripcion: {
                required: true,
                minlength: 10,
                maxlength: 1000
            },
            categoria: {
                required: true
            },
            imagen: {
                required: true,
                extension: "jpg|jpeg|png|gif"
            },
            latitud: {
                required: true
            },
            longitud: {
                required: true
            }
        },
        messages: {
            nombre: {
                required: "El nombre del sitio turístico es requerido",
                minlength: "Debe tener al menos 2 caracteres",
                maxlength: "Máximo 100 caracteres"
            },
            descripcion: {
                required: "La descripción es requerida",
                minlength: "Debe tener al menos 10 caracteres",
                maxlength: "Máximo 1000 caracteres"
            },
            categoria: {
                required: "La categoría es requerida"
            },
            imagen: {
                required: "Debe subir una imagen",
                extension: "Formato permitido: jpg, jpeg, png, gif"
            },
            latitud: {
                required: "Debe contener latitud"
            },
            longitud: {
                required: "Debe contener longitud"
            }
        }
    });
</script>

<script>
    $("#categoria").rules("add", {
        required: true,
        messages: {
            required: "Selecciona una opción antes de enviar"
        }
    });
</script>

@endsection
