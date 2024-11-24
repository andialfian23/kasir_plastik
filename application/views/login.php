<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LOGIN</title>

    <link rel="icon" type="image/png" sizes="16x16" href="<?= base_url() ?>images/pdmanplas.png">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="<?= base_url() ?>AdminLTE_3/plugins/fontawesome-free/css/all.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="<?= base_url() ?>AdminLTE_3/dist/css/adminlte.min.css">
    <!-- jQuery -->
    <script src="<?= base_url() ?>AdminLTE_3/plugins/jquery/jquery.min.js"></script>
    <style>
    .login-page {
        background-color: #343a40;
    }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-success" style='margin-top:-100px !important;'>
            <div class="card-header text-center">
                <img src="<?= base_url() ?>images/pdmanplas.png" alt="PD. Mandiri Plastik" width='50%'
                    style='margin-top:-30px !important;' />
                <p style='margin-top:-20px;font-size:20px;'>
                    <b>PD. Mandiri Plastik</b>
                </p>
            </div>
            <div class="card-body">

                <p class="login-box-msg" style="font-weight:bold;">Masukkan Username & Password</p>
                <!-- <form action="#"> -->
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Username" id="username" autofocus />
                    <div class="input-group-append">
                        <div class="input-group-text" id='icon-user'>
                            <span class="fas fa-user"></span>
                        </div>
                    </div>
                </div>
                <div class="input-group mb-3">
                    <input type="password" class="form-control" placeholder="Password" id="password" />
                    <div class="input-group-append">
                        <div class="input-group-text" id='icon-pass'>
                            <span class="fas fa-lock"></span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- /.col -->
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary btn-block" id="btn_login">LOGIN</button>
                    </div>
                    <!-- /.col -->
                </div>
                <!-- </form> -->


            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <script>
    var base_url = window.location.origin + '/Kasir/';

    function login() {
        $('.login-box-msg').removeClass('text-danger');
        $('.login-box-msg').html('Masukkan Username dan Password');
        $('input').removeClass('border-danger');
        $('.input-group-text').removeClass('border border-danger bg-danger');

        if ($('#username').val() == '') {
            $('.login-box-msg').addClass('text-danger');
            $('.login-box-msg').html('Username Masih Kosong');
            $('#username').addClass('border border-danger');
            $('#icon-user').addClass('border border-danger bg-danger');
            return false;
        }

        if ($('#password').val() == '') {
            $('.login-box-msg').addClass('text-danger');
            $('.login-box-msg').html('Password Masih Kosong');
            $('#password').addClass('border border-danger');
            $('#icon-pass').addClass('border border-danger bg-danger');
            return false;
        }

        $.ajax({
            url: base_url + 'Auth/login',
            type: 'POST',
            data: {
                username: $('#username').val(),
                password: $('#password').val()
            },
            dataType: 'json',
            success: function(res) {
                if (res.kode == 0) {
                    $('.login-box-msg').addClass('text-danger');
                    $('.login-box-msg').removeClass('text-success');
                } else {
                    $('.login-box-msg').addClass('text-success');
                }
                $('.login-box-msg').html(res.pesan);
            }
        });
    }

    $(document).on('keydown', '#username,#password', function(event) {
        if (event.key === 'Enter') {
            login();
        }
    })

    $(document).on('click', '#btn_login', function() {
        login()
    });
    </script>

    <!-- jQuery -->
    <script src="<?= base_url() ?>AdminLTE_3/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="<?= base_url() ?>AdminLTE_3/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= base_url() ?>AdminLTE_3/dist/js/adminlte.min.js"></script>
</body>

</html>