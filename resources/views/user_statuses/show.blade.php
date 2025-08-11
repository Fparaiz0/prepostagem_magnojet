@extends('layouts.admin')

@section('content')
    <h2>Detalhes do Status Usuário</h2>

    @can('index-user-status')
        <a href="{{ route('user_statuses.index') }}">Listar</a><br>
    @endcan

    @can('edit-user-status')
        <a href="{{ route('user_statuses.edit', ['userStatus' => $userStatus->id]) }}">Editar</a><br>
    @endcan

    @can('destroy-user-status')
        <form action="{{ route('user_statuses.destroy', ['userStatus' => $userStatus->id]) }}" method="POST">
            @csrf
            @method('delete')

            <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

        </form><br>
    @endcan

    <br>
    <x-alert />

    {{-- Imprimir o registro --}}
    ID: {{ $userStatus->id }}<br>
    Nome: {{ $userStatus->name }}<br>
    Cadastrado: {{ \Carbon\Carbon::parse($userStatus->created_at)->format('d/m/Y H:i:s') }}<br>
    Editado: {{ \Carbon\Carbon::parse($userStatus->updated_at)->format('d/m/Y H:i:s') }}<br>
@endsection
