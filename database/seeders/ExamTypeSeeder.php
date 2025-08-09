<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExamType;
use App\Models\Clinic;

class ExamTypeSeeder extends Seeder
{
    public function run(): void
    {
        $clinics = Clinic::all();

        $examTypes = [
            [
                'name' => 'Hemograma Completo',
                'description' => 'Análise completa das células do sangue',
                'default_price' => 45.00,
                'color' => '#DC2626'
            ],
            [
                'name' => 'Raio-X',
                'description' => 'Exame radiológico para visualização de estruturas internas',
                'default_price' => 80.00,
                'color' => '#2563EB'
            ],
            [
                'name' => 'Ultrassom',
                'description' => 'Exame de imagem por ultrassom',
                'default_price' => 120.00,
                'color' => '#7C3AED'
            ],
            [
                'name' => 'Exame de Urina',
                'description' => 'Análise física, química e microscópica da urina',
                'default_price' => 35.00,
                'color' => '#059669'
            ],
            [
                'name' => 'Exame de Fezes',
                'description' => 'Exame parasitológico de fezes',
                'default_price' => 30.00,
                'color' => '#D97706'
            ],
            [
                'name' => 'Bioquímico',
                'description' => 'Análise bioquímica do sangue',
                'default_price' => 65.00,
                'color' => '#DB2777'
            ],
            [
                'name' => 'Ecocardiograma',
                'description' => 'Ultrassom do coração',
                'default_price' => 150.00,
                'color' => '#DC2626'
            ],
            [
                'name' => 'Eletrocardiograma',
                'description' => 'Exame da atividade elétrica do coração',
                'default_price' => 70.00,
                'color' => '#2563EB'
            ]
        ];

        foreach ($clinics as $clinic) {
            foreach ($examTypes as $typeData) {
                ExamType::create([
                    'clinic_id' => $clinic->id,
                    'name' => $typeData['name'],
                    'description' => $typeData['description'],
                    'default_price' => $typeData['default_price'],
                    'color' => $typeData['color'],
                ]);
            }
        }
    }
}