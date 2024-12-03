@extends('layouts.template')

@section('title', '- Detail Pegawai')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Detail Pegawai</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <!-- Additional navigation or breadcrumbs can be added here -->
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <!-- Display Pegawai Data -->
                    <div class="form-group row">
                        <label class="col-2 col-form-label">Nama</label>
                        <div class="col-10">
                            <p class="form-control-plaintext">{{ $pegawai->user->name }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Username</label>
                        <div class="col-10">
                            <p class="form-control-plaintext">{{ $pegawai->user->username }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">NIP</label>
                        <div class="col-10">
                            <p class="form-control-plaintext">{{ $pegawai->nip }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Jabatan</label>
                        <div class="col-10">
                            <p class="form-control-plaintext">{{ $pegawai->jabatan->name_jabatan }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Alamat</label>
                        <div class="col-10">
                            <p class="form-control-plaintext">{{ $pegawai->alamat }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Tahun Masuk</label>
                        <div class="col-10">
                            <p class="form-control-plaintext">{{ $pegawai->tahun_masuk }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Sisa Cuti</label>
                        <div class="col-10">
                            <p class="form-control-plaintext">{{ $pegawai->sisa_cuti }}</p>
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-2 col-form-label">Status Pegawai</label>
                        <div class="col-10">
                            <p class="form-control-plaintext">{{ $pegawai->status_pegawai }}</p>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="form-group row">
                        <div class="col-md-12">
                            <a href="{{ route('pegawai.index') }}" class="btn btn-primary btn-block">Kembali ke Daftar
                                Pegawai</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
