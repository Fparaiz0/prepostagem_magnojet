@extends('layouts.admin')

@section('content')
    <h2>Detalhes da Permissão</h2>

    @can('index-permission')
        <a href="{{ route('permissions.index') }}">Listar as Permissões</a><br>
    @endcan

    @can('edit-permission')
        <a href="{{ route('permissions.edit', ['permission' => $permission->id]) }}">Editar</a><br>
    @endcan

    @can('destroy-permission')
        <form action="{{ route('permissions.destroy', ['permission' => $permission->id]) }}" method="POST">
            @csrf
            @method('delete')

            <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

        </form><br><br>
    @endcan

    <x-alert />

    {{-- Imprimir o registro --}}
    ID: {{ $permission->id }}<br>
    Título: {{ $permission->title }}<br>
    Nome: {{ $permission->name }}<br>
    Cadastrado: {{ \Carbon\Carbon::parse($permission->created_at)->format('d/m/Y H:i:s') }}<br>
    Editado: {{ \Carbon\Carbon::parse($permission->updated_at)->format('d/m/Y H:i:s') }}<br>
@endsection
