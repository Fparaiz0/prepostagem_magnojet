@extends('layouts.login')

@section('content')
    <h3>Recuperar a senha</h3>

    <x-alert />

    <form action="{{ route('password.email') }}" method="POST">
        @csrf
        @method('POST')

        <label for="email">E-mail</label>
        <input type="email" name="email" id="email" placeholder="Digite o e-mail cadastrado" value=" {{ old('email') }}" required> <br><br>

        <button type="submit">Recuperar</button><br><br>

    </form>

    <a href=" {{ route('login') }} ">Login</a><br><br>
    
@endsection