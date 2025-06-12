@extends('layout.app')
@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Listado de Sitios Turísticos</h1>

    <div class="text-end mb-3">
        <a href="{{ route('sitios.maparapido') }}" class="btn btn-outline-warning me-2">
            <i class="fa fa-bolt"></i> Mapa Rápido
        </a>
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
                'excel',
                'pdf',
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
