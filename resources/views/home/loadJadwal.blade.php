<table class="table table-striped table-bordered">
    <tbody style="color:black">
        <tr style="color:black">
            <th style="text-align: center" colspan="2">WAKTU</th>
            <th style="text-align: center" colspan="{{ $jmlKelas }}">KELAS</th>
        </tr>
        <tr style="color:black">
            <th style="width: 10px;text-align: center">JAM</th>
            <th style="width: 130px;text-align: center">DARI - SAMPAI</th>
            @foreach ($kelas as $k)
                <th style="text-align: center">{{ $k->nama_kelas }}</th>
            @endforeach
        </tr>
        @foreach ($jamKe as $j)
            <tr style="color:black">
                <td style="text-align: center" class="jamKe">{{ $j->jam_ke }}</td>
                <td style="text-align: center">
                    {{ $j->jam }}
                </td>
                @foreach ($kelas as $kel)
                    @php
                        $jadwal = DB::table('jadwal')
                            ->join('mapel_guru', 'mapel_guru.kode_guru_mapel', 'jadwal.kode_guru_mapel')
                            ->join('guru', 'guru.kode_guru', 'mapel_guru.kode_guru')
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
                        <td></td>
                    @endif
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
<script>
    $(document).ready(function() {


    });
</script>
