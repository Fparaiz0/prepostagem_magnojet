@extends('layouts.admin')

@section('content')
    <h2>Range de etiquetas - Disponiveis</h2>

    @can('create-range')
        <a href="{{ route('tracks.create') }}">Gerar etiquetas</a><br>
    @endcan

    @can('show-range')
        <a href="{{ route('tracks.show') }}">Etiquetas Utilizadas</a><br>
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
