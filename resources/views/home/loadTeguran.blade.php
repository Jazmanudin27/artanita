@php
    use Carbon\Carbon;
@endphp
@foreach ($teguran as $t)
    @php
        $izin = DB::table('absensi_siswa')
            ->where('status', 'I')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->where('kode_kelas', $t->kode_kelas)
            ->where('kode_siswa', $t->kode_siswa)
            ->count();
        $sakit = DB::table('absensi_siswa')
            ->where('status', 'S')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->where('kode_kelas', $t->kode_kelas)
            ->where('kode_siswa', $t->kode_siswa)
            ->count();
        $alfa = DB::table('absensi_siswa')
            ->where('status', 'A')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->where('kode_kelas', $t->kode_kelas)
            ->where('kode_siswa', $t->kode_siswa)
            ->count();
        $jmlteguran = DB::table('surat_teguran')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->join('siswa', 'siswa.kode_siswa', 'surat_teguran.kode_siswa')
            ->where('surat_teguran.kode_kelas', $t->kode_kelas)
            ->where('surat_teguran.kode_siswa', $t->kode_siswa)
            ->count();
    @endphp
    <tr style="color:black">
        <td style="text-align: center">{{ $loop->iteration }}</td>
        <td>{{ $t->nama_siswa }}</td>
        <td>{{ $t->nis }}</td>
        <td style="text-align: center">{{ $t->jk }}</td>
        <td>{{ Carbon::createFromFormat('Y-m-d', $t->tanggal)->format('d-M-Y') }}</td>
        <td>{{ $t->deskripsi }}</td>
    </tr>
@endforeach
