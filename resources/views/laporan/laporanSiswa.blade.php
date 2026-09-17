@extends('layouts.template')
@section('titlepage', 'Laporan Data Siswa')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Laporan Data Siswa</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('cetakLaporanSiswa') }}" method="POST" autocomplete="off" target="_blank">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Kelas</label>
                                <select class="form-control select2" name="kode_kelas" id="kode_kelas">
                                    @php
                                        $kelas = DB::select('SELECT * FROM kelas ORDER BY nama_kelas ASC');
                                    @endphp
                                    <option value="">Semua Kelas</option>
                                    @foreach ($kelas as $p)
                                        <option value="{{ $p->kode_kelas }}">{{ $p->nama_kelas }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control" name="status" id="status" required>
                                    <option value="Aktif">Aktif</option>
                                    <option value="Lulus">Lulus</option>
                                    <option value="Keluar/Pindah">Keluar/Pindah</option>
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
