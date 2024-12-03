@extends('layouts.template')

@section('title', '- Edit Pegawai')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form Edit Pegawai</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <!-- Additional navigation or breadcrumbs can be added here -->
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <form class="form" action="{{ route('pegawai.update', $pegawai->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Input Nama User -->
                        <div class="form-group row">
                            <label for="name" class="col-2 col-form-label">Nama</label>
                            <div class="col-10">
                                <input class="form-control" name="name" type="text" id="name"
                                    value="{{ $pegawai->user->name }}" required>
                            </div>
                        </div>

                        <!-- Input Username -->
                        <div class="form-group row">
                            <label for="username" class="col-2 col-form-label">Username</label>
                            <div class="col-10">
                                <input class="form-control" name="username" type="text" id="username"
                                    value="{{ $pegawai->user->username }}" required>
                            </div>
                        </div>

                        <!-- Input NIP -->
                        <div class="form-group row">
                            <label for="nip" class="col-2 col-form-label">NIP</label>
                            <div class="col-10">
                                <input class="form-control" name="nip" type="number" id="nip"
                                    value="{{ $pegawai->nip }}" required>
                            </div>
                        </div>

                        <!-- Pilih Jabatan -->
                        <div class="form-group row">
                            <label for="jabatan_id" class="col-2 col-form-label">Jabatan</label>
                            <div class="col-10">
                                <select class="form-control" name="jabatan_id" id="jabatan_id" required>
                                    <option value="" disabled>Pilih Jabatan</option>
                                    @foreach ($jabatan as $jab)
                                        <option value="{{ $jab->id }}"
                                            {{ $jab->id == $pegawai->jabatan_id ? 'selected' : '' }}>
                                            {{ $jab->name_jabatan }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Input Alamat -->
                        <div class="form-group row">
                            <label for="alamat" class="col-2 col-form-label">Alamat</label>
                            <div class="col-10">
                                <textarea class="form-control" name="alamat" id="alamat" rows="3" required>{{ $pegawai->alamat }}</textarea>
                            </div>
                        </div>

                        <!-- Input Tahun Masuk -->
                        <div class="form-group row">
                            <label for="tahun_masuk" class="col-2 col-form-label">Tahun Masuk</label>
                            <div class="col-10">
                                <input class="form-control" name="tahun_masuk" type="date" id="tahun_masuk"
                                    value="{{ $pegawai->tahun_masuk }}" required>
                            </div>
                        </div>

                        <!-- Input Sisa Cuti -->
                        <div class="form-group row">
                            <label for="sisa_cuti" class="col-2 col-form-label">Sisa Cuti</label>
                            <div class="col-10">
                                <input class="form-control" name="sisa_cuti" type="number" id="sisa_cuti"
                                    value="{{ $pegawai->sisa_cuti }}" required>
                            </div>
                        </div>

                        <!-- Pilih Status Pegawai -->
                        <div class="form-group row">
                            <label for="status_pegawai" class="col-2 col-form-label">Status Pegawai</label>
                            <div class="col-10">
                                <select class="form-control" name="status_pegawai" id="status_pegawai" required>
                                    <option value="aktif" {{ $pegawai->status_pegawai == 'aktif' ? 'selected' : '' }}>
                                        Aktif
                                    </option>
                                    <option value="nonaktif"
                                        {{ $pegawai->status_pegawai == 'nonaktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-block" type="submit">Update</button>
                            </div>
                        </div>
                    </form>

                    <!-- Reset Password Button -->
                    <form action="{{ route('pegawai.resetPassword', $pegawai->id) }}" method="POST" class="mt-4">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-block">Reset Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
