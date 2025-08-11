<?php

namespace App\Models;

use App\Models\Traits\BelongsToClinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Exam extends Model
{
    use HasFactory, SoftDeletes, BelongsToClinic;

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($exam) {
            if (empty($exam->codigo)) {
                $exam->codigo = static::generateCodigo();
            }
        });
    }

    public static function generateCodigo(): string
    {
        $year = date('Y');
        $prefix = "VET{$year}";
        
        // Buscar último código do ano
        $lastExam = static::where('codigo', 'like', "{$prefix}%")
            ->orderBy('codigo', 'desc')
            ->first();
        
        if ($lastExam) {
            $lastNumber = (int) substr($lastExam->codigo, -3);
            $newNumber = $lastNumber + 1;
        } else {
            $newNumber = 1;
        }
        
        return $prefix . str_pad($newNumber, 3, '0', STR_PAD_LEFT);
    }

    protected $fillable = [
        'clinic_id',
        'client_id',
        'pet_id',
        'exam_type_id',
        'codigo',
        'description',
        'exam_date',
        'result_summary',
        'veterinarian_name',
        'veterinarian_crmv',
        'original_filename',
        'file_path',
        'file_size_bytes',
        'file_hash',
        'storage_disk',
        'status',
        'price',
        'is_active',
        'expires_at',
        'uploaded_by',
    ];

    protected $casts = [
        'exam_date' => 'date',
        'expires_at' => 'datetime',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'file_size_bytes' => 'integer',
    ];

    /**
     * Relacionamento com cliente
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relacionamento com pet
     */
    public function pet()
    {
        return $this->belongsTo(Pet::class);
    }

    /**
     * Relacionamento com tipo de exame
     */
    public function examType()
    {
        return $this->belongsTo(ExamType::class);
    }

    /**
     * Relacionamento com quem fez upload
     */
    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    /**
     * Relacionamento com downloads
     */
    public function downloads()
    {
        return $this->hasMany(ExamDownload::class);
    }

    /**
     * Verifica se está disponível para download
     */
    public function isAvailable(): bool
    {
        return $this->status === 'ready' && $this->is_active;
    }

    /**
     * Verifica se já expirou
     */
    public function isExpired(): bool
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    /**
     * Formatar tamanho do arquivo
     */
    public function getFormattedSizeAttribute(): string
    {
        $bytes = $this->file_size_bytes;
        
        if ($bytes >= 1048576) {
            return round($bytes / 1048576, 2) . ' MB';
        }
        
        if ($bytes >= 1024) {
            return round($bytes / 1024, 2) . ' KB';
        }
        
        return $bytes . ' bytes';
    }
}