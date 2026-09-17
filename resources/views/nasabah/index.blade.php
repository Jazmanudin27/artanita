@extends('layouts.template')
@section('titlepage', 'Data Nasabah')
@section('content')
    <div class="container-fluid p-0">
        <div class="mb-3">
            <h1 class="h3 d-inline align-middle">Data Nasabah</h1>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('tambahNasabah') }}" class="btn btn-primary">Tambah Data</a>
                    </div>
                    <div class="card-body">
                        <div class="table-reponsive">
                            <table class="table table-striped datatables" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Nama Nasabah</th>
                                        <th>Alamat</th>
                                        <th>No HP</th>
                                        <th>Status</th>
                                        <th style="width: 100px">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengurus as $p)
                                        <tr>
                                            <td>{{ $p->nama_pengurus }}</td>
                                            <td>{{ $p->alamat }}</td>
                                            <td>{{ $p->no_hp }}</td>
                                            <td>
                                                @if ($p->status == 'Aktif')
                                                    <a class="btn btn-success btn-sm">{{ $p->status }}</a>
                                                @else
                                                    <a class="btn btn-danger btn-sm">{{ $p->status }}</a>
                                                @endif
                                            </td>
                                            <td>
                                                <a data-href="{{ route('deleteNasabah', $p->id) }}"
                                                    class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>
                                                <a href="{{ route('editNasabah', $p->id) }}"
                                                    class="btn btn-sm
                                                    btn-warning"><i
                                                        class="fa fa-edit"></i></a>
                                                @if ($p->status == 'Aktif')
                                                    <a href="{{ route('inactiveNasabah', $p->id) }}"
                                                        class="btn btn-sm btn-danger"><i class="fa fa-thumbs-down"></i></a>
                                                @else
                                                    <a href="{{ route('activeNasabah', $p->id) }}"
                                                        class="btn btn-sm btn-success"><i class="fa fa-thumbs-up"></i></a>
                                                @endif
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
    </div>
@endsection
