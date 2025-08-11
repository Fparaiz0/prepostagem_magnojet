@extends('layouts.admin')

@section('content')
    <h2>Detalhes do Usuário</h2>

    @can('index-user')
        <a href="{{ route('users.index') }}">Listar</a><br>
    @endcan

    @can('edit-user')
        <a href="{{ route('users.edit', ['user' => $user->id]) }}">Editar</a><br>
    @endcan

    @can('edit-password-user')
        <a href="{{ route('users.edit_password', ['user' => $user->id]) }}">Editar Senha</a><br>
    @endcan

    @can('destroy-user')
        <form action="{{ route('users.destroy', ['user' => $user->id]) }}" method="POST">
            @csrf
            @method('delete')

            <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

        </form><br>
    @endcan

    <br>
    <x-alert />

    {{-- Imprimir o registro --}}
    ID: {{ $user->id }}<br>
    Nome: {{ $user->name }}<br>
    E-mail: {{ $user->email }}<br>
    Status: {{ $user->userStatus->name }}<br>
    Papel: 
    @forelse ($user->getRoleNames() as $index => $role)
        @if (!$loop->last)
            {{ $role . ',' }}
        @else()
            {{ $role . '.' }}
        @endif
    @empty
        -
    @endforelse
    <br>
    Cadastrado: {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}<br>
    Editado: {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}<br>
@endsection
