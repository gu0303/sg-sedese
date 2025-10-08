@extends('layouts.master')

@section('subtitle', 'Editar Descrição')
@section('content_header_title', 'Editar descrição da alteração')

@section('content_body')
    {{-- Sobre --}}
        <div class="card card-dark collapsed-card">
            <div class="card-header">
                <h3 class="card-title">Sobre</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Expandir">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body" style="display: none;">
                <p>Aqui é armazenado a alteração dos itens (não inclui a criação e exclusão dos itens)</p>
            </div>
        </div>

    @if (session('info'))
        <div class="alert alert-info">{{ session('info') }}</div>
    @endif

    <form method="GET" action="{{ route('posts.index') }}" class="mb-3">
        <div class="input-group custom-input-group">
            <input type="text" name="search" value="{{ old('search', $search ?? '') }}" 
                   class="form-control form-control-sm"
                   placeholder="Pesquisar..."
                   style="height: 40px;">
            <button type="submit" class="btn btn-secondary btn-sm ml-1">
                <i class="fas fa-search"></i>
            </button>
        </div>
    </form>

    @if (!empty($search) && isset($mensagem))
        <div class="alert alert-warning">
            <i class="fas fa-exclamation-triangle"></i> {{ $mensagem }}
        </div>
    @elseif ($alteracoes->isEmpty())
        <p>Não há alterações registradas.</p>
    @else
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
