@extends('layouts.login')

@section('content')

    <body class="min-h-screen bg-gradient-to-br from-blue-950 via-blue-900 to-blue-950 flex items-center justify-center p-4">

        <!-- Container Principal -->
        <div class="w-full max-w-md">

            <!-- Card de Recuperação de Senha -->
            <div class="bg-white rounded-2xl shadow-2xl border border-gray-100 overflow-hidden">

                <!-- Header -->
                <div class="bg-white px-8 py-8 text-center border-b border-gray-100">
                    <div class="flex justify-center mb-4">
                        <a href="/">
                            <img src="/logo-define-500x500_v3.png" alt="Logo" class="h-20 w-32">
                        </a>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-800">Recuperar a Senha</h1>
                    <p class="text-gray-600 text-sm mt-1">Informe seu e-mail cadastrado</p>
                </div>

                <!-- Formulário -->
                <div class="px-8 py-6">
                    <form action="{{ route('password.email') }}" method="POST" class="space-y-5">
                        @csrf
                        @method('POST')

                        <!-- Campo E-mail -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-2">
                                E-mail
                            </label>
                            <input type="email" name="email" id="email" placeholder="Digite o e-mail cadastrado"
                                required value="{{ old('email') }}"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                        </div>

                        <!-- Alertas -->
                        <x-alert />

                        <!-- Botões -->
                        <div class="flex items-center justify-between pt-4">
                            <a href="{{ route('login') }}"
                                class="text-blue-600 hover:text-blue-800 text-sm font-medium transition-colors">
                                Voltar ao Login
                            </a>
                            <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white font-semibold py-3 px-6 rounded-lg transition-colors cursor-pointer shadow-sm hover:shadow-md">
                                Recuperar Senha
                            </button>
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
