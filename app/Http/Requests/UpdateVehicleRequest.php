<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateVehicleRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $id = $this->route('vehicle'); // {vehicle}
        $plateRegex = '/^([A-Z0-9]{6}|[A-Z0-9]{3}-[A-Z0-9]{3}|[A-Z0-9]{2}-[A-Z0-9]{4})$/i';

        return [
            'brand_id'         => ['required','exists:brands,id'],
            'vehicle_model_id' => ['required','exists:vehicle_models,id'],
            'vehicle_type_id'  => ['required','exists:vehicle_types,id'],
            'color_id'         => ['nullable','exists:colors,id'],
            'plate'            => ['required','regex:'.$plateRegex,'unique:vehicles,plate,'.$id],
            'year'             => ['required','integer','between:1980,' . now()->year],
            'code'             => ['required','string','max:50','unique:vehicles,code,'.$id],
            'available'        => ['nullable','boolean'],

            'images'           => ['nullable','array','max:10'],
            'images.*'         => ['image','mimes:jpg,jpeg,png,webp','max:2048'],
            'profile_image_id' => ['nullable','exists:vehicle_images,id'],
        ];
    }
}
