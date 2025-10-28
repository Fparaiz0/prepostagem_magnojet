@extends('layouts.admin')

@section('content')
    <div class="content-header">
        <h2 class="content-title">Destinatários</h2>
        <div class="flex space-x-3 mt-4 md:mt-0">
            @can('index-recipient')
                <a href="{{ route('recipients.index') }}"
                    class="flex items-center px-4 py-2.5 bg-white border border-gray-200 rounded-xl text-gray-700 hover:bg-gray-50 transition-all shadow-xs hover:shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Lista Completa
                </a>
            @endcan
        </div>
    </div><br>

    <x-alert />

    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <form action="{{ route('recipients.store') }}" method="POST">
            @csrf

            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="md:col-span-2">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-indigo-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Informações Básicas
                    </h3>
                </div>

                <div class="space-y-2">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome*</label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                        class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Nome do destinatário" required>
                </div>

                <div class="space-y-2">
                    <label for="cnpj" class="block text-sm font-medium text-gray-700">CNPJ</label>
                    <input type="text" name="cnpj" id="cnpj" value="{{ old('cnpj') }}"
                        class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="00.000.000/0000-00">
                </div>

                <div class="md:col-span-2 mt-6">
                    <h3 class="text-lg font-semibold text-gray-800 mb-4 flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-500" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        Endereço
                    </h3>
                </div>

                <div class="space-y-2">
                    <label for="cep" class="block text-sm font-medium text-gray-700">CEP*</label>
                    <div class="relative">
                        <input type="text" name="cep" id="cep" value="{{ old('cep') }}"
                            class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                            placeholder="00000-000" required>
                        <div id="cep-loading" class="absolute inset-y-0 right-0 flex items-center pr-3 hidden">
                            <svg class="animate-spin h-5 w-5 text-blue-500" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                    stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <p id="cep-error" class="text-red-500 text-xs mt-1 hidden">CEP inválido ou não encontrado</p>
                </div>

                <div class="space-y-2">
                    <label for="uf" class="block text-sm font-medium text-gray-700">UF*</label>
                    <input type="text" name="uf" id="uf" value="{{ old('uf') }}"
                        class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="UF" required maxlength="2">
                </div>

                <div class="space-y-2 md:col-span-2">
                    <label for="public_place" class="block text-sm font-medium text-gray-700">Logradouro*</label>
                    <input type="text" name="public_place" id="public_place" value="{{ old('public_place') }}"
                        class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Rua, Avenida, etc." required>
                </div>

                <div class="space-y-2">
                    <label for="number" class="block text-sm font-medium text-gray-700">Número*</label>
                    <input type="text" name="number" id="number" value="{{ old('number') }}"
                        class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Número" required>
                </div>

                <div class="space-y-2">
                    <label for="complement" class="block text-sm font-medium text-gray-700">Complemento</label>
                    <input type="text" name="complement" id="complement" value="{{ old('complement') }}"
                        class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Complemento">
                </div>

                <div class="space-y-2">
                    <label for="neighborhood" class="block text-sm font-medium text-gray-700">Bairro*</label>
                    <input type="text" name="neighborhood" id="neighborhood" value="{{ old('neighborhood') }}"
                        class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Bairro" required>
                </div>

                <div class="space-y-2">
                    <label for="city" class="block text-sm font-medium text-gray-700">Cidade*</label>
                    <input type="text" name="city" id="city" value="{{ old('city') }}"
                        class="w-full px-4 py-2 border border-blue-300 rounded-lg focus:ring-indigo-500 focus:border-indigo-500"
                        placeholder="Cidade" required>
                </div>
            </div>

            <div class="px-6 py-4 border-t border-blue-200 bg-gray-50 flex justify-between">
                <div class="text-sm text-gray-500">
                    Campos marcados com * são obrigatórios
                </div>
                <button type="submit"
                    class="px-6 py-2.5 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors cursor-pointer">
                    Cadastrar
                </button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const cepInput = document.getElementById('cep');
            const ufInput = document.getElementById('uf');
            const publicPlaceInput = document.getElementById('public_place');
            const neighborhoodInput = document.getElementById('neighborhood');
            const cityInput = document.getElementById('city');
            const complementInput = document.getElementById('complement');
            const cepLoading = document.getElementById('cep-loading');
            const cepError = document.getElementById('cep-error');

            cepInput.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 8) {
                    value = value.substring(0, 8);
                }
                e.target.value = value;

                if (value.length === 8) {
                    buscarCep(value);
                }
            });

            cepInput.addEventListener('blur', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length === 8) {
                    buscarCep(value);
                }
            });

            function buscarCep(cep) {
                cepError.classList.add('hidden');
                cepLoading.classList.remove('hidden');

                fetch(`https://viacep.com.br/ws/${cep}/json/`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erro na requisição');
                        }
                        return response.json();
                    })
                    .then(data => {
                        cepLoading.classList.add('hidden');

                        if (data.erro) {
                            cepError.classList.remove('hidden');
                            cepError.textContent = 'CEP não encontrado';
                            limparCamposEndereco();
                            return;
                        }

                        ufInput.value = data.uf || '';
                        publicPlaceInput.value = data.logradouro || '';
                        neighborhoodInput.value = data.bairro || '';
                        cityInput.value = data.localidade || '';
                        complementInput.value = data.complemento || '';

                        document.getElementById('number').focus();
                    })
                    .catch(error => {
                        cepLoading.classList.add('hidden');
                        cepError.classList.remove('hidden');
                        cepError.textContent = 'Erro ao buscar CEP. Tente novamente.';
                        limparCamposEndereco();
                        console.error('Erro ao buscar CEP:', error);
                    });
            }

            function limparCamposEndereco() {
                ufInput.value = '';
                publicPlaceInput.value = '';
                neighborhoodInput.value = '';
                cityInput.value = '';
                complementInput.value = '';
            }
        });
    </script>
@endsection
