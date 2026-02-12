@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Gestión de Usuarios</h4>
                    <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Nuevo Usuario
                    </a>
                </div>

                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            {{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Filtros -->
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Registros por página:</label>
                            <select id="perPage" class="form-select form-select-sm" style="width: auto; display: inline-block;">
                                <option value="10">10</option>
                                <option value="25">25</option>
                                <option value="50">50</option>
                                <option value="100">100</option>
                            </select>
                        </div>
                    </div>

                    <!-- Tabla -->
                    <div class="table-responsive">
                        <table id="usersTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Identificador</th>
                                    <th>Nombre</th>
                                    <th>Email</th>
                                    <th>Cédula</th>
                                    <th>Celular</th>
                                    <th>Fecha Nac.</th>
                                    <th>Edad</th>
                                    <th>Ciudad</th>
                                    <th>Estado</th>
                                    <th>País</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">

<!-- jQuery y DataTables JS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>

<script>
$(document).ready(function() {
    var table = $('#usersTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('admin.users.data') }}",
            type: "GET"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'identificador', name: 'identificador' },
            { data: 'nombre', name: 'nombre' },
            { data: 'email', name: 'email' },
            { data: 'cedula', name: 'cedula' },
            { data: 'numero_celular', name: 'numero_celular' },
            { data: 'fecha_nacimiento', name: 'fecha_nacimiento' },
            { data: 'edad', name: 'edad', orderable: false },
            { data: 'ciudad', name: 'ciudad', orderable: false },
            { data: 'estado', name: 'estado', orderable: false },
            { data: 'pais', name: 'pais', orderable: false },
            {
                data: 'id',
                orderable: false,
                searchable: false,
                render: function(data) {
                    return `
                        <a href="/admin/users/${data}/edit" class="btn btn-sm btn-warning">Editar</a>
                        <button onclick="deleteUser(${data})" class="btn btn-sm btn-danger">Eliminar</button>
                    `;
                }
            }
        ],
        pageLength: 10,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        }
    });

    // Cambiar registros por página
    $('#perPage').on('change', function() {
        table.page.len($(this).val()).draw();
    });
});

// Función para eliminar usuario
function deleteUser(id) {
    if(confirm('¿Estás seguro de eliminar este usuario?')) {
        // Crear formulario dinámico para DELETE
        let form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/users/' + id;
        
        let csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        
        let methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        
        form.appendChild(csrfInput);
        form.appendChild(methodInput);
        document.body.appendChild(form);
        form.submit();
    }
}
</script>
@endsection
