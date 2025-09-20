@extends('layout.main_layout')
@section('content')
<div class="modal fade" id="meuModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Minha Modal</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body">
        Tem certeza que deseja exclur o usuário?
        <div class="d-flex">
            <button>Sim</button>
            <button>Não</button>
        </div>
      </div>
    </div>
  </div>
</div>