<!DOCTYPE html>
<html>

<head>
    <title>Laporan Jadwal Pelajaran</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 15px;
            font-size: 12px;
        }

        .laporan {
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
            text-align: center
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
        <h2>LAPORAN JADWAL PELAJARAN<br>
        </h2>
    </div>
    <table class="laporan" style="width: 350%">
        <tbody>
            <tr>
                <th colspan="2">WAKTU</th>
                @php
                    $namaHari = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
                    $bgColorHari = ['skyblue', 'blue', 'green', 'yellow', 'orange', 'purple'];
                @endphp
                @foreach (['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $index => $hari)
                    <th colspan="{{ $jmlKelas }}"
                        style="background-color:{{ $bgColorHari[$index % count($bgColorHari)] }}">
                        {{ $hari }}</th>
                @endforeach
            </tr>
            <tr>
                <th style="width: 10px">JAM</th>
                <th style="width: 130px">DARI - SAMPAI</th>
                @foreach ($namaHari as $hari)
                    @foreach ($kelas as $k)
                        <th>{{ $k->nama_kelas }}</th>
                    @endforeach
                @endforeach
            </tr>
            @foreach ($jamKe as $j)
                <tr>
                    <td>{{ $j->jam_ke }}</td>
                    <td>{{ $j->jam }}</td>
                    @foreach ($namaHari as $hari)
                        @foreach ($kelas as $kel)
                            @php
                                $jadwal = DB::table('jadwal')
                                    ->join('mapel_guru', 'mapel_guru.kode_guru_mapel', 'jadwal.kode_guru_mapel')
                                    ->join('guru', 'guru.kode_guru', 'mapel_guru.kode_guru')
                                    ->join('mapel', 'mapel.kode_mapel', 'mapel_guru.kode_mapel')
                                    ->where('jadwal.kode_jam', $j->kode_jam)
                                    ->where('jadwal.kode_kelas', $kel->kode_kelas)
                                    ->where('jadwal.hari', $hari)
                                    ->first();
                            @endphp
                            @if ($jadwal)
                                <td style="text-align: center" title="{{ $jadwal->nama_guru }}">
                                    {{ $jadwal->no_urut }}
                                </td>
                            @else
                                <td style="text-align: center">
                                </td>
                            @endif
                        @endforeach
                    @endforeach
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
<br>
<br>
@php
    $guru = DB::table('guru')
        ->where('guru.kode_member', Auth::user()->kode_member)
        ->orderBy('no_urut', 'ASC')
        ->get();
@endphp
<table class="laporan" style="width: 70%">
    <h3>DATA GURU </h3>
    <tbody>
        <tr>
            <th>No. </th>
            <th>Nama Guru</th>
            <th>Mata Pelajaran</th>
        </tr>
        @foreach ($guru as $g)
            @php
                $jmlh = DB::table('mapel_guru')
                    ->where('mapel_guru.kode_guru', $g->kode_guru)
                    ->count();
                $mapel = DB::table('mapel_guru')
                    ->join('mapel', 'mapel.kode_mapel', 'mapel_guru.kode_mapel')
                    ->where('mapel_guru.kode_guru', $g->kode_guru)
                    ->get();
            @endphp
            <tr>
                <td rowspan="{{ $jmlh + 1 }}" style="text-align: center">{{ $g->no_urut }}</td>
                <td rowspan="{{ $jmlh + 1 }}">{{ $g->nama_guru }}</td>
            </tr>
            @foreach ($mapel as $m)
                <tr>
                    <td style="text-align: left">{{ $m->nama_mapel }}</td>
                </tr>
            @endforeach
        @endforeach
    </tbody>
</table>
