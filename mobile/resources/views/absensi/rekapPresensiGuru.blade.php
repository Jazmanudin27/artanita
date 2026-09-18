@extends('frontend.template')
@section('titlepage', 'Rekap Presensi Guru')
@section('contents')
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="{{ route('dashboard') }}" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Rekap Presensi Guru
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
                </div>
            </div>
        </div>

        <!-- Teacher Rekap Container -->
        <div class="section mt-3 mb-5">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="font-weight-bold text-dark" style="font-size: 0.95rem;">Rekap Presensi Guru</span>
                <div style="font-size: 0.72rem; color: #64748B;" class="font-weight-bold">
                    <span class="text-success">H</span>=Hadir • <span style="color: #d97706;">S</span>=Sakit • <span style="color: #0284c7;">I</span>=Izin • <span style="color: #7c3aed;">C</span>=Cuti
                </div>
            </div>
            <div id="showRekapPresensiGuru">
                <!-- Loaded via AJAX -->
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            showRekapPresensiGuru();

            function showRekapPresensiGuru() {
                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showRekapPresensiGuru') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        bulan: bulan,
                        tahun: tahun,
                    },
                    success: function(data) {
                        $('#showRekapPresensiGuru').html(data);
                    },
                });
            }

            $('#bulan,#tahun').change(function() {
                showRekapPresensiGuru();
            });
        });
    </script>
@endsection
