@extends('layouts.login')

@section('content')

<body class="bg-login">
    <div class="card-login">
        <!-- Logo -->
        <div class="logo-wrapper-login">
            <a href="/">
                <img src="/logo-define-500x500_v3.png" alt="Logo" class="logo-login">
            </a>
        </div>

        <!-- Título -->
        <h1 class="title-login">Recuperar a Senha</h1>

        <!-- Formulário -->
        <form action="{{ route('password.email') }}" method="POST" class="mt-4">
            @csrf
            @method('POST')

            <!-- Campo de e-mail -->
            <div class="form-group-login">
                <label for="email" class="form-label-login">E-mail</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="Digite o e-mail cadastrado" 
                    class="form-input-login" 
                    required
                > 
            </div>

            <!-- Alerta de feedback -->
            <x-alert />

            <!-- Botões -->
            <div class="btn-group-login">
                <a href="{{ route('login') }}" class="link-login">Login</a>
                <button type="submit" class="btn-primary">Recuperar</button>
            </div>

            <!-- Link de registro -->
            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="link-login">Criar nova conta!</a>
            </div>
        </form>
    </div>
</body>

@endsection
