@extends('layouts.admin')

@section('content')
    <h2>Editar Remetente</h2>

    @can('index-sender')
        <a href="{{ route('senders.index') }}">Listar</a><br>
    @endcan

    @can('show-sender')
        <a href="{{ route('senders.show', ['sender' => $sender->id]) }}">Visualizar</a><br><br>
    @endcan

    <x-alert />


    <form action="{{ route('senders.update', ['sender' => $sender->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nome: </label>
        <input type="text" name="name" id="name" placeholder="Nome do remetente" value="{{ old('name', $sender->name) }}" 
        required><br><br>

        <label>Cnpj: </label>
        <input type="text" name="cnpj" id="cnpj" placeholder="Cnpj do remetente" value="{{ old('cnpj', $sender->cnpj) }}" 
        required><br><br>

        <label>Cep: </label>
        <input type="text" name="cep" id="cep" placeholder="Cep do remetente" value="{{ old('cep', $sender->cep) }}" 
        required><br><br>

        <label>Logradouro: </label>
        <input type="text" name="public_place" id="public_place" placeholder="Logradouro do remetente" value="{{ old('public_place', $sender->public_place) }}" 
        required><br><br>

        <label>Número: </label>
        <input type="text" name="number" id="number" placeholder="Número do remetente" value="{{ old('number', $sender->number) }}" 
        required><br><br>

        <label>Bairro: </label>
        <input type="text" name="neighborhood" id="neighborhood" placeholder="Bairro do remetente" value="{{ old('neighborhood', $sender->neighborhood)  }}" 
        required><br><br>

        <label>Cidade: </label>
        <input type="text" name="city" id="city" placeholder="Cidade do remetente" value="{{ old('city', $sender->city) }}" 
        required><br><br>

        <label>UF: </label>
        <input type="text" name="uf" id="uf" placeholder="UF do remetente" value="{{ old('uf', $sender->uf) }}" 
        required><br><br>

        <button type="submit">Salvar</button>
    </form>

@endsection
