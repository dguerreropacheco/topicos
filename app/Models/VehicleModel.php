<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleModel extends Model
{
    use HasFactory;

    protected $fillable = ['brand_id','name'];

    public function brand() {
        return $this->belongsTo(Brand::class);
    }

    public function vehicles() {
        return $this->hasMany(Vehicle::class);
    }
}
