<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('vehicle_images')) {
            Schema::create('vehicle_images', function (Blueprint $table) {
                $table->id();
                $table->foreignId('vehicle_id')->constrained('vehicles')->cascadeOnDelete();
                $table->string('path');              // storage/app/public/vehicles/...
                $table->boolean('is_profile')->default(false);
                $table->timestamps();
                $table->index(['vehicle_id','is_profile']);
            });
        }
    }
    public function down(): void {
        Schema::dropIfExists('vehicle_images');
    }
};
