@extends('layouts.template')
@section('titlepage', 'Form Peminjaman Buku')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Peminjaman Buku</h1>
        <div class="row">
            <div class="col-xl-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('storePeminjaman') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6">
                                    <div class="mb-3">
                                        <label class="form-label">Nama Siswa</label>
                                        <select class="form-control select2" name="kode_siswa" id="kode_siswa" required>
                                            @php
                                                $kode_member = Auth::user()->kode_member;
                                                $siswa = DB::select("SELECT * FROM siswa WHERE kode_member = '$kode_member' ");
                                            @endphp
                                            <option value="">Pilih Siswa</option>
                                            @foreach ($siswa as $s)
                                                <option value="{{ $s->kode_siswa }}">{{ $s->nama_siswa }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Pinjam</label>
                                        <input type="text" value="{{ date('Y-m-d') }}" name="tanggal"
                                            class="form-control datepicker" placeholder="Tanggal Pinjam">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal Kembali</label>
                                        <input type="text" value="{{ date('Y-m-d') }}" name="tgl_kembali"
                                            class="form-control datepicker" placeholder="Tanggal Kembali">
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label class="form-label">Judul Buku</label>
                                        <input type="hidden" id="kode_buku" name="kode_buku" class="form-control"
                                            placeholder="Kode Buku" required>
                                        <input type="text" id="judul" class="form-control" placeholder="Judul"
                                            required>
                                    </div>
                                </div>
                                <div class="col-xl-3">
                                    <div class="mb-3">
                                        <label class="form-label">Pengarang</label>
                                        <input type="text" id="pengarang" readonly class="form-control"
                                            placeholder="Pengarang">
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="mb-3">
                                        <label class="form-label">Penerbit</label>
                                        <input type="text" id="penerbit" readonly class="form-control"
                                            placeholder="Penerbit">
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="mb-3">
                                        <label class="form-label">Tahun Terbit</label>
                                        <input type="text" id="tahun_terbit" readonly class="form-control"
                                            placeholder="Tahun Terbit">
                                    </div>
                                </div>
                                <div class="col-xl-2">
                                    <div class="mb-3">
                                        <label class="form-label">Stok</label>
                                        <input type="number" id="stok" name="stok" readonly class="form-control"
                                            placeholder=" Stok">
                                    </div>
                                </div>
                                <div class="col-xl-8">
                                    <div class="mb-3">
                                    </div>
                                </div>
                                <div class="col-xl-4">
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalBuku" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog  modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body m-1">
                    <h4 style="text-align: center">DATA BUKU</h4>
                    <div class="table-reponsive">
                        <table class="table table-striped datatables">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Judul</th>
                                    <th>Pengarang</th>
                                    <th>Penerbit</th>
                                    <th>Stok</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($buku as $s)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $s->judul }}</td>
                                        <td>{{ $s->pengarang }}</td>
                                        <td>{{ $s->penerbit }}</td>
                                        <td>{{ $s->sisa_stok }}</td>
                                        <td>
                                            <a href="#" data-kode="{{ $s->kode_buku }}"
                                                data-stok="{{ $s->sisa_stok }}" data-judul="{{ $s->judul }}"
                                                data-penerbit="{{ $s->penerbit }}" data-tahun="{{ $s->tahun_terbit }}"
                                                data-pengarang="{{ $s->pengarang }}"
                                                class="btn btn-sm btn-primary pilihBuku"><i class="fa fa-check"></i></a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#judul').on("click", function(e) {
                e.preventDefault();
                $('#modalBuku').modal("show");

            });

            $('.pilihBuku').on("click", function(e) {
                e.preventDefault();
                var kode = $(this).attr('data-kode');
                var stok = $(this).attr('data-stok');
                var judul = $(this).attr('data-judul');
                var pengarang = $(this).attr('data-pengarang');
                var penerbit = $(this).attr('data-penerbit');
                var tahunterbit = $(this).attr('data-tahun');
                if (stok <= 0) {
                    Swal.fire(
                        'Opps..',
                        'Stok Buku Tidak Ada',
                        'warning'
                    )
                    $('#kode_buku').val("");
                    $('#stok').val("");
                    $('#judul').val("");
                    $('#pengarang').val("");
                    $('#penerbit').val("");
                    $('#tahun_terbit').val("");
                }
                $('#kode_buku').val(kode);
                $('#stok').val(stok);
                $('#judul').val(judul);
                $('#pengarang').val(pengarang);
                $('#penerbit').val(penerbit);
                $('#tahun_terbit').val(tahunterbit);
                $('#modalBuku').modal("hide");
            });

        });
    </script>
@endsection
