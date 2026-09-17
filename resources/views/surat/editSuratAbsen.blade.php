@extends('layouts.template')
@section('titlepage', 'Form Surat Absen')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Surat Absen</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('updateSuratAbsen') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="hidden" value="{{ $surat_absen->id }}" name="id" class="form-control"
                                    placeholder="ID">
                                <input type="text" name="tanggal" value="{{ $surat_absen->tanggal }}"
                                    class="form-control datepicker" placeholder="Tanggal" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Nama Guru</label>
                                <select class="form-control select2" name="kode_guru" id="kode_guru">
                                    @php
                                        $kode_member = Auth::user()->kode_member;
                                        $guru = DB::select("SELECT * FROM guru WHERE kode_member = '$kode_member' ");
                                    @endphp
                                    <option value="">Pilih Guru</option>
                                    @foreach ($guru as $k)
                                        <option {{ $surat_absen->kode_guru == $k->kode_guru ? 'selected' : '' }}
                                            value="{{ $k->kode_guru }}">{{ $k->nama_guru }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Surat</label>
                                <select class="form-control select2" name="jenis_absen" id="jenis_absen" required>
                                    <option value="">Pilih Jenis Absen</option>
                                    <option {{ $surat_absen->jenis_absen == 'I' ? 'selected' : '' }} value="I">Izin
                                    </option>
                                    <option {{ $surat_absen->jenis_absen == 'S' ? 'selected' : '' }} value="S">Sakit
                                    </option>
                                    <option {{ $surat_absen->jenis_absen == 'C' ? 'selected' : '' }} value="C">Cuti
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea required class="form-control" rows="7" id="deskripsi" name="deskripsi">{{ $surat_absen->deskripsi }}</textarea>
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
