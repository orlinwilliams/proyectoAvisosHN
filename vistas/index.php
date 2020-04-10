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
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
    type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

  <!-- Bootstrap Core Css -->
  <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

  <!-- Botón flotante css -->
  <link href="../plugins/bootstrap/css/botonflotante.css" rel="stylesheet">

  <!-- Waves Effect Css -->
  <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

  <!-- Animation Css -->
  <link href="../plugins/animate-css/animate.css" rel="stylesheet" />

  <!-- Custom Css -->
  <link href="../css/style.css" rel="stylesheet">
  <link href="../css/estilos.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.css" rel="stylesheet">

  <!-- Dropzone Css -->
  <link href="../plugins/dropzone/dropzone.css" rel="stylesheet">

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
    <input type="text" placeholder="START TYPING...">
    <div class="close-search">
      <i class="material-icons">close</i>
    </div>
  </div>
  <!-- #END# Search Bar -->
  <!-- Top Bar -->
  <nav class="navbar">
    <div class="container-fluid">
      <div class="navbar-header">
        <a href="javascript:void(0);" class="navbar-toggle collapsed" data-toggle="collapse"
          data-target="#navbar-collapse" aria-expanded="false"></a>
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
          <li class="pull-right"><a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i
                class="material-icons">more_vert</i></a></li>
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
          <img src="<?php echo $_SESSION["usuario"]["urlFoto"]?>" width="48" height="48" alt="User" />
        </div>
        <div class="info-container">
          <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php echo $_SESSION["usuario"]["pNombre"].' '.$_SESSION["usuario"]["pApellido"];?></div>
          <div class="email"><?php echo $_SESSION["usuario"]["correoElectronico"];?></div>
          <div class="btn-group user-helper-dropdown">
            <i class="material-icons" data-toggle="dropdown" aria-haspopup="true"
              aria-expanded="true">keyboard_arrow_down</i>
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
  <section class="content">
  <div class="contenedor">
      <button class="botonF1" data-toggle="modal" data-target="#modalArticulo">
        <span>+</span>
      </button>
    </div>
    <div class="row clearfix">
      <div class="col-sm-6 col-md-6 col-lg-3 cards">
        <div class="carde">
          <div class="card__image-holder">
            <img class="card__image" src="../images/joker.jpg" alt="Miniatura del anuncio" max-width="100%;"
              height="auto;" />
          </div>
          <div class="card-title">
            <a href="#" class="toggle-info btn">
              <span class="left"></span>
              <span class="right"></span>
            </a>
            <h2>
              TITULO DEL ARTICULO
              <small>PRECIO</small>
            </h2>
          </div>
          <div class="card-flap flap1">
            <div class="card-description">
              Lorem ipsum dolor sit amet, consectetur adipiscing elit. Etiam mattis ligula sem, mollis ultrices ligula
              tempus eu. In hendrerit enim sem, in suscipit orci mollis et. Maecenas ullamcorper erat vel nisl mattis
              imperdiet. Phasellus elementum enim et sem ornare commodo.
            </div>
            <div class="card-flap flap2">
              <div class="card-actions">
                <a href="#" class="btn" data-toggle="modal" data-target="#defaultModal">VER</a>
              </div>
            </div>
          </div>
        </div>
      <!------------------------------------------------------------------------------------
                          --------------------------------------------------------------------------------------
                          --------------------------------------------------------------------------------------
                          ---------------------AQUI DEBEN CARGAR LOS ANUNCIOS PUBLICADOS------------------------
                          --------------------------------------------------------------------------------------
                          --------------------------------------------------------------------------------------
                          -------------------------------------------------------------------------------------->
    </div>
  </section>
   <!-- MODAL PARA VER LA INFORMACION DE UN ARTICULO-->
   <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-per modal-lg " role="document" style="width:70%">
      <div class="modal-content">
        <div class="modal-body modal-body-per">
          <div class="row">
            <div class="col-md-7 col-sm-12 col-xs-12 izquierdo">
              <div class="fotorama" data-width="100%" data-ratio="700/467" data-minwidth="400" data-maxwidth="1000"
                data-minheight="300" data-maxheight="100%" data-nav="thumbs" data-fit="cover" data-loop="true">
                <img src="../images/joker.jpg">
                <img src="../images/image-gallery/12.jpg">
                <img src="../images/image-gallery/19.jpg" />
              </div>
            </div>
            <div class="col-md-5 col-sm-12 col-xs-12 derecho">
              <div>
                <!--ESTOS SE DEBEN CAMBIAR POR LINKS QUE ENVIEN A TODOS LOS ANUNCIONS DE ESA CATEGORIA
                <a href="http://"> </a>-->
                <p class="font-categoria"><a class="links-categorias" href="#">Categoria</a> > <a
                    class="links-categorias" href="#">Tecnología</a>> <a class="links-categorias" href="#">Móviles y
                    Telefonía</a></p>
              </div>
              <div>
                <p class="titulo">Samsung Galaxy S20</p>
              </div>
              <div class="precio">
                <p class="font-precio">L 19,000</p>
              </div>
              <div class="estado">
                <p class="font-estado"><strong>Estado:</strong> Nuevo</p>
                <p class="font-estado"><strong>Lugar:</strong> Tegucigalpa</p>
              </div>
              <div class="descripcion">
                <p class="font-descripcion"><strong>Descripción:</strong></p>
                <p class="parrafo">Lorem, ipsum dolor sit amet consectetur adipisicing elit. Pariatur voluptate et
                  dolore magnam ipsum fuga iure voluptates, voluptatum doloremque, magni eveniet deleniti. Quia beatae
                  perspiciatis vero tenetur! Nesciunt, assumenda accusamus.</p>
              </div>
              <div class="vendedor">
                <p class="font-vendedor">Información del vendedor</p>
                <div class="div-imagen">
                  <a aria-label="Foto del vendedor" href="#" data-toggle="modal" data-target="#modalVendedor"
                      data-dismiss="modal">
                    <img class="imagen-vendedor" src="../images/joker.jpg" alt="">
                  </a>
                </div>
                <div class="div-nombre">
                  <p class="font-vendedor"><a data-toggle="modal" data-target="#modalVendedor"
                      data-dismiss="modal">Maynor Bethuell Pineda</a></p>
                  <p class="registro-de-vendedor">Unido desde 14 Febrero 2010</p>

                  <div class="demo-google-material-icon" style="color:black;">
                    <span class="icon-name" style="font-size:22px"><strong>Valoración:
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                      </strong>4.5</span>
                    <i class="material-icons md-18">star_rate</i>
                  </div>
                  <div class="demo-google-material-icon pb-5" style="color:black;">
                    <i class="material-icons md-24">phone</i>
                    <span class="icon-name" style="font-size:22px"><strong>+504 9619-9660</strong></span>
                  </div>
                  <br>
                  <div>
                    <div style="text-align:center;">
                      <button class="btn btn-info btn-lg waves-effect" type="submit">CONTACTAR</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!--Modal que carga la información del vendedor-->
  <div class="modal fade" id="modalVendedor" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header" style="text-align:center">
          <h4 class="modal-title" id="defaultModalLabel"></h4>
        </div>
        <div class="modal-body modal-body-per">
          <div class="card profile-card">
            <div class="profile-header">&nbsp;</div>
            <div class="profile-body">
              <div class="image-area">
                <img src="../images/joker.jpg" alt="Foto de perfil de Maynor Bethuell Pineda" width="200px"
                  height="200px" />
              </div>
              <div class="content-area">
                <h3>Maynor Bethuell Pineda</h3>
                <p>Miembro desde 14 Febrero 2010</p>
                <p>
                  <!--Tipo de usuario-->Administrador</p>
              </div>
            </div>
            <div class="profile-footer">
              <ul>
                <li>
                  <span>Valoración</span>
                  <span>4.5</span>
                </li>
                <li>
                  <span>Articulos publicados</span>
                  <span>125</span>
                </li>
                <li>
                  <span>Correo Electrónico</span>
                  <span>sbethuell@gmail.com</span>
                </li>
              </ul>
              <button class="btn btn-primary btn-lg waves-effect btn-block">Contactar</button>
            </div>
          </div>
          <div class="card card-about-me" style="max-height:400px; overflow-y:scroll;">
            <div class="header" style="text-align:center">
              <h2>HISTORIAL</h2>
              <small>(Se mantiene el registro de los últimos 90 días)</small>
            </div>
            <div class="body" style="height: auto;">
              <ul>
                <li>
                  <div class="title">
                    Articulo 1
                  </div>
                  <div class="content">
                    <div style="float:left;">
                      Publicado el 1 de Diciembre de 2019
                    </div>
                    <div style="margin-left:90%">
                      L 1000
                    </div>
                  </div>
                </li>
                <li>
                  <div class="title">
                    Articulo 1
                  </div>
                  <div class="content">
                    <div style="float:left;">
                      Publicado el 1 de Diciembre de 2019
                    </div>
                    <div style="margin-left:90%">
                      L 1000
                    </div>
                  </div>
                </li>
                <li>
                  <div class="title">
                    Articulo 1
                  </div>
                  <div class="content">
                    <div style="float:left;">
                      Publicado el 1 de Diciembre de 2019
                    </div>
                    <div style="margin-left:90%">
                      L 1000
                    </div>
                  </div>
                </li>
                <li>
                  <div class="title">
                    Articulo 1
                  </div>
                  <div class="content">
                    <div style="float:left;">
                      Publicado el 1 de Diciembre de 2019
                    </div>
                    <div style="margin-left:90%">
                      L 1000
                    </div>
                  </div>
                </li>
                <li>
                  <div class="title">
                    Articulo 1
                  </div>
                  <div class="content">
                    <div style="float:left;">
                      Publicado el 1 de Diciembre de 2019
                    </div>
                    <div style="margin-left:90%">
                      L 1000
                    </div>
                  </div>
                </li>
                <li>
                  <div class="title">
                    Articulo 1
                  </div>
                  <div class="content">
                    <div style="float:left;">
                      Publicado el 1 de Diciembre de 2019
                    </div>
                    <div style="margin-left:90%">
                      L 1000
                    </div>
                  </div>
                </li>
                <li>
                  <div class="title">
                    Articulo 1
                  </div>
                  <div class="content">
                    <div style="float:left;">
                      Publicado el 1 de Diciembre de 2019
                    </div>
                    <div style="margin-left:90%">
                      L 1000
                    </div>
                  </div>
                </li>
                <li>
                  <div class="title">
                    Articulo 1
                  </div>
                  <div class="content">
                    <div style="float:left;">
                      Publicado el 1 de Diciembre de 2019
                    </div>
                    <div style="margin-left:90%">
                      L 1000
                    </div>
                  </div>
                </li>
                <li>
                  <div class="title">
                    Articulo 1
                  </div>
                  <div class="content">
                    <div style="float:left;">
                      Publicado el 1 de Diciembre de 2019
                    </div>
                    <div style="margin-left:90%">
                      L 1000
                    </div>
                  </div>
                </li>
                <li>
                  <div class="title">
                    Articulo 1
                  </div>
                  <div class="content">
                    <div style="float:left;">
                      Publicado el 1 de Diciembre de 2019
                    </div>
                    <div style="margin-left:90%">
                      L 1000
                    </div>
                  </div>
                </li>
                <li>
                  <div class="title">
                    Articulo 1
                  </div>
                  <div class="content">
                    <div style="float:left;">
                      Publicado el 1 de Diciembre de 2019
                    </div>
                    <div style="margin-left:90%">
                      L 1000
                    </div>
                  </div>
                </li>           
              </ul>
            </div>
          </div>
          <div class="card card-about-me" style="max-height:400px; overflow-y:scroll;">
            <div class="header" style="text-align:center">
              <h2>Últimos comentarios</h2>
            </div>
            <div class="body" style="height: auto;">
              <ul>
                <li>
                  <div class="title">
                    Us**rio
                  </div>
                  <div class="content">
                    <div>
                    <p>orem ipsum dolor sit amet, consectetur adipiscing elit. Morbi varius vehicula luctus. Maecenas malesuada, quam sit amet sagittis posuere, sapien leo tempor quam, non rutrum lectus urna in leo.</p>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="title">
                    Us**rio
                  </div>
                  <div class="content">
                    <div>
                    <p>orem ipsum dolor sit amet, consectetur adipiscing elit. Morbi varius vehicula luctus. Maecenas malesuada, quam sit amet sagittis posuere, sapien leo tempor quam, non rutrum lectus urna in leo.</p>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="title">
                    Us**rio
                  </div>
                  <div class="content">
                    <div>
                    <p>orem ipsum dolor sit amet, consectetur adipiscing elit. Morbi varius vehicula luctus. Maecenas malesuada, quam sit amet sagittis posuere, sapien leo tempor quam, non rutrum lectus urna in leo.</p>
                    </div>
                  </div>
                </li>
                <li>
                  <div class="title">
                    Us**rio
                  </div>
                  <div class="content">
                    <div>
                    <p>orem ipsum dolor sit amet, consectetur adipiscing elit. Morbi varius vehicula luctus. Maecenas malesuada, quam sit amet sagittis posuere, sapien leo tempor quam, non rutrum lectus urna in leo.</p>
                    </div>
                  </div>
                </li>       
              </ul>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-link waves-effect" data-toggle="modal" data-target="#defaultModal"
            data-dismiss="modal">Cerrar</button>
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
        <form id="publicarArticulo" enctype="multipart/form-data">
            <div action="/" id="subirFotos" class="dropzone"  >
              <div class="dz-message">
              <div class="drag-icon-cph">
                <i class="material-icons">touch_app</i>
              </div>
              <h3>Arrastra hacia aquí tus fotos o da click para seleccionar.</h3>
              <em>(Es <strong>obligatorio</strong> subir al menos una foto del articulo.)</em>
            </div>
            <div class="fallback">
              <input name="fotos" id='fotos' type="file"  multiple/>
            </div>
          </div>
            <br>
            <div id="form_validation">
              <div class="form-group form-float">
                <div class="form-line">
                  <input type="text" class="form-control" name="name" id="nombre" required>
                  <label class="form-label">Nombre del articulo</label>
                </div>

              </div>

              <div class="form-group form-float">
                <div class="form-line">
                  <input type="number" class="form-control money-dollar" name='precio' id="precio" required>
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
                  <select class="form-control show-tick" name="estado" id="categoria" required>
                  </select>
                  <label class="form-label">Categoria</label>
                </div>
              </div>

              <div class="form-group form-float">
                <div class="form-line">
                  <textarea name="description" id='descripcion' cols="30" rows="4" class="form-control no-resize"></textarea>
                  <label class="form-label">Descripción (Opcional)</label>
                </div>
              </div>

              <div class="modal-footer">
              <button type="submit" id='publicar' class="btn btn-default waves-effect">Publicar</button>
              <button type="button" class="btn bg-black waves-effect waves-light" data-dismiss="modal">Cancelar</button>
            </div>
          </form>
        </div>
      </div>
    </div>
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

  <!-- Input Mask Plugin Js -->
  <script src="../plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

  <!-- Bootstrap Tags Input Plugin Js -->
  <script src="../plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

  <!-- Autosize Plugin Js -->
  <script src="../plugins/autosize/autosize.js"></script>

  <!-- Moment Plugin Js -->
  <script src="../plugins/momentjs/moment.js"></script>

  <!-- Bootstrap Material Datetime Picker Plugin Js -->
  <script src="../plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

  <!-- Bootstrap Datepicker Plugin Js -->
  <script src="../plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

  <!-- Custom Js -->
  <script src="../js/pages/ui/modals.js"></script>

  <!-- Dropzone Plugin Js -->
  <script src="../plugins/dropzone/dropzone.js"></script>

  <!-- Controlador de página Js -->
  <script src="../controlador/vistas-index.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js"></script>


</body>

</html>