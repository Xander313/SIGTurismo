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
