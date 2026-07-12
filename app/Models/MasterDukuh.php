<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MasterDukuh extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_dukuh';
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'id_dukuh',
        'id_kelurahan',
        'nama_dukuh',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (empty($model->id_dukuh)) {
                $model->id_dukuh = (string) \Illuminate\Support\Str::uuid();
            }
        });
    }

    public function kelurahan()
    {
        return $this->belongsTo(MasterKelurahan::class, 'id_kelurahan', 'id_kelurahan');
    }
}
