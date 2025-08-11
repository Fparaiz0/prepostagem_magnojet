@extends('layouts.admin')

@section('content')
    <h2>Editar Status Usuário</h2>

    @can('index-user-status')
        <a href="{{ route('user_statuses.index') }}">Listar</a><br>
    @endcan

    @can('show-user-status')
        <a href="{{ route('user_statuses.show', ['userStatus' => $userStatus->id]) }}">Visualizar</a><br>
    @endcan

    <br>
    <x-alert />

    <form action="{{ route('user_statuses.update', ['userStatus' => $userStatus->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nome: </label>
        <input type="text" name="name" id="name" placeholder="Nome do status"
            value="{{ old('name', $userStatus->name) }}" required><br><br>

        <button type="submit">Salvar</button>
    </form>
@endsection
