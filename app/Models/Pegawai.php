<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pegawai extends Model
{
    use HasFactory;

    protected $table = 'pegawai';

    protected $fillable = [
        'user_id',
        'nip',
        'jabatan_id',
        'alamat',
        'sisa_cuti',
        'tahun_masuk',
        'status_pegawai',
    ];

    // Relasi ke model User
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    // Relasi ke model Jabatan
    public function jabatan()
    {
        return $this->belongsTo(Jabatan::class, 'jabatan_id', 'id');
    }

    // Relasi ke model PengajuanCuti
    public function pengajuanCuti()
    {
        return $this->hasMany(PengajuanCuti::class);
    }
}
