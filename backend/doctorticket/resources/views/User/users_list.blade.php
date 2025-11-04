@extends('layout.main_layout')
@section('content')
    <link rel="stylesheet" href="{{ asset('css/users.css') }}">
    <div class="container mt-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h4 class="mb-0">Lista de Usuários</h4>
            <a href="{{ route('createUser') }}" class="btn btn-success">
                + Novo Usuário
            </a>
        </div>

        <div class="card shadow-sm">
            <div class="card-body">
                <table class="table table-bordered table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nome</th>
                            <th>Ramal</th>
                            <th>Tipo</th>
                            <th>Criado em</th>
                            <th>Atualizado em</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($users as $user)
                            <tr>
                                <td>{{ $user->id }}</td>
                                <td>{{ $user->nome }}</td>
                                <td>{{ $user->ramal }}</td>
                                <td>{{ strtoupper($user->tipo) }}</td>
                                <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                @if($user->updated_at != $user->created_at)
                                <td> {{$user->updated_at->format('d/m/Y H:i')}}</td>
                                @else <td></td>
                                @endif
                                <td class="text-center">
                                    <a href="{{ route('editUser', $user) }}" class="btn btn-warning btn-sm">Editar</a>

                                    <!-- Botão abre a modal específica -->
                                    <button class="btn btn-danger btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalDelete-{{ $user->id }}">
                                        Excluir
                                    </button>

                                    <!-- Modal exclusivo para este usuário -->
                                    <div class="modal fade" id="modalDelete-{{ $user->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title">Confirmação</h5>
                                                    <button type="button" class="btn-close"
                                                        data-bs-dismiss="modal"></button>
                                                </div>
                                                <div class="modal-body text-center">
                                                    <p>Tem certeza que deseja excluir <strong>{{ $user->nome }}</strong>?
                                                    </p>
                                                    <div class="d-flex justify-content-center gap-3 mt-3">
                                                        <form action="{{ route('deleteUserSubmit', $user) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Sim</button>
                                                        </form>
                                                        <button class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Não</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center text-muted">Nenhum usuário encontrado.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
