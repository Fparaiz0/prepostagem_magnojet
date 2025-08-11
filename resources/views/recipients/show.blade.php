@extends('layouts.admin')

@section('content')
    <h2>Detalhes do Destinatário</h2>

    @can('index-recipient')
        <a href="{{ route('recipients.index') }}">Listar os Destinatários</a><br><br>
    @endcan
    
    @can('edit-recipient')
    <a href="{{ route('recipients.edit', ['recipient' => $recipient->id]) }}">Editar</a><br><br>
    @endcan

    @can('destroy-recipient')
        <form action="{{ route('recipients.destroy', ['recipient' => $recipient->id]) }}" method="POST">
        @csrf
        @method('delete')

        <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

    </form><br>
    @endcan

    <x-alert />

    {{-- Imprimir o registro --}}
    Nome: {{ $recipient->name }}<br>
    Cnpj: {{ $recipient->cnpj }}<br>
    Cep: {{ $recipient->cep }}<br>
    Logradouro: {{ $recipient->public_place }}<br>
    Número: {{ $recipient->number }}<br>
    Bairro: {{ $recipient->neighborhood }}<br>
    Cidade: {{ $recipient->city }}<br>
    UF: {{ $recipient->uf }}<br>    
    Cadastrado: {{ \Carbon\Carbon::parse($recipient->created_at)->format('d/m/Y H:i:s') }}<br>
    Editado: {{ \Carbon\Carbon::parse($recipient->updated_at)->format('d/m/Y H:i:s') }}<br>
@endsection
