@extends('layout.app')

@section('content')

<div class="d-flex justify-content-center align-items-center flex-column">
    <h1 class="mb-4">Editar Sitio Turístico</h1>

    <div class="card p-4 shadow" style="width: 70%;">
        <form action="{{ route('sitios.update', $sitio->id) }}" id="FormEditar" method="post" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:10px;">
            @csrf
            @method('PUT')

            <label><b>Nombre:</b></label>
            <input type="text" name="nombre" id="nombre" class="form-control" value="{{ $sitio->nombre }}" required>

            <label><b>Descripción:</b></label>
            <textarea name="descripcion" id="descripcion" class="form-control">{{ $sitio->descripcion }}</textarea>

            <label><b>Categoría:</b></label>
            <select name="categoria" id="categoria" class="form-control">
                <option value="cultural" {{ $sitio->categoria == 'cultural' ? 'selected' : '' }}>Cultural</option>
                <option value="natural" {{ $sitio->categoria == 'natural' ? 'selected' : '' }}>Natural</option>
                <option value="historico" {{ $sitio->categoria == 'historico' ? 'selected' : '' }}>Histórico</option>
                <option value="arquitectonico" {{ $sitio->categoria == 'arquitectonico' ? 'selected' : '' }}>Arquitectónico</option>
                <option value="gastronomico" {{ $sitio->categoria == 'gastronomico' ? 'selected' : '' }}>Gastronómico</option>
                <option value="aventura" {{ $sitio->categoria == 'aventura' ? 'selected' : '' }}>Aventura</option>
            </select>

            <label><b>Imagen Actual:</b></label><br>
            <img src="{{ asset($sitio->imagen) }}" width="100px" height="100px"><br>

            <label><b>Subir Nueva Imagen:</b></label>
            <input type="file" name="imagen" id="imagen" class="form-control"> 

            <div class="elementosGeoespaciales">
                <label><b>Referencia Geoespacial:</b></label>
                <div id="mapa_cliente" class="mapa mt-3" style="border:1px solid black; height:350px;;"></div>
                <br>
                <button type="button" class="btn btn-info" id="toggleButton" onclick="alternarCoordenadas()">Ver coordenadas</button>

                <div class="inputs">
                    <label><b>Latitud:</b></label>
                    <input readonly type="text" name="latitud" id="latitud" class="form-control" value="{{ $sitio->latitud }}">
                    <br>
                    <label><b>Longitud:</b></label>
                    <input readonly type="text" name="longitud" id="longitud" class="form-control" value="{{ $sitio->longitud }}">
                </div>
            </div>

            <br>
            <div class="text-center">
                <a href="{{ route('sitios.index') }}" class="btn btn-outline-danger">
                    <i class="fa fa-times"></i> Cancelar
                </a>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <button type="submit" class="btn btn-outline-success">
                    <i class="fa fa-save"></i> Guardar Cambios
                </button>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    function initMap() {
        var latitud = parseFloat(document.getElementById("latitud").value) || -0.9374805;
        var longitud = parseFloat(document.getElementById("longitud").value) || -78.6161327;

        var latitud_longitud = new google.maps.LatLng(latitud, longitud);
        var mapa = new google.maps.Map(document.getElementById('mapa_cliente'), {
            center: latitud_longitud,
            zoom: 15,
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
<style>
.elementosGeoespaciales {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 100%;
}

.mapa {
    width: 100%;
    height: 250px;
    border: 1px solid black;
}

.inputs {
    display: none;
    width: 100%;
    text-align: center;
}
.mapa, .inputs {
    transition: all 0.4s ease-in-out; /* Suaviza el cambio de tamaño */
}

</style>


<script>
function alternarCoordenadas() {
    const mapa = document.querySelector(".mapa");
    const inputs = document.querySelector(".inputs");
    const contenedor = document.querySelector(".elementosGeoespaciales");
    const boton = document.getElementById("toggleButton");

    if (inputs.style.display === "none" || inputs.style.display === "") {
        // Mostrar coordenadas y ajustar diseño
        inputs.style.display = "block";
        inputs.style.width = "50%";
        mapa.style.width = "50%";
        boton.textContent = "Ocultar coordenadas";
        
        contenedor.style.display = "flex";
        contenedor.style.flexDirection = "row";
        contenedor.style.justifyContent = "space-between";
    } else {
        // Ocultar coordenadas y restaurar diseño original
        inputs.style.display = "none";
        mapa.style.width = "100%";
        boton.textContent = "Ver coordenadas";
        
        contenedor.style.display = "flex";
        contenedor.style.flexDirection = "column";
        contenedor.style.alignItems = "center";
    }
}



</script>



<script type="text/javascript">
    function initMap() {
        // Obtener la latitud y longitud del sitio
        var latitud = parseFloat(document.getElementById("latitud").value);
        var longitud = parseFloat(document.getElementById("longitud").value);

        // Si no hay coordenadas, usa valores por defecto
        if (isNaN(latitud) || isNaN(longitud)) {
            latitud = -0.9374805;
            longitud = -78.6161327;
        }

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

        // Actualizar coordenadas cuando el usuario arrastre el marcador
        google.maps.event.addListener(marcador, 'dragend', function(event) {
            document.getElementById("latitud").value = this.getPosition().lat();
            document.getElementById("longitud").value = this.getPosition().lng();
        });

        // Asegurar que el mapa se centre en la posición inicial
        mapa.setCenter(marcador.getPosition());
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
    $("#FormEditar").validate({
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
        },
        submitHandler: function(form) {
            form.submit();
        }

    });

</script>

<SCript>
    $("#categoria").rules("add", {
        required: true,
        messages: {
            required: "Selecciona una opción antes de enviar"
        }
    });
</SCript>

@endsection
