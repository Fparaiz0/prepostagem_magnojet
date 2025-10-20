@extends('layouts.login')

@section('content')

    <body class="min-h-screen bg-gradient-to-br from-blue-950 via-blue-900 to-blue-950 flex items-center justify-center p-4">

        <!-- Container Principal -->
        <div class="w-full max-w-md">

            <!-- Card de Login -->
            <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">

                <!-- Header -->
                <div class="bg-white px-8 py-8 text-center border-b border-gray-100">
                    <div class="flex justify-center mb-4">
                        <a href="/">
                            <img src="/logo-define-500x500_v3.png" alt="Logo" class="h-20 w-35">
                        </a>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Pré-Postagem</h1>
                    <p class="text-gray-600 text-sm mt-1">Sistema de Gestão</p>
                </div>

                <!-- Formulário -->
                <div class="px-8 py-6">
                    <form action="{{ route('login.process') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('POST')

                        <!-- Campo E-mail -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                E-mail
                            </label>
                            <input type="email" name="email" id="email" placeholder="seu@email.com" required
                                value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>

                        <!-- Campo Senha -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                                Senha
                            </label>
                            <input type="password" name="password" id="password" placeholder="Sua senha" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>

                        <!-- Alertas -->
                        <x-alert />

                        <!-- Botão -->
                        <button type="submit"
                            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-4 rounded-lg transition-colors cursor-pointer shadow-sm hover:shadow-md">
                            Acessar Sistema
                        </button>

                        <!-- Link Esqueci Senha -->
                        <div class="text-center">
                            <a href="{{ route('password.request') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                                Esqueceu sua senha?
                            </a>
                        </div>
                    </form>
                </div>

                <!-- Footer -->
                <div class="bg-gray-50 px-8 py-4 border-t border-gray-100 text-center">
                    <p class="text-xs text-gray-500">
                        &copy; {{ date('Y') }} MagnoJet
                    </p>
                </div>
            </div>
        </div>
    </body>
@endsection
