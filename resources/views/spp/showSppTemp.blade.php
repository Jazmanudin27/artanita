@php
    use Carbon\Carbon;
@endphp
@foreach ($spp as $s)
    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $s->bulan }}</td>
        <td>{{ $s->tahun }}</td>
        <td style="text-align: right">{{ number_format($s->jumlah) }}</td>
        <td style="text-align: right">
            <a href="#" data-id="{{ $s->id }}" class="btn btn-sm btn-danger hapus"><i
                    class="fa fa-trash"></i></a>
        </td>
    </tr>
@endforeach
<script>
    $(document).ready(function() {

        function showSppTemp() {
            var kode_siswa = $('#kode_siswa').val();
            $.ajax({
                type: 'POST',
                url: '{{ route('showSppTemp') }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    kode_siswa: kode_siswa,
                },
                success: function(data) {
                    $('#showSppTemp').html(data);
                },
            });
        }

        $('.hapus').on("click", function(e) {
            var id = $(this).attr('data-id');
            e.preventDefault();
            $.ajax({
                type: 'POST',
                url: '{{ route('deleteSppTemp') }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    id: id,
                },
                success: function(data) {
                    showSppTemp();
                },
            });
        });

    });
</script>
