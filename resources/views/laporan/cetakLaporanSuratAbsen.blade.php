<!DOCTYPE html>
<html>
@php
    use Carbon\Carbon;
    $jmlhTanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
@endphp

<head>
    <title>Laporan Surat Absen</title>
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
        <h2>LAPORAN SURAT ABSEN<br>
            BULAN {{ $bulan }} TAHUN {{ $tahun }}<br>
        </h2>
    </div>
    <table class="laporan">
        <thead>
            <tr>
                <th style="width:1%">No</th>
                <th style="width:10%">Tanggal</th>
                <th style="width:10%">Jenis Absen</th>
                <th>Nama Guru</th>
                <th>Deskripsi</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $l)
                @php
                    if ($l->status == '0') {
                        $status = 'Ditolak';
                        $color = 'red';
                    } elseif ($l->status == null) {
                        $status = 'Pending';
                        $color = 'orange';
                    } else {
                        $status = 'Disetujui';
                        $color = 'green';
                    }
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ Carbon::createFromFormat('Y-m-d', $l->tanggal)->format('d-M-Y') }}
                    </td>
                    <td>{{ $l->jenis_absen }}</td>
                    <td>{{ strtoupper($l->nama_guru) }}</td>
                    <td>{{ $l->deskripsi }}</td>
                    <td style="color:{{ $color }}">{{ $status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
