<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('exams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained('clinics')->onDelete('cascade');
            $table->foreignId('client_id')->constrained('clients')->onDelete('cascade');
            $table->foreignId('pet_id')->constrained('pets')->onDelete('cascade');
            $table->foreignId('exam_type_id')->constrained('exam_types');
            
            // Identificação única
            $table->string('codigo', 20)->unique(); // Ex: VET2024001, VET2024002
            
            // Dados do exame
            $table->text('description')->nullable();
            $table->date('exam_date');
            $table->text('result_summary')->nullable();
            $table->string('veterinarian_name')->nullable();
            $table->string('veterinarian_crmv', 20)->nullable();
            
            // Arquivo
            $table->string('original_filename');
            $table->string('file_path', 500); // Caminho no storage (local ou MinIO)
            $table->bigInteger('file_size_bytes');
            $table->string('file_hash', 64)->nullable(); // SHA256 para integridade
            $table->string('storage_disk', 20)->default('local'); // Tipo: local, minio
            
            // Status: pending, processing, ready, failed
            $table->string('status', 20)->default('ready');
            
            // Configurações
            $table->decimal('price', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamp('expires_at')->nullable(); // Para exames temporários
            
            // Auditoria
            $table->foreignId('uploaded_by')->constrained('users');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exams');
    }
};