<!DOCTYPE html>
<html>
@php
    use Carbon\Carbon;
    $jmlhTanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
@endphp

<head>
    <title>Laporan Surat Teguran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
            font-size: 12px
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
        <h2>LAPORAN SURAT TEGURAN<br>
            BULAN {{ $bulan }} TAHUN {{ $tahun }}<br>
            @if ($kode_kelas != '')
                KELAS {{ strtoupper($kelas->nama_kelas) }} <br>
            @else
                SEMUA KELAS<br>
            @endif
        </h2>
    </div>
    <table class="laporan">
        <thead>
            <tr>
                <th style="width:1%">No</th>
                <th style="width:10%">Tanggal</th>
                <th style="width:20%">Nama Siswa</th>
                <th style="width:5%">Kelas</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $l)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ Carbon::createFromFormat('Y-m-d', $l->tanggal)->format('d-M-Y') }}
                    </td>
                    <td>{{ strtoupper($l->nama_siswa) }}</td>
                    <td>{{ strtoupper($l->nama_kelas) }}</td>
                    <td>{{ $l->deskripsi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
