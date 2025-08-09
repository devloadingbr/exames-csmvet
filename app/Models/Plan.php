<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price_monthly',
        'price_yearly',
        'max_exams_per_month',
        'max_storage_gb',
        'max_users',
        'max_clients',
        'features',
        'is_active',
    ];

    protected $casts = [
        'features' => 'array',
        'is_active' => 'boolean',
        'price_monthly' => 'decimal:2',
        'price_yearly' => 'decimal:2',
    ];

    /**
     * Relacionamento com clínicas
     */
    public function clinics()
    {
        return $this->hasMany(Clinic::class);
    }

    /**
     * Verifica se o plano permite uso ilimitado
     */
    public function isUnlimited(string $feature): bool
    {
        $value = $this->getAttribute("max_{$feature}");
        return $value === -1;
    }
}