@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h2 class="content-title">Gerenciar Permissões do Papel</h2>
            <p class="text-sm text-gray-500 mt-1">Controle as permissões atribuídas ao papel: <span class="font-semibold text-purple-600">{{ $role->name }}</span></p>
        </div>
        <div class="flex space-x-3 mt-4 md:mt-0">
            @can('index-role')
            <a href="{{ route('roles.index') }}" 
                class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-indigo-50 transition-all shadow-xs hover:shadow-sm hover:border-indigo-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Listar Papéis
            </a>
            @endcan
        </div>
    </div>

    <div class="mt-5">
        <x-alert />
    </div>

    <!-- Informações do Papel -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mt-6 mb-6">
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50">
            <h3 class="text-lg font-semibold text-gray-800">Informações do Papel</h3>
        </div>
        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-1">
                    <label class="block text-xs font-medium text-gray-500">ID do Papel</label>
                    <p class="text-sm font-medium text-gray-800">{{ $role->id }}</p>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-medium text-gray-500">Nome do Papel</label>
                    <p class="text-lg font-semibold text-purple-600">{{ $role->name }}</p>
                </div>
                <div class="space-y-1">
                    <label class="block text-xs font-medium text-gray-500">Permissões Atribuídas</label>
                    <p class="text-sm font-medium text-gray-800">{{ count($rolePermissions ?? []) }} de {{ $permissions->count() }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Listagem de Permissões -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden mt-6">
        <!-- Cabeçalho da Tabela -->
        <div class="px-6 py-4 border-b border-gray-100 bg-gray-50 flex items-center justify-between">
            <h3 class="text-lg font-semibold text-gray-800">Permissões Disponíveis</h3>
            <span class="text-sm text-gray-500">{{ $permissions->count() }} permissões encontradas</span>
        </div>

        @forelse ($permissions as $permission)
        <div class="border-b border-gray-100 last:border-b-0">
            <div class="px-6 py-4 hover:bg-gray-50 transition-colors">
                <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                    <div class="flex-1">
                        <div class="flex items-center gap-3">
                            <div class="w-3 h-3 rounded-full bg-green-500 flex-shrink-0"></div>
                            <div>
                                <h4 class="text-lg font-medium text-gray-800">{{ $permission->title }}</h4>
                                <div class="flex flex-wrap gap-4 mt-1">
                                    <span class="text-xs bg-gray-100 text-gray-600 px-2 py-1 rounded">ID: {{ $permission->id }}</span>
                                    @can('create-permission')
                                    <span class="text-xs font-mono bg-blue-100 text-blue-600 px-2 py-1 rounded">{{ $permission->name }}</span>
                                    @endcan 
                                    <span class="text-xs bg-purple-100 text-purple-600 px-2 py-1 rounded">Papel: {{ $role->name }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex-shrink-0">
                        @if (in_array($permission->id, $rolePermissions ?? []))
                        <a href="{{ route('role-permissions.update', ['role' => $role->id, 'permission' => $permission->id]) }}"
                           class="flex items-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                            </svg>
                            Liberado
                            <span class="ml-2 text-xs text-green-500 group-hover:text-green-700">(Clique para bloquear)</span>
                        </a>
                        @else
                        <a href="{{ route('role-permissions.update', ['role' => $role->id, 'permission' => $permission->id]) }}"
                           class="flex items-center px-4 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors group">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            Bloqueado
                            <span class="ml-2 text-xs text-red-500 group-hover:text-red-700">(Clique para liberar)</span>
                        </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="px-6 py-12 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 mx-auto text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <h3 class="mt-4 text-lg font-medium text-gray-600">Nenhuma permissão encontrada</h3>
            <p class="mt-1 text-sm text-gray-500">Não há permissões cadastradas no sistema.</p>
        </div>
        @endforelse
    </div>

    <!-- Estatísticas -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mt-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="bg-blue-100 p-3 rounded-lg mr-4">
                  <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z" />
                  </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Total de Permissões</p>
                    <p class="text-2xl font-bold text-gray-800">{{ $permissions->count() }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="bg-green-100 p-3 rounded-lg mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Permissões Liberadas</p>
                    <p class="text-2xl font-bold text-green-600">{{ count($rolePermissions ?? []) }}</p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center">
                <div class="bg-red-100 p-3 rounded-lg mr-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </div>
                <div>
                    <p class="text-sm text-gray-500">Permissões Bloqueadas</p>
                    <p class="text-2xl font-bold text-red-600">{{ $permissions->count() - count($rolePermissions ?? []) }}</p>
                </div>
            </div>
        </div>
    </div>
@endsection