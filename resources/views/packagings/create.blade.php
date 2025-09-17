@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Embalagens</h2>

        <!-- Botão: Lista Completa -->
        <div class="flex flex-wrap gap-3">
            @can('index-packaging')
                <a href="{{ route('packagings.index') }}"
                    class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Lista Completa
                </a>
            @endcan
        </div>
    </div>

    <!-- Componente de Alerta (mensagens de sucesso/erro) -->
    <div class="mt-4">
        <x-alert />
    </div>

    <!-- Formulário de Cadastro de Embalagem -->
    <div class="bg-white rounded-lg shadow-md border border-gray-200 mt-6 overflow-hidden">
        <form action="{{ route('packagings.store') }}" method="POST">
            @csrf

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Seção: Informações Básicas -->
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

                <!-- Campo: Nome da Embalagem -->
                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome*</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('name') border-red-500 @enderror"
                        placeholder="Nome da embalagem" required>
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo: Status da Embalagem -->
                <div class="space-y-2">
                    <label for="active" class="block text-sm font-medium text-gray-700">Status*</label>
                    <select name="active" id="active"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('active') border-red-500 @enderror"
                        required>
                        <option value="1" {{ old('active', '1') == '1' ? 'selected' : '' }}>Ativo</option>
                        <option value="0" {{ old('active') == '0' ? 'selected' : '' }}>Inativo</option>
                    </select>
                    @error('active')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Seção: Dimensões -->
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
                    <input type="number" step="0.01" name="height" id="height" value="{{ old('height') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('height') border-red-500 @enderror"
                        placeholder="Altura em centímetros" required>
                    @error('height')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo: Largura -->
                <div class="space-y-2">
                    <label for="width" class="block text-sm font-medium text-gray-700">Largura*</label>
                    <input type="number" step="0.01" name="width" id="width" value="{{ old('width') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('width') border-red-500 @enderror"
                        placeholder="Largura em centímetros" required>
                    @error('width')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo: Comprimento -->
                <div class="space-y-2">
                    <label for="length" class="block text-sm font-medium text-gray-700">Comprimento*</label>
                    <input type="number" step="0.01" name="length" id="length" value="{{ old('length') }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('length') border-red-500 @enderror"
                        placeholder="Comprimento em centímetros" required>
                    @error('length')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo: Diâmetro -->
                <div class="space-y-2">
                    <label for="diameter" class="block text-sm font-medium text-gray-700">Diâmetro*</label>
                    <input type="number" step="0.01" name="diameter" id="diameter" value="{{ old('diameter', 0) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('diameter') border-red-500 @enderror"
                        placeholder="Diâmetro em centímetros" required>
                    @error('diameter')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Campo: Peso -->
                <div class="space-y-2">
                    <label for="weight" class="block text-sm font-medium text-gray-700">Peso (g)*</label>
                    <input type="number" step="0.01" name="weight" id="weight" value="{{ old('weight', 1) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500 @error('weight') border-red-500 @enderror"
                        placeholder="Peso em gramas" required>
                    @error('weight')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Rodapé do Formulário: Botão de Enviar -->
            <div class="px-6 py-4 border-t border-blue-200 bg-gray-50 flex justify-end">
                <button type="submit"
                    class="px-6 py-2.5 bg-indigo-600 text-white font-medium rounded-lg hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition-colors">
                    Cadastrar
                </button>
            </div>
        </form>
    </div>
@endsection
