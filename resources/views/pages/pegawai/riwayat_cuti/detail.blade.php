@extends('layouts.template')

@section('title', '- Detail Pengajuan Cuti')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Detail Pengajuan Cuti</h4>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <a href="{{ route('pegawai.riwayat-cuti') }}" class="btn btn-info">Kembali</a>
                    </div>
                    <hr>

                    <!-- Informasi Pengajuan -->
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Status Cuti :</strong>
                                @if ($pengajuanCuti->status_staff_admin === 'diverifikasi' && $pengajuanCuti->status_direktur === 'proses')
                                    <span class="badge badge-info">Menunggu Direktur</span>
                                @elseif ($pengajuanCuti->status_staff_admin === 'direvisi' && $pengajuanCuti->status_direktur === 'proses')
                                    <span class="badge" style="background-color: #cd476b; color: white;">Direvisi</span>
                                @elseif ($pengajuanCuti->status_staff_admin === 'diverifikasi' && $pengajuanCuti->status_direktur === 'disetujui')
                                    <span class="badge
                                    badge-success">Disetujui</span>
                                @elseif ($pengajuanCuti->status_staff_admin === 'ditolak' || $pengajuanCuti->status_direktur === 'ditolak')
                                    <span class="badge badge-danger">Ditolak</span>
                                @else
                                    <span class="badge badge-warning">Menunggu</span>
                                @endif
                            </p>
                            <p><strong>Jenis Cuti :</strong> {{ $pengajuanCuti->jenisCuti->name_jenis_cuti }}</p>
                            <p><strong>Mulai Cuti :</strong>
                                {{ \Carbon\Carbon::parse($pengajuanCuti->tanggal_mulai)->translatedFormat('d F Y') }} -
                                {{ \Carbon\Carbon::parse($pengajuanCuti->tanggal_selesai)->translatedFormat('d F Y') }}
                            </p>
                            <p><strong>Durasi :</strong> {{ $pengajuanCuti->durasi }} hari</p>
                        </div>

                        <div class="col-md-6">
                            @if ($pengajuanCuti->status_staff_admin === 'direvisi')
                                <h4>Catatan Revisi</h4>
                                <p>{{ $pengajuanCuti->catatan_staff_admin }}</p>
                            @endif

                            <h4>Alasan Cuti</h4>
                            <p>{{ $pengajuanCuti->alasan }}</p>

                            <h4>Dokumen Pendukung</h4>
                            @php
                                $dokumenPendukung = json_decode($pengajuanCuti->dokumen_pendukung, true);
                            @endphp

                            @if ($dokumenPendukung && count($dokumenPendukung) > 0)
                                <ul>
                                    @foreach ($dokumenPendukung as $dokumen)
                                        <li>
                                            <a href="{{ asset('storage/' . $dokumen) }}" target="_blank">Lihat Dokumen</a>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p>Tidak ada dokumen pendukung</p>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
