@extends('layout.app')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Listado de Sitios Turísticos</h1>

    <div class="text-end mb-3">
        <a href="{{ route('sitios.create') }}" class="btn btn-outline-primary">
            <i class="fa fa-plus"></i> Nuevo Sitio
        </a>
        <a href="#" class="btn btn-outline-success" data-bs-toggle="modal" data-bs-target="#modalBusqueda">
            <i class="fa fa-search"></i> Filtro avanzado del mapa
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



    <div class="table-responsive">
        <table class="table table-striped table-bordered align-middle" id="tableSitios">
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
                            <form action="{{ route('sitios.destroy', $sitio->id) }}" method="POST" style="display:inline;" class="form-eliminar">
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
    $(document).ready(function() {
        let table = new DataTable('#tableSitios', {
            language: {
                url: 'https://cdn.datatables.net/plug-ins/2.3.1/i18n/es-ES.json'
            },
            dom: 'Bfrtip',
            buttons: [
                'copy',
                'csv',
                'e                            <a href="#" class="btn btn-sm btn-outline-secondary">
                                <i class="bi bi-link-45deg"></i>
                            </a>df',
                'print'
            ]
        });
    });

</script>





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
