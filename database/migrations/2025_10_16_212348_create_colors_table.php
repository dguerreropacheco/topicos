<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        if (!Schema::hasTable('colors')) {
            Schema::create('colors', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->string('rgb', 7); // "#RRGGBB"
                $table->unique(['name','rgb']);
                $table->timestamps();
            });
        }
    }
    public function down(): void {
        Schema::dropIfExists('colors');
    }
};
