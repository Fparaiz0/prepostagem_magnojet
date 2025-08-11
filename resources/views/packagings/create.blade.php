@extends('layouts.admin')

@section('content')
    <h2>Cadastrar Embalagem</h2>

    @can('index-packaging')
        <a href="{{ route('packagings.index') }}">Listar</a><br><br>
    @endcan
    
    <x-alert />

        <form action="{{ route('packagings.store') }}" method="POST">
            @csrf
            @method('POST')

            <label>Nome: </label>
            <input type="text" name="name" id="name" placeholder="Nome da embalagem" value="{{ old('name') }}" required><br><br>

            <label>Altura: </label>
            <input type="text" name="height" id="height" placeholder="Altura da embalagem" value="{{ old('height') }}" required><br><br>

            <label>Largura: </label>
            <input type="text" name="width" id="width" placeholder="Largura da embalagem" value="{{ old('width') }}" required><br><br>

            <label>Comprimento: </label>
            <input type="text" name="length" id="length" placeholder="Comprimento da embalagem" value="{{ old('length') }}" required><br><br>

            <label>Diâmetro: </label>
            <input type="text" name="diameter" id="diameter" placeholder="Diâmetro da embalagem" value="0" required><br><br>

            <label>Peso: </label>
            <input type="text" name="weight" id="weight" placeholder="Peso da embalagem" value="1" required><br><br>

            <label>Ativo?: </label>
            <input type="text" name="active" id="active" placeholder="1 - Ativo | 2 - Inativo" value="{{ old('active') }}" required><br><br>

            <button type="submit">Cadastrar</button>
        </form>

@endsection
