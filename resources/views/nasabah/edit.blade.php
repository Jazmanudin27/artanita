@extends('layouts.template')
@section('titlepage', 'Form Edit Nasabah')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Edit Nasabah</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('updateNasabah') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Nasabah</label>
                                <input type="hidden" value="{{ $pengurus->id }}" name="id">
                                <input type="text" value="{{ $pengurus->nama_pengurus }}" name="nama_pengurus"
                                    class="form-control" placeholder="Nama Nasabah">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Alamat</label>
                                <input type="text" value="{{ $pengurus->alamat }}" name="alamat" class="form-control"
                                    placeholder="Alamat">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">No HP</label>
                                <input type="number" value="{{ $pengurus->no_hp }}" name="no_hp" class="form-control"
                                    placeholder="No HP">
                            </div>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
