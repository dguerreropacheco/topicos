@extends('layouts.app')
@section('title','Nuevo Vehículo')

@section('content')
<h3>Nuevo Vehículo</h3>
<form action="{{ route('vehicles.store') }}" method="POST" enctype="multipart/form-data" class="row g-3">
@csrf

<div class="col-md-6">
  <label class="form-label">Marca</label>
  <select name="brand_id" id="brand_id" class="form-select" required>
    <option value="">-- Seleccione --</option>
    @foreach($brands as $b)
      <option value="{{ $b->id }}" {{ old('brand_id')==$b->id?'selected':'' }}>{{ $b->name }}</option>
    @endforeach
  </select>
  @error('brand_id')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label">Modelo</label>
  <select name="vehicle_model_id" id="vehicle_model_id" class="form-select" required>
    <option value="">-- Seleccione marca primero --</option>
  </select>
  @error('vehicle_model_id')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label">Tipo</label>
  <select name="vehicle_type_id" class="form-select" required>
    <option value="">-- Seleccione --</option>
    @foreach($types as $t)
      <option value="{{ $t->id }}" {{ old('vehicle_type_id')==$t->id?'selected':'' }}>{{ $t->name }}</option>
    @endforeach
  </select>
  @error('vehicle_type_id')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="col-md-6">
  <label class="form-label">Color</label>
  <select name="color_id" class="form-select">
    <option value="">-- (Opcional) --</option>
    @foreach($colors as $c)
      <option value="{{ $c->id }}" {{ old('color_id')==$c->id?'selected':'' }}>{{ $c->name }}</option>
    @endforeach
  </select>
  @error('color_id')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="col-md-4">
  <label class="form-label">Placa</label>
  <input name="plate" value="{{ old('plate') }}" class="form-control" required>
  @error('plate')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="col-md-2">
  <label class="form-label">Año</label>
  <input type="number" name="year" value="{{ old('year') }}" class="form-control" required>
  @error('year')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="col-md-4">
  <label class="form-label">Código interno</label>
  <input name="code" value="{{ old('code') }}" class="form-control" required>
  @error('code')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="col-md-2">
  <label class="form-label">Disponible</label>
  <select name="available" class="form-select">
    <option value="1" {{ old('available','1')=='1'?'selected':'' }}>Sí</option>
    <option value="0" {{ old('available')=='0'?'selected':'' }}>No</option>
  </select>
</div>

<div class="col-12">
  <label class="form-label">Imágenes (máx 10)</label>
  <input type="file" name="images[]" class="form-control" multiple accept="image/*">
  <div class="form-text">La imagen de perfil será la de índice “profile_index”.</div>
  <div class="row mt-2 g-2">
    <div class="col-sm-4">
      <label class="form-label">Índice de imagen de perfil (0..9)</label>
      <input type="number" name="profile_index" class="form-control" min="0" max="9" value="0">
    </div>
  </div>
  @error('images.*')<div class="text-danger small">{{ $message }}</div>@enderror
</div>

<div class="col-12">
  <button class="btn btn-primary">Guardar</button>
  <a href="{{ route('vehicles.index') }}" class="btn btn-secondary">Cancelar</a>
</div>
</form>
@endsection

@push('scripts')
<script>
(function(){
  const brandSel = document.getElementById('brand_id');
  const modelSel = document.getElementById('vehicle_model_id');

  async function loadModels(brandId, preselect=null){
    if(!brandId){ modelSel.innerHTML = '<option value="">-- Seleccione marca primero --</option>'; return; }
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

  brandSel.addEventListener('change', e => loadModels(e.target.value));

  // restaurar valores antiguos si la validación falló
  const oldBrand = '{{ old('brand_id') }}';
  const oldModel = '{{ old('vehicle_model_id') }}';
  if(oldBrand){ loadModels(oldBrand, oldModel); }
})();
</script>
@endpush
