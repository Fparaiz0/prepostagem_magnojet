@extends('layouts.admin')

@section('content')
    <h2>Cadastrar Pré-Postagem</h2>

    @can('index-prepostagem')
        <a href="{{ route('prepostagens.index') }}">Listar</a><br><br>
    @endcan
    
    <x-alert />

        <form action="{{ route('prepostagens.store') }}" method="POST">
            @csrf
            @method('POST')

            <h4>Remetente</h4>

            <label>Nome: </label>
            <input type="text" name="name_sender" id="name_sender" placeholder="Buscar por nome" value="{{ old('name_sender') }}" required>
            <button type="button" onclick="buscarRemetente()" title="Buscar por nome">🔍</button>
            <br><br>

            <label>Cnpj: </label>
            <input type="text" name="cnpj_sender" id="cnpj_sender" placeholder="Cnpj do remetente" value="{{ old('cnpj_sender') }}" readonly required><br><br>

            <label>Cep: </label>
            <input type="text" name="cep_sender" id="cep_sender" placeholder="Cep do remetente" value="{{ old('cep_sender') }}" readonly required><br><br>

            <label>Logradouro: </label>
            <input type="text" name="public_place_sender" id="public_place_sender" placeholder="Logradouro do remetente" value="{{ old('public_place_sender') }}" readonly required><br><br>

            <label>Número: </label>
            <input type="text" name="number_sender" id="number_sender" placeholder="Número do remetente" value="{{ old('number_sender') }}" readonly required><br><br>

            <label>Bairro: </label>
            <input type="text" name="neighborhood_sender" id="neighborhood_sender" placeholder="Bairro do remetente" value="{{ old('neighborhood_sender') }}" readonly><br><br>

            <label>Cidade: </label>
            <input type="text" name="city_sender" id="city_sender" placeholder="Cidade do remetente" value="{{ old('city_sender') }}" readonly required><br><br>
            
            <label>UF: </label>
            <input type="text" name="uf_sender" id="uf_sender" placeholder="UF do remetente" value="{{ old('uf_sender') }}" readonly required><br><br>

            <hr>

            <h4>Destinatário</h4>

            <label>Nome: </label>
            <input type="text" name="name_recipient" id="name_recipient" placeholder="Buscar por nome" value="{{ old('name_recipient') }}" required>
            <button type="button" onclick="buscarDestinatario()" title="Buscar por nome">🔍</button>
            <br><br>

            <label>Cnpj: </label>
            <input type="text" name="cnpj_recipient" id="cnpj_recipient" placeholder="Cnpj do destinatário" value="{{ old('cnpj_recipient') }}" readonly required><br><br>

            <label>Cep: </label>
            <input type="text" name="cep_recipient" id="cep_recipient" placeholder="Cep do destinatário" value="{{ old('cep_recipient') }}" readonly required><br><br>

            <label>Logradouro: </label>
            <input type="text" name="public_place_recipient" id="public_place_recipient" placeholder="Logradouro do destinatário" value="{{ old('public_place_recipient') }}" readonly required><br><br>

            <label>Número: </label>
            <input type="text" name="number_recipient" id="number_recipient" placeholder="Logradouro do destinatário" value="{{ old('number_recipient') }}" readonly required><br><br>

            <label>Bairro: </label>
            <input type="text" name="neighborhood_recipient" id="neighborhood_recipient" placeholder="Bairro do destinatário" value="{{ old('neighborhood_recipient') }}" readonly><br><br>

            <label>Cidade: </label>
            <input type="text" name="city_recipient" id="city_recipient" placeholder="Cidade do destinatário" value="{{ old('city_recipient') }}" readonly required><br><br>
            
            <label>UF: </label>
            <input type="text" name="uf_recipient" id="uf_recipient" placeholder="UF do destinatário" value="{{ old('uf_recipient') }}" readonly required><br><br>

            <hr>

            <h4>Embalagem</h4>

            <label>Nome: </label>
            <input type="text" name="name" id="name" placeholder="Buscar por embalagem" value="{{ old('name') }}" required>
            <button type="button" onclick="buscarEmbalagem()" title="Buscar por embalagem">🔍</button>
            <br><br>

            <label>Altura: </label>
            <input type="text" name="height_informed" id="height_informed" placeholder="Altura" value="{{ old('height_informed') }}" readonly required><br><br>

            <label>Largura: </label>
            <input type="text" name="width_informed" id="width_informed" placeholder="Largura" value="{{ old('width_informed') }}" readonly required><br><br>

            <label>Comprimento: </label>
            <input type="text" name="length_informed" id="length_informed" placeholder="Comprimento" value="{{ old('length_informed') }}" readonly required><br><br>

            <label>Diâmetro: </label>
            <input type="text" name="diameter_informed" id="diameter_informed" placeholder="Diâmetro" value="{{ old('diameter_informed') }}" readonly required><br><br>

            <label>Peso: </label>
            <input type="text" name="weight_informed" id="weight_informed" placeholder="Peso" value="{{ old('weight_informed') }}" readonly required><br><br>

            <hr>

            <label>Código de Serviço: </label>
            <input type="text" name="code_service" id="code_service" placeholder="Código de serviço" value="03220" readonly required><br><br>

            <label>Código de rastreamento: </label>
            <input type="text" name="object_code" id="object_code" placeholder="Código de Rastreio" value="{{ old('object_code') }}" required><br><br>

            <label>Número Nota Fiscal: </label>
            <input type="text" name="invoice_number" id="invoice_number" placeholder="Número Nota Fiscal" value="{{ old('invoice_number') }}" required><br><br>

            <label>Chave Nfe: </label>
            <input type="text" name="nfe_key" id="nfe_key" placeholder="Número Nota Fiscal" value="{{ old('nfe_key') }}" required><br><br>

            <label>Formato do objeto: </label>
            <select name="code_format_informed_object" id="code_format_informed_object" required>
            <option value="" readonly selected>Selecione</option>
            <option value="1" {{ old('code_format_informed_object') == '1' ? 'selected' : '' }}>Envelope</option>
            <option value="2" {{ old('code_format_informed_object') == '2' ? 'selected' : '' }}>Caixa/Pacote</option>
            <option value="3" {{ old('code_format_informed_object') == '3' ? 'selected' : '' }}>Rolo/Cilindro   </option>
            </select><br><br>

            <label>Objeto Proibido?</label>
            <select name="aware_object_not_forbidden" id="aware_object_not_forbidden" readonly required>
            <option value="1">NÃO</option>
            </select><br><br>

            <label>Mobilidade de pagamento:</label>
            <select name="payment_method" id="payment_method" readonly required>
            <option value="2">À FATURAR</option>
            </select><br><br>

            <label>Observação: </label>
            <input type="text" name="observation" id="observation" placeholder="Observação" value="{{ old('observation') }}"><br><br>

            <button type="submit">Cadastrar</button>
        </form>

<script src="{{ asset('js/prepostagem.js') }}"></script>
@endsection
