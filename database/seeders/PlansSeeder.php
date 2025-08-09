<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlansSeeder extends Seeder
{
    public function run(): void
    {
        $plans = [
            [
                'name' => 'Básico',
                'slug' => 'basic',
                'description' => 'Plano ideal para clínicas pequenas com até 500 exames por mês',
                'price_monthly' => 99.00,
                'price_yearly' => 990.00,
                'max_exams_per_month' => 500,
                'max_storage_gb' => 5,
                'max_users' => 3,
                'max_clients' => 500,
                'features' => json_encode([
                    'email_notifications' => true,
                    'sms_notifications' => false,
                    'api_access' => false
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Profissional',
                'slug' => 'professional',
                'description' => 'Plano completo para clínicas em crescimento',
                'price_monthly' => 199.00,
                'price_yearly' => 1990.00,
                'max_exams_per_month' => 2000,
                'max_storage_gb' => 20,
                'max_users' => 10,
                'max_clients' => 2000,
                'features' => json_encode([
                    'email_notifications' => true,
                    'sms_notifications' => true,
                    'api_access' => true,
                    'custom_branding' => true
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Enterprise',
                'slug' => 'enterprise',
                'description' => 'Plano sem limites para grandes clínicas e redes veterinárias',
                'price_monthly' => 399.00,
                'price_yearly' => 3990.00,
                'max_exams_per_month' => -1, // -1 = ilimitado
                'max_storage_gb' => 100,
                'max_users' => -1, // -1 = ilimitado
                'max_clients' => -1, // -1 = ilimitado
                'features' => json_encode([
                    'email_notifications' => true,
                    'sms_notifications' => true,
                    'api_access' => true,
                    'custom_branding' => true,
                    'priority_support' => true,
                    'white_label' => true
                ]),
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        DB::table('plans')->insert($plans);
    }
}