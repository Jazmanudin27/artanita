<table class="table table-striped table-bordered">
    <tbody style="color:black">
        <tr style="color:black">
            <th colspan="2">WAKTU</th>
            <th colspan="{{ $jmlKelas }}">KELAS</th>
        </tr>
        <tr style="color:black">
            <th style="width: 10px">JAM</th>
            <th style="width: 130px">DARI - SAMPAI</th>
            @foreach ($kelas as $k)
                <th>{{ $k->nama_kelas }}</th>
            @endforeach
        </tr>
        @foreach ($jamKe as $j)
            <tr style="color:black">
                <td style="text-align: center" class="jamKe">{{ $j->jam_ke }}</td>
                <td style="text-align: center"><input style="color:black" type="text" data-kode="{{ $j->kode_jam }}"
                        class="form-control updateJam" value="{{ $j->jam }}">
                </td>
                @foreach ($kelas as $kel)
                    <td>
                        @php
                            $jadwal = DB::table('jadwal')
                                ->where('jadwal.kode_jam', $j->kode_jam)
                                ->where('jadwal.kode_kelas', $kel->kode_kelas)
                                ->where('jadwal.hari', $hari)
                                ->first();
                        @endphp
                        @if ($jadwal)
                            <select class="form-control updateJadwal" style="color:black">
                                @foreach ($guru as $m)
                                    <option {{ $jadwal->kode_guru_mapel == $m->kode_guru_mapel ? 'selected' : '' }}
                                        data-kode="{{ $jadwal->kode_jadwal }}" data-id="{{ $m->kode_guru_mapel }}"
                                        data-kelas="{{ $kel->kode_kelas }}" data-jam="{{ $j->kode_jam }}">
                                        {{ $m->no_urut }} ( {{ $m->nama_mapel }} )
                                    </option>
                                @endforeach
                            </select>
                        @else
                            <select class="form-control simpanJadwal" style="color:black">
                                <option value="">-</option>
                                @foreach ($guru as $m)
                                    <option data-guru="{{ $m->kode_guru }}" data-nama="{{ $kel->nama_kelas }}"
                                        data-kelas="{{ $kel->kode_kelas }}" data-jam="{{ $j->kode_jam }}"
                                        data-id="{{ $m->kode_guru_mapel }}" value="{{ $m->kode_guru_mapel }}">
                                        {{ $m->no_urut }} ( {{ $m->nama_mapel }} )
                                    </option>
                                @endforeach
                            </select>
                        @endif
                    </td>
                @endforeach
            </tr>
        @endforeach
    </tbody>
</table>
<br>
<br>
@php
    $guru = DB::table('guru')
        ->where('guru.kode_member', Auth::user()->kode_member)
        ->whereRaw("guru.no_urut IS NOT NULL")
        ->orderByRaw('CAST(no_urut AS UNSIGNED) ASC')
        ->get();
@endphp
<table class="table table-striped table-bordered" style="width:70%">
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

<script>
    $(document).ready(function() {

        $('.updateJadwal').on("change", function(e) {
            e.preventDefault();
            var kode_jadwal = $('option:selected', this).data('kode');
            var hari = $('#hari').val();
            var kode_jam = $('option:selected', this).data('jam');
            var kode_guru_mapel = $('option:selected', this).data('id');
            var kode_kelas = $('option:selected', this).data('kelas');
            $.ajax({
                type: 'POST',
                url: '{{ route('cekData') }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_guru_mapel: kode_guru_mapel,
                    hari: hari,
                    kode_jam: kode_jam,
                },
                success: function(data) {
                    if (data == 0) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('updateJadwal') }}',
                            data: {
                                _token: "{{ csrf_token() }}",
                                kode_jadwal: kode_jadwal,
                                kode_guru_mapel: kode_guru_mapel,
                            },
                            success: function(data) {},
                        });
                    } else {
                        Swal.fire(
                            'Opps..',
                            'Guru tidak boleh dalam waktu yang sama',
                            'warning'
                        )
                    }
                },
            });

        });



        $('.simpanJadwal').on("change", function(e) {
            e.preventDefault();
            var hari = $('#hari').val();
            var kode_jam = $('option:selected', this).data('jam');
            var kode_guru_mapel = $('option:selected', this).data('id');
            var kode_kelas = $('option:selected', this).data('kelas');
            $.ajax({
                type: 'POST',
                url: '{{ route('cekData') }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_guru_mapel: kode_guru_mapel,
                    hari: hari,
                    kode_jam: kode_jam,
                },
                success: function(data) {
                    if (data == 0) {
                        $.ajax({
                            type: 'POST',
                            url: '{{ route('simpanJadwal') }}',
                            data: {
                                _token: "{{ csrf_token() }}",
                                kode_guru_mapel: kode_guru_mapel,
                                hari: hari,
                                kode_kelas: kode_kelas,
                                kode_jam: kode_jam,
                            },
                            success: function(data) {},
                        });
                    } else {
                        Swal.fire(
                            'Opps..',
                            'Guru tidak boleh mengajar dalam waktu yang sama',
                            'warning'
                        )
                    }
                },
            });

        });

        $('.updateJam').on("input", function(e) {
            e.preventDefault();
            var jam = $(this).val();
            var kode_jam = $(this).attr('data-kode');
            $.ajax({
                type: 'POST',
                url: '{{ route('updateJam') }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_jam: kode_jam,
                    jam: jam,
                },
                success: function(data) {},
            });
        });

    });
</script>
