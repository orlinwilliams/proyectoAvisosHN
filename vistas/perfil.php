<?php
session_start();
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <title>Perfil | MarketHN</title>
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
    <!-- noUISlider Css -->
    <link href="../plugins/nouislider/nouislider.min.css" rel="stylesheet" /> 
    <!-- Sweetalert Css -->
    <link href="../plugins/sweetalert/sweetalert.css" rel="stylesheet" />

    <!-- Custom Css -->
    <link href="../css/style.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
    <link href="../css/estilos.css" rel="stylesheet">
    <link href="../css/font.css" rel="stylesheet">

    <!-- estrellas Css -->
    <link href="../plugins/star/css/starrr.css" rel="stylesheet" />
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />

    <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
    <link href="../css/themes/all-themes.css" rel="stylesheet" />
</head>

<body class="theme-black">
    <!-- Page Loader -->
    <div class="page-loader-wrapper">
        <div class="loader">
            <div class="preloader">
                <div class="spinner-layer pl-red">
                    <div class="circle-clipper left">
                        <div class="circle"></div>
                    </div>
                    <div class="circle-clipper right">
                        <div class="circle"></div>
                    </div>
                </div>
            </div>
            <p>Cargando...</p>
        </div>
    </div>
    <!-- #END# Page Loader -->
    <!-- Overlay For Sidebars -->
    <div class="overlay"></div>
    <!-- #END# Overlay For Sidebars -->
    <!-- Search Bar -->
    <div class="search-bar">
        <div class="search-icon">
            <i class="material-icons">search</i>
        </div>
        <input id="buscaAnuncio" type="text" placeholder="BUSCAR ANUNCIO...">
        <div class="close-search">
            <i class="material-icons">close</i>
        </div>
    </div>
    <!-- #END# Search Bar -->
    <!-- Top Bar -->
    <nav class="navbar">
        <div class="container-fluid">
            <div class="navbar-header">
                <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse" aria-expanded="false"></a>
                <a href="javascript:void(0);" class="bars"></a>
                <a class="navbar-brand" href="index.php">MarketHN</a>
            </div>
            <div class="collapse navbar-collapse" id="navbar-collapse">
                <ul class="nav navbar-nav navbar-right">
                    <!-- Call Search -->
                    <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a></li>
                    <!-- #END# Call Search -->
                    <li><a href="../clases/cerrarSesion.php"><i class="material-icons">input</i></a></li>
                    <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a></li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- #Top Bar -->
    <section>
        <!-- Left Sidebar -->
        <aside id="leftsidebar" class="sidebar">
            <!-- User Info -->
            <div class="user-info">
                <div class="image">
                    <img id="imagenPerfil1" width="48" height="48" alt="User" />
                </div>
                <div class="info-container">
                    <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <?php echo $_SESSION["usuario"]["pNombre"] . ' ' . $_SESSION["usuario"]["pApellido"]; ?></div>
                    <div class="email"><?php echo $_SESSION["usuario"]["correoElectronico"]; ?></div>
                    <div class="btn-group user-helper-dropdown">
                        <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
                        <ul class="dropdown-menu pull-right">
                            <li><a href="perfil.php"><i class="material-icons">person</i>Perfil</a></li>
                            <li role="separator" class="divider"></li>
                            <li><a href="../clases/cerrarSesion.php"><i class="material-icons">exit_to_app</i>Cerrar
                                    sesión</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- #User Info -->
            <!-- Menu -->
            <div class="menu">
                <ul class="list">
                    <li class="header">Panel de navegacion</li>
                    <?php
                    if ($_SESSION["usuario"]["tipousuario"] == "Administrador") {
                        echo '<li ">
                                <a href="dashboard.php">
                                <i class="material-icons">pie_chart</i>
                                <span>Dashboard</span>
                                </a>
                            </li>';
                    }
                    ?>
                    <li>
                        <a href="index.php">
                            <i class="material-icons">home</i>
                            <span>Inicio</span>
                        </a>
                    </li>
                    <li class="active">
                        <a href="perfil.php">
                            <i class="material-icons">person</i>
                            <span>Perfil</span>
                        </a>
                    </li>
                    <li>
                        <a href="mis-publicaciones.php">
                            <i class="material-icons">list</i>
                            <span>Mis publicaciones</span>
                        </a>
                    </li>
                    <?php
                    if ($_SESSION["usuario"]["tipousuario"] == "Administrador") {
                        echo '<li>
                                <a href="javascript:void(0);" class="menu-toggle">
                                <i class="material-icons">widgets</i>
                                <span>Administración</span>
                                </a>
                                <ul class="ml-menu">
                                <li>
                                <a href="configuraciones.php">Configuraciones</a>
                              </li>
                                <li>
                                    <a href="gestion-publicaciones.php">Gestión de publicaciones</a>
                                </li>
                                <li>
                                    <a href="gestion-usuarios.php">Gestión de usuarios</a>
                                </li>
                                <li>
                                    <a href="gestion-denuncias.php">Gestión de denuncias</a>
                                </li>
                                </ul>
                            </li>';
                    }
                    ?>
                </ul>
            </div>
            <!-- #Menu -->
            <!-- Footer -->
            <div class="legal">
                <div class="copyright">
                    &copy; 2020 - 2021 <a href="javascript:void(0);">AvisosHN</a>.
                </div>
                <div class="version">
                    <b>Version: </b> 1.0.0
                </div>
            </div>
            <!-- #Footer -->
        </aside>
        <!-- #END# Left Sidebar -->
        <!-- Right Sidebar -->
        <aside id="rightsidebar" class="right-sidebar">
            <ul class="nav nav-tabs tab-nav-right" role="tablist">
                <li role="presentation" class="active"><a href="#skins" data-toggle="tab">SKINS</a></li>
                <!--<li role="presentation"><a href="#settings" data-toggle="tab">SETTINGS</a></li>-->
            </ul>
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane fade in active in active" id="skins">
                    <ul class="demo-choose-skin">
                        <li data-theme="red">
                            <div class="red"></div>
                            <span>Red</span>
                        </li>
                        <li data-theme="pink">
                            <div class="pink"></div>
                            <span>Pink</span>
                        </li>
                        <li data-theme="purple">
                            <div class="purple"></div>
                            <span>Purple</span>
                        </li>
                        <li data-theme="deep-purple">
                            <div class="deep-purple"></div>
                            <span>Deep Purple</span>
                        </li>
                        <li data-theme="indigo">
                            <div class="indigo"></div>
                            <span>Indigo</span>
                        </li>
                        <li data-theme="blue">
                            <div class="blue"></div>
                            <span>Blue</span>
                        </li>
                        <li data-theme="light-blue">
                            <div class="light-blue"></div>
                            <span>Light Blue</span>
                        </li>
                        <li data-theme="cyan">
                            <div class="cyan"></div>
                            <span>Cyan</span>
                        </li>
                        <li data-theme="teal">
                            <div class="teal"></div>
                            <span>Teal</span>
                        </li>
                        <li data-theme="green">
                            <div class="green"></div>
                            <span>Green</span>
                        </li>
                        <li data-theme="light-green">
                            <div class="light-green"></div>
                            <span>Light Green</span>
                        </li>
                        <li data-theme="lime">
                            <div class="lime"></div>
                            <span>Lime</span>
                        </li>
                        <li data-theme="yellow">
                            <div class="yellow"></div>
                            <span>Yellow</span>
                        </li>
                        <li data-theme="amber">
                            <div class="amber"></div>
                            <span>Amber</span>
                        </li>
                        <li data-theme="orange">
                            <div class="orange"></div>
                            <span>Orange</span>
                        </li>
                        <li data-theme="deep-orange">
                            <div class="deep-orange"></div>
                            <span>Deep Orange</span>
                        </li>
                        <li data-theme="brown">
                            <div class="brown"></div>
                            <span>Brown</span>
                        </li>
                        <li data-theme="grey">
                            <div class="grey"></div>
                            <span>Grey</span>
                        </li>
                        <li data-theme="blue-grey">
                            <div class="blue-grey"></div>
                            <span>Blue Grey</span>
                        </li>
                        <li data-theme="black" class="active">
                            <div class="black"></div>
                            <span>Black</span>
                        </li>
                    </ul>
                </div>
            </div>
        </aside>
        <!-- #END# Right Sidebar -->
    </section>

    <section class="content">
        <div class="container-fluid">
            <div class="row clearfix cards" id="contenedorTarjetas">
                <div class="col-xs-12 col-sm-3">
                    <div class="card profile-card">
                        <div class="profile-header">&nbsp;</div>
                        <form id="formAtualizarImagen" style="display:none" enctype="multipart/form-data">
                            <!-- ACTUALIZAR IMAGEN -->
                            <input type="file" name="imagen" accept="image/*" id="imagenActualizar">
                        </form>
                        <div class="profile-body">
                            <div class="image-area">
                                <img style="cursor:pointer" title="CAMBIAR IMAGEN" id="imagenPerfil" alt="AdminBSB - Profile Image" height=128px width=128px />
                            </div>
                            <div class="content-area">
                                <h3><?php echo $_SESSION["usuario"]["pNombre"] . ' ' . $_SESSION["usuario"]["pApellido"]; ?>
                                </h3>
                                <p><?php echo $_SESSION["usuario"]["tipousuario"] ?></p>
                            </div>
                        </div>
                        <div class="profile-footer">
                            <ul>
                                <li style="text-align:left;">
                                    <span>Articulos publicados</span>
                                    <span id="articulosPublicados">cargar desde la base</span>
                                </li>
                                <li style="text-align:left;">
                                    <span>Calificacion Vendedor</span>
                                    <span id="calificacionUsuario">cargar desde la base</span>
                                </li>
                                <li style="text-align:left;">
                                    <span>Unido desde</span>
                                    <span><?php echo $_SESSION["usuario"]["fechaRegistro"] ?></span>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <a href="eliminarCuenta.php">
                        <button type="submit" class="btn bg-red btn-block waves-effect" data-toggle="modal" data-target="#defaultModal" style="margin-top:-10px;">
                            <span>Eliminar cuenta</span></button>
                    </a> <br>
                    <br>
                    <div class='card card-about-me' style='max-height:400px; overflow-y:scroll;'>
                        <div class="header">
                            <h2>VENDEDORES FAVORITOS</h2>
                        </div>
                        <div class='body' style='height: auto;'>
                            <ul id="agregarFavoritos">
                               
                                
                            </ul>
                        </div>

                    </div>
                </div>
                <div class="col-xs-12 col-sm-9">
                    <div class="card">
                        <div class="body">
                            <div>
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#profile_settings" aria-controls="settings" role="tab" data-toggle="tab">Configuración de
                                            perfil</a>
                                    </li>
                                    <li role="presentation"><a href="#change_password_settings" aria-controls="settings" role="tab" data-toggle="tab">Cambiar contraseña</a></li>
                                    
                                </ul>

                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane fade in active" id="profile_settings">
                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <label for="first-name" class="col-sm-2 control-label" style="text-align:left;">Nombre</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="text" id="txt_nombre" class="form-control" name="first-name" placeholder="<?php echo $_SESSION["usuario"]["pNombre"]; ?>" value="<?php echo $_SESSION["usuario"]["pNombre"]; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="last-name" class="col-sm-2 control-label" style="text-align:left;">Apellido</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" id="txt_apellido" name="last-name" placeholder="<?php echo $_SESSION["usuario"]["pApellido"]; ?>" value="<?php echo $_SESSION["usuario"]["pApellido"]; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="Email" class="col-sm-2 control-label" style="text-align:left;">Correo
                                                    electrónico</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="email" class="form-control" id="txt_correo" name="Email" placeholder="<?php echo $_SESSION["usuario"]["correoElectronico"]; ?>" value="<?php echo $_SESSION["usuario"]["correoElectronico"]; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <?php
                                            $fechaTemp = $_SESSION["usuario"]["fechaNacimiento"];
                                            $date = str_replace('-', '/', $fechaTemp);
                                            $fechaTemp = date('d-m-Y', strtotime($date));
                                            ?>
                                            <div class="form-group">
                                                <label for="fecha" class="col-sm-2 control-label" style="text-align:left;">Fecha de
                                                    Nacimiento</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="text" id="date_fecha" class="form-control date" value="<?php echo $fechaTemp; ?>" placeholder="<?php echo $fechaTemp; ?>" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- debe cargar desde la base de datos -->
                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" style="text-align:left;">municipio</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <select id="int_municipio" class="form-control show-tick" required>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label class="col-sm-2 control-label" style="text-align:left;">Teléfono</label>
                                                <div class="col-sm-10">
                                                    <div class="form-line">
                                                        <input type="text" id="txt_tefelono" class="form-control mobile-phone-number" value="<?php echo $_SESSION["usuario"]["numTelefono"]; ?>" placeholder="<?php echo $_SESSION["usuario"]["numTelefono"]; ?>" required>
                                                    </div>
                                                </div>
                                            </div>



                                            <div class="form-group">
                                                <label class="col-sm-4 control-label" style="text-align:left;">RTN (Llenelo solo si desea identificar su perfil como empresarial)</label>
                                                <div class="col-sm-8">
                                                    <div class="form-line">
                                                        <input type="text" class="form-control" value="<?php echo $_SESSION["usuario"]["RTN"]; ?>" placeholder="<?php echo $_SESSION["usuario"]["RTN"]; ?>" id="txt_rtn">
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="form-group">
                                                <div class="col-sm-offset-2 col-sm-10">
                                                    <button id="editar" type="button" class="btn btn-danger">Guardar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <div role="tabpanel" class="tab-pane fade in" id="change_password_settings">
                                        <form class="form-horizontal">
                                            <div class="form-group">
                                                <label for="OldPassword" class="col-sm-3 control-label" style="text-align:left;">Contraseña
                                                    actual</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" id="contraseñaActual" name="OldPassword" placeholder="Contraseña actual" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="NewPassword" class="col-sm-3 control-label" style="text-align:left;">Nueva
                                                    contraseña</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" id="txt_contraseña" name="NewPassword" placeholder="Nueva contraseña" required>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <label for="NewPasswordConfirm" class="col-sm-3 control-label" style="text-align:left;">Nueva
                                                    contraseña (Confirmación)</label>
                                                <div class="col-sm-9">
                                                    <div class="form-line">
                                                        <input type="password" class="form-control" id="txt_contraseña2" name="NewPasswordConfirm" placeholder="Confirme la contraseña" required>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-offset-3 col-sm-9">
                                                    <button id="cambiar" type="button" class="btn btn-danger">Cambiar</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- MODAL PARA VER LA INFORMACION DE UN ARTICULO-->
        <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-per modal-lg " role="document" style="width:70%">
            <div class="modal-content" style="">
                <div class="modal-body modal-body-per" id="infoArticulo">
                </div>
            </div>
            </div>
        </div>


        <!--Modal que carga la información del vendedor-->
        <div class="modal fade" id="modalVendedor" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-per" role="document">
            <div class="modal-content">
                <div class="modal-body modal-body-per" id="contenidoModalVendedor">
                </div>
                
            </div>
            </div>
        </div>

        <!-- modal para hacer contacto con el vendedor -->
        <div class="modal fade" id="modalContacto" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel">¡Hazlo, contacta con el vendedor!</h4>
                </div>
                <div class="modal-body">
                <div style="padding:5px; ">
                    <div class="input-group input-group-sm">
                    <span class="input-group-addon">
                        <i class="material-icons">person</i>
                    </span>
                    <div class="form-line">
                        <input type="text" id="nombreUsuario" class="form-control" placeholder="<?php echo $_SESSION["usuario"]["pNombre"] . ' ' . $_SESSION["usuario"]["pApellido"]; ?>" readonly="readonly">
                    </div>
                    </div>
                    <div class="input-group input-group-sm">
                    <span class="input-group-addon">
                        <i class="material-icons">mail</i>
                    </span>
                    <div class="form-line">
                        <input type="text" class="form-control" id="correoUsuario" placeholder="<?php echo $_SESSION["usuario"]["correoElectronico"]; ?>" readonly="readonly">
                    </div>
                    </div>
                    <div id="descrip">
                    </div>
                </div>
                </div>
            </div>
            </div>
        </div>

        <!--Modal para las denuncias-->
        <div class="modal fade" id="denuncias" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel" style="text-align:center;">¡Cuentanos tu denuncia!</h4>
                </div>
                <div class="modal-body">
                <div class="row clearfix">
                    <div class="col-sm-12">
                    <div class="form-group form-float">
                        <div class="form-line">
                        <select class="form-control show-tick" id="razónDenuncia">
                            <option value=""></option>
                            <option value="1">Descripción imprecisa</option>
                            <option value="2">Contenido ofensivo o dañino</option>
                            <option value="3">Estafa</option>
                            <option value="4">Articulo falso</option>
                            <option value="5">Contenido sexual</option>
                            <option value="6">Venta de armas o drogas</option>
                            <option value="7">Publicación discriminatoria</option>
                            <option value="8">Sin intención de venta</option>
                        </select>
                        <label class="form-label">Razón</label>
                        </div>
                    </div>
                    <div class="form-group form-float">
                        <div class="form-line">
                        <textarea cols="30" rows="4" class="form-control no-resize" id="comentario-denuncia"></textarea>
                        <label class="form-label">Tu comentario es valioso</label>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                <div class="modal-footer">
                <button type="button" id="denuncia" class="btn bg-pink waves-effect">DENUNCIAR</button>
                <button type="button" class="btn bg-black waves-effect" data-dismiss="modal">CANCELAR</button>
                <!--data-target='#denuncias' data-dismiss='#defaultModal'-->
                </div>
            </div>
            </div>
        </div>



        <!--Modal para compartir-->
        <div class="modal fade" id="modalCompartir" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-header">
                <h4 class="modal-title" id="smallModalLabel" style="text-align:center;">¡Comparte MarketHN!</h4>
                </div>
                <div class="modal-body">
                <div class="social">
                    <ul>
                    <li><a href="http://www.facebook.com/sharer/sharer.php?u=https://markethn.herokuapp.com/" class="icon-facebook" target="_blank"></a></li>
                    <li><a href="https://www.instagram.com/" class="icon-instagram" target="_blank"></a></li>
                    </ul>
                </div>

                </div>
                <div class="modal-footer">
                <button type="button" class="btn bg-black waves-effect" data-dismiss="modal">CANCELAR</button>
                </div>
            </div>
            </div>
        </div>

        
        
        



        <!--Modal con el mensaje de respuesta-->
        <div class="modal fade" id="ModalMensaje" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true ">
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

        
        <!--Modal que carga la información del vendedor2-->
        <div class="modal fade" id="modalVendedor2" tabindex="-1" role="dialog">
            <div class="modal-dialog modal-dialog-per" role="document">
                <div class="modal-content">
                    <div class="modal-body modal-body-per" id="contenidoModalVendedor2">
                    </div>

                </div>
            </div>
        </div>
        
    </section>

    <!-- Jquery Core Js -->
    <script src="../plugins/jquery/jquery.min.js"></script>

    <!-- Bootstrap Core Js -->
    <script src="../plugins/bootstrap/js/bootstrap.js"></script>


    <!-- Slimscroll Plugin Js -->
    <script src="../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

    <!-- Waves Effect Plugin Js -->
    <script src="../plugins/node-waves/waves.js"></script>

    <!-- Custom Js -->
    <script src="../js/admin.js"></script>

    <!-- Demo Js -->
    <script src="../js/demo.js"></script>

    <!-- Validation Plugin Js -->
    <script src="../plugins/jquery-validation/jquery.validate.js"></script>

    <!-- Input Mask Plugin Js -->
    <script src="../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>
    <!-- Autosize Plugin Js -->
    <script src="../plugins/autosize/autosize.js"></script>

    <!-- Moment Plugin Js -->
    <script src="../plugins/momentjs/moment.js"></script>

    <!-- Bootstrap Material Datetime Picker Plugin Js -->
    <script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

    <!-- Bootstrap Datepicker Plugin Js -->
    <script src="../plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

    <!-- Custom Js -->
    <script src="../js/pages/forms/basic-form-elements.js"></script>
    <!-- Custom Js -->
    <script src="../js/pages/ui/modals.js"></script>
    <!-- Star Plugin Js -->
    <script src="../plugins/star/js/starrr.js"></script>

    <!-- Demo Js -->
    <script src="../js/index.js"></script>
    <script src="../controlador/perfiles.js"></script>
    <script src="../plugins/sweetalert/sweetalert.min.js"></script>


</body>

</html>