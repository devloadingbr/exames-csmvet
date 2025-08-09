<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemSettingsSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            [
                'key' => 'app_name',
                'value' => 'VetExams SaaS',
                'type' => 'string',
                'description' => 'Nome da aplicação',
                'is_public' => true,
            ],
            [
                'key' => 'default_timezone',
                'value' => 'America/Sao_Paulo',
                'type' => 'string',
                'description' => 'Timezone padrão',
                'is_public' => false,
            ],
            [
                'key' => 'max_file_size_mb',
                'value' => '50',
                'type' => 'integer',
                'description' => 'Tamanho máximo de arquivo em MB',
                'is_public' => false,
            ],
            [
                'key' => 'allowed_file_types',
                'value' => '["pdf"]',
                'type' => 'json',
                'description' => 'Tipos de arquivo permitidos',
                'is_public' => false,
            ],
            [
                'key' => 'email_from_address',
                'value' => 'noreply@vetexams.com.br',
                'type' => 'string',
                'description' => 'E-mail remetente padrão',
                'is_public' => false,
            ],
            [
                'key' => 'trial_period_days',
                'value' => '14',
                'type' => 'integer',
                'description' => 'Período de trial em dias',
                'is_public' => false,
            ],
            [
                'key' => 'storage_type',
                'value' => 'local',
                'type' => 'string',
                'description' => 'Tipo de storage: local ou minio',
                'is_public' => false,
            ],
            [
                'key' => 'storage_path',
                'value' => 'exams',
                'type' => 'string',
                'description' => 'Pasta base para arquivos',
                'is_public' => false,
            ],
        ];

        foreach ($settings as $setting) {
            DB::table('system_settings')->insert([
                ...$setting,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}