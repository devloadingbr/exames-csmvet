<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StorageService
{
    protected string $disk;

    public function __construct()
    {
        $this->disk = config('filesystems.default');
    }

    /**
     * Armazena um arquivo no sistema configurado
     */
    public function store(UploadedFile $file, string $directory = 'exams'): string
    {
        // Gerar nome único para o arquivo
        $fileName = $this->generateFileName($file);
        $path = $directory . '/' . $fileName;

        // Salvar no disco configurado
        $storedPath = Storage::disk($this->disk)->putFileAs($directory, $file, $fileName);

        return $storedPath;
    }

    /**
     * Faz download de um arquivo
     */
    public function download(string $filePath, string $originalName = null): StreamedResponse
    {
        if (!Storage::disk($this->disk)->exists($filePath)) {
            abort(404, 'Arquivo não encontrado');
        }

        $fileName = $originalName ?? basename($filePath);

        return Storage::disk($this->disk)->download($filePath, $fileName, [
            'Content-Type' => 'application/pdf',
        ]);
    }

    /**
     * Retorna URL para visualização (se suportado pelo storage)
     */
    public function url(string $filePath): string
    {
        if ($this->disk === 'local') {
            // Para storage local, usar rota protegida
            return route('admin.exams.download', ['exam' => $filePath]);
        }

        // Para MinIO/S3, usar URL temporária
        return Storage::disk($this->disk)->temporaryUrl($filePath, now()->addHours(1));
    }

    /**
     * Remove arquivo do storage
     */
    public function delete(string $filePath): bool
    {
        return Storage::disk($this->disk)->delete($filePath);
    }

    /**
     * Verifica se arquivo existe
     */
    public function exists(string $filePath): bool
    {
        return Storage::disk($this->disk)->exists($filePath);
    }

    /**
     * Retorna tamanho do arquivo em bytes
     */
    public function size(string $filePath): int
    {
        return Storage::disk($this->disk)->size($filePath);
    }

    /**
     * Gera nome único para o arquivo
     */
    protected function generateFileName(UploadedFile $file): string
    {
        $extension = $file->getClientOriginalExtension();
        $timestamp = now()->format('YmdHis');
        $random = substr(md5(uniqid()), 0, 8);
        
        return "{$timestamp}_{$random}.{$extension}";
    }

    /**
     * Valida se arquivo é PDF
     */
    public function validatePdf(UploadedFile $file): bool
    {
        return $file->getClientOriginalExtension() === 'pdf' 
               && $file->getMimeType() === 'application/pdf';
    }

    /**
     * Formatar tamanho do arquivo
     */
    public static function formatBytes(int $bytes): string
    {
        if ($bytes >= 1073741824) {
            return number_format($bytes / 1073741824, 2) . ' GB';
        } elseif ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' bytes';
        }
    }

    /**
     * Verifica limites de storage da clínica
     */
    public function checkStorageLimit(int $clinicId, int $fileSizeBytes): bool
    {
        $clinic = \App\Models\Clinic::find($clinicId);
        if (!$clinic || !$clinic->plan) {
            return false;
        }

        // Calcular uso atual
        $currentUsage = \App\Models\Exam::where('clinic_id', $clinicId)
            ->sum('file_size_bytes');

        $maxStorageBytes = $clinic->plan->max_storage_gb * 1024 * 1024 * 1024;
        
        return ($currentUsage + $fileSizeBytes) <= $maxStorageBytes;
    }

    /**
     * Retorna estatísticas de uso de storage
     */
    public function getStorageStats(int $clinicId): array
    {
        $clinic = \App\Models\Clinic::find($clinicId);
        $currentUsage = \App\Models\Exam::where('clinic_id', $clinicId)
            ->sum('file_size_bytes');

        $maxStorageBytes = $clinic->plan->max_storage_gb * 1024 * 1024 * 1024;
        $usagePercent = $maxStorageBytes > 0 ? ($currentUsage / $maxStorageBytes) * 100 : 0;

        return [
            'current_usage_bytes' => $currentUsage,
            'current_usage_formatted' => self::formatBytes($currentUsage),
            'max_storage_bytes' => $maxStorageBytes,
            'max_storage_formatted' => self::formatBytes($maxStorageBytes),
            'usage_percent' => round($usagePercent, 2),
            'available_bytes' => max(0, $maxStorageBytes - $currentUsage),
            'available_formatted' => self::formatBytes(max(0, $maxStorageBytes - $currentUsage)),
        ];
    }
}