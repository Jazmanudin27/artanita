@if(count($siswa) > 0)
    <div class="rekap-mapel-container">
        @foreach ($siswa as $s)
            <div class="card mb-2 shadow-sm border-0" style="border-radius: 14px; background: #ffffff;">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center justify-content-between mb-2 pb-2 border-bottom">
                        <div class="d-flex align-items-center gap-2">
                            <div class="avatar-icon d-flex align-items-center justify-content-center text-primary font-weight-bold" 
                                 style="width: 36px; height: 36px; border-radius: 10px; background: #eff6ff; font-size: 0.95rem;">
                                {{ strtoupper(substr($s->nama_siswa, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-weight-bold text-dark" style="font-size: 0.9rem;">{{ $s->nama_siswa }}</div>
                                <div class="text-muted" style="font-size: 0.72rem;">NIS: {{ $s->nis ?: '-' }} • {{ $s->nama_kelas }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- Counter Badges -->
                    <div class="row text-center g-2 mt-1">
                        <div class="col-3">
                            <div class="p-2" style="background: #dcfce7; border-radius: 10px;">
                                <div class="font-weight-bold text-success" style="font-size: 1.1rem; line-height: 1;">{{ $s->total_hadir }}</div>
                                <div class="text-success font-weight-bold" style="font-size: 0.75rem; margin-top: 2px;">H</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2" style="background: #fef3c7; border-radius: 10px;">
                                <div class="font-weight-bold text-warning" style="font-size: 1.1rem; line-height: 1; color: #d97706 !important;">{{ $s->total_sakit }}</div>
                                <div class="font-weight-bold" style="font-size: 0.75rem; margin-top: 2px; color: #d97706 !important;">S</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2" style="background: #e0f2fe; border-radius: 10px;">
                                <div class="font-weight-bold text-info" style="font-size: 1.1rem; line-height: 1; color: #0284c7 !important;">{{ $s->total_izin }}</div>
                                <div class="font-weight-bold" style="font-size: 0.75rem; margin-top: 2px; color: #0284c7 !important;">I</div>
                            </div>
                        </div>
                        <div class="col-3">
                            <div class="p-2" style="background: #fee2e2; border-radius: 10px;">
                                <div class="font-weight-bold text-danger" style="font-size: 1.1rem; line-height: 1;">{{ $s->total_alfa }}</div>
                                <div class="text-danger font-weight-bold" style="font-size: 0.75rem; margin-top: 2px;">A</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@else
    <div class="card border-0 shadow-sm text-center p-4" style="border-radius: 16px; background: #ffffff;">
        <ion-icon name="document-text-outline" style="font-size: 48px; color: #94a3b8;"></ion-icon>
        <div class="font-weight-bold text-dark mt-2" style="font-size: 0.95rem;">Tidak ada rekap absensi mapel</div>
        <div class="text-muted" style="font-size: 0.8rem;">Pilih bulan, tahun, kelas, atau mapel lain.</div>
    </div>
@endif
