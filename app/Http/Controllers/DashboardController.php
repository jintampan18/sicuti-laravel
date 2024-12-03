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
        $role = Auth::user()->role;
        switch ($role) {
            case 'pegawai':
                return $this->index_pegawai($request);
                break;
            case 'direktur':
                # code...
                return $this->index_direktur($request);
                break;
            case 'staff admin':
                # code...
                return $this->index_admin($request);
                break;
            default:
                # code...
                return redirect('/login');
                break;
        }
    }

    private function index_pegawai($request)
    {
        $id_user = Auth::user()->id;
        $pegawai = Pegawai::where('user_id', $id_user)->firstOrFail();

        $cuti_terpakai = $pegawai->pengajuanCuti()
            ->where('status_staff_admin', 'Diverifikasi')
            ->where('status_direktur', 'Disetujui')
            ->sum('durasi') ?? 0;

        $sisa_cuti = $pegawai->sisa_cuti ?? 0;

        $pengajuan_cuti_verifikasi = $pegawai->pengajuanCuti()
            ->where('status_direktur', 'disetujui')
            ->whereYear('created_at', date('Y'))
            ->count();

        $total_pengajuan_cuti = $pegawai->pengajuanCuti()
            ->whereYear('created_at', date('Y'))
            ->count();

        $data = [
            'cuti_terpakai' => $cuti_terpakai,
            'sisa_cuti' => $sisa_cuti,
            'pengajuan_cuti_verifikasi' => $pengajuan_cuti_verifikasi,
            'total_pengajuan_cuti' => $total_pengajuan_cuti
        ];

        return view('pages.dashboard.index', $data);
    }



    private function index_direktur($request)
    {
        $jumlah_pegawai = Pegawai::count();
        $pengajuan_cuti_verifikasi = PengajuanCuti::where(
            'status_direktur',
            'disetujui'
        )->count();
        $total_pengajuan_cuti = PengajuanCuti::where(
            'status_staff_admin',
            'diverifikasi'
        )->count();

        $data['jumlah_pegawai'] = $jumlah_pegawai;
        $data['pengajuan_cuti_verifikasi'] = $pengajuan_cuti_verifikasi;
        $data['total_pengajuan_cuti'] = $total_pengajuan_cuti;

        return view('pages.dashboard.index', $data);
    }

    private function index_admin($request)
    {
        $jumlah_pegawai = Pegawai::count();
        $jumlah_jabatan = Jabatan::count();
        $jumlah_jenis_cuti = JenisCuti::count();
        $pengajuan_cuti_verifikasi = PengajuanCuti::where([
            'status_direktur' => 'disetujui'
        ])->count();
        $total_pengajuan_cuti = PengajuanCuti::count();

        $data['jumlah_pegawai'] = $jumlah_pegawai;
        $data['jumlah_jabatan'] = $jumlah_jabatan;
        $data['jumlah_jenis_cuti'] = $jumlah_jenis_cuti;
        $data['pengajuan_cuti_verifikasi'] = $pengajuan_cuti_verifikasi;
        $data['total_pengajuan_cuti'] = $total_pengajuan_cuti;

        return view('pages.dashboard.index', $data);
    }
}
