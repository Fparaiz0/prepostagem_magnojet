@extends('layouts.admin')

@section('content')
    <h2>Cadastrar Permissão</h2>

    @can('index-permission')
        <a href="{{ route('permissions.index') }}">Listar</a><br><br>
    @endcan

    <x-alert />

    <form action="{{ route('permissions.store') }}" method="POST">
        @csrf
        @method('POST')

        <label>Título: </label>
        <input type="text" name="title" id="title" placeholder="Título da permissão" value="{{ old('title') }}"
            ><br><br>

        <label>Nome: </label>
        <input type="text" name="name" id="name" placeholder="Nome da permissão" value="{{ old('name') }}"
            ><br><br>

        <button type="submit">Cadastrar</button>
    </form>
@endsection

