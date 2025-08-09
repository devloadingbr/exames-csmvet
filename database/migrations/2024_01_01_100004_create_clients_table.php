<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('clinic_id')->constrained('clinics')->onDelete('cascade');
            
            // Dados do cliente
            $table->string('name');
            $table->string('cpf', 14); // Com formatação: 000.000.000-00
            $table->date('birth_date');
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            
            // Endereço
            $table->text('address')->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 2)->nullable();
            $table->string('zip_code', 10)->nullable();
            
            // Configurações
            $table->boolean('receive_email_notifications')->default(true);
            $table->boolean('receive_sms_notifications')->default(false);
            $table->timestamp('last_login_at')->nullable();
            $table->boolean('is_active')->default(true);
            
            // Controle de segurança
            $table->integer('login_attempts')->default(0);
            $table->timestamp('blocked_until')->nullable();
            
            // Auditoria
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->timestamps();
            $table->softDeletes();
            
            // Unique por clínica
            $table->unique(['clinic_id', 'cpf']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};