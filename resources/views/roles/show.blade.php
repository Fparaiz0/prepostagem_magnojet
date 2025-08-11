@extends('layouts.admin')

@section('content')
    <h2>Detalhes do Papel</h2>

    @can('index-role')
        <a href="{{ route('roles.index') }}">Listar Papéis</a><br>
    @endcan

    @can('edit-role')
        <a href="{{ route('roles.edit', ['role' => $role->id]) }}">Editar</a><br>
    @endcan

    @can('destroy-role')
        <form action="{{ route('roles.destroy', ['role' => $role->id]) }}" method="POST">
            @csrf
            @method('delete')

            <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

        </form><br><br>
    @endcan

    <x-alert />

    {{-- Imprimir o registro --}}
    ID: {{ $role->id }}<br>
    Nome: {{ $role->name }}<br>
    Cadastrado: {{ \Carbon\Carbon::parse($role->created_at)->format('d/m/Y H:i:s') }}<br>
    Editado: {{ \Carbon\Carbon::parse($role->updated_at)->format('d/m/Y H:i:s') }}<br>
@endsection