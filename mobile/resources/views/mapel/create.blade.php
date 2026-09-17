@extends('frontend.template')
@section('titlepage', 'Form Tambah Mapel')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Tambah Data Mapel</div>
        <div class="right">

        </div>
    </div>
    <div id="appCapsule" class="full-height pt-5 mb-5">
        <div class="section pt-5">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('storeMapel') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">Nama Mapel</label>
                                <input type="text" name="nama_mapel" class="form-control" placeholder="Nama Siswa"
                                    required>
                            </div>
                        </div>
                        <div class="form-group basic">
                            <div class="input-wrapper">
                                <label class="label">KKM</label>
                                <input type="text" name="kkm" class="form-control" placeholder="KKM" required>
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

        });
    </script>
@endsection
