@extends('layouts.master')

@section('subtitle', 'Editar Descrição')
@section('content_header_title', 'Editar descrição da alteração')
@section('content_body')

    @if (session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    @if ($alteracoes->isEmpty())
        <p>Não há alterações registradas.</p>
    @else
        <form method="GET" action="{{ route('posts.index') }}" class="mb-3">
            <div class="input-group custom-input-group">
                <input type="text" name="search" value="{{ request('search') }}" class="form-control form-control-sm"
                    placeholder="Pesquisar descrições" style="height: 40px;">
                <button type="submit" class="btn btn-secondary btn-sm ml-1" >
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </form>

        @foreach ($alteracoes as $alteracao)
            <div class="card mb-3">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-2">
                        <h5 class="card-title mb-0">{{ $alteracao->user->name ?? 'Usuário desconhecido' }}</h5>
                        <h6 class="card-subtitle text-muted mb-0" style="margin-left: 20px;">
                            {{ $alteracao->created_at->setTimezone('America/Sao_Paulo')->format('d/m/Y H:i') }}
                        </h6>
                    </div>
                    <p class="card-text">{{ $alteracao->descricao }}</p>
                    <a href="{{ route('cards.edit', $alteracao->id) }}" class="btn btn-primary btn-sm mr-2">Editar</a>
                    <form action="{{ route('cards.destroy', $alteracao->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger btn-sm">Remover</button>
                    </form>
                </div>
            </div>
        @endforeach
    @endif

@endsection
