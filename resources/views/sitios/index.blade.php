@extends('layout.app')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Listado de Sitios Turísticos</h1>

    @if(session('message'))
        <script>
            Swal.fire({
                title: "CONFIRMACIÓN",
                text: "{{ session('message') }}",
                icon: "success",
            });
        </script>
    @endif

    <div class="text-end mb-3">
        <a href="{{ route('sitios.create') }}" class="btn btn-outline-primary">
            <i class="fa fa-plus"></i> Nuevo Sitio
        </a>
        &nbsp;&nbsp;&nbsp;&nbsp;
        <a href="{{ route('sitios.mapa') }}" class="btn btn-outline-success">
            <i class="fa fa-map"></i> Ver Mapa Global
        </a>
    </div>

    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle">
            <thead class="table-dark">
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Categoría</th>
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Latitud</th>
                    <th>Longitud</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sitios as $sitio)
                    <tr>
                        <td>{{ $sitio->id }}</td>
                        <td>{{ $sitio->nombre }}</td>
                        <td>{{ $sitio->categoria }}</td>
                        <td>{{ $sitio->descripcion }}</td>
                        <td>
                            <img src="{{ asset($sitio->imagen) }}" width="80px" height="80px">
                        </td>
                        <td>{{ $sitio->latitud }}</td>
                        <td>{{ $sitio->longitud }}</td>
                        <td>
                            <!-- Botón Editar (Icono de lápiz) -->
                            <a href="{{ route('sitios.edit', $sitio->id) }}" class="btn btn-outline-warning btn-sm">
                                <i class="fa fa-pen"></i>
                            </a>

                            <!-- Botón Eliminar (Icono de basurero) -->
                            <form action="{{ route('Sitios.destroy', $sitio->id) }}" method="POST" style="display:inline;" class="form-eliminar">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-outline-danger btn-sm btn-eliminar">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.btn-eliminar').forEach(button => {
            button.addEventListener('click', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro de eliminar este sitio?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    });
</script>
@endsection
