@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Perfil do Usuário</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('profile.edit', $user->id) }}"
                class="flex items-center px-4 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar Perfil
            </a>

            <a href="{{ route('profile.edit_password', $user->id) }}"
                class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                </svg>
                Alterar Senha
            </a>
        </div>
    </div>

    <!-- Alert -->
    <div class="mt-4">
        <x-alert />
    </div>

    <!-- Profile Information -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 mt-6 overflow-hidden">
        <div class="p-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- User Avatar -->
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-indigo-500" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                <span class="mt-1 px-3 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                    {{ $user->userStatus->name }}
                </span>
            </div>

            <!-- User Details -->
            <div class="md:col-span-2">
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">ID do Usuário</p>
                        <p class="text-gray-800 font-mono">{{ $user->id }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Nome Completo</p>
                        <p class="text-gray-800">{{ $user->name }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Endereço de E-mail</p>
                        <p class="text-gray-800">{{ $user->email }}</p>
                    </div>

                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Data de Cadastro</p>
                        <p class="text-gray-800">{{ $user->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
