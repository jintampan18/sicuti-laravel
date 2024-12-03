@extends('layouts.template')

@section('title', '- Form Konfig Cuti')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form Edit Konfig Cuti</h4>
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
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <form class="form" action="{{ route('konfig_cuti.update', $konfigCuti->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="tahun" class="col-2 col-form-label">Tahun</label>
                            <div class="col-10">
                                <select class="form-control" name="tahun" id="tahun" required>
                                    <option value="" disabled selected>Pilih Tahun</option>
                                    @for ($year = date('Y'); $year <= date('Y') + 5; $year++)
                                        <option value="{{ $year }}"
                                            {{ $konfigCuti->tahun == $year ? 'selected' : '' }}>
                                            {{ $year }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jumlah_cuti" class="col-2 col-form-label">Jumlah Cuti</label>
                            <div class="col-10">
                                <input class="form-control" name="jumlah_cuti" type="number" id="jumlah_cuti"
                                    value="{{ old('jumlah_cuti', $konfigCuti->jumlah_cuti) }}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12">
                                <button class="btn btn-primary btn-block" type="submit">Buat</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
