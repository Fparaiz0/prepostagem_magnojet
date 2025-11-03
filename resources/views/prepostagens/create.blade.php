@extends('layouts.admin')

@section('page-title', 'Nova Pré-Postagem')
@section('breadcrumb')
    <li>
        <span class="text-gray-500">/</span>
        <span class="text-gray-700 ml-2">Pré-Postagem</span>
        <span class="text-gray-500">/</span>
        <span class="text-gray-700 ml-2">Cadastrar</span>
    </li>
@endsection

@section('content')
    <div class="min-h-screen bg-gray-50 py-8">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
                    <div class="mb-4 sm:mb-0">
                        <h1 class="text-2xl font-bold text-gray-900">Nova Pré-Postagem</h1>
                        <p class="text-sm text-gray-600 mt-1">Cadastre uma nova pré-postagem para envio</p>
                    </div>
                </div>
            </div>

            <div class="mb-6">
                <x-alert />
            </div>

            <form action="{{ route('prepostagens.store') }}" method="POST" class="space-y-6">
                @csrf
                @method('POST')

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-blue-50 to-blue-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-2 bg-blue-500 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Remetente</h3>
                                <p class="text-sm text-gray-600 mt-1">Informações do remetente</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Nome</label>
                                <div class="flex">
                                    <input type="text" name="name_sender" id="name_sender"
                                        value="MAGNO JET INDUSTRIA LTDA" readonly
                                        class="w-full px-4 py-3 border border-gray-300 rounded-l-lg bg-gray-50 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                                    <button type="button" onclick="buscarRemetente()" title="Buscar por nome"
                                        class="px-4 bg-gray-200 border cursor-pointer border-gray-300 border-l-0 rounded-r-lg hover:bg-gray-300 transition-colors flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">CNPJ</label>
                                <input type="text" name="cnpj_sender" id="cnpj_sender" value="06092428000198" readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">CEP</label>
                                <input type="text" name="cep_sender" id="cep_sender" value="84900000" readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Logradouro</label>
                                <input type="text" name="public_place_sender" id="public_place_sender"
                                    value="Avenida Governador Paulo Cruz Pimentel" readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Número</label>
                                <input type="text" name="number_sender" id="number_sender" value="1051" readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Bairro</label>
                                <input type="text" name="neighborhood_sender" id="neighborhood_sender" value="Centro"
                                    readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Cidade</label>
                                <input type="text" name="city_sender" id="city_sender" value="Ibaiti" readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">UF</label>
                                <input type="text" name="uf_sender" id="uf_sender" value="PR" readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-green-50 to-emerald-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-2 bg-green-500 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Destinatário</h3>
                                <p class="text-sm text-gray-600 mt-1">Informações do destinatário</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Nome</label>
                                <div class="flex">
                                    <input type="text" name="name_recipient" id="name_recipient"
                                        value="{{ old('name_recipient') }}" required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-green-500 focus:border-green-500 transition-colors">
                                    <button type="button" onclick="buscarDestinatario()" title="Buscar por nome"
                                        class="px-4 bg-green-100 border cursor-pointer border-green-300 border-l-0 rounded-r-lg hover:bg-green-200 transition-colors flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">CNPJ</label>
                                <input type="text" name="cnpj_recipient" id="cnpj_recipient"
                                    value="{{ old('cnpj_recipient') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">CEP</label>
                                <input type="text" name="cep_recipient" id="cep_recipient"
                                    value="{{ old('cep_recipient') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Logradouro</label>
                                <input type="text" name="public_place_recipient" id="public_place_recipient"
                                    value="{{ old('public_place_recipient') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Número</label>
                                <input type="text" name="number_recipient" id="number_recipient"
                                    value="{{ old('number_recipient') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Complemento</label>
                                <input type="text" name="complement_recipient" id="complement_recipient"
                                    value="{{ old('complement_recipient') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Bairro</label>
                                <input type="text" name="neighborhood_recipient" id="neighborhood_recipient"
                                    value="{{ old('neighborhood_recipient') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Cidade</label>
                                <input type="text" name="city_recipient" id="city_recipient"
                                    value="{{ old('city_recipient') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">UF</label>
                                <input type="text" name="uf_recipient" id="uf_recipient"
                                    value="{{ old('uf_recipient') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-orange-50 to-amber-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-2 bg-orange-500 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Embalagem</h3>
                                <p class="text-sm text-gray-600 mt-1">Informações da embalagem</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Nome</label>
                                <div class="flex">
                                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                                        required
                                        class="w-full px-4 py-3 border border-gray-300 rounded-l-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition-colors">
                                    <button type="button" onclick="buscarEmbalagem()" title="Buscar embalagem"
                                        class="px-4 bg-orange-100 border cursor-pointer border-orange-300 border-l-0 rounded-r-lg hover:bg-orange-200 transition-colors flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-600"
                                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                        </svg>
                                    </button>
                                </div>
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Altura (cm)</label>
                                <input type="text" name="height_informed" id="height_informed"
                                    value="{{ old('height_informed') }}" readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Largura (cm)</label>
                                <input type="text" name="width_informed" id="width_informed"
                                    value="{{ old('width_informed') }}" readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Comprimento (cm)</label>
                                <input type="text" name="length_informed" id="length_informed"
                                    value="{{ old('length_informed') }}" readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Diâmetro (cm)</label>
                                <input type="text" name="diameter_informed" id="diameter_informed"
                                    value="{{ old('diameter_informed') }}" readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Peso (g)</label>
                                <input type="text" name="weight_informed" id="weight_informed"
                                    value="{{ old('weight_informed') }}" readonly
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-200 overflow-hidden">
                    <div class="bg-gradient-to-r from-purple-50 to-violet-100 px-6 py-4 border-b border-gray-200">
                        <div class="flex items-center">
                            <div class="p-2 bg-purple-500 rounded-lg mr-3">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-gray-900">Informações Adicionais</h3>
                                <p class="text-sm text-gray-600 mt-1">Dados complementares da postagem</p>
                            </div>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Código de Rastreamento</label>
                                <input type="text" name="object_code" id="object_code"
                                    value="{{ old('object_code') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Número da Nota Fiscal</label>
                                <input type="text" name="invoice_number" id="invoice_number"
                                    value="{{ old('invoice_number') }}" required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Chave da NFe</label>
                                <input type="text" name="nfe_key" id="nfe_key" value="{{ old('nfe_key') }}"
                                    required
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                            </div>

                            <div class="space-y-2">
                                <label class="block text-sm font-medium text-gray-700">Formato do Objeto</label>
                                <select name="code_format_informed_object" id="code_format_informed_object" required
                                    class="w-full px-4 py-3 border cursor-pointer border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                                    <option value="">Selecione o formato</option>
                                    <option value="1"
                                        {{ old('code_format_informed_object') == '1' ? 'selected' : '' }}>Envelope</option>
                                    <option value="2"
                                        {{ old('code_format_informed_object') == '2' ? 'selected' : '' }} selected>
                                        Caixa/Pacote</option>
                                    <option value="3"
                                        {{ old('code_format_informed_object') == '3' ? 'selected' : '' }}>Rolo/Cilindro
                                    </option>
                                </select>
                            </div>

                            <div class="space-y-2 md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700">Observação</label>
                                <input type="text" name="observation" id="observation"
                                    value="{{ old('observation') }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 transition-colors">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit"
                        class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-lg hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transform hover:scale-105 transition-all duration-200 shadow-lg hover:shadow-xl cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Cadastrar Pré-Postagem
                    </button>
                </div>
            </form>

            <div id="modalSelecionarDestinatario"
                class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-opacity duration-300 ease-out">
                <div class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl mx-4 animate-fade-in">
                    <div
                        class="flex justify-between items-center px-6 py-4 bg-gradient-to-r from-green-50 to-emerald-100 rounded-t-2xl border-b">
                        <h2 class="text-lg font-semibold text-gray-900">Selecionar Destinatário</h2>
                        <button id="fecharModalBtn"
                            class="text-gray-500 hover:text-red-600 text-2xl font-bold focus:outline-none transition"
                            aria-label="Fechar">
                            &times;
                        </button>
                    </div>

                    <div class="p-6 overflow-y-auto max-h-[70vh] space-y-4" id="listaDestinatarios">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const invoiceInput = document.getElementById("invoice_number");
            const objectCodeInput = document.getElementById("object_code");

            invoiceInput.addEventListener("blur", async () => {
                const invoice = invoiceInput.value.trim();
                if (!invoice) return;

                try {
                    const response = await fetch(`/range/find-by-invoice/${invoice}`);
                    const data = await response.json();

                    if (response.ok && data.success) {
                        objectCodeInput.value = data.object_code;
                    } else {
                        objectCodeInput.value = "";
                        alert(data.message || "Nota Fiscal não encontrada.");
                    }
                } catch (error) {
                    console.error("Erro ao buscar código de rastreamento:", error);
                    alert("Erro ao buscar código de rastreamento. Tente novamente.");
                }
            });
        });

        document.addEventListener("DOMContentLoaded", () => {
            const nameInput = document.getElementById("name");
            const observationInput = document.getElementById("observation");

            if (nameInput && observationInput) {
                nameInput.addEventListener("blur", () => {
                    const value = nameInput.value.trim();
                    if (value) {
                        observationInput.value = value;
                    }
                });
            }
        });
    </script>

    <script src="{{ asset('js/prepostagem.js') }}"></script>
@endsection
