@php
    use Carbon\Carbon;
    $no = 1;
@endphp
@foreach ($peminjaman as $s)
    @php
        if ($s->tgl_dikembalikan == '') {
            $status = 'Belum dikembalikan';
            $tglkembali = '';
            $button = 'btn-sm btn-warning';
        } else {
            if ($s->tgl_dikembalikan <= $s->tgl_kembali) {
                $tglkembali = $s->tgl_dikembalikan;
                $status = 'Tepat Waktu';
                $button = 'btn-sm btn-primary';
            } else {
                $tglkembali = $s->tgl_dikembalikan;
                $status = 'Terlambat';
                $button = 'btn-sm btn-danger';
            }
        }
    @endphp
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $s->nama_siswa }} ( {{ $s->nama_kelas }} )</td>
        <td>{{ $s->judul }}</td>
        <td><b>{{ $s->tanggal }}</b> s/d <b>{{ $s->tgl_kembali }}</b></td>
        <td>{{ $tglkembali }}</td>
        <td> <a href="#" class="btn {{ $button }}" data-kode="{{ $s->kode_buku }}"
                data-stok="{{ $s->sisa_stok }}" data-id="{{ $s->id }}">{{ $status }}</a></td>
        <td style="text-align: right;width:{{ $s->tgl_dikembalikan == '' ? '160px' : '' }}">
            @if ($s->tgl_dikembalikan == '')
                <a href="#" class="btn btn-sm btn-primary pengembalianBuku" data-kode="{{ $s->kode_buku }}"
                    data-stok="{{ $s->sisa_stok }}" data-id="{{ $s->id }}"><i class="fa fa-check"></i></a>
                {{-- <a href="#" class="btn btn-sm btn-success perpanjangWaktu" data-kode="{{ $s->kode_buku }}"
                    data-stok="{{ $s->sisa_stok }}" data-id="{{ $s->id }}"><i class="fa fa-plus"></i></a> --}}
                <a data-href="{{ route('deletePeminjaman', $s->id) }}" data-kode="{{ $s->kode_buku }}"
                    data-stok="{{ $s->sisa_stok }}" data-id="{{ $s->id }}"
                    class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>
                <a href="{{ route('editPeminjaman', $s->id) }}" class="btn btn-sm btn-warning"><i
                        class="fa fa-edit"></i></a>
            @elseif ($s->tgl_dikembalikan == Date('Y-m-d'))
                <a href="#" class="btn btn-sm btn-danger batalDikembalikan" data-kode="{{ $s->kode_buku }}"
                    data-stok="{{ $s->sisa_stok }}" data-id="{{ $s->id }}"><i class="fa fa-times"></i></a>
            @endif

        </td>
    </tr>
@endforeach
<script>
    $(document).ready(function() {

        $('.pengembalianBuku').on("click", function(e) {
            e.preventDefault();
            $('#modalPengembalian').modal("show");
            var id = $(this).attr('data-id');
            var kode = $(this).attr('data-kode');
            var stok = $(this).attr('data-stok');
            $('#kode_buku').val(kode);
            $('#id').val(id);
            $('#stok').val(stok);
        });

        $('.batalDikembalikan').on("click", function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Batal Dikembalikan',
                text: "Apakah kamu yakin akan dibatalkan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Batalkan'
            }).then((result) => {
                if (result.isConfirmed) {
                    var id = $(this).attr('data-id');
                    var kode = $(this).attr('data-kode');
                    var stok = $(this).attr('data-stok');
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('batalDikembalikan') }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            kode_buku: kode,
                            stok: stok,
                        },
                        success: function(data) {
                            window.location.href = '{{ route('viewPeminjaman') }}';
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        },
                    });
                }
            })
        });

        $('.perpanjangWaktu').on("click", function(e) {
            e.preventDefault();
            $('#modalPerpanjang').modal("show");
            var id = $(this).attr('data-id');
            $('#id_peminjaman').val(id);
        });

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
                    var id = $(this).attr('data-id');
                    var kode = $(this).attr('data-kode');
                    var stok = $(this).attr('data-stok');
                    $.ajax({
                        type: 'POST',
                        url: '{{ route('deletePeminjaman') }}',
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: id,
                            kode_buku: kode,
                            stok: stok,
                        },
                        success: function(data) {
                            window.location.href = '{{ route('viewPeminjaman') }}';
                            Swal.fire(
                                'Deleted!',
                                'Your file has been deleted.',
                                'success'
                            )
                        },
                    });
                }
            })
        });

    });
</script>
