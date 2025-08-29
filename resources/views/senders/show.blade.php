@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Remetentes</h2>
        <div class="flex flex-wrap gap-3">
            @can('index-sender')
            <a href="{{ route('senders.index') }}" 
               class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 transition-all shadow-xs hover:shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                </svg>
                Lista Completa
            </a>
            @endcan
            
            @can('edit-sender')
            <a href="{{ route('senders.edit', ['sender' => $sender->id]) }}" 
               class="flex items-center px-4 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all shadow-md hover:shadow-lg">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                </svg>
                Editar Cadastro
            </a>
            @endcan
        </div>
    </div><br>
            
    <x-alert />

    <!-- Container Principal -->
    <div class="bg-white rounded-2xl shadow-lg overflow-hidden border border-gray-100">
        <!-- Seção de Informações -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 p-8">
            <!-- Informações Básicas -->
            <div class="lg:col-span-2">
                <div class="flex items-center mb-6">
                    <div class="bg-indigo-100 p-2 rounded-lg mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Dados Cadastrais</h3>
                </div>
                
                <div class="space-y-5">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Nome Completo</p>
                            <p class="text-gray-800 font-medium">{{ $sender->name }}</p>
                        </div>
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">CNPJ</p>
                            <p class="text-gray-800 font-mono">{{ $sender->cnpj }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Metadados -->
            <div>
                <div class="flex items-center mb-6">
                    <div class="bg-purple-100 p-2 rounded-lg mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Registro</h3>
                </div>
                
                <div class="space-y-5">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Cadastrado em</p>
                        <p class="text-gray-800">
                            {{ \Carbon\Carbon::parse($sender->created_at)->format('d/m/Y') }}
                            <span class="text-gray-400 mx-2">•</span>
                            {{ \Carbon\Carbon::parse($sender->created_at)->format('H:i') }}
                        </p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Última atualização</p>
                        <p class="text-gray-800">
                            {{ \Carbon\Carbon::parse($sender->updated_at)->format('d/m/Y') }}
                            <span class="text-gray-400 mx-2">•</span>
                            {{ \Carbon\Carbon::parse($sender->updated_at)->format('H:i') }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Endereço Completo -->
            <div class="lg:col-span-3">
                <div class="flex items-center mb-6">
                    <div class="bg-blue-100 p-2 rounded-lg mr-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                    </div>
                    <h3 class="text-xl font-semibold text-gray-800">Endereço Completo</h3>
                </div>
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">CEP</p>
                        <p class="text-gray-800 font-mono">{{ $sender->cep }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Estado</p>
                        <p class="text-gray-800">{{ $sender->uf }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Cidade</p>
                        <p class="text-gray-800">{{ $sender->city }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Logradouro</p>
                        <p class="text-gray-800">{{ $sender->public_place }}</p>
                    </div>
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Número</p>
                        <p class="text-gray-800 font-medium">{{ $sender->number }}</p>
                    </div>
                    
                    @if($sender->complement)
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Complemento</p>
                        <p class="text-gray-800">{{ $sender->complement }}</p>
                    </div>
                    @endif
                    
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-1">Bairro</p>
                        <p class="text-gray-800">{{ $sender->neighborhood }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Rodapé com Ação de Exclusão -->
        @can('destroy-sender')
        <div class="px-8 py-6 border-t border-gray-100 bg-gray-50 flex justify-end">
            <form action="{{ route('senders.destroy', ['sender' => $sender->id]) }}" method="POST">
                @csrf
                @method('delete')
                <button type="submit" 
                        onclick="return confirm('Tem certeza que deseja excluir permanentemente este remetente?')" 
                        class="flex items-center px-5 py-2.5 cursor-pointer bg-white border border-red-200 rounded-xl text-red-600 hover:bg-red-50 transition-all shadow-xs hover:shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                    Excluir Remetente
                </button>
            </form>
        </div>
        @endcan
    </div>
@endsection