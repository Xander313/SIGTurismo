@extends('layout.app')

@section('content')
<div class="p-4">
  <h1 class="mb-4">Mapa Rápido para agregar Sitios Turísticos</h1>
  <div id="mapa-sitios"
       style="width:100%; height:600px; border:2px solid #000; box-shadow:0 0 10px rgba(0,0,0,0.3);">
  </div>
</div>

<script>
  let marcador;

  function initMap() {
    const centro = { lat: -0.9374805, lng: -78.6161327 };
    const mapa = new google.maps.Map(document.getElementById('mapa-sitios'), {
      center: centro,
      zoom: 7,
      mapTypeId: google.maps.MapTypeId.ROADMAP
    });

    mapa.addListener('click', function(e) {
      const lat = e.latLng.lat().toFixed(6);
      const lng = e.latLng.lng().toFixed(6);

      if (marcador) {
        marcador.setPosition(e.latLng);
      } else {
        marcador = new google.maps.Marker({
          position: e.latLng,
          map: mapa,
          title: "Ubicación seleccionada"
        });
      }

      setTimeout(() => {
        window.location.href = `{{ route('sitios.nuevorapido') }}?lat=${lat}&lng=${lng}`;
      }, 600);
    });
  }

  window.initMap = initMap;
</script>
@endsection
