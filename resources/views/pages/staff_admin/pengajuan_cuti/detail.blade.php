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
                        <a href="{{ route('pengajuan-cuti.index') }}" class="btn btn-info">Kembali</a>
                    </div>
                    <hr>

                    <!-- Informasi Pengajuan -->
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Nama:</strong> {{ $pengajuanCuti->pegawai->user->name }}</p>
                            <p><strong>Jenis Cuti:</strong> {{ $pengajuanCuti->jenisCuti->name_jenis_cuti }}</p>
                            <p><strong>Tanggal Pengajuan:</strong>
                                {{ \Carbon\Carbon::parse($pengajuanCuti->tanggal_mulai)->translatedFormat('d F Y') }} -
                                {{ \Carbon\Carbon::parse($pengajuanCuti->tanggal_selesai)->translatedFormat('d F Y') }}
                            </p>
                            <p><strong>Durasi:</strong> {{ $pengajuanCuti->durasi }} hari</p>
                        </div>

                        <div class="col-md-6">
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

                    <hr>

                    <!-- Tombol Aksi -->
                    <div class="row">
                        <div class="col-md-12">
                            <form action="{{ route('pengajuan-cuti.verifikasi', $pengajuanCuti->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-success">Verifikasi</button>
                            </form>

                            <!-- Tombol Revisi -->
                            <button class="btn btn-warning" data-bs-toggle="modal"
                                data-bs-target="#modalRevisi">Revisi</button>

                            <!-- Tombol Tolak -->
                            <form action="{{ route('pengajuan-cuti.tolak', $pengajuanCuti->id) }}" method="POST"
                                class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button class="btn btn-danger">Tolak</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Revisi -->
    <div class="modal fade" id="modalRevisi" tabindex="-1" aria-labelledby="modalRevisiLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form action="{{ route('pengajuan-cuti.revisi', $pengajuanCuti->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalRevisiLabel">Revisi Pengajuan</h5>
                        {{-- <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button> --}}
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="catatan_staff_admin">Catatan Revisi</label>
                            <textarea name="catatan_staff_admin" id="catatan_staff_admin" class="form-control" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-warning">Kirim Revisi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
