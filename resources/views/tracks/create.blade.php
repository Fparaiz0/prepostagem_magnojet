@extends('layouts.admin')

@section('content')
    <!-- Wrapper Principal -->
    <div class="content-wrapper">

        <!-- Cabeçalho da Página -->
        <div class="content-header">
            <h2 class="content-title">Range de etiquetas</h2>
            <nav class="breadcrumb">
                <span>Gerar</span>
            </nav>
        </div>

        <!-- Caixa de Conteúdo Principal -->
        <div class="content-box">

            <!-- Cabeçalho da Caixa -->
            <div class="content-box-header">
                <h3 class="text-gray-700 mb-4 font-bold">Códigos de Rastreamento</h3>

                <!-- Botão: Etiquetas Disponíveis -->
                <div class="flex space-x-1">
                    @can('index-range')
                        <a href="{{ route('tracks.index') }}">
                            <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-3 rounded cursor-pointer">
                                Disponíveis
                            </button>
                        </a>
                    @endcan
                </div>
            </div>

            <!-- Formulário de Geração de Etiquetas -->
            <form action="{{ route('tracks.store') }}" method="POST"
                class="bg-white p-6 rounded-lg shadow-lg w-full max-w-md mx-auto border-blue-200 border">
                @csrf

                <h2 class="text-xl font-semibold mb-4 text-gray-800">Gerar Etiquetas</h2>

                <!-- Campo: Quantidade -->
                <div class="mb-4">
                    <label for="amount" class="block text-sm font-medium text-gray-700 mb-1">
                        Quantidade de etiquetas
                    </label>
                    <input type="number" name="amount" id="amount" value="{{ old('amount') }}"
                        placeholder="Digite a quantidade" required min="500"
                        class="w-full border border-blue-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    @error('amount')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Botão: Gerar -->
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white font-semibold px-4 py-2 rounded-md shadow-sm transition duration-150 ease-in-out cursor-pointer">
                        Gerar
                    </button>
                </div>
            </form>

            <!-- Alerta -->
            <x-alert />

        </div>
    </div>
@endsection
