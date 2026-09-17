@php
    use Carbon\Carbon;
    $no = 1;
@endphp
@foreach ($absensi_siswa as $s)

    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $s->nisn }}</td>
        <td>{{ $s->nama_siswa }}</td>
        <td>{{ $s->jk }}</td>
        <td>{{ $s->nama_kelas }}</td>
    </tr>
@endforeach
