<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MasterProvinsi extends Model
{
    protected $table = 'master_provinsis';
    protected $primaryKey = 'id_provinsi';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['id_provinsi', 'nama_provinsi'];

    public function kabupatens(): HasMany
    {
        return $this->hasMany(MasterKabupaten::class, 'id_provinsi', 'id_provinsi');
    }
}
