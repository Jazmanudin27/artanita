@extends('frontend.template')
@section('titlepage', 'Data Absensi Mapel')
@section('contents')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{ route('dashboard') }}" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Absensi Mata Pelajaran
        </div>
        <div class="right"></div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule" class="full-height pt-4">
        <!-- Filter Card -->
        <div class="section mt-2">
            <div class="card shadow-sm border-0" style="border-radius: 16px; background: #ffffff;">
                <div class="card-body p-3">
                    <div class="form-group basic mb-2">
                        <label class="label font-weight-bold text-dark mb-1" style="font-size: 0.82rem;">
                            <ion-icon name="calendar-outline" style="vertical-align: middle; margin-right: 4px; color: #2563eb;"></ion-icon> Tanggal
                        </label>
                        <div class="input-group">
                            <input type="date" value="{{ Date('Y-m-d') }}" id="tanggal" class="form-control" style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 10px 12px; font-weight: 500;">
                        </div>
                    </div>

                    <div class="form-group basic mb-2">
                        <div class="input-wrapper">
                            <label class="label font-weight-bold text-dark mb-1" style="font-size: 0.82rem;">
                                <ion-icon name="school-outline" style="vertical-align: middle; margin-right: 4px; color: #2563eb;"></ion-icon> Kelas
                            </label>
                            <select class="form-control custom-select" id="kode_kelas" style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 10px 12px; font-weight: 500;">
                                @php
                                    $selectedKelas = null;
                                    if (Auth::guard('siswa')->check()) {
                                        $selectedKelas = Auth::guard('siswa')->user()->kode_kelas;
                                        $kelas = DB::select("SELECT * FROM kelas WHERE kode_kelas = '$selectedKelas' ORDER BY nama_kelas ASC");
                                    } elseif (Auth::guard('kelas')->check()) {
                                        $selectedKelas = Auth::guard('kelas')->user()->kode_kelas;
                                        $kelas = DB::select("SELECT * FROM kelas WHERE kode_kelas = '$selectedKelas' ORDER BY nama_kelas ASC");
                                    } else {
                                        $kelas = DB::select('SELECT * FROM kelas ORDER BY nama_kelas ASC');
                                    }
                                @endphp
                                @foreach ($kelas as $p)
                                    <option value="{{ $p->kode_kelas }}" {{ ($selectedKelas == $p->kode_kelas) ? 'selected' : '' }}>{{ $p->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="form-group basic mb-1">
                        <div class="input-wrapper">
                            <label class="label font-weight-bold text-dark mb-1" style="font-size: 0.82rem;">
                                <ion-icon name="book-outline" style="vertical-align: middle; margin-right: 4px; color: #2563eb;"></ion-icon> Mata Pelajaran
                            </label>
                            <select class="form-control custom-select" id="kode_mapel" style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 10px 12px; font-weight: 500;">
                                @php
                                    $mapel = DB::select('SELECT * FROM mapel ORDER BY nama_mapel ASC');
                                @endphp
                                @foreach ($mapel as $p)
                                    <option value="{{ $p->kode_mapel }}">{{ $p->nama_mapel }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student List Container -->
        <div class="section mt-3 mb-5">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="font-weight-bold text-dark" style="font-size: 0.95rem; font-family: sans-serif;">Daftar Presensi Mapel</span>
                <span class="badge badge-primary px-2 py-1" style="border-radius: 8px;">Live Data</span>
            </div>
            <div id="showAbsensiMapel">
                <!-- Loaded via AJAX -->
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            showAbsensiMapel();

            function showAbsensiMapel() {
                var tanggal = $('#tanggal').val();
                var kode_kelas = $('#kode_kelas').val();
                var kode_mapel = $('#kode_mapel').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showAbsensiMapel') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tanggal: tanggal,
                        kode_kelas: kode_kelas,
                        kode_mapel: kode_mapel,
                    },
                    success: function(data) {
                        $('#showAbsensiMapel').html(data);
                    },
                });
            }

            $('#tanggal,#kode_kelas,#kode_mapel').change(function() {
                showAbsensiMapel();
            });
        });
    </script>
@endsection
