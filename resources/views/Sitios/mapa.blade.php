@extends('layout.app')

@section('content')

<br>
<h1>Mapa de Sitios Turísticos</h1>
<br>
<div id="mapa-sitios" style="border:2px solid black; height:500px; width:100%;"></div>

<br>
<div class="text-center">
    <a href="{{ route('sitios.index') }}" class="btn btn-outline-secondary">
        <i class="fa fa-arrow-left"></i> Volver
    </a>
</div>


    <div class="text-center">
        <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalBusqueda">
            <i class="fa fa-globe"></i> Volver a ultilizar Filtro avanzado del mapa
        </a>
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
                    <form id="formBusqueda" style="display:flex; flex-direction:column; gap:10px;">
                        <label for="buscar">Sitio a buscar por categoria:</label>

                        <select name="categoria" id="categoria" class="form-control">
                            <option value="cultural" selected>Cultural</option>
                            <option value="natural">Natural</option>
                            <option value="historico">Histórico</option>
                            <option value="arquitectonico">Arquitectónico</option>
                            <option value="gastronomico">Gastronómico</option>
                            <option value="aventura">Aventura</option>
                        </select>                        
                        
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary">Buscar sitios</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<script>
document.getElementById("formBusqueda").addEventListener("submit", function(event) {
    event.preventDefault();

    let query = document.getElementById("categoria").value;

    if (!query) {
        alert("Por favor, selecciona una categoría válida.");
        return;
    }

    window.location.href = `/sitios/mapa?buscar=${encodeURIComponent(query)}`;
});


</script>


<script type="text/javascript">
    function initMap() {
        var latitud = -0.9374805;
        var longitud = -78.6161327;

        var latitud_longitud = new google.maps.LatLng(latitud, longitud);
        var mapa = new google.maps.Map(document.getElementById('mapa-sitios'), {
            center: latitud_longitud,
            zoom: 7,
            mapTypeId: google.maps.MapTypeId.ROADMAP
        });

        var sitios = @json($sitios); // Convertir datos PHP a JSON para JavaScript

        sitios.forEach(sitio => {
            var coordenadasSitio = new google.maps.LatLng(sitio.latitud, sitio.longitud);
            var marcador = new google.maps.Marker({
                position: coordenadasSitio,
                map: mapa,
                icon: {
                    url: 'https://static.vecteezy.com/system/resources/previews/059/918/232/non_2x/vibrant-minimalist-three-quarter-portrait-angled-portrait-exclusive-free-png.png',
                    scaledSize: new google.maps.Size(40, 40)
                },
                title: sitio.nombre,
                draggable: false
            });

            var infoWindow = new google.maps.InfoWindow({
                content: `<strong>${sitio.nombre}</strong><br>${sitio.descripcion}`
            });

            marcador.addListener("click", () => {
                infoWindow.open(mapa, marcador);
            });
        });
    }
    window.onload = initMap;
</script>

@endsection
