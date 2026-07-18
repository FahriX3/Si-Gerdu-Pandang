<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MasterKelompokGp extends Model
{
    use HasUuids;

    protected $table = 'master_kelompok_gps';
    protected $primaryKey = 'id_kelompok_gp';
    
    protected $fillable = [
        'id_puskesmas',
        'nama_kelompok_gp'
    ];

    public function puskesmas()
    {
        return $this->belongsTo(MasterPuskesmas::class, 'id_puskesmas', 'id_puskesmas');
    }
}
