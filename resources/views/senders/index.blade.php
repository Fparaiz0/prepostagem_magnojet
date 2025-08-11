@extends('layouts.admin')

@section('content')
    <h2>Listar os remetentes</h2>

    @can('create-sender')
        <a href="{{ route('senders.create') }}">Cadastrar</a><br>
    @endcan

    <br>
    <x-alert />

    {{-- Imprimir os registros --}}
    @forelse ($senders as $sender)
        Nome: {{ $sender->name }}<br>
        Cnpj: {{ $sender->cnpj }}<br>

        @can('show-sender')
            <a href="{{ route('senders.show', ['sender' => $sender->id]) }}">Visualizar</a><br>
        @endcan

        @can('edit-sender')
            <a href="{{ route('senders.edit', ['sender' => $sender->id]) }}">Editar</a><br>
        @endcan

        @can('destroy-sender')
            <form action="{{ route('senders.destroy', ['sender' => $sender->id]) }}" method="POST">
                @csrf
                @method('delete')

                <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

            </form>
        @endcan
        
        <hr>
    @empty
        Nenhum registro encontrado!
    @endforelse

    {{ $senders->links() }}
@endsection
