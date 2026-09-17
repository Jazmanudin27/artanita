<!-- resources/views/laporan/cetakLaporanDetailPresensi.blade.php -->

<!DOCTYPE html>
<html>
<head>
    <title>Laporan Detail Presensi Guru</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
            font-size: 12px;
        }

        .laporan {
            width: 200%;
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
            background-color: #f2f2f2;
        }

        .laporan tr:hover {
            background-color: #ddd;
        }
    </style>
</head>

<body>
    <div style="text-align: center">
        <h2>LAPORAN DETAIL PRESENSI GURU<br>
            PERIODE {{ \Carbon\Carbon::parse($start_date)->format('d-m-Y') }} S/D {{ \Carbon\Carbon::parse($end_date)->format('d-m-Y') }}<br>
        </h2>
    </div>
    <table class="laporan">
        <thead>
            <tr>
                <th width="1%" rowspan="2">No</th>
                <th width="10%" rowspan="2">Nama Guru</th>
                <th colspan="{{ $jmlhTanggal }}" style="text-align: center">Periode</th>
                <th colspan="3" style="text-align: center">Jumlah Absen</th>
            </tr>
            <tr>
                @foreach ($dates as $date)
                    <th style="text-align: center; width:2.8%">{{ \Carbon\Carbon::parse($date)->format('d') }}</th>
                @endforeach
                <th style="text-align: center;width:3%">Izin</th>
                <th style="text-align: center;width:3%">Sakit</th>
                <th style="text-align: center;width:3%">Cuti</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $index => $l)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ strtoupper($l->nama_guru) }}</td>
                    @foreach ($l->days as $day)
                        <td align="center" style="color: {{ $day['color'] }}">
                            {{ $day['jam_in'] != '' ? substr($day['jam_in'], 0, 5) : '' }}
                            {{ $day['jam_in'] != '' ? ' - ' : '' }}
                            {{ $day['jam_out'] != '' ? substr($day['jam_out'], 0, 5) : '' }}
                        </td>
                    @endforeach
                    <td align="center">{{ $l->Izin != '' ? $l->Izin : '' }}</td>
                    <td align="center">{{ $l->Sakit != '' ? $l->Sakit : '' }}</td>
                    <td align="center">{{ $l->Cuti != '' ? $l->Cuti : '' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
