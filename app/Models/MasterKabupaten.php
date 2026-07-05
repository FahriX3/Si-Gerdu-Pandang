<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterKabupaten extends Model
{
    protected $table = 'master_kabupatens';
    protected $primaryKey = 'id_kabupaten';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_kabupaten', 'id_provinsi', 'nama_kabupaten'];

    public function provinsi(): BelongsTo
    {
        return $this->belongsTo(MasterProvinsi::class, 'id_provinsi', 'id_provinsi');
    }

    public function kecamatans(): HasMany
    {
        return $this->hasMany(MasterKecamatan::class, 'id_kabupaten', 'id_kabupaten');
    }
}
