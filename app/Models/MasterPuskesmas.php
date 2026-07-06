<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterPuskesmas extends Model
{
    use HasUuids;

    protected $table = 'master_puskesmas';
    protected $primaryKey = 'id_puskesmas';
    protected $fillable = ['id_puskesmas', 'id_kecamatan', 'kode_puskesmas', 'nama_puskesmas', 'alamat', 'no_telp'];

    public function kecamatan(): BelongsTo
    {
        return $this->belongsTo(MasterKecamatan::class, 'id_kecamatan', 'id_kecamatan');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }

    public function kelurahans()
    {
        return $this->hasMany(MasterKelurahan::class, 'id_puskesmas', 'id_puskesmas');
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class, 'id_puskesmas', 'id_puskesmas');
    }
    
    public function pasiens(): HasMany
    {
        return $this->hasMany(Pasien::class, 'id_puskesmas', 'id_puskesmas');
    }
}
