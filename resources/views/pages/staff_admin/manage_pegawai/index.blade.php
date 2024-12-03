@extends('layouts.template')

@section('title', '- Manage Pegawai')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage Pegawai</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                @if (Session::has('success'))
                    <div class="alert alert-success alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('success') }}
                    </div>
                @endif
                @if (Session::has('failed'))
                    <div class="alert alert-danger alert-dismissable">
                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                        {{ Session::get('failed') }}
                    </div>
                @endif
            </div>
            <!-- /.col-lg-12 -->
            <div class="col-md-12">
                <a href="{{ route('pegawai.create') }}">
                    <button class="btn btn-primary btn-block">Tambah</button>
                </a>
            </div>
        </div>
        <!-- /row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th style="width: 5%">No</th>
                                    <th style="width: 15%">NIP</th>
                                    <th style="width: 25%">Nama</th>
                                    <th style="width: 15%">Jabatan</th>
                                    <th style="width: 10">Status Pegawai</th>
                                    <th style="width: 20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($pegawai as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->jabatan->name_jabatan }}</td>
                                        <td>
                                            @if ($item->status_pegawai === 'aktif')
                                                <span class="badge badge-success">Aktif</span>
                                            @else
                                                <span class="badge badge-danger">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('pegawai.show', $item->id) }}">
                                                <button class="btn btn-info">Detail</button>
                                            </a>
                                            <a href="{{ route('pegawai.edit', $item->id) }}">
                                                <button class="btn btn-warning">Edit</button>
                                            </a>
                                            <form class="d-inline" method="POST"
                                                action="{{ route('pegawai.destroy', $item->id) }}"
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger">Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php $no++; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- /.row -->
@endsection
