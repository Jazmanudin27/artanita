<!DOCTYPE html>
<html>
@php
    use Carbon\Carbon;
    $jmlhTanggal = cal_days_in_month(CAL_GREGORIAN, $bulan, $tahun);
@endphp

<head>
    <title>Laporan Absensi Mapel</title>
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
        <h2>
            LAPORAN ABSENSI MAPEL<br>
            BULAN {{ $bulan }} TAHUN {{ $tahun }}<br>
            @if ($kode_mapel != '')
                MATA PELAJARAN {{ strtoupper($mapel->nama_mapel) }} <br>
            @else
                SEMUA MAPEL<br>
            @endif
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
                <th width="1%" rowspan="2">No</th>
                <th rowspan="2" style="text-align: center">Nama mapel</th>
                <th rowspan="2" style="text-align: center">NIS</th>
                <th colspan="{{ $jmlhTanggal }}" style="text-align: center">BULAN {{ $bulan }}</th>
                <th colspan="3" style="text-align: center">Jumlah Absen</th>
            </tr>
            <tr>
                @for ($i = 1; $i <= $jmlhTanggal; $i++)
                    <th style="text-align: center">{{ $i }}</th>
                @endfor
                <th style="text-align: center">I</th>
                <th style="text-align: center">S</th>
                <th style="text-align: center">A</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($laporan as $l)
                @php
                    $abs = DB::table('absensi_mapel')
                        ->selectRaw(
                            "MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '01' , status , '')) AS Satu,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '02' , status , '')) AS Dua,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '03' , status , '')) AS Tiga,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '04' , status , '')) AS Empat,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '05' , status , '')) AS Lima,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '06' , status , '')) AS Enam,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '07' , status , '')) AS Tujuh,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '08' , status , '')) AS Delapan,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '09' , status , '')) AS Sembilan,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '10' , status , '')) AS Sepuluh,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '11' , status , '')) AS Sebelas,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '12' , status , '')) AS Duabelas,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '13' , status , '')) AS Tigabelas,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '14' , status , '')) AS Empatbelas,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '15' , status , '')) AS Limabelas,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '16' , status , '')) AS Enambelas,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '17' , status , '')) AS Tujuhbelas,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '18' , status , '')) AS Delapanbelas,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '19' , status , '')) AS Sembilanbelas,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '20' , status , '')) AS Duapuluh,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '21' , status , '')) AS Duasatu,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '22' , status , '')) AS Duadua,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '23' , status , '')) AS Duatiga,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '24' , status , '')) AS Duaempat,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '25' , status , '')) AS Dualima,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '26' , status , '')) AS Duaenam,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '27' , status , '')) AS Duatujuh,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '28' , status , '')) AS Duadelapan,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '29' , status , '')) AS Duasembilan,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '30' , status , '')) AS Tigapuluh,
                            MAX(IF ( status != 'H' AND MONTH(tanggal) = '$bulan' AND YEAR(tanggal) = '$tahun'  AND DAY(tanggal) = '31' , status , '')) AS Tigasatu
                    ",
                        )
                        ->where('kode_mapel', $kode_mapel)
                        ->where('kode_siswa', $l->kode_siswa)
                        ->where('kode_kelas', $l->kode_kelas)
                        ->first();
                    $Sakit = DB::table('absensi_mapel')
                        ->where('status', 'S')
                        ->whereRaw("MONTH(tanggal) = '$bulan'")
                        ->where('kode_siswa', $l->kode_siswa)
                        ->whereRaw("YEAR(tanggal) = '$tahun'")
                        ->where('kode_mapel', $kode_mapel)
                        ->count();
                    $Izin = DB::table('absensi_mapel')
                        ->where('status', 'I')
                        ->whereRaw("MONTH(tanggal) = '$bulan'")
                        ->where('kode_siswa', $l->kode_siswa)
                        ->whereRaw("YEAR(tanggal) = '$tahun'")
                        ->where('kode_mapel', $kode_mapel)
                        ->count();
                    $Alfa = DB::table('absensi_mapel')
                        ->where('status', 'A')
                        ->whereRaw("MONTH(tanggal) = '$bulan'")
                        ->where('kode_siswa', $l->kode_siswa)
                        ->whereRaw("YEAR(tanggal) = '$tahun'")
                        ->where('kode_mapel', $kode_mapel)
                        ->count();
                @endphp
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ strtoupper($l->nama_siswa) }}</td>
                    <td>{{ strtoupper($l->nis) }}</td>
                    <td style="text-align: center">{{ $abs->Satu }}</td>
                    <td style="text-align: center">{{ $abs->Dua }}</td>
                    <td style="text-align: center">{{ $abs->Tiga }}</td>
                    <td style="text-align: center">{{ $abs->Empat }}</td>
                    <td style="text-align: center">{{ $abs->Lima }}</td>
                    <td style="text-align: center">{{ $abs->Enam }}</td>
                    <td style="text-align: center">{{ $abs->Tujuh }}</td>
                    <td style="text-align: center">{{ $abs->Delapan }}</td>
                    <td style="text-align: center">{{ $abs->Sembilan }}</td>
                    <td style="text-align: center">{{ $abs->Sepuluh }}</td>
                    <td style="text-align: center">{{ $abs->Sebelas }}</td>
                    <td style="text-align: center">{{ $abs->Duabelas }}</td>
                    <td style="text-align: center">{{ $abs->Tigabelas }}</td>
                    <td style="text-align: center">{{ $abs->Empatbelas }}</td>
                    <td style="text-align: center">{{ $abs->Limabelas }}</td>
                    <td style="text-align: center">{{ $abs->Enambelas }}</td>
                    <td style="text-align: center">{{ $abs->Tujuhbelas }}</td>
                    <td style="text-align: center">{{ $abs->Delapanbelas }}</td>
                    <td style="text-align: center">{{ $abs->Sembilanbelas }}</td>
                    <td style="text-align: center">{{ $abs->Duapuluh }}</td>
                    <td style="text-align: center">{{ $abs->Duasatu }}</td>
                    <td style="text-align: center">{{ $abs->Duadua }}</td>
                    <td style="text-align: center">{{ $abs->Duatiga }}</td>
                    <td style="text-align: center">{{ $abs->Duaempat }}</td>
                    <td style="text-align: center">{{ $abs->Dualima }}</td>
                    <td style="text-align: center">{{ $abs->Duaenam }}</td>
                    <td style="text-align: center">{{ $abs->Duatujuh }}</td>
                    <td style="text-align: center">{{ $abs->Duadelapan }}</td>
                    @if ($jmlhTanggal >= 29)
                        <td style="text-align: center">{{ $abs->Duasembilan }}</td>
                    @endif
                    @if ($jmlhTanggal >= 30)
                        <td style="text-align: center">{{ $abs->Tigapuluh }}</td>
                    @endif
                    @if ($jmlhTanggal >= 31)
                        <td style="text-align: center">{{ $abs->Tigasatu }}</td>
                    @endif
                    <td style="text-align: center">{{ $Izin == 0 ? '' : $Izin }}</td>
                    <td style="text-align: center">{{ $Sakit == 0 ? '' : $Sakit }}</td>
                    <td style="text-align: center">{{ $Alfa == 0 ? '' : $Alfa }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
