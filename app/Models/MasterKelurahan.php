<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MasterKelurahan extends Model
{
    use HasUuids;

    protected $table = 'master_kelurahans';
    protected $primaryKey = 'id_kelurahan';
    protected $fillable = ['id_kelurahan', 'id_puskesmas', 'nama_kelurahan'];

    public function puskesmas()
    {
        return $this->belongsTo(MasterPuskesmas::class, 'id_puskesmas', 'id_puskesmas');
    }
}
