@extends('layout.app')

@section('content')



<div style="display:flex; width:100%; height:auto; flex-direction:column; justify-content:center; gap:15px; padding:15px;">
    <h1 style="font-size:2rem;">
        Mapa de Sitios Turísticos para 
        {{ $tipoBusqueda === 'categoria' ? 'la categoría' : 'el nombre' }}: 
        {{ $valorBusqueda }}
    </h1>
    <div style="display:flex; width:100%; justify-content:right; gap:15px; padding:15px;">
        <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalBusqueda">
            <i class="fa fa-search"></i> Volver a utilizar Filtro avanzado del mapa
        </a>
        <a href="{{ route('sitios.index') }}" class="btn btn-outline-secondary">
            <i class="fa fa-arrow-left"></i> Volver al administrador
        </a>
    </div>

    <div id="mapa-sitios" style="border:2px solid black; height:500px; width:100%; box-shadow: 0 0 10px 0 black; padding:15px;"></div>
</div>

    
   <!-- Modal -->
<div class="modal fade" id="modalBusqueda" tabindex="-1" aria-labelledby="modalBusquedaLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalBusquedaLabel">Buscar Sitios Turísticos</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <div class="text-center">
                    <button type="button" id="btnBuscarCategoria" class="btn btn-info">Buscar por Categoría</button>
                    <button type="button" id="btnBuscarNombre" class="btn btn-secondary">Buscar por Nombre</button>
                </div>
                <br>
                <form id="formBusqueda" style="display:flex; flex-direction:column; gap:10px;">
                    
                    <div id="categoriaContainer" style="display:none;">
                        <label for="categoria">Seleccione una categoría:</label>
                        <br>
                        <select name="categoria" id="categoria" class="form-control">
                            <option value="cultural" selected>Cultural</option>
                            <option value="natural">Natural</option>
                            <option value="historico">Histórico</option>
                            <option value="arquitectonico">Arquitectónico</option>
                            <option value="gastronomico">Gastronómico</option>
                            <option value="aventura">Aventura</option>
                        </select>
                    </div>

                    <div id="nombreContainer" style="display:none;">
                        <label for="nombre">Ingrese el nombre del sitio:</label>
                        <input type="text" name="nombre" id="nombre" class="form-control">
                    </div>
                    
                    <input type="hidden" name="tipoBusqueda" id="tipoBusqueda" value="categoria"> <!-- Tipo de búsqueda -->
                    
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Buscar sitios</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>




<script>
    document.getElementById("btnBuscarCategoria").addEventListener("click", function() {
        document.getElementById("categoriaContainer").style.display = "block";
        document.getElementById("nombreContainer").style.display = "none";
        document.getElementById("tipoBusqueda").value = "categoria"; // Indicamos el tipo de búsqueda
    });

    document.getElementById("btnBuscarNombre").addEventListener("click", function() {
        document.getElementById("categoriaContainer").style.display = "none";
        document.getElementById("nombreContainer").style.display = "block";
        document.getElementById("tipoBusqueda").value = "nombre"; // Indicamos el tipo de búsqueda
    });

    document.getElementById("formBusqueda").addEventListener("submit", function(event) {
        event.preventDefault();

        let tipoBusqueda = document.getElementById("tipoBusqueda").value;
        let valorBusqueda = tipoBusqueda === "categoria" 
            ? document.getElementById("categoria").value
            : document.getElementById("nombre").value.trim();

        if (valorBusqueda === "") {
            alert("Por favor, ingresa un valor para buscar.");
            return;
        }

        window.location.href = `/sitios/mapa?buscar=${encodeURIComponent(valorBusqueda)}&tipoBusqueda=${encodeURIComponent(tipoBusqueda)}`;
    });

</script> 


<script type="text/javascript">
    let mapa;

    function initMap() {
        var centro = { lat: -0.9374805, lng: -78.6161327 };

        mapa = new google.maps.Map(document.getElementById('mapa-sitios'), {
            center: centro,
            zoom: 7,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var sitios = @json($sitios); 

        sitios.forEach(sitio => {
            var posicion = { lat: parseFloat(sitio.latitud), lng: parseFloat(sitio.longitud) };
            var imagenUrl = sitio.imagen ? `/${sitio.imagen}` : '/imagen/default.png';

            
            var marcador = new google.maps.Marker({
                position: posicion,
                map: mapa,
                icon: {
                    url: imagenUrl,
                    scaledSize: new google.maps.Size(35, 35)
                },
                title: sitio.nombre
            });

            
            var infoWindow = new google.maps.InfoWindow({
                content: `
                    <strong>${sitio.nombre}</strong><br>
                    ${sitio.descripcion}<br>
                    <img src="${imagenUrl}" width="100" height="100">
                `
            });

            marcador.addListener("click", function () {
                infoWindow.open(mapa, marcador);
            });
        });
        window.initMap = initMap;
    }
    //window.onload = initMap;

</script>

@endsection
