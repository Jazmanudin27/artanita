@foreach ($siswa as $s)
    <div class="card mt-1 mb-1">
        <div class="card-body">
            <ul class="listview flush transparent no-line image-listview detailed-list">
                <li>
                    <a href="{{ route('editSiswa', $s->kode_siswa) }}" class="item">
                        <div class="in">
                            <div>
                                <strong>{{ $s->nama_siswa }}</strong>
                                <div class="text-small text-secondary">{{ $s->nisn }}</div>
                                <span>{{ $s->nama_kelas }}</span>
                            </div>
                            <div class="text-end">
                                {{ $s->jk }}
                            </div>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
@endforeach
<script>
    $(document).ready(function() {


    });
</script>
