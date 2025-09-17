@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Embalagens</h2>

        <!-- Botões de Ação (visíveis de acordo com permissões do usuário) -->
        <div class="flex flex-wrap gap-3">

            <!-- Botão: Voltar para a lista de embalagens -->
            @can('index-packaging')
                <a href="{{ route('packagings.index') }}"
                    class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                    <!-- Ícone -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Lista Completa
                </a>
            @endcan

            <!-- Botão: Visualizar embalagem atual -->
            @can('show-packaging')
                <a href="{{ route('packagings.show', $packaging->id) }}"
                    class="flex items-center px-4 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-700 transition-all shadow-md hover:shadow-lg">
                    <!-- Ícone -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    Visualizar
                </a>
            @endcan
        </div>
    </div>

    <!-- Alerta de Sucesso/Erro -->
    <div class="mt-4">
        <x-alert />
    </div>

    <!-- Formulário de Edição da Embalagem -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 mt-6 overflow-hidden">
        <form action="{{ route('packagings.update', $packaging->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Necessário para atualizar registros com método PUT -->

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Título da Seção -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
                        </svg>
                        Informações Básicas
                    </h3>
                </div>

                <!-- Campo: Nome -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome*</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $packaging->name) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Nome da embalagem" required>
                </div>

                <!-- Campo: Status (Ativo/Inativo) -->
                <div class="space-y-2">
                    <label for="active" class="block text-sm font-medium text-gray-700">Status*</label>
                    <select name="active" id="active"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        required>
                        <option value="1" {{ old('active', $packaging->active) == 1 ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ old('active', $packaging->active) == 0 ? 'selected' : '' }}>Inativo
                        </option>
                    </select>
                </div>

                <!-- Título da Seção: Dimensões -->
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3" />
                        </svg>
                        Dimensões (cm)
                    </h3>
                </div>

                <!-- Campo: Altura -->
                <div class="space-y-2">
                    <label for="height" class="block text-sm font-medium text-gray-700">Altura*</label>
                    <input type="number" step="0.01" name="height" id="height"
                        value="{{ old('height', $packaging->height) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Altura em centímetros" required>
                </div>

                <!-- Campo: Largura -->
                <div class="space-y-2">
                    <label for="width" class="block text-sm font-medium text-gray-700">Largura*</label>
                    <input type="number" step="0.01" name="width" id="width"
                        value="{{ old('width', $packaging->width) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Largura em centímetros" required>
                </div>

                <!-- Campo: Comprimento -->
                <div class="space-y-2">
                    <label for="length" class="block text-sm font-medium text-gray-700">Comprimento*</label>
                    <input type="number" step="0.01" name="length" id="length"
                        value="{{ old('length', $packaging->length) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Comprimento em centímetros" required>
                </div>

                <!-- Campo: Diâmetro -->
                <div class="space-y-2">
                    <label for="diameter" class="block text-sm font-medium text-gray-700">Diâmetro*</label>
                    <input type="number" step="0.01" name="diameter" id="diameter"
                        value="{{ old('diameter', $packaging->diameter) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Diâmetro em centímetros" required>
                </div>

                <!-- Campo: Peso -->
                <div class="space-y-2">
                    <label for="weight" class="block text-sm font-medium text-gray-700">Peso (g)*</label>
                    <input type="number" step="0.01" name="weight" id="weight"
                        value="{{ old('weight', $packaging->weight) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Peso em gramas" required>
                </div>
            </div>

            <!-- Rodapé do Formulário: Botão de Enviar -->
            <div class="px-6 py-4 border-t border-blue-200 bg-gray-50 flex justify-end">
                <button type="submit"
                    class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Salvar Alterações
                </button>
            </div>
        </form>
    </div>
@endsection
