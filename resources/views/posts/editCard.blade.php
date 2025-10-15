@extends('layouts.master')

@section('subtitle', 'Editar Descrição')
@section('content_header_title', 'Editar Descrição da Alteração')

@section('content_body')
    <div class="col-md-8 offset-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Editar Card</h3>
            </div>

            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form id="editCardForm" action="{{ route('cards.update', $card->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea class="form-control" id="descricao" name="descricao" rows="3">{{ $card->descricao }}</textarea>
                    </div>
                    <div class="d-flex mt-3">
                        <button type="submit" class="btn btn-success mt-2">Salvar alterações</button>
                        <a href="{{ route('posts.index') }}" class="btn btn-secondary mt-2 ml-2">Voltar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Script de validação --}}
    <script>
        document.getElementById('editCardForm').addEventListener('submit', function (event) {
            const descricao = document.getElementById('descricao').value.trim();

            if (descricao === '') {
                event.preventDefault(); // impede o envio do formulário
                alert('A descrição não pode estar vazia.');
            }
        });
    </script>
@endsection
