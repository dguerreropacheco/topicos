@extends('layouts.app')
@section('title','Vehículos')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
  <h3 class="mb-0">Vehículos</h3>
  <a href="{{ route('vehicles.create') }}" class="btn btn-primary">Nuevo</a>
</div>

<form class="mb-3" method="GET">
  <div class="input-group">
    <input class="form-control" name="q" value="{{ $q }}" placeholder="Buscar por placa o código">
    <button class="btn btn-outline-secondary">Buscar</button>
  </div>
</form>

<div class="row g-3">
@foreach($vehicles as $v)
  <div class="col-md-4">
    <div class="card h-100">
      @php $img = optional($v->profileImage)->path ?? optional($v->images->first())->path; @endphp
      @if($img)
        <img class="card-img-top" src="{{ asset('storage/'.$img) }}" alt="vehículo">
      @endif
      <div class="card-body">
        <h5 class="card-title">{{ $v->plate }} — {{ $v->brand->name }} {{ $v->modelRef->name }}</h5>
        <p class="card-text mb-1"><strong>Código:</strong> {{ $v->code }}</p>
        <p class="card-text mb-1"><strong>Tipo:</strong> {{ $v->type->name }}</p>
        <p class="card-text"><strong>Año:</strong> {{ $v->year }} | <strong>Disponible:</strong> {{ $v->available ? 'Sí' : 'No' }}</p>
        <a href="{{ route('vehicles.show',$v) }}" class="btn btn-sm btn-outline-primary">Ver</a>
        <a href="{{ route('vehicles.edit',$v) }}" class="btn btn-sm btn-outline-secondary">Editar</a>
        <form class="d-inline" action="{{ route('vehicles.destroy',$v) }}" method="POST" onsubmit="return confirm('¿Eliminar vehículo?');">
          @csrf @method('DELETE')
          <button class="btn btn-sm btn-outline-danger">Eliminar</button>
        </form>
      </div>
    </div>
  </div>
@endforeach
</div>

<div class="mt-3">
  {{ $vehicles->withQueryString()->links() }}
</div>
@endsection
