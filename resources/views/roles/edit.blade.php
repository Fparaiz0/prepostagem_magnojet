@extends('layouts.admin')

@section('content')
    <h2>Editar Papel</h2>

    @can('index-role')
        <a href="{{ route('roles.index') }}">Listar</a><br>
    @endcan

    @can('show-role')
        <a href="{{ route('roles.show', ['role' => $role->id]) }}">Visualizar</a><br><br>
    @endcan

    <x-alert />

    <form action="{{ route('roles.update', ['role' => $role->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nome: </label>
        <input type="text" name="name" id="name" placeholder="Nome do papel" value="{{ old('name', $role->name) }}"
            required><br><br>

        <button type="submit">Salvar</button>
    </form>
@endsection