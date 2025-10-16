@extends('layouts.app')
@section('title','Editar Vehículo')

@section('content')
<h3>Editar Vehículo: {{ $vehicle->plate }}</h3>
<form action="{{ route('vehicles.update',$vehicle) }}" method="POST" enctype="multipart/form-data" class="row g-3">
@csrf @method('PUT')

<div class="col-md-6">
  <label class="form-label">Marca</label>
  <select name="brand_id" id="brand_id" class="form-select" required>
    @foreach($brands as $b)
      <option value="{{ $b->id }}" {{ $vehicle->brand_id==$b->id?'selected':'' }}>{{ $b->name }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-6">
  <label class="form-label">Modelo</label>
  <select name="vehicle_model_id" id="vehicle_model_id" class="form-select" required>
    <option value="">Cargando...</option>
  </select>
</div>

<div class="col-md-6">
  <label class="form-label">Tipo</label>
  <select name="vehicle_type_id" class="form-select" required>
    @foreach($types as $t)
      <option value="{{ $t->id }}" {{ $vehicle->vehicle_type_id==$t->id?'selected':'' }}>{{ $t->name }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-6">
  <label class="form-label">Color</label>
  <select name="color_id" class="form-select">
    <option value="">-- (Opcional) --</option>
    @foreach($colors as $c)
      <option value="{{ $c->id }}" {{ $vehicle->color_id==$c->id?'selected':'' }}>{{ $c->name }}</option>
    @endforeach
  </select>
</div>

<div class="col-md-4">
  <label class="form-label">Placa</label>
  <input name="plate" value="{{ $vehicle->plate }}" class="form-control" required>
</div>

<div class="col-md-2">
  <label class="form-label">Año</label>
  <input type="number" name="year" value="{{ $vehicle->year }}" class="form-control" required>
</div>

<div class="col-md-4">
  <label class="form-label">Código interno</label>
  <input name="code" value="{{ $vehicle->code }}" class="form-control" required>
</div>

<div class="col-md-2">
  <label class="form-label">Disponible</label>
  <select name="available" class="form-select">
    <option value="1" {{ $vehicle->available ? 'selected':'' }}>Sí</option>
    <option value="0" {{ !$vehicle->available ? 'selected':'' }}>No</option>
  </select>
</div>

<hr class="mt-3">

<div class="col-12">
  <label class="form-label">Agregar imágenes nuevas (opcional)</label>
  <input type="file" name="images[]" class="form-control" multiple accept="image/*">
  @error('images.*')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="col-12">
  <label class="form-label d-block mb-2">Imágenes actuales</label>
  <div class="d-flex flex-wrap gap-3">
    @foreach($vehicle->images as $img)
      <div class="border rounded p-2 text-center" style="width:160px">
        <img src="{{ asset('storage/'.$img->path) }}" class="img-fluid mb-2" alt="">
        <div class="form-check">
          <input class="form-check-input" type="radio" name="profile_image_id" value="{{ $img->id }}" {{ $img->is_profile ? 'checked':'' }}>
          <label class="form-check-label">Perfil</label>
        </div>
      </div>
    @endforeach
  </div>
</div>

<div class="col-12">
  <button class="btn btn-primary">Actualizar</button>
  <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Volver</a>
</div>

</form>
@endsection

@push('scripts')
<script>
(async function(){
  const brandSel = document.getElementById('brand_id');
  const modelSel = document.getElementById('vehicle_model_id');

  async function loadModels(brandId, preselect=null){
    modelSel.innerHTML = '<option value="">Cargando...</option>';
    try{
      const res  = await fetch(`/ajax/brands/${brandId}/models`);
      if(!res.ok) throw new Error('HTTP ' + res.status);
      const data = await res.json();
      modelSel.innerHTML = '<option value="">-- Seleccione --</option>' +
        data.map(m => `<option value="${m.id}" ${preselect==m.id?'selected':''}>${m.name}</option>`).join('');
    }catch(e){
      modelSel.innerHTML = '<option value="">(Error cargando modelos)</option>';
      console.error(e);
    }
  }

  await loadModels('{{ $vehicle->brand_id }}', '{{ $vehicle->vehicle_model_id }}');
  brandSel.addEventListener('change', e => loadModels(e.target.value));
})();
</script>
@endpush
