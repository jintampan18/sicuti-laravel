@extends('layouts.template')

@section('title', 'Detail Rekap Pengajuan Cuti Pegawai')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-12">
                <h4 class="page-title">Detail Rekap Pengajuan Cuti - {{ $pegawai->user->name }}</h4>
            </div>
        </div>

        <!-- Informasi Pegawai -->
        <div class="row">
            <div class="col-lg-12 col-md-6">
                <div class="white-box">
                    <p><strong>Nama:</strong> {{ $pegawai->user->name }}</p>
                    <p><strong>NIP:</strong> {{ $pegawai->nip }}</p>
                    <p><strong>Jabatan:</strong> {{ $pegawai->jabatan->name_jabatan }}</p>
                    <p><strong>Sisa Cuti:</strong> {{ $sisaCuti }} hari</p>
                </div>
            </div>
        </div>

        <!-- Tabel Rekap Cuti -->
        <div class="row">
            <div class="col-lg-12">
                <div class="white-box">
                    <h4 class="box-title">Detail Rekap Pengajuan Cuti</h4>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Jenis Cuti</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Lama Cuti</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($pengajuanCuti as $index => $cuti)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $cuti->jenisCuti->name_jenis_cuti }}</td>
                                        <td>{{ \Carbon\Carbon::parse($cuti->created_at)->translatedFormat('d F Y') }}</td>
                                        <td>{{ $cuti->durasi }} hari</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-center">Belum ada data pengajuan cuti</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <a href="{{ route('rekap-cuti') }}" class="btn btn-secondary">Kembali</a>
                </div>
            </div>
        </div>
    </div>
@endsection
