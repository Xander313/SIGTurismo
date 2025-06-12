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
            <input type="text" name="categoria" id="categoria" class="form-control" required> <br>

            <label><b>Imagen:</b></label>
            <input type="file" name="imagen" id="imagen" class="form-control"> <br>

            <label><b>Latitud:</b></label>
            <input readonly type="text" name="latitud" id="latitud" class="form-control"> <br>

            <label><b>Longitud:</b></label>
            <input readonly type="text" name="longitud" id="longitud" class="form-control"> <br>

            <div id="mapa_cliente" class="mt-3" style="border:1px solid black; height:250px;"></div>

            <br>
            <div class="text-center">
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function initMap() {
        var latitud = -0.9374805;
        var longitud = -78.6161327;

        var latitud_longitud = new google.maps.LatLng(latitud, longitud);
        var mapa = new google.maps.Map(document.getElementById('mapa_cliente'), {
            center: latitud_longitud,
            zoom: 7,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var marcador = new google.maps.Marker({
            position: latitud_longitud,
            map: mapa,
            title: "Seleccione la dirección",
            draggable: true
        });

        google.maps.event.addListener(marcador, 'dragend', function(event) {
            document.getElementById("latitud").value = this.getPosition().lat();
            document.getElementById("longitud").value = this.getPosition().lng();
        });
    }
    window.onload = initMap;
</script>

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
            }
        },
        messages: {
            nombre: {
                required: "El nombre del sitio turístico es requerido",
                minlength: "El nombre del sitio turístico no puede tener menos de 2 letras",
                maxlength: "El nombre del sitio turístico no puede tener más de 100 letras"
            },
            descripcion: {
                required: "La descripción del sitio turístico es requerida",
                minlength: "La descripción del sitio turístico no puede tener menos de 10 letras",
                maxlength: "La descripción del sitio turístico no puede tener más de 1000 letras"
            },
            categoria: {
                required: "La categoría del sitio turístico es requerida"
            },
            imagen: {
                required: "Debe subir una imagen del sitio turístico",
                extension: "Solo se permiten imágenes en formato jpg, jpeg, png, gif"
            }
        },
        submitHandler: function(form) {
            form.submit();
        }
    });
</script>

@endsection
