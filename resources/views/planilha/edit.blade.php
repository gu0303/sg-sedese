@extends('layouts.master')

@section('title', 'Editar Item da Planilha')

@section('content')

<div class="container mb-3">
        <h1>Editar Item</h1>

        <form action="{{ route('planilha.update', $item->id) }}" method="POST">
            @csrf
            @method('PUT')

            @foreach ($fields as $field => $label)
                <div class="form-group">
                    <label for="{{ $field }}">{{ $label }}</label>
                    <input type="text" id="{{ $field }}" name="{{ $field }}" class="form-control"
                        value="{{ old($field, $item->$field) }}">
                </div>
            @endforeach

            <button type="submit" class="btn btn-primary mt-3">Salvar</button>
            <a href="{{ route('planilha.index') }}" class="btn btn-secondary mt-3">Cancelar</a>

        </form>
    </div>
@endsection
