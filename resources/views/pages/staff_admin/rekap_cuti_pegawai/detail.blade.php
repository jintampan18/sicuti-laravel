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
                    <a href="{{ route('rekap-cuti') }}" class="btn btn-danger mb-3">Kembali</a>

                    <style>
                        .table-custom {
                            width: 100%;
                        }

                        .table-custom td {
                            padding: 10px 0px;
                        }
                    </style>

                    <table class="table-custom">
                        <tr>
                            <td style="width: 130px;"> <strong>Nama</strong> </td>
                            <td style="width: 10px;"> <strong>:</strong> </td>
                            <td> {{ $pegawai->user->name }} </td>
                        </tr>
                        <tr>
                            <td> <strong>NIP</strong> </td>
                            <td> <strong>:</strong> </td>
                            <td> {{ $pegawai->nip }} </td>
                        </tr>
                        <tr>
                            <td> <strong>Jabatan</strong> </td>
                            <td> <strong>:</strong> </td>
                            <td> {{ $pegawai->jabatan->name_jabatan }} </td>
                        </tr>
                        <tr>
                            <td> <strong>Tahun Masuk</strong> </td>
                            <td> <strong>:</strong> </td>
                            <td> {{ \Carbon\Carbon::parse($pegawai->tahun_masuk)->translatedFormat('d F Y') }} </td>
                        </tr>
                        <tr>
                            <td> <strong>Sisa Cuti</strong> </td>
                            <td> <strong>:</strong> </td>
                            <td> {{ $sisaCuti }} </td>
                        </tr>
                    </table>
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
                </div>
            </div>
        </div>
    </div>
@endsection
