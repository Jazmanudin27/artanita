@extends('layouts.template')
@section('titlepage', 'Data Peminjaman Buku')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Data Peminjaman Buku</h1>
        </div>
        <div class="row">
            <div class="col-12 col-xl-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('tambahPeminjaman') }}" class="btn btn-primary">Tambah Data</a>
                    </div>
                    <div class="card-header">
                        <div class="row">
                            <div class="col-sm-3">
                                <input type="seacrh" class="form-control" autocomplete="off" id="nama_siswa"
                                    placeholder="Nama Siswa">
                            </div>
                            <div class="col-md-3">
                                <select name="bulan" id="bulan" class="form-control select2">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option {{ Date('m') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}
                                            value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="tahun" id="tahun" class="form-control select2">
                                    @php
                                        $startYear = '2023';
                                        $endYear = $startYear + 4;
                                    @endphp

                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                        <option {{ Date('Y') == $year ? 'selected' : '' }} value="{{ $year }}">
                                            {{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                            <div class="col-md-3">
                                <select name="status" id="status" class="form-control select2">
                                    <option value="">Pilih Status</option>
                                    <option value="1">Belum Dikembalikan</option>
                                    <option value="2">Sudah Dikembalikan</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="zoom:85%">
                        <div class="table-reponsive">
                            <table class="table table-striped" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Siswa</th>
                                        <th>Judul</th>
                                        <th>Tanggal Pinjam</th>
                                        <th>Dikembalikan</th>
                                        <th>Status</th>
                                        <th style="text-align:right">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="showPeminjaman">

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPengembalian" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 style="text-align: center">PENGEMBALIAN BUKU</h5>
                    <form action="{{ route('pengembalianBuku') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Tanggal</label>
                            <input type="hidden" id="id" name="id" class="form-control" placeholder="ID">
                            <input type="hidden" id="kode_buku" name="kode_buku" class="form-control"
                                placeholder="Kode Buku">
                            <input type="hidden" id="stok" name="stok" class="form-control" placeholder="Stok">
                            <input type="text" value="{{ date('Y-m-d') }}" name="tgl_dikembalikan"
                                class="form-control datepicker" placeholder="Tanggal Dikembalikan">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalPerpanjang" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body">
                    <h5 style="text-align: center">PERPANJANG DURASI PINJAM BUKU</h5>
                    <form action="{{ route('perpanjangPeminjaman') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Sampai Tanggal</label>
                            <input type="hidden" id="id_peminjaman" name="id_peminjaman" class="form-control"
                                placeholder="ID">
                            <input type="text" value="{{ date('Y-m-d') }}" name="tgl_kembali"
                                class="form-control datepicker" placeholder="Sampai Tanggal">
                        </div>
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary btn-block">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            showPeminjaman();

            function showPeminjaman() {

                var nama_siswa = $('#nama_siswa').val();
                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();
                var status = $('#status').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showPeminjaman') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        nama_siswa: nama_siswa,
                        bulan: bulan,
                        tahun: tahun,
                        status: status,
                    },
                    success: function(data) {
                        $('#showPeminjaman').html(data);
                    },
                });
            }

            $('#bulan,#tahun,#status').on("change", function(e) {
                e.preventDefault();
                showPeminjaman();
            });

            $('#nama_siswa').on("input", function(e) {
                e.preventDefault();
                showPeminjaman();
            });

        });
    </script>

@endsection
