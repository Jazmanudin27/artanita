@foreach ($siswa as $k)
    @php
        $izin = DB::table('absensi_siswa')
            ->where('status', 'I')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->where('kode_kelas', $k->kode_kelas)
            ->where('kode_siswa', $k->kode_siswa)
            ->count();
        $sakit = DB::table('absensi_siswa')
            ->where('status', 'S')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->where('kode_kelas', $k->kode_kelas)
            ->where('kode_siswa', $k->kode_siswa)
            ->count();
        $alfa = DB::table('absensi_siswa')
            ->where('status', 'A')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->where('kode_kelas', $k->kode_kelas)
            ->where('kode_siswa', $k->kode_siswa)
            ->count();
        $jmlteguran = DB::table('surat_teguran')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->join('siswa', 'siswa.kode_siswa', 'surat_teguran.kode_siswa')
            ->where('surat_teguran.kode_kelas', $k->kode_kelas)
            ->where('surat_teguran.kode_siswa', $k->kode_siswa)
            ->count();
    @endphp
    <tr style="color:black">
        <td style="text-align: center">{{ $loop->iteration }}</td>
        <td>{{ $k->nama_siswa }}</td>
        <td>{{ $k->nis }}</td>
        <td style="text-align: center">{{ $k->jk }}</td>
        <td style="text-align: center">{{ $izin == 0 ? '-' : $izin }}</td>
        <td style="text-align: center">{{ $sakit == 0 ? '-' : $sakit }}</td>
        <td style="text-align: center">{{ $alfa == 0 ? '-' : $alfa }}</td>
        <td style="text-align: center">{{ $jmlteguran == 0 ? '-' : $jmlteguran }}</td>
    </tr>
@endforeach
