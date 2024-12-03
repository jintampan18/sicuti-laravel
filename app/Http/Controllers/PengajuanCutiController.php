<?php

namespace App\Http\Controllers;

use App\Models\JenisCuti;
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
        $pengajuanCuti = PengajuanCuti::with('pegawai.user')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.staff_admin.pengajuan_cuti.index', compact('pengajuanCuti'));
    }

    public function show($id)
    {
        $pengajuanCuti = PengajuanCuti::with('pegawai.user', 'jenisCuti')
            ->findOrFail($id);

        return view('pages.staff_admin.pengajuan_cuti.detail', compact('pengajuanCuti'));
    }

    public function verifikasi($id)
    {
        $pengajuanCuti = PengajuanCuti::findOrFail($id);
        $pengajuanCuti->update([
            'status_staff_admin' => 'diverifikasi',
            'tanggal_verifikasi_admin' => now(),
        ]);

        return redirect()->route('pengajuan-cuti.index')->with('success', 'Pengajuan cuti berhasil diverifikasi.');
    }

    public function revisi(Request $request, $id)
    {
        $request->validate([
            'catatan_staff_admin' => 'required|string|max:500',
        ]);

        $pengajuanCuti = PengajuanCuti::findOrFail($id);
        $pengajuanCuti->update([
            'status_staff_admin' => 'proses',
            'catatan_staff_admin' => $request->catatan_staff_admin,
        ]);

        return redirect()->route('pengajuan-cuti.index')->with('warning', 'Pengajuan cuti dikembalikan untuk revisi.');
    }

    public function tolak($id)
    {
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
        $pengajuanCuti = PengajuanCuti::with('pegawai.user')
            ->where('status_staff_admin', 'diverifikasi')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pages.direktur.pengajuan_cuti.index', compact('pengajuanCuti'));
    }

    public function detailDirektur($id)
    {
        $pengajuanCuti = PengajuanCuti::with('pegawai.user', 'jenisCuti')
            ->findOrFail($id);

        return view('pages.direktur.pengajuan_cuti.detail', compact('pengajuanCuti'));
    }

    public function setujuiDirektur($id)
    {
        $pengajuanCuti = PengajuanCuti::findOrFail($id);


        // // Pastikan status sebelumnya belum disetujui untuk mencegah pengurangan berulang
        // if ($pengajuanCuti->status_direktur !== 'disetujui') {
        //     // Cari pegawai terkait
        //     $pegawai = Pegawai::findOrFail($pengajuanCuti->pegawai_id);

        //     // Kurangi sisa cuti dengan durasi pengajuan cuti
        //     $pegawai->update([
        //         'sisa_cuti' => $pegawai->sisa_cuti - $pengajuanCuti->durasi,
        //     ]);
        // }

        // Perbarui status pengajuan cuti
        $pengajuanCuti->update([
            'status_direktur' => 'disetujui',
            'tanggal_verifikasi_direktur' => now(),
        ]);

        return redirect()->route('direktur.pengajuan-cuti')->with('success', 'Pengajuan cuti berhasil disetujui.');
    }


    public function tolakDirektur($id)
    {
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
        $jenisCuti = JenisCuti::all();

        return view('pages.pegawai.pengajuan_cuti.form', compact('jenisCuti'));
    }

    public function pengajuanCuti(Request $request)
    {
        // Validasi data
        $request->validate([
            'jenis_cuti_id' => 'required',
            'mulai_cuti' => 'required|date|after_or_equal:today',
            'selesai_cuti' => 'required|date|after_or_equal:mulai_cuti',
            'alasan' => 'required|string|max:255',
            'dokumen_pendukung.*' => 'nullable|file|mimes:pdf|max:2048',
        ]);

        // Ambil pegawai id berdasarkan user yang sedang login
        $pegawai = Pegawai::where('user_id', Auth::id())->firstOrFail();

        // Hitung durasi hari
        $tanggal_mulai = Carbon::parse($request->mulai_cuti);
        $tanggal_selesai = Carbon::parse($request->selesai_cuti);
        $durasi = $tanggal_mulai->diffInDays($tanggal_selesai) + 1;

        // Simpan dokumen pendukung jika ada
        $dokumenPendukung = [];
        if ($request->hasFile('dokumen_pendukung')) {
            foreach ($request->file('dokumen_pendukung') as $file) {
                $path = $file->store('dokumen_pendukung', 'public');
                $dokumenPendukung[] = $path;
            }
        }

        // Simpan data pengajuan cuti
        PengajuanCuti::create([
            'pegawai_id' => $pegawai->id,
            'jenis_cuti_id' => $request->jenis_cuti_id,
            'tanggal_mulai' => $tanggal_mulai,
            'tanggal_selesai' => $tanggal_selesai,
            'durasi' => $durasi,
            'alasan' => $request->alasan,
            'dokumen_pendukung' => json_encode($dokumenPendukung),
            'status_staff_admin' => 'proses',
            'catatan_staff_admin' => null,
            'tanggal_verifikasi_admin' => null,
            'status_direktur' => 'proses',
            'catatan_direktur' => null,
            'tanggal_verifikasi_direktur' => null,
        ]);

        return redirect()->route('pegawai.riwayat-cuti')->with('success', 'Pengajuan cuti berhasil dibuat!');
    }
}
