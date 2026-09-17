<!DOCTYPE html>
<html>
@php
    use Carbon\Carbon;
    $jmlhTanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
@endphp

<head>
    <title>Laporan Rekap Presensi Guru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
            font-size: 12px
        }

        th {
            background-color: #f2f2f2;
            position: sticky;
            top: 0;
            border: 1;
        }

        .laporan {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        .laporan th,
        .laporan td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .laporan th {
            background-color: #f2f2f2;
        }

        .laporan tr:nth-child(even) {
            background-color: #f2f2f2;
        }

        .laporan tr:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <div style="text-align: center">
        <h2>LAPORAN REKAP PRESENSI GURU<br>
            TAHUN {{ $tahun }}<br>
        </h2>
    </div>
    <table class="laporan">
        <thead>
            <tr>
                <th width="1%" rowspan="3">No</th>
                <th rowspan="3">Nama Guru</th>
                <th colspan="39" style="text-align: center">TAHUN {{ $tahun }}</th>
            </tr>
            <tr>
                @for ($i = 1; $i <= 12; $i++)
                    <th colspan="3" style="text-align: center">{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}</th>
                @endfor
                <th colspan="3">Total</th>
            </tr>
            <tr>
                @for ($i = 1; $i <= 12; $i++)
                    <th style="text-align: center">I</th>
                    <th style="text-align: center">S</th>
                    <th style="text-align: center">C</th>
                @endfor
                <th style="text-align: center">I</th>
                <th style="text-align: center">S</th>
                <th style="text-align: center">C</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $l)
                @php
                    $sakit = [];
                    $izin = [];
                    $cuti = [];

                    for ($i = 1; $i <= 12; $i++) {
                        $sakit[$i] = DB::table('surat_absen')
                            ->where('jenis_absen', 'Sakit')
                            ->whereRaw("MONTH(tanggal) = '$i'")
                            ->whereRaw("YEAR(tanggal) = '$tahun'")
                            ->where('kode_guru', $l->kode_guru)
                            ->count();

                        $izin[$i] = DB::table('surat_absen')
                            ->where('jenis_absen', 'Izin')
                            ->whereRaw("MONTH(tanggal) = '$i'")
                            ->whereRaw("YEAR(tanggal) = '$tahun'")
                            ->where('kode_guru', $l->kode_guru)
                            ->count();

                        $cuti[$i] = DB::table('surat_absen')
                            ->where('jenis_absen', 'Cuti')
                            ->whereRaw("MONTH(tanggal) = '$i'")
                            ->whereRaw("YEAR(tanggal) = '$tahun'")
                            ->where('kode_guru', $l->kode_guru)
                            ->count();
                    }

                    $totizin = DB::table('surat_absen')
                        ->where('jenis_absen', 'Izin')
                        ->whereRaw("YEAR(tanggal) = '$tahun'")
                        ->where('kode_guru', $l->kode_guru)
                        ->count();

                    $totsakit = DB::table('surat_absen')
                        ->where('jenis_absen', 'Sakit')
                        ->whereRaw("YEAR(tanggal) = '$tahun'")
                        ->where('kode_guru', $l->kode_guru)
                        ->count();

                    $totcuti = DB::table('surat_absen')
                        ->where('jenis_absen', 'Cuti')
                        ->whereRaw("YEAR(tanggal) = '$tahun'")
                        ->where('kode_guru', $l->kode_guru)
                        ->count();
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ strtoupper($l->nama_guru) }}</td>
                    @for ($i = 1; $i <= 12; $i++)
                        <td>{{ isset($izin[$i]) ? ($izin[$i] != 0 ? $izin[$i] : '') : '' }}</td>
                        <td>{{ isset($sakit[$i]) ? ($sakit[$i] != 0 ? $sakit[$i] : '') : '' }}</td>
                        <td>{{ isset($cuti[$i]) ? ($cuti[$i] != 0 ? $cuti[$i] : '') : '' }}</td>
                    @endfor
                    <td>{{ isset($totizin) ? ($totizin != 0 ? $totizin : '') : '' }}</td>
                    <td>{{ isset($totsakit) ? ($totsakit != 0 ? $totsakit : '') : '' }}</td>
                    <td>{{ isset($totcuti) ? ($totcuti != 0 ? $totcuti : '') : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
