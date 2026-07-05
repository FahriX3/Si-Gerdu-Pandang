<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TerapiObat extends Model
{
    use HasUuids;

    protected $table = 'terapi_obats';
    protected $primaryKey = 'id_terapi';
    protected $fillable = ['id_terapi', 'id_pemeriksaan', 'nama_obat', 'aturan_pakai', 'jumlah_obat'];

    public function pemeriksaan(): BelongsTo
    {
        return $this->belongsTo(Pemeriksaan::class, 'id_pemeriksaan', 'id_pemeriksaan');
    }
}
