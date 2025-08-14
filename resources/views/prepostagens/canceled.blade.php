@extends('layouts.admin')

@section('content')
    <h2>Listar as Pré-Postagem - Canceladas</h2>

    @can('create-prepostagem')
        <a href="{{ route('prepostagens.create') }}">Cadastrar</a><br>
    @endcan

    @can('create-prepostagem')
        <a href="{{ route('prepostagens.index') }}">Listar Pré-Postagens</a><br>
    @endcan

    <br>
    <x-alert />

    {{-- Imprimir os registros --}}
    @forelse ($prepostagens as $prepostagem)
        Nome do destinatário: {{ $prepostagem->name_recipient }}<br>
        Data da Pré-Postagem: {{ \Carbon\Carbon::parse($prepostagem->created_at)->format('d/m/Y H:i:s') }}<br>
        Código de Rastreamento: {{ $prepostagem->object_code }}<br>
        Situação:
        {{ 
        $prepostagem->situation == 1 ? 'Pré-Postado' : 
        ($prepostagem->code_format_informed_object == 2 ? 'Cancelada' : 'Desconhecida') 
        }}<br><br>

        @can('show-prepostagem')
            <a href="{{ route('prepostagens.show', ['prepostagem' => $prepostagem->id]) }}">Visualizar</a><br><br>
        @endcan
        
        <hr>
    @empty
        Nenhum registro encontrado!
    @endforelse

    {{ $prepostagens->links() }}
@endsection
