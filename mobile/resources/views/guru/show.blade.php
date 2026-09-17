@foreach ($guru as $s)
    <div class="card mt-1 mb-1">
        <div class="card-body">
            <ul class="listview flush transparent no-line image-listview detailed-list">
                <li>
                    <a href="{{ route('editGuru', $s->kode_guru) }}" class="item">
                        <div class="in">
                            <div>
                                <strong>{{ $s->nama_guru }}</strong>
                                <div class="text-small text-secondary">{{ $s->nip_nuptk }}</div>
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
