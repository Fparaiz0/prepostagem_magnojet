@extends('layouts.login')

@section('content')

    <body class="bg-login">

        <div class="card-login">
            <div class="logo-wrapper-login">
                <a href="/">
                    <img src="/logo-define-500x500_v3.png" alt="Logo" class="logo-login">
                </a>
            </div>

            <h1 class="title-login">Novo Usuário</h1>

            <form action="{{ route('register.store') }}" method="POST" class="mt-4">
                @csrf
                @method('POST')

                <!-- Campo nome -->
                <div class="form-group-login">
                    <label for="name" class="form-label-login">Nome</label>
                    <input type="text" name="name" id="name" placeholder="Nome completo"
                        value="{{ old('name') }}" class="form-input-login" required>
                </div>

                <!-- Campo e-mail -->
                <div class="form-group-login">
                    <label for="email" class="form-label-login">E-mail</label>
                    <input type="email" name="email" id="email" placeholder="Melhor e-mail"
                        value="{{ old('email') }}" class="form-input-login" required>
                </div>

                <!-- Campo senha -->
                <div class="form-group-login">
                    <label for="password" class="form-label-login">Senha</label>
                    <input type="password" name="password" id="password" placeholder="Digite a senha"
                        value="{{ old('password') }}" class="form-input-login" required>
                </div>

                <!-- Campo confirmar senha -->
                <div class="form-group-login">
                    <label for="password" class="form-label-login">Confirmar senha</label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        placeholder="Confirmar a senha" value="{{ old('password_confirmation') }}" class="form-input-login"
                        required>
                </div>

                <x-alert />

                <!-- Link para página de login e botão cadastrar novo usuário -->
                <div class="btn-group-login">
                    <a href="{{ route('login') }}" class="link-login">Login</a>
                    <button type="submit" class="btn-primary">Cadastrar</button>
                </div>

            </form>
        </div>

    </body>
@endsection
