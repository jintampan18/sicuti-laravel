<?php

namespace App\Http\Controllers;

use App\Models\KonfigCuti;
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
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.pegawai.riwayat_cuti.index', compact('riwayatCuti'));
    }

    public function show($id)
    {
        // Ambil ID pegawai dari user yang sedang login
        $pegawaiId = Auth::user()->pegawai->id;

        // Cari pengajuan cuti berdasarkan ID dan milik pegawai yang sedang login
        $pengajuanCuti = PengajuanCuti::with('jenisCuti', 'pegawai.user') // Pastikan relasi lengkap
            ->where('id', $id)
            ->where('pegawai_id', $pegawaiId)
            ->firstOrFail(); // Jika tidak ditemukan, lemparkan 404

        // Hitung sisa cuti untuk pegawai pada tahun saat ini
        $tahun = date('Y');
        $konfigCuti = KonfigCuti::where('tahun', $tahun)->first();
        if (!$konfigCuti) {
            abort(404, 'Konfigurasi cuti untuk tahun ini tidak ditemukan.');
        }

        // Total cuti terpakai oleh pegawai
        $cutiTerpakai = PengajuanCuti::where('pegawai_id', $pegawaiId)
            ->whereYear('tanggal_verifikasi_direktur', $tahun)
            ->where('status_direktur', 'disetujui')
            ->sum('durasi');

        // Sisa cuti = total hak cuti - cuti terpakai
        $sisaCuti = $konfigCuti->jumlah_cuti + Auth::user()->pegawai->sisa_cuti - $cutiTerpakai;

        // Tampilkan detail pengajuan cuti
        return view('pages.pegawai.riwayat_cuti.detail', compact('pengajuanCuti', 'sisaCuti'));
    }
}
