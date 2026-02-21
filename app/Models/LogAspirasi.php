<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogAspirasi extends Model
{
    protected $table = 'log_aspirasis';

    protected $fillable = [
        'id_aspirasi',
        'status_lama',
        'status_baru',
        'keterangan',
        'perubah_role',
        'perubah_id',
    ];

    public function aspirasi()
    {
        return $this->belongsTo(InputAspirasi::class, 'id_aspirasi', 'id_pelaporan');
    }
}
