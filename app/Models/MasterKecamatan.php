<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterKecamatan extends Model
{
    protected $table = 'master_kecamatans';
    protected $primaryKey = 'id_kecamatan';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_kecamatan', 'id_kabupaten', 'nama_kecamatan'];

    public function kabupaten(): BelongsTo
    {
        return $this->belongsTo(MasterKabupaten::class, 'id_kabupaten', 'id_kabupaten');
    }

    public function puskesmas(): HasMany
    {
        return $this->hasMany(MasterPuskesmas::class, 'id_kecamatan', 'id_kecamatan');
    }
}
