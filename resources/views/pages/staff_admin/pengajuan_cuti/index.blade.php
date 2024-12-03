@extends('layouts.template')

@section('title', '- Manage Pengajuan Cuti')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage Pengajuan Cuti</h4>
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
        </div>
        <!-- /row -->
        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <div class="table-responsive">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Pegawai</th>
                                    <th>Tanggal Pengajuan</th>
                                    <th>Lama Cuti</th>
                                    <th>Jenis Cuti</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($pengajuanCuti as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->pegawai->user->name }}</td>
                                        <td>{{ \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</td>
                                        <td>{{ $item->durasi }} hari</td>
                                        <td>{{ $item->jenisCuti->name_jenis_cuti }}</td>
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
                                        <td>
                                            <a class="ml-auto mr-auto" href="{{ route('pengajuan-cuti.show', $item->id) }}">
                                                <button class="btn btn-info ml-auto mr-auto">Detail</button>
                                            </a>
                                            {{-- <a class="ml-auto mr-auto" href="#">
                                                <button class="btn btn-warning ml-auto mr-auto">Verifikasi</button>
                                            </a> --}}

                                            {{-- @if ($item->status == 'verifikasi') --}}
                                            {{-- <form class="ml-auto mr-auto mt-3" method="POST" action="#">
                                                @csrf
                                                @method('DELETE')

                                                <button class="btn btn-danger ml-auto mr-auto">Delete</button>
                                            </form> --}}
                                            {{-- @endif --}}
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
