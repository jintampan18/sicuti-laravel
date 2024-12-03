@extends('layouts.template')

@section('title', '- Rekap Pengajuan Cuti')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Data Rekap Pengajuan Cuti Pegawai</h4>
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

        <!-- Filter Tahun -->
        <div class="row mb-3">
            <div class="col-sm-12">
                <form method="get" action="{{ route('rekap-cuti') }}">
                    <label for="tahun">Pilih Tahun:</label>
                    <select name="tahun" id="tahun" class="form-control" onchange="this.form.submit()">
                        @foreach ($tahunOptions as $tahunOption)
                            <option value="{{ $tahunOption }}" {{ $tahun == $tahunOption ? 'selected' : '' }}>
                                {{ $tahunOption }}
                            </option>
                        @endforeach
                    </select>
                </form>
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
                                    <th>NIP</th>
                                    <th>Nama Pegawai</th>
                                    <th>Jabatan</th>
                                    <th>Cuti Terpakai</th>
                                    <th>Sisa Cuti</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $no = 1; ?>
                                @foreach ($rekapCuti as $item)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $item->nip }}</td>
                                        <td>{{ $item->user->name }}</td>
                                        <td>{{ $item->jabatan->name_jabatan }}</td>
                                        <td>{{ $item->cuti_terpakai }}</td>
                                        <td>{{ $item->sisa_cuti }}</td>
                                        {{-- <td>
                                            <a class="ml-auto mr-auto" href="{{ route('rekap-cuti.detail', $item->id) }}">
                                                <button class="btn btn-info ml-auto mr-auto">Detail</button>
                                            </a>
                                        </td> --}}
                                        <td>
                                            <a class="ml-auto mr-auto"
                                                href="{{ route('rekap-cuti.detail', ['id' => $item->id, 'tahun' => request('tahun', date('Y'))]) }}">
                                                <button class="btn btn-info ml-auto mr-auto">Detail</button>
                                            </a>
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
