<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JenisCuti extends Model
{
    use HasFactory;

    protected $table = 'jenis_cuti';

    protected $fillable = [
        'name_jenis_cuti',
    ];

    public function pengajuanCuti()
    {
        return $this->hasMany(PengajuanCuti::class);
    }
}
