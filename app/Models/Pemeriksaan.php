<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pemeriksaan extends Model
{
    use HasUuids;

    protected $table = 'pemeriksaans';
    protected $primaryKey = 'id_pemeriksaan';
    protected $fillable = [
        'id_pemeriksaan', 'id_pasien', 'id_user', 'tanggal_pemeriksaan',
        'tempat_pemeriksaan', 'keluhan', 'berat_badan', 'tinggi_badan',
        'lingkar_perut', 'systole', 'diastole', 'nadi', 'diagnosis', 'catatan',
        'tanggal_pemberian_obat', 'gula_darah_puasa', 'gula_darah_sewaktu',
        'kolesterol_total', 'kategori_kolesterol', 'trigliserida', 'kategori_trigliserida', 
        'asam_urat', 'kategori_asam_urat', 'hba1c', 'dokumen_lab', 'path_foto_lab'
    ];

    protected $casts = [
        'tanggal_pemeriksaan' => 'date',
        'tanggal_pemberian_obat' => 'date',
    ];

    public function getImtAttribute(): float
    {
        if ($this->tinggi_badan > 0) {
            $tinggi_m = $this->tinggi_badan / 100;
            return round($this->berat_badan / ($tinggi_m * $tinggi_m), 2);
        }
        return 0.0;
    }

    public function getStatusImtAttribute(): string
    {
        $imt = $this->imt;
        if ($imt < 17.0) return 'Sangat Kurus';
        if ($imt <= 18.4) return 'Kurus';
        if ($imt <= 25.0) return 'Normal (Ideal)';
        if ($imt <= 27.0) return 'Gemuk (Overweight)';
        return 'Obesitas';
    }
    
    public function getKategoriTensiAttribute(): string
    {
        if ($this->systole >= 160 || $this->diastole >= 100) return 'Hipertensi Derajat 2';
        if ($this->systole >= 140 || $this->diastole >= 90) return 'Hipertensi Derajat 1';
        if ($this->systole >= 120 || $this->diastole >= 80) return 'Pra-Hipertensi';
        if ($this->systole < 90 || $this->diastole < 60) return 'Hipotensi';
        return 'Normal';
    }
    
    public function getKategoriKolesterolAttribute(): string
    {
        if (!$this->kolesterol_total) return 'Tidak Diperiksa';
        if ($this->kolesterol_total < 200) return 'Normal';
        if ($this->kolesterol_total <= 239) return 'Batas Tinggi (Borderline)';
        return 'Tinggi';
    }

    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    public function pemeriksa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id');
    }

    public function terapiObats(): HasMany
    {
        return $this->hasMany(TerapiObat::class, 'id_pemeriksaan', 'id_pemeriksaan');
    }
    
    protected static function booted()
    {
        static::addGlobalScope('puskesmas', function (\Illuminate\Database\Eloquent\Builder $builder) {
            if (auth()->check() && auth()->user()->role !== 'admin_dinkes') {
                $builder->whereHas('pasien', function ($q) {
                    $q->where('id_puskesmas', auth()->user()->id_puskesmas);
                });
            }
        });
    }
}
