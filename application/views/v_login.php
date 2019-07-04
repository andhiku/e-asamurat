<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title; ?></title>
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <!--<link rel="shortcut icon" type="image/png" href="<?php echo base_url(); ?>assets/images/logo-icon.png"/>-->
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/login/normalize.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/login/style.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/fontawesome/css/font-awesome.min.css">
        <link rel="stylesheet" href="<?php echo base_url(); ?>assets/dist/css/AdminLTE.css">
        <style type="text/css" media="screen">
            .lg-login {margin-right: auto; margin-left: auto;}
            .head-login {border-top: #A14617 5px solid;}
            .powered { color: #A6782A; margin-top: 12.5%;}
            .italic-small {font-size:12px; font-style:italic;}

            /*canvas*/
            #large-header{
                position: absolute;
                z-index: -1;
            }
            .large-header{
                margin: -100px 0 0 0;
                position: fixed;
            }
            img{
                width: 80px;
                /*border: 2px dotted lawngreen;*/
            }
        </style>
    </head>
    <body class="login-page">
        <div id="large-header" class="large-header" style="height: 200%;">
            <canvas id="demo-canvas" ></canvas>
        </div>
        <div class="login-box">
            <div class="login-logo">
                <!--<img src="< ?= base_url(); ?>assets/images/bjb.png">-->
                <!--<H4>PEMERINTAH KOTA BANJARBARU</h4>-->
                <img style="width: 25%" src="<?= base_url(); ?>assets/images/logo-ams.png">
                <h5 style="color: white; font-weight: bold;">APLIKASI MANAJEMEN SURAT</h5>
                <h5 style="color: white; ">BADAN PENANGGULANGAN BENCANA DAERAH<br>KOTA BANJARBARU</h5>
            </div>
            <div class="login-box-body head-login">
                <div id="progrr" style="text-align: center"></div>
                <form id="login"  action="" method="post">
                    <div class="form-group has-feedback">
                        <label>Username </label>
                        <input type="text" class="form-control" placeholder="*Masukkan Username" name="username" autocomplete="off" autofocus>
                        <span class="glyphicon glyphicon-user form-control-feedback"></span>
                    </div>
                    <div class="form-group has-feedback">
                        <label>Password </label>
                        <input type="password" class="form-control" placeholder="*Masukkan Password" name="passlogin" autofocus>
                        <span class="glyphicon glyphicon-lock form-control-feedback"></span>
                    </div>
                    <div class="row">
                        <div class="col-xs-4  pull-right">
                            <button type="submit" class="btn btn-warning btn-block btn-flat">Login</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <script src="<?php echo base_url(); ?>assets/dist/js/jquery.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/dist/js/jquery.validate.min.js" type="text/javascript"></script>
        <script src="<?php echo base_url(); ?>assets/bootstrap/js/bootstrap.min.js"></script>
        <script type="text/javascript">
            jQuery(function ($) {
                $.validator.setDefaults({
                    submitHandler: function () {
                        login();
                    }
                });
                $().ready(function () {
                    $("#login").validate({
                        errorElement: 'div',
                        errorClass: 'help-block italic-small',
                        focusInvalid: true,
                        rules: {
                            username: {
                                required: true,
                                number: false
                            },
                            passlogin: {
                                required: true
                            }
                        },
                        messages: {
                            username: "Mohon isi Username Pegawai!",
                            passlogin: "Mohon isi Password anda!"
                        },
                        highlight: function (e) {
                            $(e).closest('.form-group').removeClass('has-info').addClass('has-error');
                        },
                        success: function (e) {
                            $(e).closest('.form-group').removeClass('has-error');
                            $(e).remove();
                        }
                    })
                });
                function login() {
                    $("#progrr").html('<h3 style="color:white"><i class="fa fa-spinner icon-spinner"></i></h3>');

                    $.post('<?php echo site_url(); ?>login/act_login', $("form").serialize(), function (hasil) {
                        $('form input[type="text"],form input[type="password"]');
                        $("#progrr").html(hasil);
                    });
                }
            });
        </script>
        <script type="text/javascript" src="<?php echo base_url(); ?>assets/dist/js/jquery.backstretch.min.js"></script>
        <script>
//            $.backstretch("<?php echo base_url(); ?>assets/images/bg.jp", {speed: 100});
        </script> 
        <script src="<?php echo base_url(); ?>assets/dist/js/login/TweenLite.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/dist/js/login/EasePack.min.js"></script>
        <script src="<?php echo base_url(); ?>assets/dist/js/login/rAF.js"></script>
        <script src="<?php echo base_url(); ?>assets/dist/js/login/index.js"></script>
    </body>
</html>
