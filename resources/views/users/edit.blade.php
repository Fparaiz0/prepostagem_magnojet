@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Usuários</h2>
        <div class="flex flex-wrap gap-2">
            @can('index-user')
                <a href="{{ route('users.index') }}"
                    class="flex items-center px-4 py-2.5 bg-white borde rounded-xl text-gray-700 hover:bg-indigo-50 transition-all shadow-xs hover:shadow-sm border-indigo-100 hover:border-indigo-200">
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
                <i class="fas fa-user text-primary-500 mr-2"></i> Informações do Usuário
            </h2>
        </div>
        <div class="p-6">
            <form id="user-edit-form" action="{{ route('users.update', ['user' => $user->id]) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                    <div>
                        <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                            Nome completo <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="name" id="name"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
                            placeholder="Digite o nome completo" value="{{ old('name', $user->name) }}" required>
                        <p class="mt-1.5 text-xs text-gray-500">Mínimo de 3 caracteres</p>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                            E-mail <span class="text-red-500">*</span>
                        </label>
                        <input type="email" name="email" id="email"
                            class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-500 focus:border-primary-500 outline-none transition"
                            placeholder="Digite o e-mail válido" value="{{ old('email', $user->email) }}" required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                @can('edit-roles-user')
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">Papéis do Usuário</label>
                        <div class="flex flex-wrap gap-2 mt-2" id="roles-container">
                            @forelse ($roles as $role)
                                @if ($role != 'Super Admin' || Auth::user()->hasRole('Super Admin'))
                                    <div class="role-item">
                                        <input type="checkbox" name="roles[]" id="role_{{ Str::slug($role) }}"
                                            value="{{ $role }}" class="role-checkbox hidden"
                                            {{ in_array($role, old('roles', $userRoles)) ? 'checked' : '' }}>
                                        <label for="role_{{ Str::slug($role) }}"
                                            class="role-label inline-flex items-center px-4 py-2 border rounded-full text-sm font-medium cursor-pointer transition-colors 
                                        {{ in_array($role, old('roles', $userRoles))
                                            ? 'border-primary-500 bg-primary-100 text-primary-700'
                                            : 'border-gray-300 text-gray-700 hover:bg-gray-100' }}">
                                            {{ $role }}
                                        </label>
                                    </div>
                                @endif
                            @empty
                                <p class="text-gray-500">Nenhum papel disponível.</p>
                            @endforelse
                        </div>
                        <p class="mt-1.5 text-xs text-gray-500">Selecione pelo menos um papel para o usuário</p>
                    </div>
                @endcan

                <div
                    class="flex flex-col-reverse md:flex-row justify-between items-center gap-4 mt-8 pt-6 border-t border-gray-200">
                    <a href="{{ URL::previous() }}"
                        class="w-full md:w-auto flex items-center justify-center px-5 py-2.5 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <i class="fas fa-arrow-left mr-2"></i> Voltar
                    </a>
                    <button type="submit"
                        class="w-full md:w-auto flex items-center justify-center px-5 py-2.5 cursor-pointer bg-blue-500 text-white rounded-lg hover:bg-primary-600 focus:ring-4 focus:ring-primary-200 transition-colors">
                        <i class="fas fa-save mr-2"></i> Salvar Alterações
                    </button>
                </div>
            </form>
        </div>
    </div>

    <style>
        /* Estilização para os checkboxes de papéis */
        .role-checkbox:checked+.role-label {
            border-color: rgb(59 130 246);
            background-color: rgb(219 234 254);
            color: rgb(29 78 216);
        }

        /* Estilo para validação */
        .input-error {
            border-color: rgb(239 68 68) !important;
        }

        /* Animações para notificações */
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
    </style>
@endsection
