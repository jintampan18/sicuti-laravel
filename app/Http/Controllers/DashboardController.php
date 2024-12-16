<?php

namespace App\Http\Controllers;

use App\Models\Jabatan;
use App\Models\JenisCuti;
use App\Models\Pegawai;
use App\Models\PengajuanCuti;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // Mendapatkan role pengguna yang sedang login
        $role = Auth::user()->role;

        // Menentukan logika berdasarkan role pengguna
        switch ($role) {
            case 'pegawai':
                // Jika pengguna adalah pegawai, panggil fungsi index_pegawai
                return $this->index_pegawai($request);
                break;
            case 'direktur':
                // Jika pengguna adalah direktur, panggil fungsi index_direktur
                return $this->index_direktur($request);
                break;
            case 'staff admin':
                // Jika pengguna adalah staff admin, panggil fungsi index_admin
                return $this->index_admin($request);
                break;
            default:
                // Jika role tidak dikenali, arahkan pengguna ke halaman login
                return redirect('/login');
                break;
        }
    }

    private function index_pegawai($request)
    {
        // Mendapatkan ID pengguna yang sedang login
        $id_user = Auth::user()->id;

        // Mendapatkan data pegawai berdasarkan ID pengguna
        $pegawai = Pegawai::where('user_id', $id_user)->firstOrFail();

        // Menghitung total cuti yang sudah terpakai berdasarkan pengajuan yang disetujui
        $cuti_terpakai = $pegawai->pengajuanCuti()
            ->where('status_staff_admin', 'Diverifikasi')
            ->where('status_direktur', 'Disetujui')
            ->sum('durasi') ?? 0;

        // Mendapatkan sisa cuti pengguna
        $sisa_cuti = $pegawai->sisa_cuti ?? 0;

        // Menghitung jumlah pengajuan cuti yang diverifikasi oleh direktur tahun ini
        $pengajuan_cuti_verifikasi = $pegawai->pengajuanCuti()
            ->where('status_direktur', 'disetujui')
            ->whereYear('created_at', date('Y'))
            ->count();

        // Menghitung total pengajuan cuti tahun ini
        $total_pengajuan_cuti = $pegawai->pengajuanCuti()
            ->whereYear('created_at', date('Y'))
            ->count();

        // Menyiapkan data untuk dikirimkan ke view
        $data = [
            'cuti_terpakai' => $cuti_terpakai,
            'sisa_cuti' => $sisa_cuti,
            'pengajuan_cuti_verifikasi' => $pengajuan_cuti_verifikasi,
            'total_pengajuan_cuti' => $total_pengajuan_cuti
        ];

        // Mengembalikan view dashboard untuk pegawai dengan data
        return view('pages.dashboard.index', $data);
    }

    private function index_direktur($request)
    {
        // Menghitung jumlah pegawai
        $jumlah_pegawai = Pegawai::count();

        // Menghitung jumlah pengajuan cuti yang disetujui oleh direktur
        $pengajuan_cuti_verifikasi = PengajuanCuti::where(
            'status_direktur',
            'disetujui'
        )->count();

        // Menghitung total pengajuan cuti yang diverifikasi oleh staff admin
        $total_pengajuan_cuti = PengajuanCuti::where(
            'status_staff_admin',
            'diverifikasi'
        )->count();

        // Menyiapkan data untuk dikirimkan ke view
        $data['jumlah_pegawai'] = $jumlah_pegawai;
        $data['pengajuan_cuti_verifikasi'] = $pengajuan_cuti_verifikasi;
        $data['total_pengajuan_cuti'] = $total_pengajuan_cuti;

        // Mengembalikan view dashboard untuk direktur dengan data
        return view('pages.dashboard.index', $data);
    }

    private function index_admin($request)
    {
        // Tahun saat ini
        $tahun = date('Y');

        // Menghitung jumlah pegawai
        $jumlah_pegawai = Pegawai::count();

        // Menghitung jumlah jabatan
        $jumlah_jabatan = Jabatan::count();

        // Menghitung jumlah jenis cuti
        $jumlah_jenis_cuti = JenisCuti::count();

        // Menghitung jumlah pengajuan cuti yang disetujui oleh direktur
        $pengajuan_cuti_verifikasi = PengajuanCuti::where([
            'status_direktur' => 'disetujui'
        ])->count();

        // Menghitung total pengajuan cuti
        $total_pengajuan_cuti = PengajuanCuti::count();

        // Mengambil jumlah pengajuan cuti per jenis untuk tahun ini
        $cuti_per_jenis = PengajuanCuti::selectRaw('jenis_cuti_id, COUNT(*) as total')
            ->whereYear('tanggal_verifikasi_direktur', $tahun)
            ->where('status_direktur', 'disetujui')
            ->groupBy('jenis_cuti_id')
            ->pluck('total', 'jenis_cuti_id');

        // Mengambil semua jenis cuti
        $jenis_cuti = JenisCuti::all();

        // Format data untuk semua jenis cuti
        $cuti_dinamis = [];
        foreach ($jenis_cuti as $jenis) {
            $cuti_dinamis[] = [
                'jenis_cuti' => $jenis->name_jenis_cuti,
                'total' => $cuti_per_jenis[$jenis->id] ?? 0
            ];
        }

        // Menyiapkan data untuk dikirimkan ke view
        $data['jumlah_pegawai'] = $jumlah_pegawai;
        $data['jumlah_jabatan'] = $jumlah_jabatan;
        $data['jumlah_jenis_cuti'] = $jumlah_jenis_cuti;
        $data['pengajuan_cuti_verifikasi'] = $pengajuan_cuti_verifikasi;
        $data['total_pengajuan_cuti'] = $total_pengajuan_cuti;
        $data['cuti_dinamis'] = $cuti_dinamis;

        // Mengembalikan view dashboard untuk staff admin dengan data
        return view('pages.dashboard.index', $data);
    }
}
