@extends('frontend.template')
@section('titlepage', 'Rekap Absensi Siswa')
@section('contents')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{ route('dashboard') }}" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Rekap Absensi Siswa
        </div>
        <div class="right"></div>
    </div>

    <!-- App Capsule -->
    <div id="appCapsule" class="full-height pt-4">
        <!-- Filter Card -->
        <div class="section mt-2">
            <div class="card shadow-sm border-0" style="border-radius: 16px; background: #ffffff;">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group basic mb-2">
                                <label class="label font-weight-bold text-dark mb-1" style="font-size: 0.82rem;">
                                    <ion-icon name="calendar-outline" style="vertical-align: middle; margin-right: 4px; color: #2563eb;"></ion-icon> Bulan
                                </label>
                                <select id="bulan" class="form-control custom-select" style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 10px; font-weight: 500;">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option {{ Date('m') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}
                                            value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                            {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                        </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group basic mb-2">
                                <label class="label font-weight-bold text-dark mb-1" style="font-size: 0.82rem;">
                                    Tahun
                                </label>
                                <select id="tahun" class="form-control custom-select" style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 10px; font-weight: 500;">
                                    @php
                                        $startYear = '2023';
                                        $endYear = Date('Y') + 1;
                                    @endphp
                                    @for ($year = $startYear; $year <= $endYear; $year++)
                                        <option {{ Date('Y') == $year ? 'selected' : '' }} value="{{ $year }}">{{ $year }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group basic mb-1">
                        <div class="input-wrapper">
                            <label class="label font-weight-bold text-dark mb-1" style="font-size: 0.82rem;">
                                <ion-icon name="school-outline" style="vertical-align: middle; margin-right: 4px; color: #2563eb;"></ion-icon> Kelas
                            </label>
                            <select class="form-control custom-select" id="kode_kelas" style="border-radius: 10px; border: 1px solid #cbd5e1; padding: 10px 12px; font-weight: 500;">
                                @php
                                    if (Auth::guard('siswa')->check()) {
                                        $kode_kelas = Auth::guard('siswa')->user()->kode_kelas;
                                        $kelas = DB::select("SELECT * FROM kelas WHERE kode_kelas = '$kode_kelas' ORDER BY nama_kelas ASC");
                                    } else {
                                        $kelas = DB::select('SELECT * FROM kelas ORDER BY nama_kelas ASC');
                                    }
                                @endphp
                                @foreach ($kelas as $p)
                                    <option value="{{ $p->kode_kelas }}">{{ $p->nama_kelas }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Student Rekap Container -->
        <div class="section mt-3 mb-5">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="font-weight-bold text-dark" style="font-size: 0.95rem;">Rekap Absensi Bulanan</span>
                <span class="badge badge-primary px-2 py-1" style="border-radius: 8px;">Per Bulan</span>
            </div>
            <div id="showRekapAbsensiSiswa">
                <!-- Loaded via AJAX -->
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            showRekapAbsensiSiswa();

            function showRekapAbsensiSiswa() {
                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();
                var kode_kelas = $('#kode_kelas').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showRekapAbsensiSiswa') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: bulan,
                        tahun: tahun,
                        kode_kelas: kode_kelas,
                    },
                    success: function(data) {
                        $('#showRekapAbsensiSiswa').html(data);
                    },
                });
            }

            $('#bulan,#tahun,#kode_kelas').change(function() {
                showRekapAbsensiSiswa();
            });
        });
    </script>
@endsection
