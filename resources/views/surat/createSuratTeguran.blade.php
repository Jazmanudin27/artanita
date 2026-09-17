@extends('layouts.template')
@section('titlepage', 'Form Surat Teguran')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Surat Teguran</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('storeSuratTeguran') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-xl-12">
                                    <div class="mb-3">
                                        <label class="form-label">Tanggal</label>
                                        <input type="text" name="tanggal" value="{{ Date('Y-m-d') }}"
                                            class="form-control datepicker" placeholder="Tanggal" required>
                                    </div>
                                </div>
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
                                        <option value="{{ $k->kode_siswa }}">{{ $k->nama_siswa }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Deskripsi</label>
                                <textarea required class="form-control" rows="7" id="deskripsi" name="deskripsi"></textarea>
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
