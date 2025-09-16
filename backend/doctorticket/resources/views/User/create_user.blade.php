@extends('layout.main_layout')
@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header text-center">
                    <h5 class="mb-0">Cadastro de Usuário</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('createUserSubmit') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label>Tipo:</label>
                            <div class="d-flex mt-2">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="analista" name="tipo" id="analista">
                                <label class="form-check-label" for="analista">Analista</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="admin" name="tipo" id="adm">
                                <label class="form-check-label" for="adm">Administrador</label>
                            </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="nome" class="form-label">Nome</label>
                            <input 
                                type="text" 
                                class="form-control @error('nome') is-invalid @enderror" 
                                id="nome" 
                                name="nome" 
                                value="{{ old('nome') }}" 
                                required
                            >
                            @error('nome')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="ramal" class="form-label">Ramal</label>
                            <input 
                                type="number" 
                                class="form-control @error('ramal') is-invalid @enderror" 
                                id="ramal" 
                                name="ramal" 
                                value="{{ old('ramal') }}" 
                                required
                            >
                            @error('ramal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="senha" class="form-label">Senha</label>
                            <input 
                                type="password" 
                                class="form-control @error('senha') is-invalid @enderror" 
                                id="senha" 
                                name="senha" 
                                required
                            >
                            @error('senha')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                Enviar
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
