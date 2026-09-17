@extends('frontend.template')
@section('titlepage', 'Histori Presensi')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Histori Presensi</div>
        <div class="right">
            <a href="{{ route('tambahSiswa') }}" class="headerButton">
                <ion-icon name="add-outline"></ion-icon>
            </a>
        </div>
    </div>
    <div id="appCapsule" class="full-height pt-5 mb-5">
        <div class="section pt-5">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Bulan</label>
                                    <select name="bulan" id="bulan" class="form-control select2" required>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option {{ Date('m') == str_pad($i, 2, '0', STR_PAD_LEFT) ? 'selected' : '' }}
                                                value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                                                {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                            </option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group basic">
                                <div class="input-wrapper">
                                    <label class="label">Tahun</label>
                                    <select name="tahun" id="tahun" class="form-control select2" required>
                                        @php
                                            $startYear = date('Y') - 1;
                                            $endYear = date('Y') + 4;
                                        @endphp

                                        @for ($year = $startYear; $year <= $endYear; $year++)
                                            <option {{ Date('Y') == $year ? 'selected' : '' }} value="{{ $year }}">
                                                {{ $year }}</option>
                                        @endfor
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="section mt-2 mb-5">
            <div class="transactions" id="showPresensi">

            </div>
        </div>
    </div>
    <br>
    <script>
        $(document).ready(function() {

            showPresensi();

            function showPresensi() {

                var bulan = $('#bulan').val();
                var tahun = $('#tahun').val();

                $.ajax({
                    type: 'POST',
                    url: '{{ route('showPresensi') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        tahun: tahun,
                        bulan: bulan,
                    },
                    success: function(data) {
                        $('#showPresensi').html(data);
                    },
                });
            }

            $('#bulan,#tahun').on("change", function(e) {
                e.preventDefault();
                showPresensi();
            });

        });
    </script>

@endsection
