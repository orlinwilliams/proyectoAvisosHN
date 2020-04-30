<?php
session_start();
?>
<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Inicio | MarketHN</title>
  <!-- Favicon-->
  <link rel="icon" href="../favicon.ico" type="image/x-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

  <!-- Bootstrap Core Css -->
  <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

  <!-- Botón flotante css -->
  <link href="../plugins/bootstrap/css/botonflotante.css" rel="stylesheet">

  <!-- Waves Effect Css -->
  <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

  <!-- Animation Css -->
  <link href="../plugins/animate-css/animate.css" rel="stylesheet" />
  <!-- noUISlider Css -->
  <link href="../plugins/nouislider/nouislider.min.css" rel="stylesheet" />

  <!-- Custom Css -->
  <link href="../css/style.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">
  <link href="../css/estilos.css" rel="stylesheet">
  <link href="../css/font.css" rel="stylesheet">

  <!-- estrellas Css -->
  <link href="../plugins/star/css/starrr.css" rel="stylesheet" />
  <link href="http://netdna.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet" />

  <!-- Dropzone Css -->
  <link href="../plugins/dropzone/dropzone.css" rel="stylesheet">

  <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
  <link href="../css/themes/all-themes.css" rel="stylesheet" />

  <!-- Bootstrap Select Css -->
  <link href="../plugins/bootstrap-select/css/bootstrap-select.css" rel="stylesheet" />
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
    <input id="buscaAnuncio" type="text" placeholder="START TYPING...">
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
          <li><a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a>
          </li>
          <!-- #END# Call Search -->
          <!-- Tasks -->
          <li><a href="../clases/cerrarSesion.php"><i class="material-icons">input</i></a></li>
          <!-- #END# Tasks -->
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
          <img src="<?php echo $_SESSION["usuario"]["urlFoto"] ?>" width="48" height="48" alt="User" />
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
          <li class="header">Panel de navegación</li>
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
          <li class="active">
            <a href="index.php">
              <i class="material-icons">home</i>
              <span>Inicio</span>
            </a>
          </li>
          <li>
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
                        <a href="gestion-publicaciones.php">Gestión de publicaciones</a>
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
          &copy; 2020- 2021 <a href="javascript:void(0);">MarketHN</a>.
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
  <!-- #Contenido -->
  <section class="content">
  <div class="row clearfix" style="max-width:100% !important; margin-left:auto !important; margin-right:auto !important; max-height:140px !important;">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card">
          <div class="Header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
              <span class="sr-only" style="background-color:black">Toggle navigation</span>
              <span class="icon-bar" style="background-color:black"></span>
              <span class="icon-bar" style="background-color:black"></span>
              <span class="icon-bar" style="background-color:black"></span>
            </button>
          </div>
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <div class="body" style="padding: 20px 5px 20px 5px">
              <div class="row clearfix" style="margin:0px">
                <div class="col-md-3">
                  <div class="form-group form-float">
                    <div class="form-line">
                      <select class="form-control show-tick" name="lugar" id="f-lugar">
                        <option></option>
                      </select>
                      <label class="form-label">Lugar</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-3">
                  <div class="form-group form-float">
                    <div class="form-line">
                      <select class="form-control show-tick" name="categoria" id="f-categoria">
                        <option></option>
                      </select>
                      <label class="form-label">Categoría</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-2">

                  <div class="form-group form-float">
                    <div class="form-line">
                      <select class="form-control show-tick" name="valoracion" id="valoracion">
                        <option value=""></option>
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                      </select>
                      <label class="form-label">Valoración</label>
                    </div>
                  </div>
                </div>
                <div class="col-md-3" style="margin-bottom:0px">
                  <p><b>Rango de precio</b></p>
                  <div id="nouislider_range_example" class="col-md-12">
                  
                  </div><br>
                  <span class="js-nouislider-value"></span>
                  <div class="col-md-12" style="padding:0px; margin-bottom:0px">
                      
                      <div class="col-md-6" style="padding:0px; margin-bottom:0px">
                        <input type="hidden"class="col-md-12" style="padding:2px; margin-bottom:0px" readonly ="readonly" name="" id="lower-value">
                      </div>
                      <div class="col-md-6" style="padding:0px; margin-bottom:0px">
                      
                      <input type="hidden" class="col-md-12" style="padding:2px; margin-bottom:0px" readonly ="readonly" name=""id="upper-value">
                      </div>
                  </div>
                  
                  
                </div>
                
                 <button type="button" style="margin:6px" id="filtrar" onclick="publicacionesFiltradas();" class="btn bg-black btn-circle-lg waves-effect waves-circle waves-float waves-light col-md-1 ">
                                    <i class="material-icons">filter_list</i>
                 </button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="contenedor">
      <button class="botonF1" data-toggle="modal" data-target="#modalArticulo">
        <span>+
        </span>
      </button>
    </div>
    <div id="contenedorTarjeta" class="row clearfix cards">
    </div>
  </section>
  <!-- MODAL PARA VER LA INFORMACION DE UN ARTICULO-->
  <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-per modal-lg " role="document" style="width:70%">
      <div class="modal-content">
        <div class="modal-body modal-body-per" id="infoArticulo">
        </div>
      </div>
    </div>
  </div>
  <!--Modal que carga la información del vendedor-->
  <div class="modal fade" id="modalVendedor" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content" id="contenidoModalVendedor">
        <div class="modal-footer">
          <button type="button" class="btn btn-link waves-effect" data-toggle="modal" data-target="#defaultModal" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>
  <!-- Modal para publicar un articulo -->
  <div class="modal fade" id="modalArticulo" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="largeModalLabel">Publica tu artículo</h4>
        </div>
        <div class="modal-body">
          <form id="publicarArticulo">
            <div action="/" id="subirFotos" class="dropzone" enctype="multipart/form-data">
              <div class="dz-message">
                <div class="drag-icon-cph">
                  <i class="material-icons">touch_app</i>
                </div>
                <h3>Arrastra hacia aquí tus fotos o da click para seleccionar.</h3>
                <em>(Es <strong>obligatorio</strong> subir al menos una foto del articulo.)</em>
              </div>
              <div class="fallback">
                <input name="file" type="file" accept="image/*" requerid />
              </div>
            </div>
            <br>
            <div id="form_validation">
              <div class="form-group form-float">
                <div class="form-line">
                  <input type="text" class="form-control" name="nombre" id="nombre" required>
                  <label class="form-label">Nombre del articulo</label>
                </div>

              </div>
              <div class="form-group form-float">
                <div class="form-line">
                  <input type="number" class="form-control money-dollar" name="precio" id="precio" required>
                  <label class="form-label">Precio</label>
                </div>
              </div>
              <div class="form-group form-float">
                <div class="form-line">
                  <select class="form-control show-tick" name="estado" id="estado" required>
                    <option></option>
                    <option value="Nuevo">Nuevo</option>
                    <option value="Usado">Usado</option>
                    <option value="Restaurado">Restaurado</option>
                    <option value="Dañado">Dañado</option>
                  </select>
                  <label class="form-label">Estado</label>
                </div>
              </div>
              <div class="form-group form-float">
                <div class="form-line">
                  <select class="form-control show-tick" name="categoria" id="categoria">
                    <option></option>
                  </select>
                  <label class="form-label">Categoria</label>
                </div>
              </div>
              <div class="form-group form-float">
                <div class="form-line">
                  <textarea name="descripcion" cols="30" rows="4" class="form-control no-resize"></textarea>
                  <label class="form-label">Descripción (Opcional)</label>
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" id="publicarAnuncio" class="btn btn-default waves-effect">Publicar</button>
                <button type="button" class="btn bg-black waves-effect waves-light" data-dismiss="modal">Cancelar</button>
              </div>
            </div>
          </form>
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
              <li><a href="http://www.facebook.com/sharer/sharer.php?u=https://e-markethn.com/" class="icon-facebook" target="_blank"></a></li>
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


  <!-- Jquery Core Js -->
  <script src="../plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap Core Js -->
  <script src="../plugins/bootstrap/js/bootstrap.js"></script>
  <!-- Slimscroll Plugin Js -->
  <script src="../plugins/jquery-slimscroll/jquery.slimscroll.js"></script>
  <!-- Waves Effect Plugin Js -->
  <script src="../plugins/node-waves/waves.js"></script>
  <!-- Validation Plugin Js -->
  <script src="../plugins/jquery-validation/jquery.validate.js"></script>
  <!-- Wait Me Plugin Js -->
  <script src="../plugins/waitme/waitMe.js"></script>
  <!-- Custom Js -->
  <script src="../js/admin.js"></script>
  <!-- Demo Js -->
  <script src="../js/demo.js"></script>
  <script src="../js/index.js"></script>
  <!-- Autosize Plugin Js -->
  <script src="../plugins/autosize/autosize.js"></script>
  <!-- Moment Plugin Js -->
  <script src="../plugins/momentjs/moment.js"></script>
  <!-- Custom Js -->
  <script src="../js/pages/ui/modals.js"></script>
  <!-- Dropzone Plugin Js -->
  <script src="../plugins/dropzone/dropzone.js"></script>
  <!-- Star Plugin Js -->
  <script src="../plugins/star/js/starrr.js"></script>
  <!-- Controlador de página Js -->
  <script src="../plugins/nouislider/nouislider.js"></script>
  <script src="../controlador/vistas-index.js"></script>
  <script src="../controlador/filtros.js"></script>


</body>

</html>