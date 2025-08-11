@extends('layouts.admin')

@section('content')
    <h2>Editar Destinatário</h2>

    @can('index-recipient')
        <a href="{{ route('recipients.index') }}">Listar</a><br>
    @endcan

    @can('show-recipient')
        <a href="{{ route('recipients.show', ['recipient' => $recipient->id]) }}">Visualizar</a><br><br>
    @endcan

    <x-alert />


    <form action="{{ route('recipients.update', ['recipient' => $recipient->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nome: </label>
        <input type="text" name="name" id="name" placeholder="Nome do remetente" value="{{ old('name', $recipient->name) }}" 
        required><br><br>

        <label>Cnpj: </label>
        <input type="text" name="cnpj" id="cnpj" placeholder="Cnpj do remetente" value="{{ old('cnpj', $recipient->cnpj) }}" 
        required><br><br>

        <label>Cep: </label>
        <input type="text" name="cep" id="cep" placeholder="Cep do remetente" value="{{ old('cep', $recipient->cep) }}" 
        required><br><br>

        <label>Logradouro: </label>
        <input type="text" name="public_place" id="public_place" placeholder="Logradouro do remetente" value="{{ old('public_place', $recipient->public_place) }}" 
        required><br><br>

        <label>Número: </label>
        <input type="text" name="number" id="number" placeholder="Número do remetente" value="{{ old('number', $recipient->number) }}" 
        required><br><br>

        <label>Bairro: </label>
        <input type="text" name="neighborhood" id="neighborhood" placeholder="Bairro do remetente" value="{{ old('neighborhood', $recipient->neighborhood)  }}" 
        required><br><br>

        <label>Cidade: </label>
        <input type="text" name="city" id="city" placeholder="Cidade do remetente" value="{{ old('city', $recipient->city) }}" 
        required><br><br>

        <label>UF: </label>
        <input type="text" name="uf" id="uf" placeholder="UF do remetente" value="{{ old('uf', $recipient->uf) }}" 
        required><br><br>

        <button type="submit">Salvar</button>
    </form>

@endsection
