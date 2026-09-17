@foreach ($siswa as $s)
    @php
        $izin = DB::table('absensi_mapel')
            ->where('status', 'I')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->where('kode_mapel', $kode_mapel)
            ->where('kode_siswa', $s->kode_siswa)
            ->count();
        $sakit = DB::table('absensi_mapel')
            ->where('status', 'S')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->where('kode_mapel', $kode_mapel)
            ->where('kode_siswa', $s->kode_siswa)
            ->count();
        $alfa = DB::table('absensi_mapel')
            ->where('status', 'A')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->where('kode_mapel', $kode_mapel)
            ->where('kode_siswa', $s->kode_siswa)
            ->count();
    @endphp
    <tr>
        <td style="text-align: center">{{ $loop->iteration }}</td>
        <td style="text-align: left">{{ $s->nama_siswa }}</td>
        <td style="text-align: left">{{ $s->nis }}</td>
        <td style="text-align: center">{{ $s->jk }}</td>
        <td style="text-align: center; font-weight: bold">{{ $izin == 0 ? '-' : $izin }}</td>
        <td style="text-align: center; font-weight: bold">{{ $sakit == 0 ? '-' : $sakit }}</td>
        <td style="text-align: center; font-weight: bold">{{ $alfa == 0 ? '-' : $alfa }}</td>
    </tr>
@endforeach
<script>
    $(document).ready(function() {


        function loadAbsensiSiswaPerSiswa() {

            var tahun = $('#tahun').val();
            var bulan = $('#bulan').val();
            var kode_kelas = $('#kode_kelas2').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('loadAbsensiSiswaPerSiswa') }}',
                data: {
                    tahun: tahun,
                    bulan: bulan,
                    kode_kelas: kode_kelas,
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    $('#loadAbsensiSiswaPerSiswa').html(data);
                },
            });
        }
    });
</script>
