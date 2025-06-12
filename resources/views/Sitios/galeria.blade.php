@extends('layout.app')

@section('content')
<section id="gallery" class="gallery section py-5">
    <div class="container" data-aos="fade-up" data-aos-delay="100">
        <h2 class="text-center mb-5">Bienvenido a la Galería</h2>
        <div class="row gy-4 justify-content-center">
            @foreach ($sitios as $sitio)
                <div class="col-xl-3 col-lg-4 col-md-6">
                    <div class="card shadow-sm rounded-4 border-0 h-100">
                        <img src="{{ asset($sitio->imagen) }}" class="card-img-top rounded-top-4" alt="{{ $sitio->nombre }}">
                        <div class="card-body text-center">
                            <h5 class="card-title">{{ $sitio->nombre }}</h5>
                            <p class="card-text text-muted small">{{ $sitio->descripcion }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 d-flex justify-content-center gap-3 pb-3">
                            <a href="{{ asset($sitio->imagen) }}" title="{{ $sitio->nombre }}" class="btn btn-sm btn-outline-primary glightbox" data-gallery="gallery">
                                <i class="bi bi-arrows-angle-expand">Expandir</i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
