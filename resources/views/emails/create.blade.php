@extends('layouts.user')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">Crear Nuevo Email</h4>
                </div>

                <div class="card-body">
                    <form method="POST" action="{{ route('emails.store') }}">
                        @csrf

                        <!-- Asunto -->
                        <div class="mb-3">
                            <label for="asunto" class="form-label">Asunto <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('asunto') is-invalid @enderror" 
                                   id="asunto" name="asunto" value="{{ old('asunto') }}" maxlength="255" required>
                            @error('asunto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Destinatario -->
                        <div class="mb-3">
                            <label for="destinatario" class="form-label">Destinatario <span class="text-danger">*</span></label>
                            <input type="email" class="form-control @error('destinatario') is-invalid @enderror" 
                                   id="destinatario" name="destinatario" value="{{ old('destinatario') }}" required>
                            @error('destinatario')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Cuerpo del mensaje -->
                        <div class="mb-3">
                            <label for="cuerpo" class="form-label">Mensaje <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('cuerpo') is-invalid @enderror" 
                                      id="cuerpo" name="cuerpo" rows="8" required>{{ old('cuerpo') }}</textarea>
                            @error('cuerpo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('emails.index') }}" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Enviar Email</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
