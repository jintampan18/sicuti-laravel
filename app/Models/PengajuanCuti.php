<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengajuanCuti extends Model
{
    use HasFactory;

    protected $table = 'pengajuan_cutis';

    protected $fillable = [
        'pegawai_id',
        'jenis_cuti_id',
        'tanggal_mulai',
        'tanggal_selesai',
        'durasi',
        'alasan',
        'dokumen_pendukung',
        'status_staff_admin',
        'catatan_staff_admin',
        'tanggal_verifikasi_admin',
        'status_direktur',
        'catatan_direktur',
        'tanggal_verifikasi_direktur',
    ];

    // Relasi ke model Pegawai
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class);
    }

    // Relasi ke model JenisCuti
    public function jenisCuti()
    {
        return $this->belongsTo(JenisCuti::class);
    }
}
