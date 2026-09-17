@extends('layouts.template')
@section('titlepage', 'Form Edit Absensi')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Edit Absensi</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('updateAbsensiSiswa') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Siswa</label>
                                <input type="hidden" value="{{ $absensi->id }}" name="id" class="form-control"
                                    placeholder="Kode Buku">
                                <select class="form-control select2" id="kode_siswa" name="kode_siswa">
                                    @php
                                        $data = DB::table('siswa')
                                            ->where('kode_member', Auth::user()->kode_member)
                                            ->get();
                                    @endphp
                                    <option value="">Semua Kelas</option>
                                    @foreach ($data as $d)
                                        <option {{ $d->kode_siswa == $absensi->kode_siswa ? 'selected' : '' }}
                                            value="{{ $d->kode_siswa }}">{{ $d->nama_siswa }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="text" value="{{ $absensi->tanggal }}" name="tanggal"
                                    class="form-control datepicker" placeholder="Tanggal" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Status</label>
                                <select class="form-control select2" id="status" name="status">
                                    <option value="">Pilih Status</option>
                                    <option {{ $absensi->status == 'A' ? 'selected' : '' }} value="A">Alfa</option>
                                    <option {{ $absensi->status == 'I' ? 'selected' : '' }} value="I">Izin</option>
                                    <option {{ $absensi->status == 'S' ? 'selected' : '' }} value="S">Sakit</option>
                                </select>
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
