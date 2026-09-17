@foreach ($mapel as $s)
    <div class="card mt-1 mb-1">
        <div class="card-body">
            <ul class="listview flush transparent no-line image-listview detailed-list">
                <li>
                    <a href="{{ route('editMapel', $s->kode_mapel) }}" class="item">
                        <div class="in">
                            <div>
                                <strong>{{ $s->nama_mapel }}</strong>
                                <div class="text-small text-secondary">{{ $s->kkm }}</div>
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
