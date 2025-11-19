@extends('layouts.admin')

@section('page-title', 'Dashboard')
@section('breadcrumb')
    <li>
        <span class="text-gray-500">/</span>
        <span class="text-gray-700 ml-2">Dashboard</span>
    </li>
@endsection

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-2xl font-bold text-gray-900">Dashboard</h1>
                        <p class="text-sm text-gray-600 mt-1">Visão geral do sistema</p>
                    </div>

                    <nav class="flex items-center text-sm text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        <span>Página Inicial</span>
                    </nav>
                </div>
            </div>

            <div class="mb-6">
                <x-alert />
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Pré-Postagens</p>
                            <p class="text-2xl font-bold text-gray-800">{{ \App\Models\PrePostagem::count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-green-100 text-green-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Destinatários</p>
                            <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Recipient::count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Embalagens</p>
                            <p class="text-2xl font-bold text-gray-800">{{ \App\Models\Packaging::count() }}</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center">
                        <div class="p-3 rounded-lg bg-orange-100 text-orange-600 mr-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500">Etiquetas</p>
                            <p class="text-2xl font-bold text-gray-800">
                                {{ \App\Models\Range::count() }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-2xl shadow-sm border border-gray-200 mb-8 overflow-hidden">
                <div class="bg-linear-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                    <div class="flex items-center">
                        <div class="p-2 bg-blue-100 rounded-lg mr-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <h2 class="text-xl font-semibold text-gray-900">Bem-vindo, {{ Auth::user()->name }}! 👋</h2>
                            <p class="text-sm text-gray-600 mt-1">Sistema de Gestão de Pré-Postagem</p>
                        </div>
                    </div>
                </div>

                <div class="p-6">
                    <p class="text-gray-700 mb-6 text-lg leading-relaxed">
                        Este sistema foi desenvolvido para facilitar e otimizar o processo de preparação de envios
                        realizados pela
                        <a class="text-blue-600" href="https://www.magnojet.com.br/" target="_blank"
                            rel="noopener noreferrer">MagnoJet</a>. Aqui, você pode:
                    </p>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                        @foreach (['Gerenciar ranges de etiquetas de postagem', 'Cadastrar e organizar remetentes e destinatários', 'Registrar informações de embalagens', 'Controlar o fluxo de pré-postagens', 'Acompanhar usuários e permissões', 'Monitorar o processo logístico'] as $item)
                            <div class="flex items-start p-3 bg-gray-50 rounded-lg border border-gray-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-500 mr-3 mt-0.5 shrink-0"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <span class="text-gray-700">{{ $item }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div class="bg-blue-50 border-l-4 border-blue-400 p-4 rounded-lg">
                        <div class="flex">
                            <div class="shrink-0">
                                <svg class="h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2h-1V9z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <div class="ml-3">
                                <p class="text-sm text-blue-700">
                                    Nosso objetivo é garantir mais agilidade, controle e segurança no processo logístico da
                                    empresa,
                                    oferecendo uma plataforma centralizada e intuitiva.
                                    <strong class="block mt-2 font-semibold">Aproveite todos os recursos! 🚀</strong>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <a href="{{ route('prepostagens.create') }}"
                    class="group bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:border-blue-300 hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                    <div class="flex items-center">
                        <div
                            class="p-3 rounded-lg bg-blue-100 text-blue-600 mr-4 group-hover:bg-blue-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 group-hover:text-blue-600 transition-colors">
                                Pré-Postagem</p>
                            <p class="text-lg font-semibold text-gray-800 group-hover:text-blue-800 transition-colors">Nova
                                Pré-Postagem</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('recipients.index') }}"
                    class="group bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:border-green-300 hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                    <div class="flex items-center">
                        <div
                            class="p-3 rounded-lg bg-green-100 text-green-600 mr-4 group-hover:bg-green-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 group-hover:text-green-600 transition-colors">
                                Destinatários</p>
                            <p class="text-lg font-semibold text-gray-800 group-hover:text-green-800 transition-colors">
                                Gerenciar Cadastros</p>
                        </div>
                    </div>
                </a>

                <a href="{{ route('packagings.index') }}"
                    class="group bg-white rounded-2xl shadow-sm border border-gray-200 p-6 hover:border-purple-300 hover:shadow-lg transition-all duration-200 transform hover:scale-105">
                    <div class="flex items-center">
                        <div
                            class="p-3 rounded-lg bg-purple-100 text-purple-600 mr-4 group-hover:bg-purple-200 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 group-hover:text-purple-600 transition-colors">
                                Embalagens</p>
                            <p class="text-lg font-semibold text-gray-800 group-hover:text-purple-800 transition-colors">
                                Tipos e Dimensões</p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
@endsection
