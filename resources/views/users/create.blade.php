@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Usuários</h2>
        <div class="flex space-x-3 mt-4 md:mt-0">
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
        </div>
    </div>

    <div class="mt-5">
        <x-alert />
    </div>

    <!-- Formulário de Cadastro Melhorado -->
    <div class="bg-white rounded-2xl shadow-sm overflow-hidden mt-6 border border-blue-300">
        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            @method('POST')

            <div class="p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Informações Básicas -->
                <div class="md:col-span-2">
                    <div class="flex items-center pb-3 border-b border-blue-300">
                        <div class="bg-indigo-50 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-xl font-semibold text-gray-800">Informações Básicas</h3>
                    </div>
                </div>

                <div class="space-y-3">
                    <label for="name" class="block text-sm font-medium text-gray-700 items-center">
                        Nome
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-colors shadow-sm"
                        placeholder="Digite o nome completo" required>
                    <p class="text-xs text-gray-500 mt-1">Nome completo do usuário</p>
                </div>

                <div class="space-y-3">
                    <label for="email" class="block text-sm font-medium text-gray-700 items-center">
                        E-mail
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="email" name="email" id="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-colors shadow-sm"
                        placeholder="exemplo@email.com" required>
                    <p class="text-xs text-gray-500 mt-1">E-mail de acesso ao sistema</p>
                </div>

                <!-- Papéis do Usuário -->
                @can('edit-roles-user')
                    <div class="md:col-span-2 space-y-4 pt-4">
                        <div class="flex items-center pb-3 border-b border-gray-100">
                            <div class="bg-purple-50 p-2 rounded-lg">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M12 2a10 10 0 100 20 10 10 0 000-20z" />
                                </svg>
                            </div>
                            <h3 class="ml-3 text-xl font-semibold text-gray-800">Permissões de Acesso</h3>
                        </div>

                        <label class="block text-sm font-medium text-gray-700">Papéis e Permissões</label>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2 p-4 bg-gray-50 rounded-xl">
                            @forelse ($roles as $role)
                                @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                                    <div class="flex items-start">
                                        <div class="flex items-center h-5">
                                            <input type="checkbox" name="roles[]" id="role_{{ Str::slug($role) }}"
                                                value="{{ $role }}"
                                                {{ collect(old('roles'))->contains($role) ? 'checked' : '' }}
                                                class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                                        </div>
                                        <div class="ml-3 text-sm">
                                            <label for="role_{{ Str::slug($role) }}" class="font-medium text-gray-700">
                                                {{ $role }}
                                            </label>
                                            <p class="text-xs text-gray-500 mt-1">Permissões de {{ $role }}</p>
                                        </div>
                                    </div>
                                @endif
                            @empty
                                <p class="text-sm text-gray-500 col-span-2">Nenhum papel disponível.</p>
                            @endforelse
                        </div>
                    </div>
                @endcan

                <!-- Senha -->
                <div class="md:col-span-2 space-y-4 pt-4">
                    <div class="flex items-center pb-3 border-b border-gray-100">
                        <div class="bg-blue-50 p-2 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                            </svg>
                        </div>
                        <h3 class="ml-3 text-xl font-semibold text-gray-800">Segurança</h3>
                    </div>
                </div>

                <div class="space-y-3">
                    <label for="password" class="block text-sm font-medium text-gray-700 items-center">
                        Senha
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="password" name="password" id="password"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-colors shadow-sm"
                        placeholder="Crie uma senha segura" required>
                    <p class="text-xs text-gray-500 mt-1">Mínimo de 8 caracteres</p>
                </div>

                <div class="space-y-3">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 items-center">
                        Confirmar Senha
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="password" name="password_confirmation" id="password_confirmation"
                        class="w-full px-4 py-3 border border-gray-200 rounded-xl focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 transition-colors shadow-sm"
                        placeholder="Repita a senha" required>
                    <p class="text-xs text-gray-500 mt-1">Digite a mesma senha novamente</p>
                </div>
            </div>

            <!-- Rodapé do Formulário Melhorado -->
            <div
                class="px-8 py-5 border-t border-blue-300 bg-gray-50 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="text-sm text-gray-500">
                    <span class="text-red-500">*</span> Campos obrigatórios
                </div>
                <div class="flex space-x-3">
                    <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-xl hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors shadow-sm hover:shadow-md flex items-center">
                        Cadastrar
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
