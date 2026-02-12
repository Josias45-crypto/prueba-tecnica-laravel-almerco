@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Todos los Emails del Sistema</h4>
                </div>

                <div class="card-body">
                    <!-- Tabla -->
                    <div class="table-responsive">
                        <table id="emailsTable" class="table table-striped table-bordered">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Usuario</th>
                                    <th>Asunto</th>
                                    <th>Destinatario</th>
                                    <th>Estado</th>
                                    <th>Fecha</th>
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
    $('#emailsTable').DataTable({
        processing: true,
        serverSide: true,
        ajax: {
            url: "{{ route('emails.data') }}",
            type: "GET"
        },
        columns: [
            { data: 'id', name: 'id' },
            { data: 'usuario', name: 'usuario' },
            { data: 'asunto', name: 'asunto' },
            { data: 'destinatario', name: 'destinatario' },
            { data: 'estado', name: 'estado', orderable: false },
            { data: 'fecha', name: 'fecha' }
        ],
        order: [[0, 'desc']],
        pageLength: 10,
        language: {
            url: '//cdn.datatables.net/plug-ins/1.13.4/i18n/es-ES.json'
        }
    });
});
</script>
@endsection
