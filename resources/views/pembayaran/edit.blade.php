@extends('layouts.template')
@section('titlepage', 'Form Edit Pembayaran')
@section('content')
    <div class="container-fluid p-0">
        <h1 class="h3 mb-3">Form Edit Pembayaran</h1>
        <div class="row">
            <div class="col-12 col-xl-6">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('updatePembayaran') }}" method="POST" autocomplete="off">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Nama Pasien</label>
                                <input type="hidden" value="{{ $pembayaran->id }}" name="id" class="form-control"
                                    placeholder="ID">
                                <input type="text" readonly value="{{ $pembayaran->nama_pasien }}" name="nama_pasien"
                                    class="form-control" placeholder="Nama Pasien">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Pengurus</label>
                                <input type="text" readonly value="{{ $pembayaran->nama_pengurus }}" name="pengurus"
                                    class="form-control" placeholder="Pengurus">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tanggal Bayar</label>
                                <input type="text" value="{{ $pembayaran->tanggal }}" name="tanggal"
                                    class="form-control datepicker" placeholder="Tanggal Masuk">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jumlah Bayar</label>
                                <input type="text" value="{{ number_format($pembayaran->bayar) }}" name="bayar"
                                    id="bayar" class="form-control uang" placeholder="Jumlah Bayar">
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Jenis Bayar</label>
                                <select class="form-control select2" name="jenis_bayar">
                                    <option value="">Pilih Jenis Bayar</option>
                                    <option {{ $pembayaran->jenis_bayar == 'Perawatan' ? 'selected' : '' }}
                                        value="Perawatan">
                                        Perawatan
                                    </option>
                                    <option {{ $pembayaran->jenis_bayar == 'Uang Jajan' ? 'selected' : '' }}
                                        value="Uang Jajan">
                                        Uang Jajan
                                    </option>
                                    <option {{ $pembayaran->jenis_bayar == 'Pengurus' ? 'selected' : '' }} value="Pengurus">
                                        Pengurus
                                    </option>
                                    <option {{ $pembayaran->jenis_bayar == 'Waris' ? 'selected' : '' }} value="Waris">
                                        Waris
                                    </option>
                                    <option {{ $pembayaran->jenis_bayar == 'Infaq' ? 'selected' : '' }} value="Infaq">
                                        Infaq
                                    </option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Bulan</label>
                                <select class="form-control select2" name="bulan" id="bulan">
                                    <option value="">Pilih Bulan</option>
                                    @php
                                        $bulan = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                                    @endphp
                                    @foreach ($bulan as $index => $monthName)
                                        @php
                                            $monthNumber = $index + 1;
                                        @endphp
                                        <option {{ $monthNumber == $pembayaran->bulan ? 'selected' : '' }}
                                            value="{{ $monthNumber }}"> {{ $monthName }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Tahun</label>
                                <select class="form-control select2" name="tahun" id="tahun">
                                    <option {{ $pembayaran->tahun == '2023' ? 'selected' : '' }} value="2023">2023
                                    </option>
                                    <option {{ $pembayaran->tahun == '2024' ? 'selected' : '' }} value="2024">2024
                                    </option>
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
