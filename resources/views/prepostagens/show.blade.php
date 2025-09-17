@extends('layouts.admin')

@section('content')
    <!-- Cabeçalho da Página -->
    <div class="content-header">
        <h2 class="content-title">Pré-Postagem</h2>
        <nav class="breadcrumb">
            <span>Listar</span>
        </nav>
    </div>

    <!-- Alert -->
    <div class="mt-4">
        <x-alert />
    </div>

    <!-- Container Principal -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <!-- Cabeçalho do Objeto -->
        @switch($prepostagem->situation)
            @case(1)
                <div class="bg-gradient-to-r from-blue-100 to-gray-50 px-6 py-4 border-b">
                @break

                @case(2)
                    <div class="bg-gradient-to-r from-red-100 to-gray-50 px-6 py-4 border-b">
                    @break

                    @case(3)
                        <div class="bg-gradient-to-r from-green-100 to-gray-50 px-6 py-4 border-b">
                        @break
                    @endswitch
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                        <div class="mb-2 md:mb-0">
                            <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-blue-600" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Objeto: {{ $prepostagem->object_code }}
                            </h3>
                            <div class="flex items-center mt-1">
                                <span
                                    class="px-3 py-1 rounded-full text-xs font-medium 
                            @if ($prepostagem->situation == 1) bg-blue-100 text-blue-800 
                            @elseif($prepostagem->situation == 2) bg-red-100 text-red-800 
                            @elseif($prepostagem->situation == 3) bg-green-100 text-green-800 
                            @else bg-gray-100 text-gray-800 @endif">
                                    {{ $prepostagem->situation == 1
                                        ? 'Pré-Postado'
                                        : ($prepostagem->situation == 2
                                            ? 'Cancelado'
                                            : ($prepostagem->situation == 3
                                                ? 'Postado'
                                                : 'Desconhecida')) }}
                                </span>
                                <span class="ml-3 text-sm text-gray-500">
                                    Criado em: {{ \Carbon\Carbon::parse($prepostagem->created_at)->format('d/m/Y H:i') }}
                                </span>
                            </div>
                        </div>

                        <div class="flex items-center space-x-4">
                            <div class="text-center">
                                <p class="text-xs text-gray-500">Peso</p>
                                <p class="font-medium">{{ $prepostagem->weight_informed }}g</p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500">Formato</p>
                                <p class="font-medium">
                                    {{ $prepostagem->code_format_informed_object == 1
                                        ? 'Envelope'
                                        : ($prepostagem->code_format_informed_object == 2
                                            ? 'Caixa'
                                            : ($prepostagem->code_format_informed_object == 3
                                                ? 'Rolo'
                                                : '-')) }}
                                </p>
                            </div>
                            <div class="text-center">
                                <p class="text-xs text-gray-500">Serviço</p>
                                <p class="font-medium">
                                    {{ $prepostagem->code_service == '03220' ? 'SEDEX' : 'Desconhecido' }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Grid de Informações -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 p-6">
                    <!-- Seção Remetente -->
                    @switch($prepostagem->situation)
                        @case(1)
                            <div class="bg-gray-50 rounded-lg p-5 border border-blue-300">
                            @break

                            @case(2)
                                <div class="bg-gray-50 rounded-lg p-5 border border-red-300">
                                @break

                                @case(3)
                                    <div class="bg-gray-50 rounded-lg p-5 border border-green-300">
                                    @break
                                @endswitch
                                <div class="flex items-center mb-4">
                                    <div class="bg-blue-100 p-2 rounded-full mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-blue-600" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <h3 class="text-lg font-semibold text-gray-800">Remetente</h3>
                                </div>

                                <div class="space-y-3 text-sm">
                                    <div class="grid grid-cols-3 gap-2">
                                        <p class="text-gray-500 font-medium">Nome:</p>
                                        <p class="col-span-2">{{ $prepostagem->name_sender }}</p>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <p class="text-gray-500 font-medium">CNPJ:</p>
                                        <p class="col-span-2 font-mono">{{ $prepostagem->cnpj_sender }}</p>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <p class="text-gray-500 font-medium">Endereço:</p>
                                        <p class="col-span-2">
                                            {{ $prepostagem->public_place_sender }}, {{ $prepostagem->number_sender }}
                                            @if ($prepostagem->complement_sender)
                                                - {{ $prepostagem->complement_sender }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <p class="text-gray-500 font-medium">Bairro:</p>
                                        <p class="col-span-2">{{ $prepostagem->neighborhood_sender }}</p>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <p class="text-gray-500 font-medium">Cidade/UF:</p>
                                        <p class="col-span-2">
                                            {{ $prepostagem->city_sender }}/{{ $prepostagem->uf_sender }}</p>
                                    </div>
                                    <div class="grid grid-cols-3 gap-2">
                                        <p class="text-gray-500 font-medium">CEP:</p>
                                        <p class="col-span-2 font-mono">{{ $prepostagem->cep_sender }}</p>
                                    </div>
                                </div>
                            </div>

                            <!-- Seção Destinatário -->
                            @switch($prepostagem->situation)
                                @case(1)
                                    <div class="bg-gray-50 rounded-lg p-5 border border-blue-300">
                                    @break

                                    @case(2)
                                        <div class="bg-gray-50 rounded-lg p-5 border border-red-300">
                                        @break

                                        @case(3)
                                            <div class="bg-gray-50 rounded-lg p-5 border border-green-300">
                                            @break
                                        @endswitch
                                        <div class="flex items-center mb-4">
                                            <div class="bg-green-100 p-2 rounded-full mr-3">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-semibold text-gray-800">Destinatário</h3>
                                        </div>

                                        <div class="space-y-3 text-sm">
                                            <div class="grid grid-cols-3 gap-2">
                                                <p class="text-gray-500 font-medium">Nome:</p>
                                                <p class="col-span-2">{{ $prepostagem->name_recipient }}</p>
                                            </div>
                                            <div class="grid grid-cols-3 gap-2">
                                                <p class="text-gray-500 font-medium">CNPJ:</p>
                                                <p class="col-span-2 font-mono">{{ $prepostagem->cnpj_recipient }}</p>
                                            </div>
                                            <div class="grid grid-cols-3 gap-2">
                                                <p class="text-gray-500 font-medium">Endereço:</p>
                                                <p class="col-span-2">
                                                    {{ $prepostagem->public_place_recipient }},
                                                    {{ $prepostagem->number_recipient }}
                                                    @if ($prepostagem->complement_recipient)
                                                        - {{ $prepostagem->complement_recipient }}
                                                    @endif
                                                </p>
                                            </div>
                                            <div class="grid grid-cols-3 gap-2">
                                                <p class="text-gray-500 font-medium">Bairro:</p>
                                                <p class="col-span-2">{{ $prepostagem->neighborhood_recipient }}</p>
                                            </div>
                                            <div class="grid grid-cols-3 gap-2">
                                                <p class="text-gray-500 font-medium">Cidade/UF:</p>
                                                <p class="col-span-2">
                                                    {{ $prepostagem->city_recipient }}/{{ $prepostagem->uf_recipient }}
                                                </p>
                                            </div>
                                            <div class="grid grid-cols-3 gap-2">
                                                <p class="text-gray-500 font-medium">CEP:</p>
                                                <p class="col-span-2 font-mono">{{ $prepostagem->cep_recipient }}</p>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Seção Detalhes do Objeto -->
                                    @switch($prepostagem->situation)
                                        @case(1)
                                            <div class="lg:col-span-2 bg-gray-50 rounded-lg p-5 border border-blue-300">
                                            @break

                                            @case(2)
                                                <div class="lg:col-span-2 bg-gray-50 rounded-lg p-5 border border-red-300">
                                                @break

                                                @case(3)
                                                    <div class="lg:col-span-2 bg-gray-50 rounded-lg p-5 border border-green-300">
                                                    @break
                                                @endswitch
                                                <div class="flex items-center mb-4">
                                                    <div class="bg-purple-100 p-2 rounded-full mr-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-purple-600" fill="none"
                                                            viewBox="0 0 24 24" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-lg font-semibold text-gray-800">Detalhes do Objeto</h3>
                                                </div>

                                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                                    <div class="space-y-3 text-sm">
                                                        <div class="grid grid-cols-3 gap-2">
                                                            <p class="text-gray-500 font-medium">Nota Fiscal:</p>
                                                            <p class="col-span-2 font-mono">
                                                                {{ $prepostagem->invoice_number ?: 'Não informado' }}</p>
                                                        </div>
                                                        <div class="grid grid-cols-3 gap-2">
                                                            <p class="text-gray-500 font-medium">Chave NFe:</p>
                                                            <p
                                                                class="col-span-2 font-mono break-all whitespace-normal text-sm">
                                                                {{ $prepostagem->nfe_key ?: 'Não informado' }}</p>
                                                        </div>
                                                        <div class="grid grid-cols-3 gap-2">
                                                            <p class="text-gray-500 font-medium">Dimensões:</p>
                                                            <p class="col-span-2">
                                                                {{ $prepostagem->height_informed }}cm (A) ×
                                                                {{ $prepostagem->width_informed }}cm (L) ×
                                                                {{ $prepostagem->length_informed }}cm (C)
                                                                @if ($prepostagem->diameter_informed)
                                                                    × {{ $prepostagem->diameter_informed }}cm (D)
                                                                @endif
                                                            </p>
                                                        </div>
                                                    </div>

                                                    <div class="space-y-3 text-sm">
                                                        <div class="grid grid-cols-3 gap-2">
                                                            <p class="text-gray-500 font-medium">Objeto Proibido:</p>
                                                            <p class="col-span-2">
                                                                @if ($prepostagem->aware_object_not_forbidden == 1)
                                                                    <span
                                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-green-100 text-green-800">
                                                                        Não
                                                                    </span>
                                                                @else
                                                                    <span
                                                                        class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-red-100 text-red-800">
                                                                        Sim
                                                                    </span>
                                                                @endif
                                                            </p>
                                                        </div>
                                                        <div class="grid grid-cols-3 gap-2">
                                                            <p class="text-gray-500 font-medium">Atualizado em:</p>
                                                            <p class="col-span-2">
                                                                {{ \Carbon\Carbon::parse($prepostagem->updated_at)->format('d/m/Y H:i') }}
                                                            </p>
                                                        </div>
                                                        <div class="grid grid-cols-3 gap-2">
                                                            <p class="text-gray-500 font-medium">Observação:</p>
                                                            <p class="col-span-2 break-all whitespace-normal text-sm">
                                                                {{ $prepostagem->observation ?: 'Não informada' }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Rodapé com Ações -->
                                        <div
                                            class="bg-gray-50 px-6 py-4 border-t border-blue-200 flex justify-end space-x-3">
                                            @if ($prepostagem->situation == 1)
                                                @can('destroy-prepostagem')
                                                    <form
                                                        action="{{ route('prepostagens.destroy', ['prepostagem' => $prepostagem->id]) }}"
                                                        method="POST" class="inline">
                                                        @csrf
                                                        @method('delete')
                                                        <button type="submit"
                                                            onclick="return confirm('Tem certeza que deseja cancelar esta pré-postagem?')"
                                                            class="flex items-center px-4 py-2 border border-red-300 rounded-lg text-red-600 hover:bg-red-50 transition duration-200">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2"
                                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>
                                                            Cancelar
                                                        </button>
                                                    </form>
                                                @endcan
                                                @can('create-prepostagem')
                                                    <a href="{{ route('prepostagens.create') }}"
                                                        class="px-4 py-2 border border-blue-300 rounded-lg text-blue-700 hover:bg-blue-100 transition-colors">
                                                        Cadastrar uma nova
                                                    </a>
                                                @endcan
                                            @endif

                                            @switch($prepostagem->situation)
                                                @case(1)
                                                    <a href="{{ route('prepostagens.index') }}"
                                                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                                                        Voltar para lista
                                                    </a>
                                                @break

                                                @case(2)
                                                    <a href="{{ route('prepostagens.canceled') }}"
                                                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                                                        Voltar para lista
                                                    </a>
                                                @break

                                                @case(3)
                                                    <a href="{{ route('prepostagens.posted') }}"
                                                        class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-100 transition-colors">
                                                        Voltar para lista
                                                    </a>
                                                @break
                                            @endswitch
                                        </div>
                                    </div>
                                @endsection
