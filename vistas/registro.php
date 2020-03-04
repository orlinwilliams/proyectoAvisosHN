<!DOCTYPE html>
<html>

    <head>
        <meta charset="UTF-8">
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <title>Registrarse|AvisosHN</title>
        <!-- Favicon-->
        <link rel="icon" href="../../favicon.ico" type="image/x-icon">

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

    <body class="signup-page">
        <div class="signup-box">
            <div class="logo">
                <a href="javascript:void(0);">Avisos<b>HN</b></a>
                <small>Tu sitio de compra y venta favorito</small>
            </div>
            <div class="card">
                <div class="body">
                    <form id="sign_up" method="POST">
                        <div class="msg">Hazte nuevo miembro</div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">person</i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control" name="first-name" placeholder="Nombre" required autofocus>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">person</i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control" name="last-name" placeholder="Apellido" required autofocus>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">date_range</i>
                            </span>
                            <div class="form-line">
                                <input type="text" class="form-control date" placeholder="Ex: 30/07/2016">
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">email</i>
                            </span>
                            <div class="form-line">
                                <input type="email" class="form-control" name="email" placeholder="Correo electrónico" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">phone_iphone</i>
                            </span>
                            <div class="form-line">
                                <input type="text" name="phone" class="form-control mobile-phone-number" placeholder="Ex: +504 9999-9999">
                            </div>
                        </div>
                        <!-------------------------------------------------
                        ---------------------------------------------------

                        Inicio Aqui debe cargar los departamentos y municipios

                        ---------------------------------------------------
                        -------------------------------------------------->
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">place</i>
                            </span>
                            <div class="form-line">
                                    <select class="form-control show-tick">
                                    <!---------------------------------------------
                                    -----------------------------------------------
                                                    Inicio de codigo PHP
                                    -----------------------------------------------
                                    ---------------------------------------------->
                                    <?php
                                        include("../clases/conexion.php");
                                        $conexion = new conexion();
                                        $sql="SELECT iddepartamentos, nombredepartamento FROM `departamentos`
                                                ORDER by iddepartamentos ASC;";
                                        $resultado=$conexion->ejecutarInstruccion($sql);
                                        var_dump($resultado);
                                        if(!$resultado){
                                            echo "No hay municipios";
                                        }
                                        else{
                                            while($fila=$conexion->obtenerFila($resultado)){    /**Recorre todas las filas de departamentos */
                                                $iddepartamento=$fila["iddepartamentos"];
                                                echo '<optgroup label="'.$fila["nombredepartamento"].'">';
                                                $sql2="SELECT idmunicipios, municipio FROM `municipios`
                                                WHERE iddepartamentos=$iddepartamento
                                                ORDER by idmunicipios ASC;";
                                                $resultado2=$conexion->ejecutarInstruccion($sql2);
                                                if($resultado2){
                                                    while($fila2=$conexion->obtenerFila($resultado2)){ /**Recorre todas las filas de municipio según el departamento */
                                                        echo'<option value="'.$fila2["idmunicipios"].'">'.$fila2["municipio"].'</option>';
                                                    }
                                                }
                                            }
                                        }
                                    ?>
                                    <!---------------------------------------------
                                    -----------------------------------------------
                                                    Inicio de codigo PHP
                                    -----------------------------------------------
                                    ---------------------------------------------->
                                </select>
                            </div>
                        </div>
                        <!-------------------------------------------------
                        ---------------------------------------------------

                        Fin Aqui debe cargar los departamentos y municipios

                        ---------------------------------------------------
                        ------------------------------------------------->
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>
                            <div class="form-line">
                                <input type="password" class="form-control" name="password" minlength="6" placeholder="Contraseña" required>
                            </div>
                        </div>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="material-icons">lock</i>
                            </span>
                            <div class="form-line">
                                <input type="password" class="form-control" name="confirm" minlength="6" placeholder="Confirme contraseña" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="terms" id="terms" class="filled-in chk-col-pink">
                            <label for="terms">Acepto los <a href="javascript:void(0);">terminos de usuario</a>.</label>
                        </div>

                        <button class="btn btn-block btn-lg bg-pink waves-effect" type="submit">Registrarse</button>

                        <div class="m-t-25 m-b--5 align-center">
                            <a href="login.php">¿Ya eres miembro?</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Jquery Core Js -->
        <script src="../plugins/jquery/jquery.min.js"></script>

        <!-- Bootstrap Core Js -->
        <script src="../plugins/bootstrap/js/bootstrap.js"></script>

        <!-- Waves Effect Plugin Js -->
        <script src="../plugins/node-waves/waves.js"></script>

        <!-- Validation Plugin Js -->
        <script src="../plugins/jquery-validation/jquery.validate.js"></script>

        <!-- Input Mask Plugin Js -->
        <script src="../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

        <!-- Custom Js -->
        <script src="../js/admin.js"></script>
        <script src="../js/pages/examples/sign-up.js"></script>
    </body>

</html>