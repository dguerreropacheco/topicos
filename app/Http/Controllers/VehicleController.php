<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreVehicleRequest;
use App\Http\Requests\UpdateVehicleRequest;
use App\Models\{Vehicle,Brand,VehicleModel,VehicleType,Color,VehicleImage};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VehicleController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $vehicles = Vehicle::with(['brand','modelRef','type','color','profileImage'])
            ->when($q, function($query) use ($q){
                $query->where(function($sub) use ($q){
                    $sub->where('plate','like',"%$q%")
                        ->orWhere('code','like',"%$q%");
                });
            })
            ->orderByDesc('id')
            ->paginate(12);

        return view('vehicles.index', compact('vehicles','q'));
    }

    public function create()
    {
        return view('vehicles.create', [
            'brands' => Brand::orderBy('name')->get(),
            'types'  => VehicleType::orderBy('name')->get(),
            'colors' => Color::orderBy('name')->get(),
        ]);
    }

    public function store(StoreVehicleRequest $request)
    {
        $data = $request->validated();
        $data['available'] = $data['available'] ?? true;

        $vehicle = Vehicle::create([
            'brand_id'         => $data['brand_id'],
            'vehicle_model_id' => $data['vehicle_model_id'],
            'vehicle_type_id'  => $data['vehicle_type_id'],
            'color_id'         => $data['color_id'] ?? null,
            'plate'            => $data['plate'],
            'year'             => $data['year'],
            'code'             => $data['code'],
            'available'        => $data['available'],
        ]);

        if (!empty($data['images'])) {
            $profileIndex = $data['profile_index'] ?? 0;
            foreach ($request->file('images') as $idx => $img) {
                $path = $img->store('vehicles','public');
                $vehicle->images()->create([
                    'path'       => $path,
                    'is_profile' => ($idx === (int)$profileIndex),
                ]);
            }
        }

        return redirect()->route('vehicles.index')->with('ok','Vehículo creado correctamente.');
    }

    public function show(Vehicle $vehicle)
    {
        $vehicle->load(['brand','modelRef','type','color','images']);
        return view('vehicles.show', compact('vehicle'));
    }

    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', [
            'vehicle'=> $vehicle->load(['images']),
            'brands' => Brand::orderBy('name')->get(),
            'types'  => VehicleType::orderBy('name')->get(),
            'colors' => Color::orderBy('name')->get(),
        ]);
    }

    public function update(UpdateVehicleRequest $request, Vehicle $vehicle)
    {
        $data = $request->validated();

        $vehicle->update([
            'brand_id'         => $data['brand_id'],
            'vehicle_model_id' => $data['vehicle_model_id'],
            'vehicle_type_id'  => $data['vehicle_type_id'],
            'color_id'         => $data['color_id'] ?? null,
            'plate'            => $data['plate'],
            'year'             => $data['year'],
            'code'             => $data['code'],
            'available'        => $data['available'] ?? true,
        ]);

        if (!empty($data['images'])) {
            foreach ($request->file('images') as $img) {
                $path = $img->store('vehicles', 'public');
                $vehicle->images()->create(['path' => $path, 'is_profile' => false]);
            }
        }

        if (!empty($data['profile_image_id'])) {
            $vehicle->images()->update(['is_profile' => false]);
            $vehicle->images()->where('id', $data['profile_image_id'])->update(['is_profile' => true]);
        }

        return redirect()->route('vehicles.show', $vehicle)->with('ok','Vehículo actualizado.');
    }

    public function destroy(Vehicle $vehicle)
    {
        foreach ($vehicle->images as $img) {
            if ($img->path && Storage::disk('public')->exists($img->path)) {
                Storage::disk('public')->delete($img->path);
            }
        }
        $vehicle->delete();
        return redirect()->route('vehicles.index')->with('ok','Vehículo eliminado.');
    }

    // === AJAX: modelos por marca ===
    public function modelsByBrand(Brand $brand)
    {
        $models = VehicleModel::where('brand_id',$brand->id)
                    ->orderBy('name')
                    ->get(['id','name']);
        return response()->json($models);
    }
}
