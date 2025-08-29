@extends('layouts.admin')

@section('content')
<div class="content-wrapper">
    <!-- Cabeçalho da Página -->
    <div class="content-header flex flex-col md:flex-row md:items-center md:justify-between mb-6">
        <div>
            <h2 class="content-title">Pré-Postagem</h2>
        </div>
        <nav class="flex space-x-2 text-sm text-gray-500 mt-2 md:mt-0">
            <span class="text-gray-600">Cadastrar</span>
        </nav>
    </div>

    <!-- Alert -->
    <div class="mt-5">
        <x-alert />
    </div>

    <!-- Formulário -->
    <form action="{{ route('prepostagens.store') }}" method="POST" class="bg-white rounded-xl shadow-sm border border-blue-300 overflow-hidden">
        @csrf
        @method('POST')

        <!-- Remetente -->
        <div class="border-b border-gray-100">
            <div class="px-6 py-4 bg-gray-50 flex items-center">
                <div class="bg-blue-100 p-2 rounded-lg mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Remetente</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Nome</label>
                    <div class="flex">
                        <input type="text" name="name_sender" id="name_sender" value="MAGNO JET INDUSTRIA LTDA" readonly 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-l-lg bg-gray-50 text-gray-700">
                        <button type="button" onclick="buscarRemetente()" title="Buscar por nome" 
                                class="px-4 bg-gray-200 border cursor-pointer border-gray-300 border-l-0 rounded-r-lg hover:bg-gray-300 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">CNPJ</label>
                    <input type="text" name="cnpj_sender" id="cnpj_sender" value="06092428000198" readonly 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">CEP</label>
                    <input type="text" name="cep_sender" id="cep_sender" value="84900000" readonly 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Logradouro</label>
                    <input type="text" name="public_place_sender" id="public_place_sender" value="Avenida Governador Paulo Cruz Pimentel" readonly 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Número</label>
                    <input type="text" name="number_sender" id="number_sender" value="1051" readonly 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Bairro</label>
                    <input type="text" name="neighborhood_sender" id="neighborhood_sender" value="Centro" readonly 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Cidade</label>
                    <input type="text" name="city_sender" id="city_sender" value="Ibaiti" readonly 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">UF</label>
                    <input type="text" name="uf_sender" id="uf_sender" value="PR" readonly 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>
            </div>
        </div>

        <!-- Destinatário -->
        <div class="border-b border-gray-100">
            <div class="px-6 py-4 bg-gray-50 flex items-center">
                <div class="bg-green-100 p-2 rounded-lg mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Destinatário</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Nome</label>
                    <div class="flex">
                        <input type="text" name="name_recipient" id="name_recipient" value="{{ old('name_recipient') }}" required 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-l-lg focus:ring-blue-500 focus:border-blue-500">
                        <button type="button" onclick="buscarDestinatario()" title="Buscar por nome" 
                                class="px-4 bg-blue-100 border cursor-pointer border-blue-300 border-l-0 rounded-r-lg hover:bg-blue-200 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">CNPJ</label>
                    <input type="text" name="cnpj_recipient" id="cnpj_recipient" value="{{ old('cnpj_recipient') }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">CEP</label>
                    <input type="text" name="cep_recipient" id="cep_recipient" value="{{ old('cep_recipient') }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Logradouro</label>
                    <input type="text" name="public_place_recipient" id="public_place_recipient" value="{{ old('public_place_recipient') }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Número</label>
                    <input type="text" name="number_recipient" id="number_recipient" value="{{ old('number_recipient') }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Complemento</label>
                    <input type="text" name="complement_recipient" id="complement_recipient" value="{{ old('complement_recipient') }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Bairro</label>
                    <input type="text" name="neighborhood_recipient" id="neighborhood_recipient" value="{{ old('neighborhood_recipient') }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Cidade</label>
                    <input type="text" name="city_recipient" id="city_recipient" value="{{ old('city_recipient') }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">UF</label>
                    <input type="text" name="uf_recipient" id="uf_recipient" value="{{ old('uf_recipient') }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>
            </div>
        </div>

        <!-- Embalagem -->
        <div class="border-b border-gray-100">
            <div class="px-6 py-4 bg-gray-50 flex items-center">
                <div class="bg-orange-100 p-2 rounded-lg mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Embalagem</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Nome</label>
                    <div class="flex">
                        <input type="text" name="name" id="name" value="{{ old('name') }}" required 
                               class="w-full px-4 py-2.5 border border-gray-300 rounded-l-lg focus:ring-orange-500 focus:border-orange-500">
                        <button type="button" onclick="buscarEmbalagem()" title="Buscar embalagem" 
                                class="px-4 bg-orange-100 border cursor-pointer border-orange-300 border-l-0 rounded-r-lg hover:bg-orange-200 transition-colors flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Altura (cm)</label>
                    <input type="text" name="height_informed" id="height_informed" value="{{ old('height_informed') }}" readonly 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Largura (cm)</label>
                    <input type="text" name="width_informed" id="width_informed" value="{{ old('width_informed') }}" readonly 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Comprimento (cm)</label>
                    <input type="text" name="length_informed" id="length_informed" value="{{ old('length_informed') }}" readonly 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Diâmetro (cm)</label>
                    <input type="text" name="diameter_informed" id="diameter_informed" value="{{ old('diameter_informed') }}" readonly 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Peso (g)</label>
                    <input type="text" name="weight_informed" id="weight_informed" value="{{ old('weight_informed') }}" readonly 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg bg-gray-50 text-gray-700">
                </div>
            </div>
        </div>

        <!-- Outros Dados -->
        <div>
            <div class="px-6 py-4 bg-gray-50 flex items-center">
                <div class="bg-purple-100 p-2 rounded-lg mr-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-purple-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-800">Informações Adicionais</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Código de Rastreamento</label>
                    <input type="text" name="object_code" id="object_code" value="{{ old('object_code') }}" required 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Número da Nota Fiscal</label>
                    <input type="text" name="invoice_number" id="invoice_number" value="{{ old('invoice_number') }}" required 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Chave da NFe</label>
                    <input type="text" name="nfe_key" id="nfe_key" value="{{ old('nfe_key') }}" required 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Formato do Objeto</label>
                    <select name="code_format_informed_object" id="code_format_informed_object" required 
                            class="w-full px-4 py-2.5 border cursor-pointer border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                        <option value="">Selecione o formato</option>
                        <option value="1" {{ old('code_format_informed_object') == '1' ? 'selected' : '' }}>Envelope</option>
                        <option value="2" {{ old('code_format_informed_object') == '2' ? 'selected' : '' }} selected>Caixa/Pacote</option>
                        <option value="3" {{ old('code_format_informed_object') == '3' ? 'selected' : '' }}>Rolo/Cilindro</option>
                    </select>
                </div>

                <div class="space-y-2">
                    <label class="block text-sm font-medium text-gray-700">Observação</label>
                    <input type="text" name="observation" id="observation" value="{{ old('observation') }}" 
                           class="w-full px-4 py-2.5 border border-gray-300 rounded-lg focus:ring-purple-500 focus:border-purple-500">
                </div>
            </div>
        </div>

        <!-- Botão -->
        <div class="px-6 py-4 border-t border-blue-300 bg-gray-50 flex justify-end">
            <button type="submit" 
                    class="px-6 py-2.5 bg-blue-900 text-white font-medium cursor-pointer rounded-lg hover:bg-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-900 transition-colors flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Cadastrar Pré-Postagem
            </button>
        </div>
    </form>

     <!-- Modal Seleção de Destinatário -->
    <div id="modalSelecionarDestinatario"
        class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden transition-opacity duration-300 ease-out">
        
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-4xl mx-4 md:mx-auto animate-fade-in-slow">
            <!-- Cabeçalho -->
            <div class="flex justify-between items-center border-b px-6 py-4 bg-gray-100 rounded-t-xl">
                <h2 class="text-lg font-semibold text-gray-800">Selecionar Destinatário</h2>
                <button id="fecharModalBtn"
                    class="text-gray-500 hover:text-red-600 text-2xl font-bold focus:outline-none transition"
                    aria-label="Fechar">
                    &times;
                </button>
            </div>

            <!-- Conteúdo dinâmico -->
            <div class="p-6 overflow-y-auto max-h-[70vh] space-y-4" id="listaDestinatarios">
                <!-- resultados aqui ... -->
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
            // chamada para a rota correta
            const response = await fetch(`/range/find-by-invoice/${invoice}`);
            const data = await response.json();

            if (response.ok && data.success) {
                // preenche o código de rastreamento automaticamente
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
</script>

<script src="{{ asset('js/prepostagem.js') }}"></script>
@endsection