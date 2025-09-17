@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Status Usuários</h2>
        <div class="flex space-x-3 mt-4 md:mt-0">
            @can('index-user-status')
                <a href="{{ route('user_statuses.index') }}"
                    class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 transition-all shadow-xs hover:shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-600" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Listar Status
                </a>
            @endcan
        </div>
    </div>

    <div class="mt-5">
        <x-alert />
    </div>

    <!-- Formulário de Cadastro -->
    <div class="bg-white rounded-xl shadow-sm border border-blue-200 overflow-hidden mt-6">
        <form action="{{ route('user_statuses.store') }}" method="POST">
            @csrf
            @method('POST')

            <div class="p-6">
                <!-- Cabeçalho do Formulário -->
                <div class="pb-5 border-b border-blue-200">
                    <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 9v2m0 4h.01M4.93 19h14.14a2 2 0 001.74-3l-7.07-12a2 2 0 00-3.48 0l-7.07 12a2 2 0 001.74 3z" />
                        </svg>

                        Informações do Status
                    </h3>
                    <p class="text-sm text-gray-500 mt-2">Preencha as informações do novo status de usuário</p>
                </div>

                <!-- Campo Nome -->
                <div class="mt-6 space-y-2 max-w-md">
                    <label for="name" class="text-sm font-medium text-gray-700 flex items-center">
                        Nome do Status
                        <span class="text-red-500 ml-1">*</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 transition-colors"
                        placeholder="Ex: Ativo, Inativo, Pendente..." required>
                    <p class="text-xs text-gray-500">Digite um nome descritivo para o status</p>
                </div>
            </div>

            <!-- Rodapé do Formulário -->
            <div class="px-6 py-4 border-t border-blue-200 bg-gray-50 flex justify-between">
                <div class="text-sm text-gray-500">
                    Campos marcados com <span class="text-red-500">*</span> são obrigatórios
                </div>
                <div class="flex space-x-3">
                    <a href="{{ URL::previous() }}"
                        class="px-5 py-2 border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 transition-colors">
                        Cancelar
                    </a>
                    <button type="submit"
                        class="px-6 py-2 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Cadastrar Status
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
