@extends('layouts.template')
@section('titlepage', 'Laporan Presensi Guru')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Laporan Presensi Guru</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('cetakLaporanPresensi') }}" method="POST" autocomplete="off" target="_blank">
                            @csrf
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Bulan</label>
                                        <input type="date" name="start_date" id="start_date"  class="form-control" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tahun</label>
                                        <input type="date" name="end_date" id="end_date"  class="form-control" required>
                                    </div>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Jenis Laporan</label>
                                <select class="form-control select2" name="jenis_laporan" id="jenis_laporan" required>
                                    <option value="">Jenis Laporan</option>
                                    <option value="Standar">Standar</option>
                                    <option value="Detail">Detail</option>
                                    <option value="Rekap">Rekap</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <button type="submit" name="cetak" class="btn btn-primary btn-block">
                                            <i class="fa fa-print mr-2"></i>
                                            CETAK
                                        </button>
                                    </div>
                                    <div class="col-md-6">
                                        <button type="submit" name="export" class="btn btn-success btn-block">
                                            <i class="fa fa-download mr-2"></i>
                                            <span>EXCEL</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

        });
    </script>
@endsection
