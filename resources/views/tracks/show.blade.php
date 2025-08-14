@extends('layouts.admin')

@section('content')
    <h2>Range de etiquetas - Utilizadas</h2>

    @can('create-range')
        <a href="{{ route('tracks.create') }}">Gerar etiquetas</a><br>
    @endcan

    @can('index-range')
        <a href="{{ route('tracks.index') }}">Etiquetas Disponiveis</a><br>
    @endcan

    <br>
    <x-alert />

    {{-- Imprimir os registros --}}
    @forelse ($tracks as $range)
      {{ $range->object_code }}
        <hr>
    @empty
        Nenhum registro encontrado!
    @endforelse

  <div class="d-flex justify-content-center">
      {{ $tracks->links() }}
    </div>
@endsection
