@extends('layouts.admin')

@section('content')
    <h2>Listar as embalagens</h2>

    @can('create-packaging')
        <a href="{{ route('packagings.create') }}">Cadastrar</a><br>
    @endcan

    <br>
    <x-alert />

    {{-- Imprimir os registros --}}
    @forelse ($packagings as $packaging)
        Nome: {{ $packaging->name }}<br>

        @can('show-packaging')
            <a href="{{ route('packagings.show', ['packaging' => $packaging->id]) }}">Visualizar</a><br>
        @endcan

        @can('edit-packaging')
            <a href="{{ route('packagings.edit', ['packaging' => $packaging->id]) }}">Editar</a><br>
        @endcan

        @can('destroy-packaging')
            <form action="{{ route('packagings.destroy', ['packaging' => $packaging->id]) }}" method="POST">
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
      {{ $packagings->links() }}
    </div>
@endsection
