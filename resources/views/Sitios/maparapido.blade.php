@extends('layout.app')

@section('content')
<div class="p-4">
  <h1 class="mb-4">Mapa Rápido para agregar Sitios Turísticos</h1>
  <div id="mapa-sitios"
       style="width:100%; height:600px; border:2px solid #000; box-shadow:0 0 10px rgba(0,0,0,0.3);">
  </div>
</div>

<script>
  
  let mapa;
  let marcador;

  
  function initMap() {
    try {
      
      const centro = { lat: -0.9374805, lng: -78.6161327 };
      
      
      mapa = new google.maps.Map(document.getElementById('mapa-sitios'), {
        center: centro,
        zoom: 7,
        mapTypeId: 'roadmap',
        gestureHandling: 'cooperative',
        disableDefaultUI: false, 
        clickableIcons: false 
      });

      
      mapa.addListener('click', function(e) {
        
        if (marcador) {
          marcador.setMap(null);
        }

        
        marcador = new google.maps.Marker({
          position: e.latLng,
          map: mapa,
          animation: google.maps.Animation.DROP,
          title: "Ubicación seleccionada"
        });

        
        setTimeout(() => {
          window.location.href = `{{ route('sitios.nuevorapido') }}?lat=${e.latLng.lat().toFixed(6)}&lng=${e.latLng.lng().toFixed(6)}`;
        }, 600);
      });

      
      google.maps.event.addListenerOnce(mapa, 'tilesloaded', function() {
        console.log('Mapa completamente cargado');
      });

    } catch (error) {
      console.error('Error al inicializar el mapa:', error);
      
    }
  }

  function checkGoogleMaps() {
    if (window.google && window.google.maps) {
      initMap();
    } else {
      
      setTimeout(checkGoogleMaps, 200);
    }
  }

  
  document.addEventListener('DOMContentLoaded', function() {
    checkGoogleMaps();
  });

  
  if (document.readyState === 'complete') {
    checkGoogleMaps();
  }
</script>

@endsection
