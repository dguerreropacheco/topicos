<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id','vehicle_model_id','vehicle_type_id','color_id',
        'plate','year','code','available'
    ];

    protected $casts = [
        'available' => 'boolean',
        'year' => 'integer',
    ];

    public function brand()         { return $this->belongsTo(Brand::class); }
    public function modelRef()      { return $this->belongsTo(VehicleModel::class, 'vehicle_model_id'); }
    public function type()          { return $this->belongsTo(VehicleType::class, 'vehicle_type_id'); }
    public function color()         { return $this->belongsTo(Color::class); }
    public function images()        { return $this->hasMany(VehicleImage::class); }

    public function profileImage() {
        return $this->hasOne(VehicleImage::class)->where('is_profile', true);
    }
}
