<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        // SuperAdmin user (você)
        DB::table('users')->insert([
            'name' => 'SuperAdmin',
            'email' => 'admin@vetexams.com.br',
            'password' => Hash::make('password'), // Altere para uma senha segura
            'role' => 'superadmin',
            'clinic_id' => null,
            'is_active' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Clínica de exemplo para desenvolvimento
        $clinicId = DB::table('clinics')->insertGetId([
            'name' => 'Clínica Veterinária São José',
            'slug' => 'clinica-sao-jose',
            'email' => 'contato@clinicasaojose.com.br',
            'plan_id' => 1, // Plano Básico
            'subscription_status' => 'active',
            'created_by' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Gestor da clínica de exemplo
        DB::table('users')->insert([
            'name' => 'Dr. João Silva',
            'email' => 'joao@clinicasaojose.com.br',
            'password' => Hash::make('password'),
            'role' => 'manager',
            'clinic_id' => $clinicId,
            'is_active' => true,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Cliente de exemplo
        $clientId = DB::table('clients')->insertGetId([
            'clinic_id' => $clinicId,
            'name' => 'Maria Santos',
            'cpf' => '123.456.789-00',
            'birth_date' => '1985-05-15',
            'email' => 'maria@email.com',
            'created_by' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Pet de exemplo
        DB::table('pets')->insert([
            'clinic_id' => $clinicId,
            'client_id' => $clientId,
            'name' => 'Rex',
            'species' => 'Cão',
            'breed' => 'Labrador',
            'gender' => 'macho',
            'birth_date' => '2020-03-15',
            'created_by' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Tipos de exame de exemplo
        $examTypes = [
            'Hemograma Completo' => 'Análise completa do sangue',
            'Raio-X' => 'Exame radiológico',
            'Ultrassom' => 'Exame ultrassonográfico',
        ];

        foreach ($examTypes as $name => $description) {
            DB::table('exam_types')->insert([
                'clinic_id' => $clinicId,
                'name' => $name,
                'description' => $description,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}