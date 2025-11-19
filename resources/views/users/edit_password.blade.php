@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Editar Senha</h2>
        <div class="flex flex-wrap gap-2">
            @can('index-user')
                <a href="{{ route('users.index') }}"
                    class="flex items-center px-4 py-2.5 bg-white border rounded-xl text-gray-700 hover:bg-indigo-50 transition-all shadow-xs hover:shadow-sm border-indigo-100 hover:border-indigo-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Listar Usuários
                </a>
            @endcan
            @can('show-user')
                <a href="{{ route('users.show', ['user' => $user->id]) }}"
                    class="flex items-center px-4 py-2 bg-white border border-blue-400 text-blue-500 rounded-lg hover:bg-blue-50 transition-colors shadow-sm">
                    <i class="fas fa-eye mr-2"></i> Visualizar
                </a>
            @endcan
        </div>
    </div>

    <!-- Container de alertas -->
    <div class="mb-6 fade-in">
        <x-alert />
    </div>

    <!-- Card do formulário -->
    <div class="bg-white rounded-xl shadow-md overflow-hidden slide-in">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-lock text-primary-500 mr-2"></i> Alteração de Senha
            </h2>
            <p class="text-sm text-gray-600 mt-1">Altere a senha do usuário {{ $user->name }}</p>
        </div>
        <div class="p-6">
            <form id="password-edit-form" action="{{ route('users.update_password', ['user' => $user->id]) }}"
                method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 gap-6 mb-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                            Nova Senha <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password" id="password"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition pr-10"
                                placeholder="Digite a nova senha" value="{{ old('password') }}" required minlength="8">
                            <button type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none"
                                onclick="togglePasswordVisibility('password', 'password-toggle')">
                                <i class="fas fa-eye-slash" id="password-toggle"></i>
                            </button>
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500">Mínimo de 8 caracteres</p>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                            Confirmar Nova Senha <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition pr-10"
                                placeholder="Confirme a nova senha" value="{{ old('password_confirmation') }}" required
                                minlength="8">
                            <button type="button"
                                class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-500 hover:text-gray-700 focus:outline-none"
                                onclick="togglePasswordVisibility('password_confirmation', 'password-confirmation-toggle')">
                                <i class="fas fa-eye-slash" id="password-confirmation-toggle"></i>
                            </button>
                        </div>
                        @error('password_confirmation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="bg-blue-50 border-l-4 border-blue-500 p-4 mb-6 rounded">
                    <div class="flex">
                        <div class="shrink-0">
                            <i class="fas fa-info-circle text-blue-400"></i>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-blue-700">
                                <strong>Requisitos de senha:</strong> Pelo menos 8 caracteres, incluindo letras maiúsculas,
                                minúsculas, números e símbolos.
                            </p>
                        </div>
                    </div>
                </div>

                <div
                    class="flex flex-col-reverse md:flex-row justify-end items-center gap-4 mt-8 pt-6 border-t border-gray-200">
                    <button type="submit"
                        class="flex items-center justify-center px-5 py-2.5 bg-blue-500 cursor-pointer text-white rounded-lg hover:bg-primary-600 focus:ring-4 focus:ring-primary-200 transition-colors">
                        <i class="fas fa-key mr-2"></i> Alterar Senha
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        .input-error {
            border-color: rgb(239 68 68) !important;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }

            to {
                opacity: 0;
                transform: translateY(-20px);
            }
        }

        .notification {
            animation: slideIn 0.3s forwards;
        }

        .notification.hide {
            animation: slideOut 0.3s forwards;
        }

        .fade-in {
            animation: fadeIn 0.5s ease-in;
        }

        .slide-in {
            animation: slideIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }
    </style>
@endsection
