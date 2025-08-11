@extends('layouts.admin')

@section('content')
    <h2>Listar os Status Usuário</h2>

    @can('create-user-status')
        <a href="{{ route('user_statuses.create') }}">Cadastrar</a><br>
    @endcan

    <br>
    <x-alert />

    {{-- Imprimir os registros --}}
    @forelse ($userStatuses as $userStatus)
        ID: {{ $userStatus->id }}<br>
        Nome: {{ $userStatus->name }}<br>

        @can('show-user-status')
            <a href="{{ route('user_statuses.show', ['userStatus' => $userStatus->id]) }}">Visualizar</a><br>
        @endcan

        @can('edit-user-status')
            <a href="{{ route('user_statuses.edit', ['userStatus' => $userStatus->id]) }}">Editar</a><br>
        @endcan

        @can('destroy-user-status')
            <form action="{{ route('user_statuses.destroy', ['userStatus' => $userStatus->id]) }}" method="POST">
                @csrf
                @method('delete')

                <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

            </form>
        @endcan
        
        <hr>
    @empty
        Nenhum registro encontrado!
    @endforelse

    {{ $userStatuses->links() }}
@endsection
