<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VehicleLookupsSeeder extends Seeder
{
    public function run(): void
    {
        // BRANDS
        $brands = [
            ['name' => 'Volvo'],
            ['name' => 'Mercedes-Benz'],
            ['name' => 'Hino'],
            ['name' => 'Toyota'],
            ['name' => 'Isuzu'],
        ];
        DB::table('brands')->insert($brands);

        // VEHICLE TYPES
        $types = [
            ['name' => 'Camión'],
            ['name' => 'Camioneta'],
            ['name' => 'Compactador'],
            ['name' => 'Volquete'],
            ['name' => 'Pickup'],
        ];
        DB::table('vehicle_types')->insert($types);

        // COLORS
        $colors = [
            ['name' => 'Blanco', 'rgb' => '#FFFFFF'],
            ['name' => 'Negro',  'rgb' => '#000000'],
            ['name' => 'Rojo',   'rgb' => '#FF0000'],
            ['name' => 'Azul',   'rgb' => '#0000FF'],
            ['name' => 'Verde',  'rgb' => '#00FF00'],
            ['name' => 'Amarillo','rgb'=> '#FFFF00'],
        ];
        DB::table('colors')->insert($colors);

        // VEHICLE MODELS (ejemplo simple; puedes ampliarlo)
        // Primero mapeamos IDs reales
        $brandIds = DB::table('brands')->pluck('id','name'); // name => id

        $models = [
            ['brand_id' => $brandIds['Volvo'],        'name' => 'FMX'],
            ['brand_id' => $brandIds['Volvo'],        'name' => 'FH'],
            ['brand_id' => $brandIds['Mercedes-Benz'], 'name' => 'Actros'],
            ['brand_id' => $brandIds['Hino'],         'name' => '500'],
            ['brand_id' => $brandIds['Toyota'],       'name' => 'Hilux'],
            ['brand_id' => $brandIds['Isuzu'],        'name' => 'N-Series'],
        ];
        DB::table('vehicle_models')->insert($models);
    }
}
