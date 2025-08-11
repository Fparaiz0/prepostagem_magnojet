@extends('layouts.admin')

@section('content')
    <h2>Listar os Usuários</h2>

    @can('create-user')
        <a href="{{ route('users.create') }}">Cadastrar</a><br>
    @endcan

    <br>
    <x-alert />

    {{-- Imprimir os registros --}}
    @forelse ($users as $user)
        ID: {{ $user->id }}<br>
        Nome: {{ $user->name }}<br>

        @can('show-user')
            <a href="{{ route('users.show', ['user' => $user->id]) }}">Visualizar</a><br>
        @endcan

        @can('edit-user')
            <a href="{{ route('users.edit', ['user' => $user->id]) }}">Editar</a><br>
        @endcan

        @can('destroy-user')
            <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
                @csrf
                @method('delete')

                <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

            </form>
        @endcan
        <hr>
    @empty
        Nenhum registro encontrado!
    @endforelse

    {{ $users->links() }}
@endsection
