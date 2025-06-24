@extends('layouts.master')

@section('title', 'Editar Perfil')

@section('content')
<div class="container">
    <h1>Editar Perfil</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Ops!</strong> Erros encontrados:<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('profile.update') }}" method="POST">
        @csrf

        <div class="form-group">
            <label for="name">Nome:</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="email">E-mail:</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Nova Senha: (deixe em branco se não for mudar)</label>
            <input type="password" name="password" class="form-control" autocomplete="new-password">
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirme a Nova Senha:</label>
            <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password">
        </div>

        <button type="submit" class="btn btn-primary mt-3">Salvar Alterações</button>
        <a href="{{ route('profile.profile') }}" class="btn btn-secondary mt-3">Cancelar</a>
    </form>
</div>
@endsection
