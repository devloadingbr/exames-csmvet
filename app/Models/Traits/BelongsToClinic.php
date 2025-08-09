<?php

namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

trait BelongsToClinic
{
    protected static function booted()
    {
        // Global scope para isolamento por clinic_id
        static::addGlobalScope('clinic', function (Builder $builder) {
            if (app()->has('current_clinic_id')) {
                $builder->where('clinic_id', app('current_clinic_id'));
            }
        });

        // Automaticamente definir clinic_id ao criar um novo registro
        static::creating(function (Model $model) {
            if (app()->has('current_clinic_id') && !$model->clinic_id) {
                $model->clinic_id = app('current_clinic_id');
            }
        });
    }

    /**
     * Relacionamento com a clínica
     */
    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    /**
     * Escopo para buscar sem filtro de clínica (apenas SuperAdmin)
     */
    public function scopeWithoutTenantScope(Builder $query)
    {
        return $query->withoutGlobalScope('clinic');
    }
}