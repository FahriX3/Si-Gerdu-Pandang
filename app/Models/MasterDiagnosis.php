<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MasterDiagnosis extends Model
{
    use \Illuminate\Database\Eloquent\Concerns\HasUuids;

    protected $table = 'master_diagnoses';
    protected $primaryKey = 'id_diagnosis';
    protected $fillable = ['nama_diagnosis'];

    public function pemeriksaans()
    {
        return $this->belongsToMany(Pemeriksaan::class, 'pemeriksaan_diagnosis', 'id_diagnosis', 'id_pemeriksaan');
    }
}
