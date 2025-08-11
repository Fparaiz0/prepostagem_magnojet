@extends('layouts.admin')

@section('content')
    <h2>Editar Senha</h2>

    @can('index-user')
        <a href="{{ route('users.index') }}">Listar</a><br>
    @endcan

    @can('show-user')
        <a href="{{ route('users.show', ['user' => $user->id]) }}">Visualizar</a><br>
    @endcan

    <br>
    <x-alert />

    <form action="{{ route('users.update_password', ['user' => $user->id]) }}" method="POST">
        @csrf
        @method('PUT')        

        <label>Senha: </label>
        <input type="password" name="password" id="password" placeholder="Senha do usuário" value="{{ old('password') }}" required><br><br>

        <label>Confirmar Senha: </label>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmar a senha" value="{{ old('password_confirmation') }}" required><br><br>

        <button type="submit">Salvar</button>
    </form>
@endsection
