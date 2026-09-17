@php
    use Carbon\Carbon;
    $no = 1;
@endphp
@foreach ($surat_dispensasi as $s)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ Carbon::createFromFormat('Y-m-d', $s->tanggal)->format('d-M-Y') }}</td>
        <td>{{ $s->nama_siswa }}</td>
        <td>{{ $s->nama_kelas }}</td>
        <td>{{ $s->jurusan }}</td>
        <td>{{ $s->deskripsi }}</td>
        <td>
            {{-- <a data-href="{{ route('deleteSuratDispensasi', $s->id) }}" class="btn btn-sm btn-danger delete"><i
                    class="fa fa-trash"></i></a> --}}
            <a href="{{ route('editSuratDispensasi', $s->id) }}" class="btn btn-sm
            btn-warning"><i
                    class="fa fa-edit"></i></a>
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
