@extends('layouts.login')

@section('content')
    <h3>Nova Senha</h3>

    <x-alert />

    <form action="{{ route('password.update') }}" method="POST">
        @csrf
        @method('POST')

        <input type="hidden" name="token" value="{{ $token }}">

        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="Digite o e-mail cadastrado" value=" {{ old('email', $email) }}" required> <br><br>

        <label for="password">Senha</label>
        <input type="password" name="password" id="password" placeholder="Digite a nova senha" value="{{ old('password')}}" required> <br><br>

        <label>Confirmar Senha: </label>
        <input type="password" name="password_confirmation" id="password_confirmation" placeholder="Confirmar a senha" value="{{ old('password_confirmation') }}" required><br><br>

        <button type="submit">Atualizar</button><br><br>

    </form>

    <a href=" {{ route('login') }} ">Login</a><br><br>

@endsection