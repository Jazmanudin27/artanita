@extends('layouts.template')
@section('titlepage', 'Laporan Surat Absen')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Laporan Surat Absen</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('cetakLaporanSuratAbsen') }}" method="POST" autocomplete="off" target="_blank">
                            @csrf
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-6">
                                        <label class="form-label">Bulan</label>
                                        <select name="bulan" id="bulan" class="form-control select2">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option
                                                    {{ Date('m') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}
                                                    value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label">Tahun</label>
                                        <select name="tahun" id="tahun" class="form-control select2">
                                            @php
                                                $startYear = '2023';
                                                $endYear = $startYear + 4;
                                            @endphp

                                            @for ($year = $startYear; $year <= $endYear; $year++)
                                                <option {{ Date('Y') == $year ? 'selected' : '' }}
                                                    value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
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
