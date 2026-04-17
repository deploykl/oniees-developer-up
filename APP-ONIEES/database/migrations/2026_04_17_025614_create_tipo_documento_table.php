<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tipo_documento', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->integer('longitud')->nullable();
            $table->boolean('numerico')->default(false);
            $table->boolean('alfanumerico')->default(false);
            $table->boolean('exacto')->default(false);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tipo_documento');
    }
};