@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Usuários</h2>
        <div class="flex flex-wrap gap-3">
                @can('index-user')
            <a href="{{ route('users.index') }}" 
                class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-indigo-50 transition-all shadow-xs hover:shadow-sm border-indigo-100 hover:border-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Listar Usuários
            </a>
            @endcan

                @can('edit-user')
                <a href="{{ route('users.edit', $user->id) }}"
                   class="flex items-center px-4 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar
                </a>
                @endcan

                @can('edit-password-user')
                <a href="{{ route('users.edit_password', $user->id) }}"
                   class="flex items-center px-4 py-2.5 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Editar Senha
                </a>
                @endcan
            </div>
    </div>

    <!-- Alert -->
    <div class="mt-4">
        <x-alert />
    </div>

    <!-- User Details -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 mt-6 overflow-hidden">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 p-6">
            <!-- User Avatar -->
            <div class="flex flex-col items-center">
                <div class="w-32 h-32 bg-indigo-100 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                </div>
                <h2 class="text-xl font-semibold text-gray-800">{{ $user->name }}</h2>
                <span class="mt-2 px-3 py-1 rounded-full text-xs font-medium 
                    {{ $user->userStatus->name === 'Ativo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                    {{ $user->userStatus->name }}
                </span>

                @can('edit-password-user')
                <a href="{{ route('users.edit_password', $user->id) }}" 
                   class="mt-4 flex items-center px-3 py-1.5 text-sm bg-white border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                    </svg>
                    Alterar Senha
                </a>
                @endcan
            </div>

            <!-- User Details -->
            <div class="md:col-span-2">
                <div class="space-y-4">
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">ID do Usuário</p>
                        <p class="text-gray-800 font-mono">{{ $user->id }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Endereço de E-mail</p>
                        <p class="text-gray-800">{{ $user->email }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                        <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Papéis</p>
                        <div class="flex flex-wrap gap-2 mt-1">
                            @forelse ($user->getRoleNames() as $role)
                                <span class="px-2 py-1 text-xs font-medium rounded-full bg-indigo-100 text-indigo-800">
                                    {{ $role }}
                                </span>
                            @empty
                                <span class="text-gray-500">Nenhum papel atribuído</span>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Metadata -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 px-6 pb-6">
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Cadastrado em</p>
                <p class="text-gray-800">
                    {{ \Carbon\Carbon::parse($user->created_at)->format('d/m/Y H:i:s') }}
                    <span class="text-gray-400 text-sm">({{ $user->created_at->diffForHumans() }})</span>
                </p>
            </div>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-100">
                <p class="text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Última atualização</p>
                <p class="text-gray-800">
                    {{ \Carbon\Carbon::parse($user->updated_at)->format('d/m/Y H:i:s') }}
                    <span class="text-gray-400 text-sm">({{ $user->updated_at->diffForHumans() }})</span>
                </p>
            </div>
        </div>

        <!-- Delete Action -->
        @can('destroy-user')
        <div class="px-6 py-4 border-t border-gray-200 bg-gray-50 flex justify-end">
            <form action="{{ route('users.destroy', $user->id) }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit"
                        onclick="return confirm('Tem certeza que deseja apagar permanentemente este usuário? Esta ação não pode ser desfeita.')"
                        class="flex items-center px-4 py-2 bg-white border border-red-200 rounded-lg text-red-600 hover:bg-red-50 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Excluir Usuário
                </button>
            </form>
        </div>
        @endcan
    </div>
@endsection