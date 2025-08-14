@extends('layouts.admin')

@section('content')
    <h2>Listar os Destinatários</h2>

    @can('create-recipient')
        <a href="{{ route('recipients.create') }}">Cadastrar</a><br>
    @endcan

    <br>
    <x-alert />

    {{-- Imprimir os registros --}}
    @forelse ($recipients as $recipient)
        Nome: {{ $recipient->name }}<br>
        Cnpj: {{ $recipient->cnpj }}<br>

        @can('show-recipient')
            <a href="{{ route('recipients.show', ['recipient' => $recipient->id]) }}">Visualizar</a><br>
        @endcan

        @can('edit-recipient')
            <a href="{{ route('recipients.edit', ['recipient' => $recipient->id]) }}">Editar</a><br>
        @endcan

        @can('destroy-recipient')
            <form action="{{ route('recipients.destroy', ['recipient' => $recipient->id]) }}" method="POST">
                @csrf
                @method('delete')

                <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

            </form>
        @endcan
        
        <hr>
    @empty
        Nenhum registro encontrado!
    @endforelse

    <div class="d-flex justify-content-center">
      {{ $recipients->links() }}
    </div>
@endsection
