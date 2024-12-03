<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KonfigCuti extends Model
{
    use HasFactory;

    protected $table = 'konfig_cuti';

    protected $fillable = [
        'tahun',
        'jumlah_cuti',
    ];
}
