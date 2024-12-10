@extends('layouts.template')

@section('title', '- Form Jenis Cuti')

@section('konten')
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form</h4>
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="white-box">
                    <form class="form" action="{{ route('jenis_cuti.update', $jenisCuti->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group row">
                            <label for="example-text-input" class="col-2 col-form-label">Nama Jenis Cuti<span
                                    style="color: red;">*</span></label>
                            <div class="col-10">
                                <input class="form-control" name="name_jenis_cuti" type="text" id="example-text-input"
                                    value="{{ $jenisCuti->name_jenis_cuti }}" required>
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
