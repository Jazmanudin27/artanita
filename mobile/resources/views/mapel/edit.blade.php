@extends('frontend.template')
@section('titlepage', 'Form Edit Mapel')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Form Edit Mapel</div>
        <div class="right">
            <a data-href="{{ route('deleteMapel', $mapel->kode_mapel) }}" class="headerButton" id="delete">
                <ion-icon name="trash-outline"></ion-icon>
            </a>
        </div>
    </div>
    <div id="appCapsule" class="full-height pt-5 mb-5">
        <div class="section pt-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('updateMapel') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Nama Mapel</label>
                                <input type="hidden" name="kode_mapel" value="{{ $mapel->kode_mapel }}"
                                    class="form-control" placeholder="Kode Siswa" required>
                                <input type="text" name="nama_mapel" value="{{ $mapel->nama_mapel }}"
                                    class="form-control" placeholder="Nama Siswa" required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">KKM</label>
                                <input type="text" name="kkm" value="{{ $mapel->kkm }}" class="form-control"
                                    placeholder="KKM" required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <button type="submit" class="btn btn-primary btn-block">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <br>
    <script>
        $(document).ready(function() {
            $('#delete').on("click", function(e) {
                e.preventDefault();
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = $(this).attr('data-href');
                        Swal.fire(
                            'Deleted!',
                            'Your file has been deleted.',
                            'success'
                        )
                    }
                })
            });
        });
    </script>
@endsection
