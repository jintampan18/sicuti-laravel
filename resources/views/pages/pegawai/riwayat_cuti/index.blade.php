@extends('layouts.template')

@section('title', '- Riwayat Pengajuan Cuti')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Riwayat Pengajuan Cuti</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Riwayat Pengajuan Cuti</h3>
                    <hr>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Cuti</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Lama Cuti</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($riwayatCuti as $index => $item)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $item->jenisCuti->name_jenis_cuti }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                                        <td>{{ $item->durasi }} hari</td>
                                        <td>
                                            @if ($item->status_staff_admin === 'diverifikasi' && $item->status_direktur === 'proses')
                                                <span class="badge badge-primary">Menunggu Direktur</span>
                                            @elseif ($item->status_staff_admin === 'diverifikasi' && $item->status_direktur === 'disetujui')
                                                <span class="badge badge-success">Disetujui</span>
                                            @elseif ($item->status_staff_admin === 'ditolak' || $item->status_direktur === 'ditolak')
                                                <span class="badge badge-danger">Ditolak</span>
                                            @else
                                                <span class="badge badge-warning">Menunggu</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">Belum ada riwayat pengajuan cuti</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
