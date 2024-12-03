@extends('layouts.template')

@section('title', '- Manage Konfig Cuti')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Manage Konfig Cuti</h4>
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
                <a href="{{ route('konfig_cuti.create') }}">
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
                                    <th style="width: 50%">Tahun</th>
                                    <th style="width: 20%">Jumlah Cuti</th>
                                    <th style="width: 25%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($konfigCuti as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->tahun }}</td>
                                        <td>{{ $item->jumlah_cuti }}</td>
                                        <th>
                                            <a class="ml-auto mr-auto" href="{{ route('konfig_cuti.edit', $item->id) }}">
                                                <button class="btn btn-warning ml-auto mr-auto">Edit</button>
                                            </a>
                                            <form class="d-inline ml-auto mr-auto mt-3" method="POST" action=""
                                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger ml-auto mr-auto">Delete</button>
                                            </form>
                                        </th>
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
