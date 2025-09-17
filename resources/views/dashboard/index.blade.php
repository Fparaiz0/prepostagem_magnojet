@extends('layouts.admin')

@section('content')
    <x-alert />

    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Página inicial</h2>

        <div class="flex flex-wrap gap-3">
            <nav class="flex items-center text-sm text-gray-500 mt-1">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
                <span>Página Inicial</span>
            </nav>
        </div>
    </div>

    <!-- Content Box -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 mt-6 overflow-hidden">
        <!-- Welcome Section -->
        <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
            <h2 class="text-xl font-semibold text-gray-800">
                Bem-vindo, {{ Auth::user()->name }}!
            </h2>
        </div>

        <!-- System Description -->
        <div class="p-6">
            <p class="text-gray-700 mb-4">
                Este sistema foi desenvolvido para facilitar e otimizar o processo de preparação de envios realizados pela
                MagnoJet. Aqui, você pode:
            </p>

            <ul class="list-disc list-inside text-gray-700 mb-6 space-y-2 pl-4">
                @foreach (['Gerenciar ranges de etiquetas de postagem', 'Cadastrar e organizar remetentes e destinatários', 'Registrar informações de embalagens', 'Controlar o fluxo de pré-postagens de forma simples e eficiente', 'Acompanhar usuários, permissões e níveis de acesso conforme as funções da equipe'] as $item)
                    <li class="flex items-start">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500 mr-2 mt-0.5 flex-shrink-0"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                        </svg>
                        <span>{{ $item }}</span>
                    </li>
                @endforeach
            </ul>

            <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded">
                <div class="flex">
                    <div class="flex-shrink-0">
                        <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                            fill="currentColor">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                                clip-rule="evenodd" />
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm text-blue-700">
                            Nosso objetivo é garantir mais agilidade, controle e segurança no processo logístico da empresa,
                            oferecendo uma plataforma centralizada e intuitiva.
                            <strong class="block mt-1 font-medium">Aproveite todos os recursos!</strong>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Quick Access Section -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <!-- Pré-Postagem -->
        <a href="{{ route('prepostagens.create') }}"
            class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:border-indigo-300 hover:shadow-md transition-all">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Pré-Postagem</p>
                    <p class="text-lg font-semibold text-gray-800">Cadastrar Pré-Postagem</p>
                </div>
            </div>
        </a>

        <!-- Destinatários -->
        <a href="{{ route('recipients.index') }}"
            class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:border-indigo-300 hover:shadow-md transition-all">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Destinatários</p>
                    <p class="text-lg font-semibold text-gray-800">Gerenciar Cadastros</p>
                </div>
            </div>
        </a>

        <!-- Embalagens -->
        <a href="{{ route('packagings.index') }}"
            class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 hover:border-indigo-300 hover:shadow-md transition-all">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600 mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-500">Embalagens</p>
                    <p class="text-lg font-semibold text-gray-800">Tipos e Dimensões</p>
                </div>
            </div>
        </a>
    </div>
@endsection
