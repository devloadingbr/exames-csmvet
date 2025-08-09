<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Clinic extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'cnpj',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'logo_url',
        'primary_color',
        'secondary_color',
        'custom_domain',
        'plan_id',
        'subscription_status',
        'trial_ends_at',
        'subscription_ends_at',
        'settings',
        'is_active',
        'created_by',
    ];

    protected $casts = [
        'settings' => 'array',
        'is_active' => 'boolean',
        'trial_ends_at' => 'datetime',
        'subscription_ends_at' => 'datetime',
    ];

    /**
     * Relacionamento com o plano
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * Relacionamento com usuários
     */
    public function users()
    {
        return $this->hasMany(User::class);
    }

    /**
     * Relacionamento com clientes
     */
    public function clients()
    {
        return $this->hasMany(Client::class);
    }

    /**
     * Relacionamento com exames
     */
    public function exams()
    {
        return $this->hasMany(Exam::class);
    }

    /**
     * Verifica se a clínica está no período de teste
     */
    public function isOnTrial(): bool
    {
        return $this->trial_ends_at && $this->trial_ends_at->isFuture();
    }

    /**
     * Verifica se a assinatura está ativa
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscription_status === 'active';
    }
}