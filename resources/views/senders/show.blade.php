@extends('layouts.admin')

@section('content')
    <h2>Detalhes do remetente</h2>

    @can('index-sender')
        <a href="{{ route('senders.index') }}">Listar os Remetentes</a><br><br>
    @endcan
    
    @can('edit-sender')
    <a href="{{ route('senders.edit', ['sender' => $sender->id]) }}">Editar</a><br><br>
    @endcan

    @can('destroy-sender')
        <form action="{{ route('senders.destroy', ['sender' => $sender->id]) }}" method="POST">
        @csrf
        @method('delete')

        <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

    </form><br>
    @endcan

    <x-alert />

    {{-- Imprimir o registro --}}
    Nome: {{ $sender->name }}<br>
    Cnpj: {{ $sender->cnpj }}<br>
    Cep: {{ $sender->cep }}<br>
    Logradouro: {{ $sender->public_place }}<br>
    Número: {{ $sender->number }}<br>
    Bairro: {{ $sender->neighborhood }}<br>
    Cidade: {{ $sender->city }}<br>
    UF: {{ $sender->uf }}<br>    
    Cadastrado: {{ \Carbon\Carbon::parse($sender->created_at)->format('d/m/Y H:i:s') }}<br>
    Editado: {{ \Carbon\Carbon::parse($sender->updated_at)->format('d/m/Y H:i:s') }}<br>
@endsection
