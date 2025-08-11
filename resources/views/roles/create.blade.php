@extends('layouts.admin')

@section('content')
    <h2>Cadastrar Papel</h2>

    @can('index-role')
        <a href="{{ route('roles.index') }}">Listar</a><br><br>
    @endcan

    <x-alert />

    <form action="{{ route('roles.store') }}" method="POST">
        @csrf
        @method('POST')

        <label>Nome: </label>
        <input type="text" name="name" id="name" placeholder="Nome do papel" value="{{ old('name') }}"
            required><br><br>

        <button type="submit">Cadastrar</button>
    </form>
@endsection