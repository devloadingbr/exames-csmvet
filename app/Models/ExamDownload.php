<?php

namespace App\Models;

use App\Models\Traits\BelongsToClinic;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamDownload extends Model
{
    use HasFactory, BelongsToClinic;

    protected $fillable = [
        'clinic_id',
        'exam_id',
        'client_id',
        'ip_address',
        'user_agent',
        'download_method',
        'downloaded_at',
    ];

    protected $casts = [
        'downloaded_at' => 'datetime',
    ];

    public $timestamps = false;

    /**
     * Relacionamento com exame
     */
    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    /**
     * Relacionamento com cliente
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}