@php
    use Carbon\Carbon;
    $no = 1;
@endphp
@foreach ($buku as $s)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $s->judul }}</td>
        <td>{{ $s->pengarang }}</td>
        <td>{{ $s->penerbit }}</td>
        <td>{{ $s->tahun_terbit }}</td>
        <td>{{ $s->jumlah_stok }}</td>
        <td>{{ $s->jumlah_stok - $s->sisa_stok }}</td>
        <td>{{ $s->sisa_stok }}</td>
        <td>
            <a data-href="{{ route('deleteBuku', $s->kode_buku) }}" class="btn btn-sm btn-danger delete"><i
                    class="fa fa-trash"></i></a>
            <a href="{{ route('editBuku', $s->kode_buku) }}" class="btn btn-sm
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
