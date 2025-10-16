<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class VehicleImage extends Model
{
    use HasFactory;

    protected $fillable = ['vehicle_id','path','is_profile'];

    protected $casts = [
        'is_profile' => 'boolean',
    ];

    public function vehicle() {
        return $this->belongsTo(Vehicle::class);
    }
}
