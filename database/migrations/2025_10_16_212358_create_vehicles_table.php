<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('vehicles')) {
            Schema::create('vehicles', function (Blueprint $table) {
                $table->id();

                $table->foreignId('brand_id')->constrained('brands')->cascadeOnDelete();
                $table->foreignId('vehicle_model_id')->constrained('vehicle_models')->cascadeOnDelete();
                $table->foreignId('vehicle_type_id')->constrained('vehicle_types')->cascadeOnDelete();
                $table->foreignId('color_id')->nullable()->constrained('colors')->nullOnDelete();

                $table->string('plate')->unique();
                $table->unsignedSmallInteger('year');
                $table->string('code')->unique();
                $table->boolean('available')->default(true);

                $table->timestamps();

                $table->index(['brand_id','vehicle_model_id','vehicle_type_id']);
            });
        }
    }
    public function down(): void {
        Schema::dropIfExists('vehicles');
    }
};
