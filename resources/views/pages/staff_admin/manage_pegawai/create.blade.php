@extends('layouts.template')

@section('title', '- Form Pegawai')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form Tambah Pegawai</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <!-- Additional navigation or breadcrumbs can be added here -->
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <form class="form" action="{{ route('pegawai.store') }}" method="POST">
                        @csrf
                        <!-- Input Nama User -->
                        <div class="form-group row">
                            <label for="name" class="col-2 col-form-label">Nama</label>
                            <div class="col-10">
                                <input class="form-control" name="name" type="text" id="name" required>
                            </div>
                        </div>

                        <!-- Input Username -->
                        <div class="form-group row">
                            <label for="username" class="col-2 col-form-label">Username</label>
                            <div class="col-10">
                                <input class="form-control" name="username" type="text" id="username" required>
                            </div>
                        </div>

                        <!-- Input NIP -->
                        <div class="form-group row">
                            <label for="nip" class="col-2 col-form-label">NIP</label>
                            <div class="col-10">
                                <input class="form-control" name="nip" type="number" id="nip" required>
                            </div>
                        </div>

                        <!-- Pilih Jabatan -->
                        <div class="form-group row">
                            <label for="jabatan_id" class="col-2 col-form-label">Jabatan</label>
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
                            <label for="alamat" class="col-2 col-form-label">Alamat</label>
                            <div class="col-10">
                                <textarea class="form-control" name="alamat" id="alamat" rows="3" required></textarea>
                            </div>
                        </div>

                        <!-- Input Tahun Masuk -->
                        <div class="form-group row">
                            <label for="tahun_masuk" class="col-2 col-form-label">Tahun Masuk</label>
                            <div class="col-10">
                                <input class="form-control" name="tahun_masuk" type="date" id="tahun_masuk" required>
                            </div>
                        </div>

                        <!-- Pilih Status Pegawai -->
                        <div class="form-group row">
                            <label for="status_pegawai" class="col-2 col-form-label">Status Pegawai</label>
                            <div class="col-10">
                                <select class="form-control" name="status_pegawai" id="status_pegawai" required>
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
