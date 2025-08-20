@extends('layouts.login')

@section('content')

<body class="bg-gradient-to-r from-blue-950 to-blue-900 min-h-screen flex flex-col justify-center items-center">

    <!-- Card de Login -->
    <div class="mt-6 w-full overflow-hidden bg-white px-6 py-4 shadow-md sm:max-w-md sm:rounded-lg">

        <!-- Logo -->
        <div class="flex justify-center mb-4">
            <a href="/">
                <img src="/logo-define-500x500_v3.png" alt="Logo" class="h-26 w-44">
            </a>
        </div>

        <!-- Título -->
        <h1 class="text-2xl font-bold text-center text-blue-400">Área Restrita</h1> 

        <!-- Formulário de Login -->
        <form action="{{ route('login.process') }}" method="POST" class="mt-4">
            @csrf
            @method('POST')

            <!-- Campo: E-mail -->
            <div class="mt-4">
                <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                <input 
                    type="email" 
                    name="email" 
                    id="email" 
                    placeholder="Digite o e-mail" 
                    required
                    class="mt-1 block w-full rounded-md border-2 border-blue-100 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none px-3 py-2"
                >
            </div>

            <!-- Campo: Senha -->
            <div class="mt-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Senha</label>
                <input 
                    type="password" 
                    name="password" 
                    id="password" 
                    placeholder="Digite a senha" 
                    required
                    class="mt-1 block w-full rounded-md border-2 border-blue-100 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:outline-none px-3 py-2"
                >
            </div>

            <!-- Alertas -->
            <x-alert />

            <!-- Ações -->
            <div class="mt-4 flex items-center justify-between">
                <a 
                    href="{{ route('password.request') }}" 
                    class="text-ms text-blue-600 hover:no-underline"
                >
                    Esqueceu a senha?
                </a>
                
                <button 
                    type="submit"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 py-2 rounded focus:outline-none cursor-pointer"
                >
                    Acessar
                </button>
            </div>

            <!-- Link para registro -->
            <div class="mt-4 text-center">
                <a href="{{ route('register') }}" class="text-ms text-blue-600 hover:no-underline">
                    Criar nova conta!
                </a>
            </div>

        </form>
    </div>

</body>

@endsection