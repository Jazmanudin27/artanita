<!DOCTYPE html>
<html>
@php
    use Carbon\Carbon;
@endphp

<head>
    <title>Laporan Data Siswa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 10px;
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
        <h2>LAPORAN DATA SISWA<br>
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
                <th>No</th>
                <th>Nama Siswa</th>
                <th>JK</th>
                <th>Tempat Lahir</th>
                <th>Tgl Lahir</th>
                <th>Umur</th>
                <th>No. HP</th>
                <th>Alamat</th>
                <th>Status</th>
                <th>Kelas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $l)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ ucwords($l->nama_siswa) }}</td>
                    <td>{{ $l->jk }}</td>
                    <td>{{ ucwords($l->tempat_lahir) }}</td>
                    <td>
                        {{ Carbon::createFromFormat('Y-m-d', $l->tgl_lahir)->format('d-M-Y') }}
                    </td>
                    @if ($l->tgl_lahir)
                        @php
                            $umur = \Carbon\Carbon::parse($l->tgl_lahir)->age;
                        @endphp
                        <td>{{ $umur }} Tahun</td>
                    @else
                        <td>0 Tahun</td>
                    @endif
                    <td>{{ $l->no_hp }}</td>
                    <td>{{ ucwords($l->alamat) }}</td>
                    <td>{{ $l->status }}</td>
                    <td>{{ $l->nama_kelas }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
