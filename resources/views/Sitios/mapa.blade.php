@extends('layout.app')

@section('content')



<div style="display:flex; width:100%; height:auto; flex-direction:column; justify-content:center; gap:15px; padding:15px;">
    <h1 style="font-size:1.5rem;">Mapa de Sitios Turísticos para la categoría: {{$categoria}}</h1>
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

    }
    //window.onload = initMap;

</script>

@endsection
