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
                    <input type="text" name="{{ $name }}" class="form-control" value="{{ old($name) }}">
                </div>
            @endforeach

            <button type="submit" class="btn btn-success mt-3">Adicionar</button>
            <a href="{{ route('planilha.index') }}" class="btn btn-secondary mt-3">Voltar</a>
        </form>
    </div>

@endsection
