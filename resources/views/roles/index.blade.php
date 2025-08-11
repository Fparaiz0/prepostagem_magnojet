@extends('layouts.admin')

@section('content')
    <h2>Listar os Papéis</h2>

    @can('create-role')
        <a href="{{ route('roles.create') }}">Cadastrar</a><br><br>
    @endcan


    <x-alert />

    {{-- Imprimir os registros --}}
    @forelse ($roles as $role)
        ID: {{ $role->id }}<br>
        Nome: {{ $role->name }}<br>

        @can('index-role-permission')
            <a href="{{ route('role-permissions.index', ['role' => $role->id]) }}">Permissões</a><br>
        @endcan

        @can('show-role')
            <a href="{{ route('roles.show', ['role' => $role->id]) }}">Visualizar</a><br>
        @endcan

        @can('edit-role')
            <a href="{{ route('roles.edit', ['role' => $role->id]) }}">Editar</a><br>
        @endcan

        @can('destroy-role')
            <form action="{{ route('roles.destroy', ['role' => $role->id]) }}" method="POST">
                @csrf
                @method('delete')

                <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

            </form>
        @endcan

        <hr>
    @empty
        Nenhum registro encontrado!
    @endforelse

    {{ $roles->links() }}
@endsection