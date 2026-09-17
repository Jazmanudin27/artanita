@php
    use Carbon\Carbon;
    $no = 1;
@endphp
@foreach ($surat_absen as $s)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ Carbon::createFromFormat('Y-m-d', $s->tanggal)->format('d-M-Y') }}</td>
        <td>{{ $s->nama_guru }}</td>
        <td>{{ $s->jenis_absen }}</td>
        <td>{{ $s->deskripsi }}</td>
        <td>
            @if ($s->status == '2')
                <a class="btn btn-success btn-sm">Disetujui</a>
            @elseif ($s->status == '0')
                <a class="btn btn-danger btn-sm">Ditolak</a>
            @else
                <a data-id="{{ $s->id }}" class="btn btn-warning btn-sm approve">Pending</a>
            @endif
        </td>
        {{-- <td>
            <a data-href="{{ route('deleteSuratAbsen', $s->id) }}" class="btn btn-sm btn-danger delete"><i
                    class="fa fa-trash"></i></a>

            <a href="{{ route('editSuratAbsen', $s->id) }}" class="btn btn-sm
            btn-warning"><i
                    class="fa fa-edit"></i></a>
        </td> --}}
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

        $('.approve').on("click", function(e) {
            e.preventDefault();
            var id = $(this).attr('data-id');
            Swal.fire({
                title: 'Approval Surat Absen',
                text: "Apakah kamu yakin",
                icon: 'warning',
                showDenyButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Terima',
                denyButtonText: 'Tolak'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('approveSuratAbsen') }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            status: '2',
                        },
                        success: function(data) {
                            Swal.fire(
                                'Diterima',
                                'Surat Absen Diterima',
                                'success'
                            )
                            window.location.href = '{{ route('viewSuratAbsen') }}';
                        },
                    });
                } else if (result.isDenied) {
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('approveSuratAbsen') }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            status: '0',
                        },
                        success: function(data) {
                            Swal.fire(
                                'Ditolak',
                                'Surat Absen Ditolak',
                                'warning'
                            )
                            window.location.href = '{{ route('viewSuratAbsen') }}';
                        },
                    });

                }
            })
        });

    });
</script>
