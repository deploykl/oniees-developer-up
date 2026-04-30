<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('provinces')) {
            Schema::create('provinces', function (Blueprint $table) {
                $table->id();
                $table->unsignedBigInteger('region_id');
                $table->string('nombre', 200);
                $table->timestamps();
                
                // Índices
                $table->index('region_id');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('provinces');
    }
};