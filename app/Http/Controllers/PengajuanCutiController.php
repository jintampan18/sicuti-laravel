<?php

namespace App\Http\Controllers;

use App\Models\JenisCuti;
use App\Models\KonfigCuti;
use App\Models\Pegawai;
use App\Models\PengajuanCuti;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PengajuanCutiController extends Controller
{
    // Staff Admin
    public function index()
    {
        // Mengambil semua data pengajuan cuti, termasuk relasi dengan pegawai dan user
        // Data diurutkan berdasarkan tanggal pembuatan secara descending
        $pengajuanCuti = PengajuanCuti::with('pegawai.user')
            ->orderBy('created_at', 'desc')
            ->get();

        // Menampilkan halaman daftar pengajuan cuti
        return view('pages.staff_admin.pengajuan_cuti.index', compact('pengajuanCuti'));
    }

    // Menampilkan halaman detail pengajuan cuti
    public function show($id)
    {
        // Tahun berjalan (default: tahun ini)
        $tahun = date('Y');

        // Ambil data pengajuan cuti berdasarkan ID
        $pengajuanCuti = PengajuanCuti::with('pegawai.user', 'jenisCuti')
            ->findOrFail($id);

        // Ambil data pegawai terkait
        $pegawai = $pengajuanCuti->pegawai;

        // Ambil konfigurasi cuti untuk tahun ini
        $konfigCuti = KonfigCuti::where('tahun', $tahun)->first();

        if (!$konfigCuti) {
            return redirect()->route('pengajuan-cuti.index')
                ->with('failed', 'Konfigurasi cuti untuk tahun ' . $tahun . ' tidak ditemukan.');
        }

        // Ambil semua pengajuan cuti pegawai ini yang disetujui pada tahun berjalan
        $pengajuanTahunIni = PengajuanCuti::where('pegawai_id', $pegawai->id)
            ->whereYear('tanggal_verifikasi_direktur', $tahun)
            ->where('status_direktur', 'disetujui')
            ->get();

        // Hitung total durasi cuti yang sudah digunakan
        $cutiTerpakai = $pengajuanTahunIni->sum('durasi');

        // Hitung sisa cuti
        $sisaCuti = $konfigCuti->jumlah_cuti + $pegawai->sisa_cuti - $cutiTerpakai;

        // Tampilkan halaman detail
        return view('pages.staff_admin.pengajuan_cuti.detail', compact('pengajuanCuti', 'sisaCuti', 'tahun'));
    }


    // Verifikasi pengajuan cuti
    public function verifikasi($id)
    {
        // Mengambil data pengajuan cuti berdasarkan ID
        $pengajuanCuti = PengajuanCuti::findOrFail($id);

        // Mengupdate status pengajuan cuti menjadi diverifikasi
        $pengajuanCuti->update([
            'status_staff_admin' => 'diverifikasi',
            'tanggal_verifikasi_admin' => now(),
        ]);

        return redirect()->route('pengajuan-cuti.index')->with('success', 'Pengajuan cuti berhasil diverifikasi.');
    }

    // Mengembalikan pengajuan cuti untuk revisi
    public function revisi(Request $request, $id)
    {
        // Validasi catatan revisi
        $request->validate([
            'catatan_staff_admin' => 'required|string|max:500',
        ]);

        // Mengupdate status dan menambahkan catatan revisi
        $pengajuanCuti = PengajuanCuti::findOrFail($id);
        $pengajuanCuti->update([
            'status_staff_admin' => 'direvisi',
            'catatan_staff_admin' => $request->catatan_staff_admin,
        ]);

        return redirect()->route('pengajuan-cuti.index')->with('warning', 'Pengajuan cuti dikembalikan untuk revisi.');
    }

    // Menolak pengajuan cuti
    public function tolak($id)
    {
        // Mengupdate status pengajuan cuti menjadi ditolak
        $pengajuanCuti = PengajuanCuti::findOrFail($id);
        $pengajuanCuti->update([
            'status_staff_admin' => 'ditolak',
            'tanggal_verifikasi_admin' => now(),
        ]);

        return redirect()->route('pengajuan-cuti.index')->with('success', 'Pengajuan cuti ditolak.');
    }

    // Direktur
    public function indexDirektur()
    {
        // Mengambil semua pengajuan cuti yang telah diverifikasi oleh staff admin
        $pengajuanCuti = PengajuanCuti::with('pegawai.user')
            ->where('status_staff_admin', 'diverifikasi')
            ->orderBy('created_at', 'desc')
            ->get();

        // Menampilkan halaman daftar pengajuan cuti untuk direktur
        return view('pages.direktur.pengajuan_cuti.index', compact('pengajuanCuti'));
    }

    // Menampilkan detail pengajuan cuti untuk direktur
    public function detailDirektur($id)
    {
        // Mengambil detail pengajuan cuti
        $pengajuanCuti = PengajuanCuti::with('pegawai.user', 'jenisCuti')
            ->findOrFail($id);

        return view('pages.direktur.pengajuan_cuti.detail', compact('pengajuanCuti'));
    }

    // Menyetujui pengajuan cuti oleh direktur
    public function setujuiDirektur($id)
    {
        // Mengupdate status menjadi disetujui
        $pengajuanCuti = PengajuanCuti::findOrFail($id);
        $pengajuanCuti->update([
            'status_direktur' => 'disetujui',
            'tanggal_verifikasi_direktur' => now(),
        ]);

        return redirect()->route('direktur.pengajuan-cuti')->with('success', 'Pengajuan cuti berhasil disetujui.');
    }

    // Menolak pengajuan cuti oleh direktur
    public function tolakDirektur($id)
    {
        // Mengupdate status menjadi ditolak
        $pengajuanCuti = PengajuanCuti::findOrFail($id);
        $pengajuanCuti->update([
            'status_direktur' => 'ditolak',
            'tanggal_verifikasi_direktur' => now(),
        ]);

        return redirect()->route('direktur.pengajuan-cuti')->with('success', 'Pengajuan cuti ditolak.');
    }

    // Pegawai
    public function showFormPengajuan()
    {
        // Mengambil semua jenis cuti untuk ditampilkan di dropdown
        $jenisCuti = JenisCuti::all();

        // Menampilkan formulir pengajuan cuti
        return view('pages.pegawai.pengajuan_cuti.form', compact('jenisCuti'));
    }

    // Memproses pengajuan cuti
    public function pengajuanCuti(Request $request)
    {
        // Validasi input
        $request->validate([
            'jenis_cuti_id' => 'required',
            'mulai_cuti' => 'required|date|after_or_equal:today',
            'selesai_cuti' => 'required|date|after_or_equal:mulai_cuti',
            'alasan' => 'required|string',
            'dokumen_pendukung.*' => 'nullable|file|mimes:pdf|max:2048',
        ], [
            'mulai_cuti.after_or_equal' => 'Tanggal mulai cuti tidak boleh sebelum hari ini.',
            'selesai_cuti.after_or_equal' => 'Tanggal selesai cuti tidak boleh sebelum tanggal mulai cuti.',
        ]);

        // Ambil data pegawai berdasarkan user yang sedang login
        $pegawai = Pegawai::where('user_id', Auth::id())->firstOrFail();

        // Hitung durasi cuti
        $tanggal_mulai = Carbon::parse($request->mulai_cuti);
        $tanggal_selesai = Carbon::parse($request->selesai_cuti);
        $durasi = $tanggal_mulai->diffInDays($tanggal_selesai) + 1;

        // Simpan dokumen pendukung
        $dokumenPendukung = [];
        if ($request->hasFile('dokumen_pendukung')) {
            foreach ($request->file('dokumen_pendukung') as $file) {
                $path = $file->store('dokumen_pendukung', 'public');
                $dokumenPendukung[] = $path;
            }
        }

        // Buat pengajuan cuti baru
        PengajuanCuti::create([
            'pegawai_id' => $pegawai->id,
            'jenis_cuti_id' => $request->jenis_cuti_id,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'durasi' => $durasi,
            'alasan' => $request->alasan,
            'dokumen_pendukung' => json_encode($dokumenPendukung),
            'status_staff_admin' => 'proses',
            'status_direktur' => 'proses',
        ]);

        return redirect()->route('pegawai.riwayat-cuti')->with('success', 'Pengajuan cuti berhasil dibuat!');
    }
}
