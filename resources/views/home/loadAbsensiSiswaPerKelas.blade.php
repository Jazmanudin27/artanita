@foreach ($kelas as $k)
    @php
        $jmlhsiswa = DB::table('siswa')
            ->where('kode_kelas', $k->kode_kelas)
            ->count();
        $lakilaki = DB::table('siswa')
            ->where('jk', 'L')
            ->where('kode_kelas', $k->kode_kelas)
            ->count();
        $perempuan = DB::table('siswa')
            ->where('jk', 'P')
            ->where('kode_kelas', $k->kode_kelas)
            ->count();
        $izin = DB::table('absensi_siswa')
            ->where('status', 'I')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->where('kode_kelas', $k->kode_kelas)
            ->count();
        $sakit = DB::table('absensi_siswa')
            ->where('status', 'S')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->where('kode_kelas', $k->kode_kelas)
            ->count();
        $alfa = DB::table('absensi_siswa')
            ->where('status', 'A')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->where('kode_kelas', $k->kode_kelas)
            ->count();
        $jmlteguran = DB::table('surat_teguran')
            ->whereRaw("MONTH(tanggal) = '$bulan'")
            ->whereRaw("YEAR(tanggal) = '$tahun'")
            ->join('siswa', 'siswa.kode_siswa', 'surat_teguran.kode_siswa')
            ->where('surat_teguran.kode_kelas', $k->kode_kelas)
            ->count();
    @endphp
    <tr style="color:black">
        <td style="text-align: center">{{ $loop->iteration }}</td>
        <td>{{ $k->nama_kelas }}</td>
        <td>{{ $k->jurusan }}</td>
        <td style="text-align: center">{{ $lakilaki }}</td>
        <td style="text-align: center">{{ $perempuan }}</td>
        <td style="text-align: center">{{ $jmlhsiswa }}</td>
        <td style="text-align: center">{{ $izin == 0 ? '-' : $izin }}</td>
        <td style="text-align: center">{{ $sakit == 0 ? '-' : $sakit }}</td>
        <td style="text-align: center">{{ $alfa == 0 ? '-' : $alfa }}</td>

        <td style="text-align: center">
            <a data-id="{{ $k->kode_kelas }}" class="btn btn-sm btn-primary showAbsensiSiswaPerSiswa"><i
                    class="fa fa-list"></i></a>
        </td>
        <td style="text-align: center">
            <a data-id="{{ $k->kode_kelas }}" class="btn btn-sm btn-success showAbsensiMapel"><i
                    class="fa fa-list"></i></a>
        </td>
        <td style="text-align: center">
            <a data-id="{{ $k->kode_kelas }}" class="btn btn-sm btn-warning showTeguran"
                style="color:black;font-size:14px">{{ $jmlteguran == 0 ? '-' : $jmlteguran }}</a>
        </td>
    </tr>
@endforeach
<script>
    $(document).ready(function() {

        $('.showAbsensiSiswaPerSiswa').on("click", function(e) {
            e.preventDefault();
            $('#modalShowSiswaPerSiswa').modal("show");
            var tahun = $('#tahun').val();
            var bulan = $('#bulan').val();
            var kode_kelas = $(this).attr('data-id');
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
        });

        $('.showAbsensiMapel').on("click", function(e) {
            e.preventDefault();
            var tahun = $('#tahun').val();
            var bulan = $('#bulan').val();
            var kode_mapel = $('#kode_mapel').val();
            var kode_kelas = $(this).attr('data-id');
            if (kode_mapel == '') {
                Swal.fire(
                    'Oppss..',
                    'Pilih dahulu Mapel',
                    'warning'
                )
            } else {
                $('#modalAbsensiMapel').modal("show");
                $.ajax({
                    type: 'POST',
                    url: '{{ route('loadAbsensiMapel') }}',
                    data: {
                        tahun: tahun,
                        bulan: bulan,
                        kode_kelas: kode_kelas,
                        kode_mapel: kode_mapel,
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(data) {
                        $('#loadAbsensiMapel').html(data);
                    },
                });
            }

        });

        $('.showTeguran').on("click", function(e) {
            e.preventDefault();
            $('#modalTeguran').modal("show");
            var tahun = $('#tahun').val();
            var bulan = $('#bulan').val();
            var kode_kelas = $(this).attr('data-id');
            $.ajax({
                type: 'POST',
                url: '{{ route('loadTeguran') }}',
                data: {
                    tahun: tahun,
                    bulan: bulan,
                    kode_kelas: kode_kelas,
                    _token: "{{ csrf_token() }}",
                },
                success: function(data) {
                    $('#loadTeguran').html(data);
                },
            });
        });
    });
</script>
