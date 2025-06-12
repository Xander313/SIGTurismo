@extends('layout.app')

@section('content')

<div class="p-4">
  <h1 class="mb-4">Mapa Rápido para agregar Sitios Turísticos</h1>
  <div id="mapa-sitios" style="width:100%; height:600px; border:2px solid #000; box-shadow:0 0 10px rgba(0,0,0,0.3);"></div>
</div>

<script>
    function initMap() {
        var latitud = -0.9374805;
        var longitud = -78.6161327;

        var latlng = new google.maps.LatLng(latitud, longitud);
        var mapa = new google.maps.Map(document.getElementById('mapa-sitios'), {
            center: latlng,
            zoom: 7,
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

@endsection
