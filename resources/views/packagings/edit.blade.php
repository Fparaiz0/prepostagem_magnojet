@extends('layouts.admin')

@section('content')
    <h2>Editar Embalagem</h2>

    @can('index-packaging')
        <a href="{{ route('packagings.index') }}">Listar</a><br>
    @endcan

    @can('show-packaging')
        <a href="{{ route('packagings.show', ['packaging' => $packaging->id]) }}">Visualizar</a><br><br>
    @endcan

    <x-alert />


    <form action="{{ route('packagings.update', ['packaging' => $packaging->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nome: </label>
        <input type="text" name="name" id="name" placeholder="Nome da embalagem" value="{{ old('name', $packaging->name) }}"
        required><br><br>

        <label>Altura: </label>
        <input type="text" name="height" id="height" placeholder="Altura da embalagem" value="{{ old('height', $packaging->height) }}"
        required><br><br>

        <label>Largura: </label>
        <input type="text" name="width" id="width" placeholder="Largura da embalagem" value="{{ old('width', $packaging->width) }}"
        required><br><br>

        <label>Comprimento: </label>
        <input type="text" name="length" id="length" placeholder="Comprimento da embalagem" value="{{ old('length', $packaging->length) }}"
        required><br><br>

        <label>Diâmetro: </label>
        <input type="text" name="diameter" id="diameter" placeholder="Diâmetro da embalagem" value="{{ old('diameter', $packaging->diameter) }}"
        required><br><br>

        <label>Peso: </label>
        <input type="text" name="weight" id="weight" placeholder="Peso da embalagem" value="{{ old('weight', $packaging->weight) }}"
        required><br><br>

        <label>Ativo?: </label>
        <input type="text" name="active" id="active" placeholder="Ativo - 1 | Inativo - 2" value="{{ old('active', $packaging->active) }}"
        required><br><br>

        <button type="submit">Salvar</button>
    </form>

@endsection
