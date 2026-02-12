@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Crear Nuevo Usuario</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.store') }}">
                        @csrf

                        <!-- Identificador -->
                        <div class="mb-3">
                            <label for="identificador" class="form-label">Identificador <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('identificador') is-invalid @enderror" 
                                   id="identificador" name="identificador" value="{{ old('identificador') }}" required>
                            @error('identificador')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                   id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password" required>
                            <small class="text-muted">Mínimo 8 caracteres, debe contener: 1 número, 1 mayúscula, 1 carácter especial</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Contraseña <span class="text-danger">*</span></label>
                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                        </div>

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="nombre" class="form-label">Nombre Completo <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nombre') is-invalid @enderror" 
                                   id="nombre" name="nombre" value="{{ old('nombre') }}" maxlength="100" required>
                            @error('nombre')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Número Celular -->
                        <div class="mb-3">
                            <label for="numero_celular" class="form-label">Número Celular (opcional)</label>
                            <input type="text" class="form-control @error('numero_celular') is-invalid @enderror" 
                                   id="numero_celular" name="numero_celular" value="{{ old('numero_celular') }}" maxlength="9">
                            @error('numero_celular')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        

                        <!-- Cédula -->
                        <div class="mb-3">
                            <label for="cedula" class="form-label">Cédula <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('cedula') is-invalid @enderror" 
                                   id="cedula" name="cedula" value="{{ old('cedula') }}" maxlength="11" required>
                            @error('cedula')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Fecha de Nacimiento -->
                        <div class="mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento <span class="text-danger">*</span></label>
                            <input type="date" class="form-control @error('fecha_nacimiento') is-invalid @enderror" 
                                   id="fecha_nacimiento" name="fecha_nacimiento" value="{{ old('fecha_nacimiento') }}" required>
                            @error('fecha_nacimiento')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- País -->
                        <div class="mb-3">
                            <label for="country_id" class="form-label">País <span class="text-danger">*</span></label>
                            <select class="form-select @error('country_id') is-invalid @enderror" id="country_id" name="country_id" required>
                                <option value="">Seleccione un país</option>
                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ old('country_id') == $country->id ? 'selected' : '' }}>
                                        {{ $country->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Estado -->
                        <div class="mb-3">
                            <label for="state_id" class="form-label">Estado/Departamento <span class="text-danger">*</span></label>
                            <select class="form-select @error('state_id') is-invalid @enderror" id="state_id" name="state_id" required disabled>
                                <option value="">Primero seleccione un país</option>
                            </select>
                            @error('state_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Ciudad -->
                        <div class="mb-3">
                            <label for="city_id" class="form-label">Ciudad <span class="text-danger">*</span></label>
                            <select class="form-select @error('city_id') is-invalid @enderror" id="city_id" name="city_id" required disabled>
                                <option value="">Primero seleccione un estado</option>
                            </select>
                            @error('city_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Crear Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
$(document).ready(function() {
    // Cuando cambia el país, cargar estados
    $('#country_id').on('change', function() {
        var countryId = $(this).val();
        $('#state_id').prop('disabled', true).html('<option value="">Cargando...</option>');
        $('#city_id').prop('disabled', true).html('<option value="">Primero seleccione un estado</option>');
        
        if(countryId) {
            $.get('/api/states/' + countryId, function(states) {
                var options = '<option value="">Seleccione un estado</option>';
                states.forEach(function(state) {
                    options += '<option value="' + state.id + '">' + state.name + '</option>';
                });
                $('#state_id').html(options).prop('disabled', false);
            });
        }
    });

    // Cuando cambia el estado, cargar ciudades
    $('#state_id').on('change', function() {
        var stateId = $(this).val();
        $('#city_id').prop('disabled', true).html('<option value="">Cargando...</option>');
        
        if(stateId) {
            $.get('/api/cities/' + stateId, function(cities) {
                var options = '<option value="">Seleccione una ciudad</option>';
                cities.forEach(function(city) {
                    options += '<option value="' + city.id + '">' + city.name + '</option>';
                });
                $('#city_id').html(options).prop('disabled', false);
            });
        }
    });
});
</script>
@endsection
