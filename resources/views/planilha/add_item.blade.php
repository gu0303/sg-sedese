@extends('layouts.master')

@section('subtitle', 'Adicionar Item')
@section('content_header_title', 'Adicionar Novo Item')
@section('content_header_subtitle', 'Preencha os campos abaixo para adicionar um novo item')

@section('content_body')

<div class="container mb-3">
    <h1>Adicionar Novo Item</h1>

    <form action="{{ route('planilha.store') }}" method="POST">
        @csrf

        @foreach ($fields as $name => $label)
            <div class="form-group">
                <label for="{{ $name }}">{{ $label }}</label>

                @if ($name === 'ambiente')
                    <select name="ambiente" id="ambiente" class="form-control">
                        <option value="">Selecione...</option>
                        <option value="Produção" {{ old('ambiente') == 'Produção' ? 'selected' : '' }}>Produção</option>
                        <option value="Homologação" {{ old('ambiente') == 'Homologação' ? 'selected' : '' }}>Homologação</option>
                        <option value="Desenvolvimento" {{ old('ambiente') == 'Desenvolvimento' ? 'selected' : '' }}>Desenvolvimento</option>
                    </select>
                @else
                    <input type="text" name="{{ $name }}" class="form-control" value="{{ old($name) }}">
                @endif
            </div>
        @endforeach

        <button type="submit" class="btn btn-success mt-3">Adicionar</button>
        <a href="{{ route('planilha.index') }}" class="btn btn-secondary mt-3">Voltar</a>
    </form>
</div>

@endsection
