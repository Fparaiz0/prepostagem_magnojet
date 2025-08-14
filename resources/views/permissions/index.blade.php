@extends('layouts.admin')

@section('content')
    <h2>Listar as Permissões</h2>

    @can('create-permission')
        <a href="{{ route('permissions.create') }}">Cadastrar</a><br><br>
    @endcan


    <x-alert />

    {{-- Imprimir os registros --}}
    @forelse ($permissions as $permission)
        ID: {{ $permission->id }}<br>
        Título: {{ $permission->title }}<br>

        @can('show-permission')
            <a href="{{ route('permissions.show', ['permission' => $permission->id]) }}">Visualizar</a><br>
        @endcan

        @can('edit-permission')
            <a href="{{ route('permissions.edit', ['permission' => $permission->id]) }}">Editar</a><br>
        @endcan

        @can('destroy-permission')
            <form action="{{ route('permissions.destroy', ['permission' => $permission->id]) }}" method="POST">
                @csrf
                @method('delete')

                <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

            </form>
        @endcan

        <hr>
    @empty
        Nenhum registro encontrado!
    @endforelse
        {{ $permissions->links() }}
@endsection
