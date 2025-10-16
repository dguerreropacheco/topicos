@extends('layouts.app')
@section('title','Detalle Vehículo')

@section('content')
<h3>Detalle: {{ $vehicle->plate }}</h3>
<p><strong>Marca/Modelo:</strong> {{ $vehicle->brand->name }} {{ $vehicle->modelRef->name }}</p>
<p><strong>Tipo:</strong> {{ $vehicle->type->name }}</p>
<p><strong>Año:</strong> {{ $vehicle->year }}</p>
<p><strong>Código:</strong> {{ $vehicle->code }}</p>
<p><strong>Disponible:</strong> {{ $vehicle->available ? 'Sí' : 'No' }}</p>

@if($vehicle->images->count())
  <div class="row g-2">
    @foreach($vehicle->images as $img)
      <div class="col-sm-3">
        <div class="card">
          <img src="{{ asset('storage/'.$img->path) }}" class="card-img-top" alt="">
          <div class="card-body p-2">
            <span class="badge {{ $img->is_profile ? 'bg-success':'bg-secondary' }}">
              {{ $img->is_profile ? 'Perfil' : 'Secundaria' }}
            </span>
          </div>
        </div>
      </div>
    @endforeach
  </div>
@endif

<div class="mt-3">
  <a href="{{ route('vehicles.edit',$vehicle) }}" class="btn btn-secondary">Editar</a>
  <a href="{{ route('vehicles.index') }}" class="btn btn-outline-primary">Volver</a>
</div>
@endsection
