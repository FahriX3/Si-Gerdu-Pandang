<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class MasterPekerjaan extends Model
{
    use HasUuids;

    protected $table = 'master_pekerjaans';
    protected $primaryKey = 'id_pekerjaan';
    protected $fillable = ['nama_pekerjaan'];
}
