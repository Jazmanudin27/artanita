@php
    use Carbon\Carbon;
@endphp
@foreach ($siswa as $s)
    <tr>
        <td>{{ $no++ }}</td>
        <td>{{ $s->nis }}</td>
        <td>{{ $s->nama_siswa }}</td>
        <td>{{ $s->jk }}</td>
        <td>{{ $s->nama_kelas }}</td>
        <td>{{ $s->jurusan }}</td>
        <td>
            <a data-href="#" class="btn btn-sm btn-danger delete"><i class="fa fa-trash"></i></a>
            <a href="#" class="btn btn-smbtn-warning"><i class="fa fa-edit"></i></a>
        </td>
    </tr>
@endforeach
<script>
    $(document).ready(function() {

        $('.simpan').on("click", function(e) {
            var kode_siswa = $('#kode_siswa').val();
            var jenis_pembayaran = $('.jenis_pembayaran').html();
            var jumlah = $('.jumlah').val();
            var tanggal = $('.tanggal').val();
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ route('showSpp') }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    jumlah: jumlah,
                    jenis_pembayaran: jenis_pembayaran,
                    kode_siswa: kode_siswa,
                    tanggal: tanggal,
                },
                success: function(data) {
                    $('#showSpp').html(data);
                },
            });
        });

    });
</script>
