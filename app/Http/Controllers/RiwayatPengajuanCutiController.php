<?php

namespace App\Http\Controllers;

use App\Models\PengajuanCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RiwayatPengajuanCutiController extends Controller
{
    public function index()
    {
        // Ambil ID pegawai dari user yang sedang login
        $pegawaiId = Auth::user()->pegawai->id;

        // Ambil riwayat pengajuan cuti berdasarkan pegawai_id
        $riwayatCuti = PengajuanCuti::where('pegawai_id', $pegawaiId)
            ->with('jenisCuti') // Pastikan ada relasi jenis cuti
            ->orderBy('tanggal_mulai', 'desc')
            ->get();

        return view('pages.pegawai.riwayat_cuti.index', compact('riwayatCuti'));
    }
}
