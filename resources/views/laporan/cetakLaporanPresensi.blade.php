<!DOCTYPE html>
<html>
<head>
    <title>Laporan Presensi Guru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
            font-size: 12px;
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
        }

        .laporan th {
            background-color: #f2f2f2;
        }

        .laporan tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .laporan tr:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <div style="text-align: center">
        <h2>LAPORAN PRESENSI GURU<br>
            PERIODE {{ \Carbon\Carbon::parse($start_date)->format('d-m-Y') }} S/D {{ \Carbon\Carbon::parse($end_date)->format('d-m-Y') }}<br>
        </h2>
    </div>
    <table class="laporan">
        <thead>
            <tr>
                <th width="1%" rowspan="2">No</th>
                <th rowspan="2">Nama Guru</th>
                <th colspan="{{ $jmlhTanggal }}" style="text-align: center">Periode</th>
                <th colspan="3" style="text-align: center">Jumlah Absen</th>
            </tr>
            <tr>
                @foreach ($dates as $date)
                    <th>{{ \Carbon\Carbon::parse($date)->format('d') }}</th>
                @endforeach
                <th>Izin</th>
                <th>Sakit</th>
                <th>Cuti</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $index => $l)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $l->nama_guru }}</td>
                    @foreach ($l->days as $dayStatus)
                        <td align="center">{{ $dayStatus }}</td>
                    @endforeach
                    <td align="center">{{ $l->Izin }}</td>
                    <td align="center">{{ $l->Sakit }}</td>
                    <td align="center">{{ $l->Cuti }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>