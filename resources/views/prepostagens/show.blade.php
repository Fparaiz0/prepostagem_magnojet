@extends('layouts.admin')

@section('content')
    <h2>Detalhes da Pré-Postagem</h2>

    @can('index-prepostagem')
        <a href="{{ route('prepostagens.index') }}">Listar as Pré-Postagem</a><br><br>
    @endcan

    @can('destroy-prepostagem')
        <form action="{{ route('prepostagens.destroy', ['prepostagem' => $prepostagem->id]) }}" method="POST">
            @csrf
            @method('delete')

            <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

        </form><br>
    @endcan

    <x-alert />

    <br>

    {{-- Imprimir o registro --}}
    <hr>
    <h4>Remetente</h4>

    Nome: {{ $prepostagem->name_sender }}<br>
    CNPJ: {{ $prepostagem->cnpj_sender }}<br>
    CEP: {{ $prepostagem->cep_sender }}<br>
    Logradouro: {{ $prepostagem->public_place_sender }}<br>
    Número: {{ $prepostagem->number_sender }}<br>
    Bairro: {{ $prepostagem->neighborhood_sender }}<br>
    Cidade: {{ $prepostagem->city_sender }}<br>
    UF: {{ $prepostagem->uf_sender }}<br>

    <h4>Destinatário</h4>

    Nome: {{ $prepostagem->name_recipient }}<br>
    CNPJ: {{ $prepostagem->cnpj_recipient }}<br>
    CEP: {{ $prepostagem->cep_recipient }}<br>
    Logradouro: {{ $prepostagem->public_place_recipient }}<br>
    Número: {{ $prepostagem->number_recipient }}<br>
    Bairro: {{ $prepostagem->neighborhood_recipient }}<br>
    Cidade: {{ $prepostagem->city_recipient }}<br>
    UF: {{ $prepostagem->uf_recipient }}<br>
    
    <h4>Objeto: {{ $prepostagem->object_code }} </h4>

    Serviço: {{ $prepostagem->code_service == '03220' ? 'SEDEX CONTRATO AG' : 'Desconhecido' }}<br>
    Peso: {{ $prepostagem->weight_informed }} g<br>
    Formato: 
    {{ 
    $prepostagem->code_format_informed_object == 1 ? 'Envelope' : 
    ($prepostagem->code_format_informed_object == 2 ? 'Caixa/Pacote' : 
    ($prepostagem->code_format_informed_object == 3 ? 'Rolo/Cilindro' : 'Desconhecido')) 
    }}<br>
    Nota fiscal: {{ $prepostagem->invoice_number }}<br>
    Dimensôes: {{ $prepostagem->height_informed}}(A) x {{ $prepostagem->width_informed}}(L) x {{ $prepostagem->length_informed}}(C) x {{ $prepostagem->diameter_informed}}(D)<br>
    Objeto Proibido: {{ $prepostagem->aware_object_not_forbidden == 1 ? 'Não' : 'Sim' }}<br>
    Chave NFe: {{ $prepostagem->nfe_key }}<br>
    Situação:
    {{ 
    $prepostagem->situation == 1 ? 'Pré-Postado' : 
    ($prepostagem->code_format_informed_object == 2 ? 'Cancelada' : 'Desconhecida') 
    }}<br>

    Cadastrado: {{ \Carbon\Carbon::parse($prepostagem->created_at)->format('d/m/Y H:i:s') }}<br>
    Editado: {{ \Carbon\Carbon::parse($prepostagem->updated_at)->format('d/m/Y H:i:s') }}<br>

    <hr>
@endsection
