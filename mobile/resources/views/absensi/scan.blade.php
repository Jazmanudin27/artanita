@extends('frontend.template')
@section('titlepage', 'Dashboard')
@section('contents')
    @php
        $absensi = DB::table('presensi')
            ->where('kode_guru', Auth::guard('guru')->user()->kode_guru)
            ->orderBy('tanggal', 'DESC')
            ->limit(5)
            ->get();
        $scanToDay = DB::table('presensi')
            ->where('kode_guru', Auth::guard('guru')->user()->kode_guru)
            ->where('tanggal', Date('Y-m-d'))
            ->first();
    @endphp
    <style>
        #map {
            height: 300px;
        }
    </style>
    <div id="appCapsule">
        <div class="section">
            <div class="row mt-2">
                <div class="col-12">
                    <div id="map"></div>
                    <input type="hidden" id="latitude">
                    <input type="hidden" id="longitude">
                    <input type="hidden" id="distance">
                </div>
            </div>
        </div>
        <div class="section mt-3 bm-5">
            <div class="row mt-2">
                <div class="col-6">
                    <a href="#" id="masuk">
                        <div class="stat-box bg-success">
                            <ion-icon name="finger-print" class="icon"></ion-icon>
                            <div class="title">Scan Masuk</div>
                            <div class="value">{{ $scanToDay->jam_in ?? 'Belum Scan' }}</div>
                        </div>
                    </a>
                </div>
                <div class="col-6">
                    <a href="#" id="pulang">
                        <div class="stat-box bg-danger">
                            <ion-icon name="finger-print" class="icon"></ion-icon>
                            <div class="title">Scan Pulang</div>
                            <div class="value">{{ $scanToDay->jam_out ?? 'Belum Scan' }}</div>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="section mt-4 mb-5">
            <div class="section-heading">
                <h2 class="title">Histori 5 Hari Terakhir</h2>
                <a href="#" class="link">View All</a>
            </div>
            <div class="transactions">
                @foreach ($absensi as $a)
                    <a href="#" class="item">
                        <div class="detail">
                            <ion-icon name="finger-print" class="icon"
                                style="font-size: 35px;padding-right:15px"></ion-icon>
                            <div>
                                <strong>{{ strftime('%A, %e %B %Y', strtotime($a->tanggal)) }}</strong>
                                <span style="color: {{ $a->jam_in ?: 'red' }}">{{ $a->jam_in ?: 'Belum Scan' }} -
                                </span>
                                <span style="color: {{ $a->jam_out ?: 'red' }}">{{ $a->jam_out ?: 'Belum Scan' }}</span>
                            </div>
                        </div>
                        <div class="right">
                            <div class="price text-danger"></div>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
    <br>
    <script>
        $(document).ready(function() {

            var map = L.map('map').setView([-7.325247858853144, 108.20838471379722], 17);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
            }).addTo(map);
            var circle = L.circle([-7.325247858853144, 108.20838471379722], {
                color: 'blue',
                fillColor: '#007cbf',
                fillOpacity: 0.5,
                radius: 90
            }).addTo(map);
            navigator.geolocation.getCurrentPosition(function(position) {
                var latitude = position.coords.latitude;
                var longitude = position.coords.longitude;
                var marker = L.marker([latitude, longitude]).addTo(map);

                var radiusLat = -7.325247858853144;
                var radiusLng = 108.20838471379722;
                var distance = haversineDistance(latitude, longitude, radiusLat, radiusLng);
                var distanceMeter = distance * 1000;

                $('#distance').val(distanceMeter);
                $('#latitude').val(latitude);
                $('#longitude').val(longitude);

            });

            $('#masuk').click(function() {
                var distance = $('#distance').val();
                var latitude = $('#latitude').val();
                var longitude = $('#longitude').val();

                var masuk = "{{ $scanToDay->jam_in ?? '' }}";

                if (distance >= 90) {
                    Swal.fire({
                        title: 'Opps,',
                        text: "Diluar radius kantor",
                        icon: 'warning',
                    });
                } else if (masuk != '') {
                    Swal.fire({
                        title: 'Opps,',
                        text: "Sudah Absen Masuk",
                        icon: 'warning',
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('scanMasuk') }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            latitude: latitude,
                            longitude: longitude,
                        },
                        success: function(data) {
                            window.location.reload();
                        },
                    });
                }
            });

            $('#pulang').click(function() {
                var distance = $('#distance').val();
                var latitude = $('#latitude').val();
                var longitude = $('#longitude').val();
                var pulang = "{{ $scanToDay->jam_out ?? '' }}";
                var masuk = "{{ $scanToDay->jam_in ?? '' }}";

                if (distance >= 90) {
                    Swal.fire({
                        title: 'Opps,',
                        text: "Diluar radius kantor",
                        icon: 'warning',
                    });
                } else if (masuk == '') {
                    Swal.fire({
                        title: 'Opps,',
                        text: "Belum Scan Masuk",
                        icon: 'warning',
                    });
                } else if (pulang != '') {
                    Swal.fire({
                        title: 'Opps,',
                        text: "Sudah Scan Pulang",
                        icon: 'warning',
                    });
                } else {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('scanPulang') }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            latitude: latitude,
                            longitude: longitude,
                        },
                        success: function(data) {
                            window.location.reload();
                        },
                    });
                }
            });

        });
    </script>
@endsection
