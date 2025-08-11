@extends('layouts.admin')

@section('content')
    <h2>Perfil</h2>

  
    <a href="{{ route('profile.edit', ['user' => $user->id]) }}">Editar</a><br>
    <a href="{{ route('profile.edit_password', ['user' => $user->id]) }}">Editar Senha</a><br>
    <br><br> 

    <x-alert />

    {{-- Imprimir o registro --}}
    ID: {{ $user->id }}<br>
    Nome: {{ $user->name }}<br>
    E-mail: {{ $user->email }}<br>
    Status: {{ $user->userStatus->name }}<br>
@endsection
