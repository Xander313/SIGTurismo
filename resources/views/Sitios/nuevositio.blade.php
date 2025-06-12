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

                <div id="errorCoordenadas" class="text-danger mt-2 text-center" style="display:none;">
                    No ha seleccionado la coordenada en el mapa.
                </div>

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
    transition: all 0.4s ease-in-out;
}

.inputs {
    display: none;
    width: 100%;
    text-align: center;
    transition: all 0.4s ease-in-out;
}

#errorCoordenadas {
    margin-top: 10px;
    font-size: 0.95rem;
    min-height: 24px;
    color: #dc3545;
    display: none;
}

/* Estilo cuando los inputs están visibles */
.elementosGeoespaciales.mostrar-coordenadas {
    flex-direction: row;
    justify-content: space-between;
    align-items: flex-start;
}

.elementosGeoespaciales.mostrar-coordenadas .mapa {
    width: 50%;
}

.elementosGeoespaciales.mostrar-coordenadas .inputs {
    display: block;
    width: 48%;
}
</style>

<script>
function alternarCoordenadas(mostrar = null) {
    const contenedor = document.querySelector(".elementosGeoespaciales");
    const boton = document.getElementById("toggleButton");
    const errorMsg = document.getElementById("errorCoordenadas");

    // Si se pasa un parámetro mostrar, forzar ese estado
    if (mostrar !== null) {
        if (mostrar) {
            contenedor.classList.add("mostrar-coordenadas");
            boton.textContent = "Ocultar coordenadas";
            errorMsg.style.display = "none";
        } else {
            contenedor.classList.remove("mostrar-coordenadas");
            boton.textContent = "Ver coordenadas";
        }
        return;
    }

    // Comportamiento normal de alternar
    if (contenedor.classList.contains("mostrar-coordenadas")) {
        contenedor.classList.remove("mostrar-coordenadas");
        boton.textContent = "Ver coordenadas";
    } else {
        contenedor.classList.add("mostrar-coordenadas");
        boton.textContent = "Ocultar coordenadas";
        errorMsg.style.display = "none";
    }
}
</script>

<script>
    function initMap() {
        var latitud = -0.9374805;
        var longitud = -78.6161327;

        var latlng = new google.maps.LatLng(latitud, longitud);
        var mapa = new google.maps.Map(document.getElementById('mapa_cliente'), {
            center: latlng,
            zoom: 6,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var marcador = new google.maps.Marker({
            position: latlng,
            map: mapa,
            title: "Haga clic para seleccionar una ubicación",
            draggable: true
        });

        mapa.addListener('click', function(event) {
            marcador.setPosition(event.latLng);
            actualizarCoordenadas(event.latLng.lat(), event.latLng.lng());
        });

        marcador.addListener('dragend', function(event) {
            actualizarCoordenadas(event.latLng.lat(), event.latLng.lng());
        });

        function actualizarCoordenadas(lat, lng) {
            document.getElementById("latitud").value = lat;
            document.getElementById("longitud").value = lng;
            document.getElementById("errorCoordenadas").style.display = "none";
        }
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
$.validator.setDefaults({
    ignore: []
});

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
            required: "Debe seleccionar una latitud"
        },
        longitud: {
            required: "Debe seleccionar una longitud"
        }
    },
    submitHandler: function(form) {
        const lat = $("#latitud").val();
        const lng = $("#longitud").val();

        if (!lat || !lng) {
            // Mostrar los inputs si están ocultos
            alternarCoordenadas(true);
            
            $("#errorCoordenadas").css("display", "block");

            $('html, body').animate({
                scrollTop: $("#errorCoordenadas").offset().top - 50
            }, 500);

            return false;
        } else {
            $("#errorCoordenadas").css("display", "none");
            form.submit();
        }
    },
    invalidHandler: function(event, validator) {
        // Verificar si los errores son de latitud/longitud
        const errors = validator.numberOfInvalids();
        if (errors && (validator.invalid.latitud || validator.invalid.longitud)) {
            alternarCoordenadas(true);
            
            $('html, body').animate({
                scrollTop: $(".elementosGeoespaciales").offset().top - 50
            }, 500);
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