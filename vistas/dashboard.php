<?php
session_start();
if ($_SESSION["usuario"]["tipousuario"] == "Miembro") {
  header('location: index.php');
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8" />
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
  <title>Administración | AvisosHN</title>
  <!-- Favicon-->
  <link rel="icon" href="../favicon.ico" type="image/x-icon" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css" />
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css" />

  <!-- Bootstrap Core Css -->
  <link href="../plugins/bootstrap/css/bootstrap.css" rel="stylesheet" />

  <!-- Waves Effect Css -->
  <link href="../plugins/node-waves/waves.css" rel="stylesheet" />

  <!-- Animation Css -->
  <link href="../plugins/animate-css/animate.css" rel="stylesheet" />

  <!-- Custom Css -->
  <link href="../css/style.css" rel="stylesheet" />

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
      <p>Please wait...</p>
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
    <input type="text" placeholder="START TYPING..." />
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
          <li>
            <a href="javascript:void(0);" class="js-search" data-close="true"><i class="material-icons">search</i></a>
          </li>
          <!-- #END# Call Search -->
          <!-- Tasks -->
          <li>
            <a href="../clases/cerrarSesion.php"><i class="material-icons">input</i></a>
          </li>
          <!-- #END# Tasks -->
          <li class="pull-right">
            <a href="javascript:void(0);" class="js-right-sidebar" data-close="true"><i class="material-icons">more_vert</i></a>
          </li>
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
            <?php echo $_SESSION["usuario"]["pNombre"] . ' ' . $_SESSION["usuario"]["pApellido"]; ?>
          </div>
          <div class="email">
            <?php echo $_SESSION["usuario"]["correoElectronico"]; ?>
          </div>
          <div class="btn-group user-helper-dropdown">
            <i class="material-icons" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">keyboard_arrow_down</i>
            <ul class="dropdown-menu pull-right">
              <li>
                <a href="perfil.php"><i class="material-icons">person</i>Perfil</a>
              </li>
              <li role="separator" class="divider"></li>
              <li>
                <a href="../clases/cerrarSesion.php"><i class="material-icons">exit_to_app</i>Cerrar sesión</a>
              </li>
            </ul>
          </div>
        </div>
      </div>
      <!-- #User Info -->
      <!-- Menu -->
      <div class="menu">
        <ul class="list" id="menu-lista">
          <li class="header">Panel de navegación</li>


          <li class="active">
            <a href="dashboard.php">
              <i class="material-icons">pie_chart</i>
              <span>Dashboard</span>
            </a>
          </li>


          <li>
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

          <li>
            <a href="javascript:void(0);" class="menu-toggle">
              <i class="material-icons">widgets</i>
              <span>Administración</span>
            </a>
            <ul class="ml-menu">
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
          </li>
        </ul>
      </div>
      <!-- #Menu -->
      <!-- Footer -->
      <div class="legal">
        <div class="copyright">
          &copy; 2020- 2021 <a href="javascript:void(0);">MarketHN</a>.
        </div>
        <div class="version"><b>Version: </b> 1.0.0</div>
      </div>
      <!-- #Footer -->
    </aside>
    <!-- #END# Left Sidebar -->
    <!-- Right Sidebar -->
    <aside id="rightsidebar" class="right-sidebar">
      <ul class="nav nav-tabs tab-nav-right" role="tablist">
        <li role="presentation" class="active">
          <a href="#skins" data-toggle="tab">SKINS</a>
        </li>
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
      <div class="block-header">
        <h2>DASHBOARD</h2>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="info-box-4 hover-zoom-effect">
            <div class="icon">
              <i class="material-icons col-blue">person_add</i>
            </div>
            <div class="content">
              <div class="text">NUEVOS USUARIOS</div>
              <div class="number">315</div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="info-box-4 hover-zoom-effect">
            <div class="icon">
              <i class="material-icons col-blue">playlist_add</i>
            </div>
            <div class="content">
              <div class="text">NUEVAS PUBLICACIONES</div>
              <div class="number">92</div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="info-box-4 hover-zoom-effect">
            <div class="icon">
              <i class="material-icons col-blue">report_problem</i>
            </div>
            <div class="content">
              <div class="text">NUEVAS DENUNCIAS</div>
              <div class="number">30</div>
            </div>
          </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-6 col-xs-12">
          <div class="info-box-4 hover-zoom-effect">
            <div class="icon">
              <i class="material-icons col-blue">comment</i>
            </div>
            <div class="content">
              <div class="text">Nuevos omentarios</div>
              <div class="number">15</div>
            </div>
          </div>
        </div>
      </div>
      <div class="row">
        <!-- carga los numeros de las categorias más publicadas-->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header">
              <h2>PUBLICACIONES POR MES</h2>
            </div>
            <div class="body">
              <canvas id="pie_chart" height="150"></canvas>
            </div>
          </div>
        </div>
        <!-- carga los numeros de las categorias más publicadas-->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header">
              <h2>PUBLICACIONES POR DÍA</h2>
            </div>
            <div class="body">
              <canvas id="bar_chart_2" height="150"></canvas>
            </div>
          </div>
        </div>
        <!-- Pie Chart que carga el porcentaje de grupo de categorías-->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header">
              <h2>PUBLICACIONES POR GRUPO DE CATEGORÍA</h2>
            </div>
            <div class="body">
              <canvas id="bar_chart" height="150"></canvas>
            </div>
          </div>
        </div>
        <!-- carga los numeros de las categorias más publicadas-->
        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
          <div class="card">
            <div class="header">
              <h2>PUBLICACIONES POR DEPARTAMENTO</h2>
            </div>
            <div class="body">
              <canvas id="pie_chart_2" height="150"></canvas>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

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
        <div class="modal-body" id="cuerpoModal"></div>
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
  <!-- Custom Js -->
  <script src="../js/admin.js"></script>
  <script src="../js/helpers.js"></script>
  <!-- Jquery CountTo Plugin Js -->
  <script src="../plugins/jquery-countto/jquery.countTo.js"></script>
  <script src="../js/pages/widgets/infobox/infobox-5.js"></script>
  <!-- Chart Plugins Js -->
  <script src="../plugins/chartjs/Chart.bundle.js"></script>
  <script src="../controlador/dashboard.js"></script>
  <!-- Demo Js -->
  <script src="../js/demo.js"></script>



</body>

</html>