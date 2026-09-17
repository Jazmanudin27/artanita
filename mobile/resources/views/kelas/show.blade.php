@foreach ($kelas as $s)
    <div class="card mt-1 mb-1">
        <div class="card-body">
            <ul class="listview flush transparent no-line image-listview detailed-list">
                <li>
                    <a href="{{ route('editKelas', $s->kode_kelas) }}" class="item">
                        <div class="in">
                            <div>
                                <strong>{{ $s->nama_kelas }}</strong>
                                <div class="text-small text-secondary">{{ $s->jurusan }}</div>
                                <span>{{ $s->nama_guru }}</span>
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
