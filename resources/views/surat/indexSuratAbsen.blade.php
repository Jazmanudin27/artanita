@extends('layouts.template')
@section('titlepage', 'Data Surat Absen')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Data Surat Absen</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('tambahSuratAbsen') }}" class="btn btn-primary">Tambah Data</a>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="mb-3">
                                <div class="row">
                                    <div class="col-md-3">
                                        <select name="bulan" id="bulan" class="form-control select2">
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option
                                                    {{ Date('m') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}
                                                    value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                    {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <select name="tahun" id="tahun" class="form-control select2">
                                            @php
                                                $startYear = date('Y') - 1;
                                                $endYear = date('Y') + 4;
                                            @endphp

                                            @for ($year = $startYear; $year <= $endYear; $year++)
                                                <option {{ Date('Y') == $year ? 'selected' : '' }}
                                                    value="{{ $year }}">{{ $year }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-3">
                                        <input type="seacrh" class="form-control" autocomplete="off" id="nama_guru"
                                            placeholder="Nama Guru">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body">
                        <div class="table-reponsive">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Tanggal</th>
                                        <th>Nama Guru</th>
                                        <th>Jenis Absen</th>
                                        <th>Deskripsi</th>
                                        <th style="width: 100px">Status</th>
                                    </tr>
                                </thead>
                                <tbody id="showSuratAbsen">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {

            showSuratAbsen();

            function showSuratAbsen() {

                var nama_guru = $('#nama_guru').val();
                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showSuratAbsen') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama_guru: nama_guru,
                        bulan: bulan,
                        tahun: tahun,
                    },
                    success: function(data) {
                        $('#showSuratAbsen').html(data);
                    },
                });
            }

            $('#bulan,#tahun').on("change", function(e) {
                e.preventDefault();
                showSuratAbsen();
            });

            $('#nama_guru').on("input", function(e) {
                e.preventDefault();
                showSuratAbsen();
            });

        });
    </script>

@endsection
