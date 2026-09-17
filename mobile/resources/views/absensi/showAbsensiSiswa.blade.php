@foreach ($siswa as $s)
    @php
        $color = $s->status == 'A' ? 'red' : ($s->status == 'S' ? 'orange' : ($s->status == 'I' ? 'green' : 'black'));
    @endphp
    <ul class="listview flush transparent no-line image-listview detailed-list mt-1 mb-1">
        <li>
            <a class="item">
                <div class="in">
                    <div>
                        <strong>{{ $s->nama_siswa }}</strong>
                        <div class="text-small text-secondary">{{ $s->nama_kelas }}</div>
                    </div>
                    <div class="text-end" style="zoom: 80%">
                        <select class="form-control status" data-kelas="{{ $s->kode_kelas }}"
                            data-id="{{ $s->kode_siswa }}" style="color:{{ $color }}">
                            <option {{ $s->status == 'H' ? 'selected' : '' }} value="H">Hadir</option>
                            <option {{ $s->status == 'S' ? 'selected' : '' }} value="S">Sakit</option>
                            <option {{ $s->status == 'I' ? 'selected' : '' }} value="I">Izin</option>
                            <option {{ $s->status == 'A' ? 'selected' : '' }} value="A">Alfa</option>
                        </select>
                    </div>
                </div>
            </a>
        </li>
    </ul>
@endforeach
<script>
    $(document).ready(function() {

        $('.status').change(function(e) {
            e.preventDefault();
            var kode_kelas = $(this).attr('data-kelas');
            var kode_siswa = $(this).attr('data-id');
            var tanggal = $('#tanggal').val();
            var status = $(this).val();
            var select = $(this);

            $.ajax({
                type: 'POST',
                url: '{{ route('createAbsensiSiswa') }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    tanggal: tanggal,
                    kode_kelas: kode_kelas,
                    kode_siswa: kode_siswa,
                    status: status,
                },
                success: function() {
                    var color;
                    if (status == 'A') {
                        color = 'red';
                    } else if (status == 'S') {
                        color = 'orange';
                    } else if (status == 'I') {
                        color = 'green';
                    } else {
                        color = 'black';
                    }
                    select.css('color', color);
                },
            });
        });

    });
</script>
