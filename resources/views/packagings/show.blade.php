@extends('layouts.admin')

@section('content')
    <h2>Detalhes da Embalagem</h2>

    @can('index-packaging')
        <a href="{{ route('packagings.index') }}">Listar as Embalagens</a><br><br>
    @endcan
    
    @can('edit-packaging')
    <a href="{{ route('packagings.edit', ['packaging' => $packaging->id]) }}">Editar</a><br><br>
    @endcan

    @can('destroy-packaging')
        <form action="{{ route('packagings.destroy', ['packaging' => $packaging->id]) }}" method="POST">
        @csrf
        @method('delete')

        <button type="submit" onclick="return confirm('Tem certeza que deseja apagar este registro?')">Apagar</button>

    </form><br><br>
    @endcan

    <x-alert />

    {{-- Imprimir o registro --}}
    Nome: {{ $packaging->name }}<br>
    Altura: {{ $packaging->height }}<br>
    Largura: {{ $packaging->width }}<br>
    Comprimento: {{ $packaging->length }}<br>
    Diametro: {{ $packaging->diameter }}<br>
    Peso: {{ $packaging->weight }}<br>
    @can('edit-packaging')
    Ativo: {{ $packaging->active == 1 ? 'SIM' : 'NÃO' }}<br>
    @endcan
    Cadastrado: {{ \Carbon\Carbon::parse($packaging->created_at)->format('d/m/Y H:i:s') }}<br>
    Editado: {{ \Carbon\Carbon::parse($packaging->updated_at)->format('d/m/Y H:i:s') }}<br>
@endsection
