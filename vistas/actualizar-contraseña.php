﻿<?php 
    session_start();
    if(!isset($_SESSION["correo"])){
        header("location:../index.php");
    }
 ?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Recuperar contraseña | MarketHN</title>
    <!-- Favicon-->
    <link rel="icon" href="../favicon.ico" type="image/x-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

    <!-- Bootstrap Core Css -->
    <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

    <!-- Waves Effect Css -->
    <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

    <!-- Animation Css -->
    <link href="../plugins/animate-css/animate.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">
</head>

<body class="fp-page">
    <div class="fp-box">
        <div class="logo">
            <a href="javascript:void(0);">Market<b>HN</b></a>
            <small>La mejor plataforma para publicar tus artículos de Honduras</small>
        </div>
        <div class="card">
            <div class="body">
                <form id="recuperar_contraseña">
                    <div class="msg">
                        Por favor ingrese una nueva contraseña.
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" id="txt_contraseña_1" class="form-control" name="password2" placeholder="Nueva contraseña" required>
                        </div>
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">
                            <i class="material-icons">lock</i>
                        </span>
                        <div class="form-line">
                            <input type="password" id="txt_contraseña_2" class="form-control" name="confirm" placeholder="Confirmar contraseña" required>
                        </div>
                    </div>

                    <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit" id="enviar">Cambiar contraseña</button>

                    <div class="row m-t-20 m-b--5 align-center">    
                        <a href="../index.php">Inicia sesión!</a>
                    </div>
                </form>
            </div>
            <!--Modal con el mensaje de respuesta-->
            <div class="modal fade" id="ModalMensaje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true ">
                <div class="modal-dialog modal-dialog-centered" role="document ">
                <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Mensaje</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true ">&times;</span>
                    </button>
                    </div>
                    <div class="modal-body" id="cuerpoModal">
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Jquery Core Js -->
    <script src="../plugins/jquery/jquery.min.js"></script>
        
    <!-- Validation Plugin Js -->
    <script src="../plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../plugins/bootstrap/js/bootstrap.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../plugins/node-waves/waves.js"></script>

    <!-- Custom Js -->
    <script src="../js/admin.js"></script>
    <script src="../controlador/actualizar-contraseña.js"></script>
</body>

</html>