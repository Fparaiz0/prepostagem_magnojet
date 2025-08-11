@extends('layouts.login')

@section('content')
    <h3>Área Restrita</h3>

    <x-alert />

    <form action="{{ route('login.process') }}" method="POST">
        @csrf
        @method('POST')

        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="Digite seu e-mail" value=" {{ old('email') }}" required> <br><br>

        <label for="password">Senha</label>
        <input type="password" name="password" id="password" placeholder="Digite a senha" value="{{ old('password')}}" required> <br><br>

        <button type="submit">Acessar</button><br><br>

    </form>

    <a href="{{ route('password.request') }}">Esqueceu a senha?</a><br>
    Precisa de uma conta? <a href="{{ route('register') }}">Inscrever-se!</a><br><br>
    
@endsection