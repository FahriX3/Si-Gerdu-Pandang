<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

class Pasien extends Model
{
    use HasUuids;

    protected $table = 'pasiens';
    protected $primaryKey = 'id_pasien';
    protected $fillable = [
        'id_pasien', 'id_puskesmas', 'nama_lengkap', 'tanggal_lahir', 'jenis_kelamin',
        'nik', 'no_kk', 'no_rm', 'nama_kepala_keluarga', 'status_peserta',
        'tanggal_meninggal', 'id_kelurahan', 'id_dukuh', 'rt', 'rw', 'no_hp',
        'no_jkn', 'tanggal_awal_terdaftar', 'jenis_prolanis', 'status_peserta_prb',
        'riwayat_hipertensi_keluarga', 'jenis_pekerjaan', 'status_merokok'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_meninggal' => 'date',
        'tanggal_awal_terdaftar' => 'date',
    ];

    public function getUmurAttribute(): int
    {
        if ($this->status_peserta === 'Meninggal' && $this->tanggal_meninggal) {
            return $this->tanggal_lahir->diffInYears($this->tanggal_meninggal);
        }
        return $this->tanggal_lahir->diffInYears(Carbon::now());
    }

    public function puskesmas(): BelongsTo
    {
        return $this->belongsTo(MasterPuskesmas::class, 'id_puskesmas', 'id_puskesmas');
    }

    public function kelurahan(): BelongsTo
    {
        return $this->belongsTo(MasterKelurahan::class, 'id_kelurahan', 'id_kelurahan');
    }

    public function dukuhM(): BelongsTo
    {
        return $this->belongsTo(MasterDukuh::class, 'id_dukuh', 'id_dukuh');
    }

    public function pemeriksaans(): HasMany
    {
        return $this->hasMany(Pemeriksaan::class, 'id_pasien', 'id_pasien');
    }
    
    protected static function booted()
    {
        static::addGlobalScope('puskesmas', function (Builder $builder) {
            if (auth()->check() && auth()->user()->role !== 'admin_dinkes') {
                $builder->where('pasiens.id_puskesmas', auth()->user()->id_puskesmas);
            }
        });
    }
}
