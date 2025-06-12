@extends('layout.app')

@section('content')

<div class="d-flex justify-content-center align-items-center flex-column">
    <h1 class="mb-4">Registrar Nuevo Sitio</h1>

    <div class="card p-4 shadow" style="width: 70%;">
        <form action="{{ route('sitios.store') }}" id="FormRegistro" method="post" enctype="multipart/form-data" style="display:flex; flex-direction:column; gap:10px;">
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
            <div class="elementosGeoespaciales">
                <label><b>Referencia Geoespacial:</b></label>
                <div id="mapa_cliente" class="mapa mt-3" style="border:1px solid black; height:350px;"></div>
                <br>
                <button type="button" class="btn btn-info" id="toggleButton" onclick="alternarCoordenadas()">Ver coordenadas</button>

                <div class="inputs">
                    <label><b>Latitud:</b></label>
                    <input readonly type="text" name="latitud" id="latitud" class="form-control">
                    <br>
                    <label><b>Longitud:</b></label>
                    <input readonly type="text" name="longitud" id="longitud" class="form-control">
                </div>
            </div>


            <br>
            <div class="text-center">
                <button type="submit" class="btn btn-outline-success">
                    <i class="fa fa-save"></i> Guardar
                </button>
                &nbsp;&nbsp;&nbsp;&nbsp;
                <a href="{{ route('sitios.index') }}" class="btn btn-outline-danger">
                    <i class="fa fa-times"></i> Cancelar
                </a>
            </div>
        </form>
    </div>
</div>


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

<SCript>
    $("#categoria").rules("add", {
        required: true,
        messages: {
            required: "Selecciona una opción antes de enviar"
        }
    });
</SCript>

@endsection
