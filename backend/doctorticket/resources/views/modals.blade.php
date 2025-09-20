@extends('layout.main_layout')
@section('content')
    <div class="modal fade" id="meuModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered"><!-- Centraliza verticalmente -->
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirmação</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body text-center"><!-- Centraliza o texto -->
                    <p>Tem certeza que deseja excluir o usuário?</p>
                    <div class="d-flex justify-content-center gap-3 mt-3"><!-- Centraliza os botões -->
                        <form action="{{ route('deleteUserSubmit', $user) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">
                                Sim
                            </button>
                        </form>
                        <button class="btn btn-secondary" data-bs-dismiss="modal">Não</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
