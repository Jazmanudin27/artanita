@extends('layouts.template')
@section('titlepage', 'Profile')
@section('content')
    <style>
        #map {
            height: 350px;
        }

        tbody,
        td,
        tfoot,
        th,
        thead,
        tr {
            border: none
        }
    </style>
    <div class="container-fluid p-0">
        <div class="row">
            <div class="col-md-6 col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-sm-12">
                                    <h4 style="text-align: center">DATA SEKOLAH</h4>
                                </div>
                            </div>
                        </div>
                        <div class="table-reponsive">
                            <table class="table table-striped ">
                                <thead style="color:black">
                                    <tr>
                                        <th>NPSN</th>
                                        <td>
                                            <input type="text" style="color:black" class="form-control" name="npsn"
                                                value="{{ $member->npsn }}" placeholder="NPSN">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Nama Sekolah</th>
                                        <td>
                                            <input type="text" style="color:black" class="form-control"
                                                name="nama_member" value="{{ $member->nama_member }}"
                                                placeholder="Nama Member">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Alamat</th>
                                        <td>
                                            <input type="text" style="color:black" class="form-control" name="alamat"
                                                value="{{ $member->alamat }}" placeholder="Alamat">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Desa/Kel.</th>
                                        <td>
                                            <input type="text" style="color:black" class="form-control" name="desa"
                                                value="{{ $member->desa }}" placeholder="Desa">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kecamatan</th>
                                        <td>
                                            <input type="text" style="color:black" class="form-control" name="kecamatan"
                                                value="{{ $member->kecamatan }}" placeholder="Kecamatan">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kota/Kab.</th>
                                        <td>
                                            <input type="text" style="color:black" class="form-control" name="kota"
                                                value="{{ $member->kota }}" placeholder="Kota">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kode POS</th>
                                        <td>
                                            <input type="text" style="color:black" class="form-control" name="pos"
                                                value="{{ $member->pos }}" placeholder="Kode POS">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Kontak</th>
                                        <td>
                                            <input type="text" style="color:black" class="form-control" name="no_hp"
                                                value="{{ $member->no_hp }}" placeholder="NO HP">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>E-mail</th>
                                        <td>
                                            <input type="text" style="color:black" class="form-control" name="email"
                                                value="{{ $member->email }}" placeholder="E-mail">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Tahun Pelajaran</th>
                                        <td>
                                            <select class="form-control" style="color:black" name="kode_tahun_pelajaran"
                                                id="kode_tahun_pelajaran" required>
                                                @php
                                                    $data = DB::select('SELECT * FROM tahun_pelajaran ORDER BY kode_tahun_pelajaran ASC');
                                                @endphp
                                                @foreach ($data as $t)
                                                    <option
                                                        {{ $t->kode_tahun_pelajaran == $member->kode_tahun_pelajaran ? 'selected' : '' }}
                                                        value="{{ $t->kode_tahun_pelajaran }}">
                                                        {{ $t->tahun_pelajaran }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>Lokasi</th>
                                        <td>
                                            <input type="text" style="color:black" class="form-control" name="lokasi"
                                                value="{{ $member->lokasi }}" placeholder="Lokasi">
                                        </td>
                                    </tr>
                                    <tr>
                                        <th></th>
                                    </tr>
                                    <tr>
                                        <th colspan="2">
                                            <a href="#" class="btn btn-primary btn-block">Update</a>
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-12">
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="col-md-12 col-sm-12">
                                <div class="col-md-12 col-sm-12">
                                    <h1 style="text-align: center" id="masaaktif"></h1>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <h1 style="text-align: center" id="remainingTime"></h1>
                                </div>
                                <div class="col-md-12 col-sm-12">
                                    <a href="#" class="btn btn-primary btn-block" id="bayarSewa">Perpanjang</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-sm-12">
                    <div class="card">
                        <div class="card-body">
                            <h4 style="text-align: center">LOKASI SEKOLAH</h4>
                            <div id="map"></div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <div class="modal fade" id="modalPembayaran" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body m-1">
                    <h4 style="text-align: center">FORM PEMBAYARAN</h4>
                    <form action="" method="POST" autocomplete="off">
                        @csrf
                        <div class="mb-3">
                            <select class="form-control" id="lama_sewa">
                                <option value="1">1 Bulan</option>
                                <option value="12">12 Bulan + Diskon</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <select class="form-control" name="kode_paket" id="kode_paket">
                                @php
                                    $paket = DB::select('SELECT * FROM paket ORDER BY nama_paket ASC');
                                @endphp
                                <option value="">Pilih Paket</option>
                                @foreach ($paket as $p)
                                    <option {{ $member->kode_paket == $p->kode_paket ? 'selected' : '' }}
                                        data-harga="{{ $p->harga }}" data-jumlah="{{ $p->jumlah }}"
                                        data-ppn="{{ $p->ppn }}" data-diskon="{{ $p->diskon }}"
                                        value="{{ $p->kode_paket }}">
                                        {{ $p->nama_paket }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <input type="text" id="harga" readonly class="form-control" placeholder="Harga">
                        </div>
                        <div class="mb-3">
                            <input type="text" id="diskon" readonly class="form-control" placeholder="Diskon">
                        </div>
                        <div class="mb-3">
                            <input type="text" id="ppn" readonly class="form-control" placeholder="PPN">
                        </div>
                        <div class="mb-3">
                            <input type="text" id="jumlah_bayar" readonly class="form-control"
                                placeholder="Jumlah Bayar">
                        </div>
                        <div class="mb-3">
                            <a href="#" class="btn btn-primary btn-block">Buat Pembayaran</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>
    <script>
        $(document).ready(function() {

            function getDistanceBetweenPoints(latitude1, longitude1, latitude2, longitude2, unit) {
                let theta = longitude1 - longitude2;
                let distance = 60 * 1.1515 * (180 / Math.PI) * Math.acos(
                    Math.sin(latitude1 * (Math.PI / 180)) * Math.sin(latitude2 * (Math.PI / 180)) +
                    Math.cos(latitude1 * (Math.PI / 180)) * Math.cos(latitude2 * (Math.PI / 180)) * Math.cos(
                        theta * (Math.PI / 180))
                );
                if (unit == 'miles') {
                    return Math.round(distance, 2);
                } else if (unit == 'kilometers') {
                    return Math.round(distance * 1.609344, 2);
                } else if (unit == 'meters') {
                    return Math.round((distance * 1.609344) * 1000, 2);
                }
            }

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(successCallback, errorCallback);
            }

            var lokasiSekolaj = "{{ $member->lokasi }}";
            var lok = lokasiSekolaj.split(",");
            var latSekolah = lok[0];
            var longSekolah = lok[1];
            var radius = "20";
            var notifikasi_in = document.getElementById('notifikasi_in');
            var notifikasi_out = document.getElementById('notifikasi_out');
            var radius_sound = document.getElementById('radius_sound');

            function successCallback(position) {
                $('#lokasi').val(latSekolah + "," + longSekolah);
                var map = L.map('map').setView([latSekolah, longSekolah], 18);
                L.tileLayer('http://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                    maxZoom: 20,
                    subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
                }).addTo(map);
                var marker = L.marker([latSekolah, longSekolah]).addTo(map);
                var circle = L.circle([latSekolah, longSekolah], {
                    color: 'red',
                    fillColor: '#f03',
                    fillOpacity: 0.5,
                    radius: radius
                }).addTo(map);
            }

            function errorCallback() {

            }
            hitungSisaWaktu();

            function hitungSisaWaktu() {
                var inputDate = '{{ $member->exp_date }}';
                var expirationDate = new Date(inputDate);
                var currentDate = new Date();
                var remainingTime = expirationDate - currentDate;
                var days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
                remainingTime %= (1000 * 60 * 60 * 24);
                var hours = Math.floor(remainingTime / (1000 * 60 * 60));
                remainingTime %= (1000 * 60 * 60);
                var minutes = Math.floor(remainingTime / (1000 * 60));
                remainingTime %= (1000 * 60);
                var seconds = Math.floor(remainingTime / 1000);

                $('#masaaktif').text("Sisa Waktu");
                $('#remainingTime').text(days + " hari " + hours + " jam");
            }

            $('#bayarSewa').on("click", function(e) {
                e.preventDefault();
                $('#modalPembayaran').modal("show");
            });

            $('#kode_paket').on("change", function(e) {
                e.preventDefault();
                var diskon = $(this).attr('data-diskon');
                var harga = $(this).attr('data-harga');
                var jumlah = $(this).attr('data-jumlah');
                var ppn = $(this).attr('data-ppn');

                $('#diskon').val(diskon);
                $('#harga').val(harga);
                $('#jumlah').val(jumlah);
                $('#ppn').val(ppn);
            });
        });
    </script>
@endsection
