@extends('layouts.template')
@section('titlepage', 'Form Surat Dispensasi')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Surat Dispensasi</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('updateSuratDispensasi') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="hidden" value="{{ $surat_dispensasi->id }}" name="id"
                                    class="form-control" placeholder="ID">
                                <input type="text" name="tanggal" value="{{ $surat_dispensasi->tanggal }}"
                                    class="form-control datepicker" placeholder="Tanggal" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Siswa</label>
                                <select class="form-control select2" name="kode_siswa" id="kode_siswa">
                                    @php
                                        $kode_member = Auth::user()->kode_member;
                                        $siswa = DB::select("SELECT * FROM siswa WHERE kode_member = '$kode_member' ORDER BY nama_siswa ASC");
                                    @endphp
                                    <option value="">Pilih Siswa</option>
                                    @foreach ($siswa as $k)
                                        <option {{ $surat_dispensasi->kode_siswa == $k->kode_siswa ? 'selected' : '' }}
                                            value="{{ $k->kode_siswa }}">{{ $k->nama_siswa }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea required class="form-control" rows="7" id="deskripsi" name="deskripsi">{{ $surat_dispensasi->deskripsi }}</textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
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
