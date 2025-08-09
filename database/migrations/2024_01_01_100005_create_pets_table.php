<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained('clinics')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            
            // Dados do pet
            $table->string('name');
            $table->string('species', 100); // cão, gato, etc
            $table->string('breed', 100)->nullable();
            $table->string('gender', 10)->nullable(); // macho, fêmea
            $table->date('birth_date')->nullable();
            $table->decimal('weight', 5, 2)->nullable();
            $table->string('color', 100)->nullable();
            
            // Configurações
            $table->string('photo_url', 500)->nullable();
            $table->text('observations')->nullable();
            $table->boolean('is_active')->default(true);
            
            // Auditoria
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pets');
    }
};