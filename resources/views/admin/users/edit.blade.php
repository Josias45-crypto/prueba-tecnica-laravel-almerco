@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Editar Usuario</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
                        @csrf
                        @method('PUT')

                        <!-- Identificador -->
                        <div class="mb-3">
                            <label for="identificador" class="form-label">Identificador <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('identificador') is-invalid @enderror" 
                                   id="identificador" name="identificador" value="{{ old('identificador', $user->identificador) }}" required>
                            @error('identificador')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Email (NO EDITABLE) -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled>
                            <small class="text-muted">El email no se puede modificar</small>
                        </div>

                        <!-- Contraseña (Opcional) -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Nueva Contraseña (dejar en blanco para mantener la actual)</label>
                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                   id="password" name="password">
                            <small class="text-muted">Mínimo 8 caracteres, debe contener: 1 número, 1 mayúscula, 1 carácter especial</small>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Confirmar Contraseña -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
