@extends('layouts.template')
@section('titlepage', 'Laporan Data Guru')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Laporan Data Guru</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('cetakLaporanGuru') }}" method="POST" autocomplete="off" target="_blank">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Guru</label>
                                <select class="form-control select2" name="kode_guru" id="kode_guru">
                                    @php
                                        $guru = DB::select('SELECT * FROM guru ORDER BY nama_guru ASC');
                                    @endphp
                                    <option value="">Semua Guru</option>
                                    @foreach ($guru as $p)
                                        <option value="{{ $p->kode_guru }}">{{ $p->nama_guru }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" id="status">
                                    <option value="Aktif">Aktif</option>
                                    <option value="Non Aktif">Non Aktif</option>
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
