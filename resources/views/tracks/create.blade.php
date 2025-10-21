@extends('layouts.admin')

@section('page-title', 'Gerar Etiquetas')
@section('breadcrumb')
    <li>
        <span class="text-gray-500">/</span>
        <span class="text-gray-700 ml-2">Gerar Etiquetas</span>
    </li>
@endsection

@section('content')
    <!-- Container Principal -->
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">

            <!-- Cabeçalho da Página -->
            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-2xl font-bold text-gray-900">Range de Etiquetas</h1>
                        <p class="text-sm text-gray-600 mt-1">Gerar novos códigos de rastreamento</p>
                    </div>

                    <!-- Botão: Etiquetas Disponíveis -->
                    @can('index-range')
                        <a href="{{ route('tracks.index') }}"
                            class="inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-lg shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 hover:shadow-md transition-all duration-200">
                            <svg class="w-4 h-4 mr-2 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                            Etiquetas Disponíveis
                        </a>
                    @endcan
                </div>

                <!-- Breadcrumb -->
                <nav class="mt-4 flex" aria-label="Breadcrumb">
                    <ol class="flex items-center space-x-2 text-sm text-gray-500">
                        <li>
                            <a href="{{ route('dashboard.index') }}" class="hover:text-gray-700 transition-colors">
                                Dashboard
                            </a>
                        </li>
                        <li class="flex items-center">
                            <svg class="w-4 h-4 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                            </svg>
                            <span class="text-gray-700">Gerar Etiquetas</span>
                        </li>
                    </ol>
                </nav>
            </div>

            <!-- Grid de Layout -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

                <!-- Card do Formulário -->
                <div class="lg:col-span-2">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">

                        <!-- Cabeçalho do Card -->
                        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 px-6 py-4 border-b border-gray-200">
                            <div class="flex items-center">
                                <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-semibold text-gray-900">Gerar Novas Etiquetas</h2>
                                    <p class="text-sm text-gray-600 mt-1">Crie um novo lote de códigos de rastreamento</p>
                                </div>
                            </div>
                        </div>

                        <!-- Formulário -->
                        <form action="{{ route('tracks.store') }}" method="POST" class="p-6">
                            @csrf

                            <!-- Campo Quantidade -->
                            <div class="mb-6">
                                <label for="amount" class="block text-sm font-medium text-gray-700 mb-2">
                                    <span class="flex items-center">
                                        <svg class="w-4 h-4 mr-1 text-blue-500" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                        Quantidade de Etiquetas
                                    </span>
                                </label>

                                <div class="relative">
                                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}"
                                        placeholder="Ex: 1000" required min="500"
                                        class="w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors
                                                  placeholder-gray-400"
                                        oninput="updatePreview(this.value)">

                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                </div>

                                <!-- Informações e Validação -->
                                <div class="mt-2 space-y-1">
                                    @error('amount')
                                        <p class="text-red-500 text-sm flex items-center">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            {{ $message }}
                                        </p>
                                    @enderror
                                    <p class="text-xs text-gray-500">
                                        Mínimo: 500 etiquetas por lote
                                    </p>
                                </div>
                            </div>

                            <!-- Preview Dinâmico -->
                            <div id="previewSection" class="mb-6 p-4 bg-gray-50 rounded-lg border border-gray-200 hidden">
                                <h4 class="text-sm font-medium text-gray-700 mb-2">Prévia do Lote</h4>
                                <div class="text-sm text-gray-600">
                                    <p>Serão geradas: <span id="previewAmount" class="font-semibold text-blue-600">0</span>
                                        etiquetas</p>
                                    <p class="text-xs text-gray-500 mt-1">As etiquetas ficarão disponíveis para uso
                                        imediatamente após a geração</p>
                                </div>
                            </div>

                            <!-- Botão de Ação -->
                            <div class="flex justify-end pt-4 border-t border-gray-200">
                                <button type="submit" id="submitButton"
                                    class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold rounded-lg shadow-sm 
                                               hover:from-green-600 hover:to-emerald-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2 
                                               transform hover:scale-105 transition-all duration-200 cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed">
                                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                    Gerar Etiquetas
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Card Informativo -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-sm border border-gray-200 p-6">
                        <div class="flex items-center mb-4">
                            <div class="p-2 bg-blue-100 rounded-lg mr-3">
                                <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold text-gray-900">Informações</h3>
                        </div>

                        <div class="space-y-4 text-sm text-gray-600">
                            <div class="flex items-start">
                                <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <p>As etiquetas são geradas em lotes sequenciais</p>
                            </div>

                            <div class="flex items-start">
                                <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <p>Cada lote possui um range único de códigos</p>
                            </div>

                            <div class="flex items-start">
                                <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <p>Mínimo de 500 etiquetas por geração</p>
                            </div>

                            <div class="flex items-start">
                                <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5 flex-shrink-0" fill="none"
                                    stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                                <p>Processo rápido e automático</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Alertas -->
            <div class="mt-6">
                <x-alert />
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function updatePreview(value) {
            const previewSection = document.getElementById('previewSection');
            const previewAmount = document.getElementById('previewAmount');
            const submitButton = document.getElementById('submitButton');

            if (value && value >= 500) {
                previewAmount.textContent = parseInt(value).toLocaleString('pt-BR');
                previewSection.classList.remove('hidden');
                submitButton.disabled = false;
            } else {
                previewSection.classList.add('hidden');
                submitButton.disabled = true;
            }
        }

        // Inicializar preview se já houver valor
        document.addEventListener('DOMContentLoaded', function() {
            const amountInput = document.getElementById('amount');
            if (amountInput.value) {
                updatePreview(amountInput.value);
            }
        });
    </script>
@endpush
