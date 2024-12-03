<?php

namespace App\Http\Controllers;

use App\Models\KonfigCuti;
use App\Models\Pegawai;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;

class RekapCutiPegawaiController extends Controller
{
    public function index(Request $request)
    {
        // Mengambil parameter tahun dari request, default ke tahun saat ini jika tidak ada
        $tahun = $request->get('tahun', date('Y'));

        // Mengambil daftar tahun yang tersedia di tabel KonfigCuti (untuk dropdown filter)
        $tahunOptions = KonfigCuti::distinct()->pluck('tahun');

        // Mengambil konfigurasi cuti berdasarkan tahun yang dipilih
        $konfigCuti = KonfigCuti::where('tahun', $tahun)->first();

        // Jika tidak ditemukan konfigurasi cuti untuk tahun tersebut, arahkan ke halaman konfigurasi
        if (!$konfigCuti) {
            return redirect()->route('konfig_cuti')->with(
                'failed',
                'Konfigurasi cuti untuk tahun ini tidak ditemukan.'
            );
        }

        // Mengambil data pegawai beserta cuti yang terpakai dan menghitung sisa cuti
        $rekapCuti = Pegawai::with('user', 'jabatan') // Mengambil relasi dengan user dan jabatan
            ->withSum(
                ['pengajuanCuti as cuti_terpakai' => function ($query) use ($tahun) {
                    $query->where('status_staff_admin', 'Diverifikasi') // Hanya pengajuan yang diverifikasi oleh admin
                        ->where('status_direktur', 'Disetujui') // Hanya pengajuan yang disetujui oleh direktur
                        ->whereYear('tanggal_verifikasi_direktur', $tahun); // Hanya data untuk tahun yang dipilih
                }],
                'durasi' // Field yang dijumlahkan adalah durasi cuti
            )
            ->where('status_pegawai', 'aktif')
            ->get()
            ->map(function ($pegawai) use ($konfigCuti) {
                // Jika cuti terpakai belum dihitung, set ke 0
                $pegawai->cuti_terpakai = $pegawai->cuti_terpakai ?? 0;

                // Hitung sisa cuti:
                // Jumlah Cuti Tahunan + Sisa Cuti Sebelumnya - Cuti Terpakai
                $pegawai->sisa_cuti =
                    $konfigCuti->jumlah_cuti + $pegawai->sisa_cuti - $pegawai->cuti_terpakai;

                return $pegawai; // Kembalikan data pegawai dengan informasi tambahan
            });

        // Mengembalikan data ke view untuk ditampilkan
        return view('pages.staff_admin.rekap_cuti_pegawai.index', compact('rekapCuti', 'tahunOptions', 'tahun'));
    }


    public function show($id, $tahun = null)
    {
        // Jika tahun tidak diberikan, gunakan tahun saat ini
        $tahun = $tahun ?? date('Y');

        // Ambil data pegawai
        $pegawai = Pegawai::with('user')->findOrFail($id);

        // Ambil data konfigurasi cuti untuk tahun terkait
        $konfigCuti = KonfigCuti::where('tahun', $tahun)->first();

        if (!$konfigCuti) {
            return redirect()->route('rekap-cuti')->with('failed', 'Konfigurasi cuti untuk tahun ' . $tahun . ' tidak ditemukan.');
        }

        // Ambil pengajuan cuti berdasarkan tahun
        $pengajuanCuti = PengajuanCuti::with('jenisCuti')
            ->where('pegawai_id', $id)
            ->whereYear('tanggal_verifikasi_direktur', $tahun)
            ->where('status_direktur', 'disetujui')
            ->orderBy('created_at', 'desc')
            ->get();

        // Hitung cuti terpakai dan sisa cuti
        $cutiTerpakai = $pengajuanCuti->sum('durasi');
        $sisaCuti = $konfigCuti->jumlah_cuti + $pegawai->sisa_cuti - $cutiTerpakai;

        // Ambil semua opsi tahun untuk dropdown filter
        $tahunOptions = KonfigCuti::distinct()->pluck('tahun');

        return view('pages.staff_admin.rekap_cuti_pegawai.detail', compact('pegawai', 'pengajuanCuti', 'tahun', 'sisaCuti', 'cutiTerpakai', 'tahunOptions'));
    }
}
