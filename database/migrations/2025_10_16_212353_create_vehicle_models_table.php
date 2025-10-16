<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('vehicle_models')) {
            Schema::create('vehicle_models', function (Blueprint $table) {
                $table->id();
                $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
                $table->string('name');
                $table->timestamps();
                $table->unique(['brand_id','name']);
            });
        }
    }
    public function down(): void {
        Schema::dropIfExists('vehicle_models');
    }
};
