@extends('frontend.template')
@section('titlepage', 'Data Settings')
@section('contents')
    <div class="appHeader">
        <div class="left">
            <a href="#" class="headerButton goBack">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">
            Settings
        </div>
        <div class="right">
        </div>
    </div>
    <div id="appCapsule">

        <div class="listview-title mt-2"></div>
        <div class="listview-title mt-5">Profile Settings</div>
        <ul class="listview image-listview text inset">
            <li>
                <a href="#" class="item" id="updateEmails">
                    <div class="in">
                        <div>Update E-mail</div>
                    </div>
                </a>
            </li>
        </ul>

        <div class="listview-title mt-1">Security</div>
        <ul class="listview image-listview text mb-2 inset">
            <li>
                <a href="#" class="item" id="updatePasswords">
                    <div class="in">
                        <div>Update Password</div>
                    </div>
                </a>
            </li>
            <li>
                <a href="{{ route('signOut') }}" class="item">
                    <div class="in">
                        <div>Log out</div>
                    </div>
                </a>
            </li>
        </ul>
    </div>
    <div class="modal fade action-sheet" id="modalEmail" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Email</h5>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content">
                        <form>
                            <div class="form-group basic">
                                <div class="input-group">
                                    <input type="email" class="form-control" value="" placeholder="Email"
                                        id="email">
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-group">
                                    <a href="#" class="btn btn-primary btn-block" id="updateEmail">Simpan</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade action-sheet" id="modalPassword" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Ubah Password</h5>
                </div>
                <div class="modal-body">
                    <div class="action-sheet-content">
                        <form>
                            <div class="form-group basic">
                                <div class="input-group">
                                    <input type="password" class="form-control" placeholder="Password" id="password">
                                </div>
                            </div>
                            <div class="form-group basic">
                                <div class="input-group">
                                    <a href="#" class="btn btn-primary btn-block" id="updatePassword">Simpan</a>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {

            $('#updateEmails').click(function(e) {
                e.preventDefault();
                $('#modalEmail').modal("show");
            });

            $('#updatePasswords').click(function(e) {
                e.preventDefault();
                $('#modalPassword').modal("show");
            });

            $('#updateEmail').click(function(e) {
                e.preventDefault();
                var email = $('#email').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('updateEmail') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        email: email,
                    },
                    success: function() {
                        location.reload();
                    },
                });
            });

            $('#updatePassword').click(function(e) {
                e.preventDefault();
                var password = $('#password').val();
                $.ajax({
                    type: 'POST',
                    url: '{{ route('updatePassword') }}',
                    data: {
                        _token: "{{ csrf_token() }}",
                        password: password,
                    },
                    success: function() {
                        location.reload();
                    },
                });
            });

        });
    </script>

@endsection
