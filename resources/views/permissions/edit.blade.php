@extends('layouts.admin')

@section('content')
    <h2>Editar Permissão</h2>

    @can('index-permission')
        <a href="{{ route('permissions.index') }}">Listar</a><br>
    @endcan

    @can('show-permission')
        <a href="{{ route('permissions.show', ['permission' => $permission->id]) }}">Visualizar</a><br><br>
    @endcan

    <x-alert />

    <form action="{{ route('permissions.update', ['permission' => $permission->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Permissão: </label>
        <input type="text" name="title" id="title" placeholder="Permissão do curso" value="{{ old('title', $permission->title) }}"
            ><br><br>

        <label>Nome: </label>
        <input type="text" name="name" id="name" placeholder="Nome do curso" value="{{ old('name', $permission->name) }}"
            ><br><br>

        <button type="submit">Salvar</button>
    </form>
@endsection
