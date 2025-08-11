@extends('layouts.admin')

@section('content')
    <h2>Permissões do Papel</h2>

    @can('index-role')
        <a href="{{ route('roles.index') }}">Listar</a><br><br>
    @endcan

    <x-alert />

    {{-- Imprimir os registros --}}
    @forelse ($permissions as $permission)
        ID: {{ $permission->id }}<br>
        Título: {{ $permission->title }}<br>
        Nome: {{ $permission->name }}<br>
        Papel: {{{ $role->name }}}<br>

        @if (in_array($permission->id, $rolePermissions ?? []))
            <a href="{{ route('role-permissions.update', ['role' => $role->id, 'permission' => $permission->id]) }}">
                <span style="color: #086">Liberado</span>
            </a>
        @else
        <a href="{{ route('role-permissions.update', ['role' => $role->id, 'permission' => $permission->id]) }}">
                <span style="color: #f00">Bloqueado</span>
            </a>
        @endif
        <hr>
    @empty
        Nenhum registro encontrado!
    @endforelse
@endsection