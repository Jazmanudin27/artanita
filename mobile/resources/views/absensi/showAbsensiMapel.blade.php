@if(count($siswa) > 0)
    <div class="siswa-absensi-container">
        @foreach ($siswa as $s)
            @php
                $bgColor = $s->status == 'A' ? '#fee2e2' : 
                          ($s->status == 'S' ? '#fef3c7' : 
                          ($s->status == 'I' ? '#e0f2fe' : '#dcfce7'));
                
                $textColor = $s->status == 'A' ? '#dc2626' : 
                           ($s->status == 'S' ? '#d97706' : 
                           ($s->status == 'I' ? '#0284c7' : '#16a34a'));
            @endphp
            
            <div class="card mb-2 shadow-sm border-0" style="border-radius: 14px; background: #ffffff; transition: transform 0.15s ease;">
                <div class="card-body p-3 d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-3">
                        <div class="avatar-icon d-flex align-items-center justify-content-center text-primary font-weight-bold" 
                             style="width: 42px; height: 42px; border-radius: 12px; background: #eff6ff; font-size: 1.1rem;">
                            {{ strtoupper(substr($s->nama_siswa, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-weight-bold text-dark" style="font-size: 0.92rem; line-height: 1.2;">{{ $s->nama_siswa }}</div>
                            <div class="text-muted" style="font-size: 0.75rem; margin-top: 3px;">
                                <span class="badge badge-light border text-secondary px-2 py-1" style="border-radius: 6px;">{{ $s->nama_kelas }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="status-select-wrapper">
                        <select class="form-control status-pill-select" data-kelas="{{ $s->kode_kelas }}" data-id="{{ $s->kode_siswa }}"
                                {{ (Auth::guard('kelas')->check() || Auth::guard('siswa')->check()) ? 'disabled' : '' }}
                                style="background-color: {{ $bgColor }}; color: {{ $textColor }}; border: 1.5px solid {{ $textColor }}; border-radius: 10px; font-weight: 700; font-size: 0.82rem; padding: 6px 12px; cursor: pointer; transition: all 0.2s ease;">
                            <option {{ $s->status == 'H' || !$s->status ? 'selected' : '' }} value="H" style="background:#fff; color:#16a34a;">Hadir</option>
                            <option {{ $s->status == 'S' ? 'selected' : '' }} value="S" style="background:#fff; color:#d97706;">Sakit</option>
                            <option {{ $s->status == 'I' ? 'selected' : '' }} value="I" style="background:#fff; color:#0284c7;">Izin</option>
                            <option {{ $s->status == 'A' ? 'selected' : '' }} value="A" style="background:#fff; color:#dc2626;">Alfa</option>
                        </select>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 16px; background: #ffffff;">
        <ion-icon name="book-outline" style="font-size: 48px; color: #94a3b8;"></ion-icon>
        <div class="font-weight-bold text-dark mt-2" style="font-size: 0.95rem;">Tidak ada data siswa</div>
        <div class="text-muted" style="font-size: 0.8rem;">Pilih tanggal, kelas, atau mapel lain untuk melihat data.</div>
    </div>
@endif

<script>
    $(document).ready(function() {
        $('.status-pill-select').change(function(e) {
            e.preventDefault();
            var kode_kelas = $(this).attr('data-kelas');
            var kode_siswa = $(this).attr('data-id');
            var tanggal = $('#tanggal').val();
            var kode_mapel = $('#kode_mapel').val();
            var status = $(this).val();
            var select = $(this);

            $.ajax({
                type: 'POST',
                url: '{{ route('createAbsensiMapel') }}',
                data: {
                    _token: "{{ csrf_token() }}",
                    tanggal: tanggal,
                    kode_kelas: kode_kelas,
                    kode_siswa: kode_siswa,
                    kode_mapel: kode_mapel,
                    status: status,
                },
                success: function() {
                    var bgColor, textColor;
                    if (status == 'A') {
                        bgColor = '#fee2e2';
                        textColor = '#dc2626';
                    } else if (status == 'S') {
                        bgColor = '#fef3c7';
                        textColor = '#d97706';
                    } else if (status == 'I') {
                        bgColor = '#e0f2fe';
                        textColor = '#0284c7';
                    } else {
                        bgColor = '#dcfce7';
                        textColor = '#16a34a';
                    }
                    select.css({
                        'background-color': bgColor,
                        'color': textColor,
                        'border-color': textColor
                    });

                    // Toast notification feedback
                    if (typeof Swal !== 'undefined') {
                        const Toast = Swal.mixin({
                            toast: true,
                            position: 'bottom-end',
                            showConfirmButton: false,
                            timer: 1500,
                            timerProgressBar: true
                        });
                        Toast.fire({
                            icon: 'success',
                            title: 'Status presensi mapel tersimpan'
                        });
                    }
                },
            });
        });
    });
</script>
