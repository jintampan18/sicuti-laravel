@extends('layouts.template')

@section('title', '- Form Pegawai')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form Tambah Pegawai</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <div>{{ $error }}</div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <form class="form" action="{{ route('pegawai.store') }}" method="POST">
                        @csrf
                        <!-- Input Nama User -->
                        <div class="form-group row">
                            <label for="name" class="col-2 col-form-label">Nama<span
                                    style="color: red;">*</span></label>
                            <div class="col-10">
                                <input class="form-control" name="name" type="text" id="name"
                                    placeholder="Masukkan nama pegawai" required>
                            </div>
                        </div>

                        <!-- Input Username -->
                        <div class="form-group row">
                            <label for="username" class="col-2 col-form-label">Username<span
                                    style="color: red;">*</span></label>
                            <div class="col-10">
                                <input class="form-control" name="username" type="text" id="username"
                                    placeholder="Masukkan username pegawai" required>
                            </div>
                        </div>

                        <!-- Input NIP -->
                        <div class="form-group row">
                            <label for="nip" class="col-2 col-form-label">NIP<span style="color: red;">*</span></label>
                            <div class="col-10">
                                <input class="form-control" name="nip" type="number" id="nip"
                                    placeholder="Masukkan NIP pegawai" required>
                            </div>
                        </div>

                        <!-- Pilih Jabatan -->
                        <div class="form-group row">
                            <label for="jabatan_id" class="col-2 col-form-label">Jabatan<span
                                    style="color: red;">*</span></label>
                            <div class="col-10">
                                <select class="form-control" name="jabatan_id" id="jabatan_id" required>
                                    <option value="" disabled selected>Pilih Jabatan</option>
                                    @foreach ($jabatan as $jab)
                                        <option value="{{ $jab->id }}">{{ $jab->name_jabatan }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Input Alamat -->
                        <div class="form-group row">
                            <label for="alamat" class="col-2 col-form-label">Alamat<span
                                    style="color: red;">*</span></label>
                            <div class="col-10">
                                <textarea class="form-control" name="alamat" id="alamat" rows="3"
                                    placeholder="Masukkan alamat lengkap pegawai" required></textarea>
                            </div>
                        </div>

                        <!-- Input Tahun Masuk -->
                        <div class="form-group row">
                            <label for="tahun_masuk" class="col-2 col-form-label">Tahun Masuk<span
                                    style="color: red;">*</span></label>
                            <div class="col-10">
                                <input class="form-control" name="tahun_masuk" type="date" id="tahun_masuk" required>
                            </div>
                        </div>

                        <!-- Pilih Status Pegawai -->
                        <div class="form-group row">
                            <label for="status_pegawai" class="col-2 col-form-label">Status Pegawai<span
                                    style="color: red;">*</span></label>
                            <div class="col-10">
                                <select class="form-control" name="status_pegawai" id="status_pegawai" required>
                                    <option value="">Pilih Status Pegawai</option>
                                    <option value="aktif">Aktif</option>
                                    <option value="nonaktif">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-block" type="submit">Simpan</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
