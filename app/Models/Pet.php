<?php

namespace App\Models;

use App\Models\Traits\BelongsToClinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pet extends Model
{
    use HasFactory, SoftDeletes, BelongsToClinic;

    protected $fillable = [
        'clinic_id',
        'client_id',
        'name',
        'species',
        'breed',
        'gender',
        'birth_date',
        'weight',
        'color',
        'photo_url',
        'observations',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'weight' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    /**
     * Relacionamento com cliente
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relacionamento com exames
     */
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * Relacionamento com quem criou
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Calcula a idade do pet
     */
    public function getAgeAttribute(): ?string
    {
        if (!$this->birth_date) {
            return null;
        }

        $age = $this->birth_date->diff(now());
        
        if ($age->y > 0) {
            return $age->y . ' ano' . ($age->y > 1 ? 's' : '');
        }

        if ($age->m > 0) {
            return $age->m . ' mês' . ($age->m > 1 ? 'es' : '');
        }

        return $age->d . ' dia' . ($age->d > 1 ? 's' : '');
    }
}