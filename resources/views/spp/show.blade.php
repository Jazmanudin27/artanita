@php
    use Carbon\Carbon;
@endphp
@foreach ($spp as $s)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $s->tanggal }}</td>
        <td>{{ $s->nama_siswa }}</td>
        <td>{{ $s->nama_kelas }}</td>
        <td>{{ $s->nama_lengkap }}</td>
        <td>{{ $s->created_at }}</td>
        <td style="text-align: right">
            <a href="#" class="btn btn-danger btn-primary"><i class="fa fa-trash"></i></a>
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
