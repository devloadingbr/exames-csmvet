<?php

namespace App\Models;

use App\Models\Traits\BelongsToClinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Client extends Authenticatable
{
    use HasFactory, SoftDeletes, BelongsToClinic;

    protected $fillable = [
        'clinic_id',
        'name',
        'cpf',
        'birth_date',
        'email',
        'phone',
        'address',
        'city',
        'state',
        'zip_code',
        'receive_email_notifications',
        'receive_sms_notifications',
        'last_login_at',
        'is_active',
        'login_attempts',
        'blocked_until',
        'created_by',
    ];

    protected $casts = [
        'birth_date' => 'date',
        'last_login_at' => 'datetime',
        'blocked_until' => 'datetime',
        'receive_email_notifications' => 'boolean',
        'receive_sms_notifications' => 'boolean',
        'is_active' => 'boolean',
    ];

    /**
     * Relacionamento com pets
     */
    public function pets()
    {
        return $this->hasMany(Pet::class);
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
     * Verifica se está bloqueado
     */
    public function isBlocked(): bool
    {
        return $this->blocked_until && $this->blocked_until->isFuture();
    }

    /**
     * Método para autenticação personalizada
     */
    public function getAuthIdentifierName()
    {
        return 'id';
    }

    public function getAuthIdentifier()
    {
        return $this->{$this->getAuthIdentifierName()};
    }

    public function getAuthPasswordName()
    {
        return 'birth_date'; // Usar data de nascimento como "senha"
    }

    public function getAuthPassword()
    {
        return $this->birth_date;
    }

    public function getRememberToken()
    {
        return null; // Clientes não têm remember token
    }

    public function setRememberToken($value)
    {
        // Não implementar remember token para clientes
    }

    public function getRememberTokenName()
    {
        return null;
    }
}