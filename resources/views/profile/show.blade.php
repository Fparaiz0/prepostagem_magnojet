@extends('layouts.admin')

@section('page-title', 'Perfil do Usuário')
@section('breadcrumb')
    <li>
        <span class="text-gray-500">/</span>
        <span class="text-gray-700 ml-2">Perfil</span>
    </li>
@endsection

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Cabeçalho da Página -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-2xl font-bold text-gray-900">Perfil do Usuário</h1>
                        <p class="text-sm text-gray-600 mt-1">Informações e configurações da conta</p>
                    </div>

                    <div class="flex flex-wrap gap-3">
                        <a href="{{ route('profile.edit', $user->id) }}"
                            class="inline-flex items-center px-5 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 transition-colors shadow-sm hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Editar Perfil
                        </a>

                        <a href="{{ route('profile.edit_password', $user->id) }}"
                            class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors shadow-sm hover:shadow-md">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                            Alterar Senha
                        </a>
                    </div>
                </div>

                <!-- Breadcrumb -->
                <nav class="mt-4 flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm text-gray-500">
                        <li>
                            <a href="{{ route('dashboard.index') }}" class="hover:text-gray-700 transition-colors">
                                Dashboard
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="text-gray-700">Perfil</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Alert -->
            <div class="mb-6">
                <x-alert />
            </div>

            <!-- Profile Information -->
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

                <!-- Card do Avatar e Status -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6 text-center">
                        <!-- Avatar -->
                        <div class="relative inline-block">
                            <div
                                class="w-32 h-32 bg-linear-to-r from-indigo-100 to-purple-100 rounded-full flex items-center justify-center mb-4 mx-auto">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-indigo-500" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <!-- Status Indicator -->
                            <div class="absolute bottom-4 right-4 w-6 h-6 bg-green-500 border-4 border-white rounded-full">
                            </div>
                        </div>

                        <h2 class="text-xl font-semibold text-gray-800 mb-2">{{ $user->name }}</h2>

                        <!-- Status Badge -->
                        <span
                            class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-blue-100 text-blue-800 mb-4">
                            <svg class="w-3 h-3 mr-1" fill="currentColor" viewBox="0 0 8 8">
                                <circle cx="4" cy="4" r="3" />
                            </svg>
                            {{ $user->userStatus->name }}
                        </span>

                        <!-- Quick Stats -->
                        <div class="mt-6 pt-6 border-t border-gray-200 space-y-3">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Membro desde</span>
                                <span class="text-gray-900 font-medium">{{ $user->created_at->format('m/Y') }}</span>
                            </div>
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">ID</span>
                                <span class="text-gray-900 font-mono font-medium">#{{ $user->id }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Card de Informações Detalhadas -->
                <div class="lg:col-span-3">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                        <!-- Header do Card -->
                        <div class="bg-linear-to-r from-gray-50 to-gray-100 px-6 py-4 border-b border-gray-200">
                            <h3 class="text-lg font-semibold text-gray-900">Informações do Perfil</h3>
                            <p class="text-sm text-gray-600 mt-1">Dados pessoais e informações da conta</p>
                        </div>

                        <!-- Conteúdo -->
                        <div class="p-6">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Informações Pessoais -->
                                <div class="space-y-6">
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            Informações Pessoais
                                        </h4>
                                        <div class="space-y-4">
                                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                                                <p class="text-xs font-medium text-blue-600 uppercase tracking-wider mb-1">
                                                    Nome Completo</p>
                                                <p class="text-gray-800 font-medium">{{ $user->name }}</p>
                                            </div>

                                            <div class="bg-blue-50 rounded-lg p-4 border border-blue-100">
                                                <p class="text-xs font-medium text-blue-600 uppercase tracking-wider mb-1">
                                                    Endereço de E-mail</p>
                                                <p class="text-gray-800 font-medium">{{ $user->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Informações da Conta -->
                                <div class="space-y-6">
                                    <div>
                                        <h4 class="text-sm font-semibold text-gray-900 mb-4 flex items-center">
                                            <svg class="w-4 h-4 mr-2 text-green-500" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            Informações da Conta
                                        </h4>
                                        <div class="space-y-4">
                                            <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                                                <p
                                                    class="text-xs font-medium text-green-600 uppercase tracking-wider mb-1">
                                                    Status da Conta</p>
                                                <div class="flex items-center">
                                                    <span
                                                        class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                        {{ $user->userStatus->name }}
                                                    </span>
                                                    <span class="ml-2 text-xs text-green-600">✓ Conta ativa</span>
                                                </div>
                                            </div>

                                            <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                                                <p
                                                    class="text-xs font-medium text-green-600 uppercase tracking-wider mb-1">
                                                    Data de Cadastro</p>
                                                <p class="text-gray-800 font-medium">
                                                    {{ $user->created_at->format('d/m/Y \\à\\s H:i') }}</p>
                                            </div>

                                            <div class="bg-green-50 rounded-lg p-4 border border-green-100">
                                                <p
                                                    class="text-xs font-medium text-green-600 uppercase tracking-wider mb-1">
                                                    Última Atualização</p>
                                                <p class="text-gray-800 font-medium">
                                                    {{ $user->updated_at->format('d/m/Y \\à\\s H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- ID do Usuário -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="bg-gray-50 rounded-lg p-4 border border-gray-200">
                                    <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">ID do
                                        Usuário</p>
                                    <p
                                        class="text-gray-800 font-mono text-sm bg-white px-3 py-2 rounded border border-gray-300 inline-block">
                                        {{ $user->id }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
