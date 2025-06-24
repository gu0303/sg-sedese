@extends('layouts.master')

@section('title', 'Meu Perfil')

@section('content')
<div class="container">
    <h1>Meu Perfil</h1>
    <div class="card">
        <div class="card-body">
            <p><strong>Nome:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <a href="{{ route('profile.edit') }}" class="btn btn-primary mb-3">Editar Perfil</a>
        </div>
    </div>
</div>
@endsection