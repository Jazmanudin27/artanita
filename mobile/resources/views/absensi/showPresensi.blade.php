@foreach ($absensi as $a)
    <a href="#" class="item">
        <div class="detail">
            <ion-icon name="finger-print-outline" class="icon" style="font-size: 35px;padding-right:15px"></ion-icon>
            <div>
                <strong>{{ strftime('%A, %e %B %Y', strtotime($a->tanggal)) }}</strong>
                <span style="color: {{ $a->jam_in ?: 'red' }}">{{ $a->jam_in ?: 'Belum Scan' }} - </span>
                <span style="color: {{ $a->jam_out ?: 'red' }}">{{ $a->jam_out ?: 'Belum Scan' }}</span>
            </div>
        </div>
        <div class="right">
            <div class="price text-danger"></div>
        </div>
    </a>
@endforeach
<script>
    $(document).ready(function() {


    });
</script>
