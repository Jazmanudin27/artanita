@php
    use Carbon\Carbon;
    $no = 1;
@endphp
@foreach ($absensi_mapel as $s)
    @php
        if ($s->status == 'A') {
            $button = 'btn-danger';
        } elseif ($s->status == 'S') {
            $button = 'btn-warning';
        } else {
            $button = 'btn-primary';
        }
    @endphp
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $s->nisn }}</td>
        <td>{{ $s->nama_siswa }}</td>
        <td>{{ $s->jk }}</td>
        <td>{{ $s->nama_kelas }}</td>
        <td>{{ $s->tanggal }}</td>
        <td style="text-align: center">
            <a href="#" class="btn btn-sm {{ $button }}">
                {{ $s->status }}
            </a>
        </td>
     
    </tr>
@endforeach

<script>
    $(document).ready(function() {

        $('.delete').on("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = $(this).attr('data-href');
                    Swal.fire(
                        'Deleted!',
                        'Your file has been deleted.',
                        'success'
                    )
                }
            })
        });

    });
</script>
