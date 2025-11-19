@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Alterar Senha</h2>
        <div class="flex flex-wrap gap-3">
            <a href="{{ route('profile.show') }}"
                class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                </svg>
                Voltar para Perfil
            </a>
        </div>
    </div>

    <div class="mt-4">
        <x-alert />
    </div>

    <div class="bg-white rounded-lg shadow-md border border-gray-200 mt-6 overflow-hidden">
        <form action="{{ route('profile.update_password') }}" method="POST">
            @csrf
            @method('PUT')
            <div class="p-6 space-y-6">
                <div class="space-y-2">
                    <label for="current_password" class="block text-sm font-medium text-gray-700">Senha Atual*</label>
                    <div class="relative">
                        <input type="password" name="current_password" id="current_password"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('current_password') border-red-500 @enderror"
                            placeholder="Digite sua senha atual" required>
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password" class="block text-sm font-medium text-gray-700">Nova Senha*</label>
                    <div class="relative">
                        <input type="password" name="password" id="password"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('password') border-red-500 @enderror"
                            placeholder="Mínimo de 8 caracteres" required>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="text-xs text-gray-500 mt-1">
                        <p id="password-strength" class="hidden">Força da senha: <span class="font-medium"
                                id="strength-text"></span></p>
                        <ul class="list-disc pl-5 text-xs text-gray-500 mt-1">
                            <li>Mínimo 8 caracteres</li>
                            <li>Pelo menos 1 letra maiúscula</li>
                            <li>Pelo menos 1 número</li>
                        </ul>
                    </div>
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirmar Nova
                        Senha*</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            class="w-full px-4 py-2 border rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('password_confirmation') border-red-500 @enderror"
                            placeholder="Digite a nova senha novamente" required>
                    </div>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-blue-200 bg-gray-50 flex justify-end">
                <button type="submit"
                    class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Salvar Nova Senha
                </button>
            </div>
        </form>
    </div>
@endsection
