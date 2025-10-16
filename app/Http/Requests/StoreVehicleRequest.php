<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        $plateRegex = '/^([A-Z0-9]{6}|[A-Z0-9]{3}-[A-Z0-9]{3}|[A-Z0-9]{2}-[A-Z0-9]{4})$/i';

        return [
            'brand_id'         => ['required','exists:brands,id'],
            'vehicle_model_id' => ['required','exists:vehicle_models,id'],
            'vehicle_type_id'  => ['required','exists:vehicle_types,id'],
            'color_id'         => ['nullable','exists:colors,id'],
            'plate'            => ['required','regex:'.$plateRegex,'unique:vehicles,plate'],
            'year'             => ['required','integer','between:1980,' . now()->year],
            'code'             => ['required','string','max:50','unique:vehicles,code'],
            'available'        => ['nullable','boolean'],

            // imágenes
            'images'        => ['nullable','array','max:10'],
            'images.*'      => ['image','mimes:jpg,jpeg,png,webp','max:2048'],
            'profile_index' => ['nullable','integer','min:0','max:9'],
        ];
    }
}
