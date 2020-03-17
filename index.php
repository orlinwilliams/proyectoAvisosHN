
<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>Inicio | MarketHN</title>
  <!-- Favicon-->
  <link rel="icon" href="favicon.ico" type="image/x-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet"
    type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

  <!-- Bootstrap Core Css -->
  <link href="plugins/bootstrap/css/bootstrap.css" rel="stylesheet">

  <!-- Waves Effect Css -->
  <link href="plugins/node-waves/waves.css" rel="stylesheet" />

  <!-- Animation Css -->
  <link href="plugins/animate-css/animate.css" rel="stylesheet" />

  <!-- Custom Css -->
  <link href="css/style.css" rel="stylesheet">

  <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
  <link href="css/themes/all-themes.css" rel="stylesheet" />
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
          <li>
            <a data-toggle="modal" data-target="#defaultModal">
              Iniciar
            </a>
          </li>
          <li>
            <a data-toggle="modal" data-target="#defaultModal2">
              Registrarse
            </a>
          </li>
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
                <img src="images/user.png" width="48" height="48" alt="User" />
            </div>
            <div class="info-container">
                <div class="name" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Invitado</div>
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
                    <li data-theme="red" >
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
      <!-- No Header Card 
      <div class="block-header">
        <h2>NO HEADER CARDS</h2>
      </div>
      <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="body bg-red">
                    Quis pharetra a pharetra fames blandit. Risus faucibus velit Risus imperdiet mattis neque volutpat, etiam lacinia netus dictum magnis per facilisi sociosqu. Volutpat. Ridiculus nostra.
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="body bg-cyan">
                    Quis pharetra a pharetra fames blandit. Risus faucibus velit Risus imperdiet mattis neque volutpat, etiam lacinia netus dictum magnis per facilisi sociosqu. Volutpat. Ridiculus nostra.
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="body bg-green">
                    Quis pharetra a pharetra fames blandit. Risus faucibus velit Risus imperdiet mattis neque volutpat, etiam lacinia netus dictum magnis per facilisi sociosqu. Volutpat. Ridiculus nostra.
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="body bg-orange">
                    Quis pharetra a pharetra fames blandit. Risus faucibus velit Risus imperdiet mattis neque volutpat, etiam lacinia netus dictum magnis per facilisi sociosqu. Volutpat. Ridiculus nostra.
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="body bg-blue-grey">
                    Quis pharetra a pharetra fames blandit. Risus faucibus velit Risus imperdiet mattis neque volutpat, etiam lacinia netus dictum magnis per facilisi sociosqu. Volutpat. Ridiculus nostra.
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="body  bg-pink">
                    Quis pharetra a pharetra fames blandit. Risus faucibus velit Risus imperdiet mattis neque volutpat, etiam lacinia netus dictum magnis per facilisi sociosqu. Volutpat. Ridiculus nostra.
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="body bg-light-blue">
                    Quis pharetra a pharetra fames blandit. Risus faucibus velit Risus imperdiet mattis neque volutpat, etiam lacinia netus dictum magnis per facilisi sociosqu. Volutpat. Ridiculus nostra.
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="body bg-light-green">
                    Quis pharetra a pharetra fames blandit. Risus faucibus velit Risus imperdiet mattis neque volutpat, etiam lacinia netus dictum magnis per facilisi sociosqu. Volutpat. Ridiculus nostra.
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="card">
                <div class="body bg-amber">
                    Quis pharetra a pharetra fames blandit. Risus faucibus velit Risus imperdiet mattis neque volutpat, etiam lacinia netus dictum magnis per facilisi sociosqu. Volutpat. Ridiculus nostra.
                </div>
            </div>
        </div>
    </div>
      #END# No Header Card -->
    </div>
  </section>
  <!-- Modal para iniciar sesión -->
  <div class="modal fade" id="defaultModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="defaultModalLabel">Ingresa tus datos para iniciar sesión</h4>
        </div>
        <div class="modal-body">
          <form id="sign_in">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">person</i>
              </span>
              <div class="form-line">
                <input type="email" class="form-control" id="correo" name="correo" placeholder="Correo electrónico"
                  required autofocus>
              </div>
            </div>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">lock</i>
              </span>
              <div class="form-line">
                <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña"
                  required>
              </div>
            </div>
            <div class="row">
              <div class="col-xs-1">
              </div>
              <div class="col-xs-10">
                <input id="iniciar" class="btn btn-block btn-lg bg-black waves-effect"
                  type="submit"></input>
              </div>
              <div class="col-xs-1">
              </div>
            </div>
            <div class="row m-t-15 m-b--20">
              <div class="col-xs-6">
                <a a data-toggle="modal" data-target="#defaultModal2" data-dismiss="modal">Registrate ahora!</a>
              </div>
              <div class="col-xs-6 align-right">
                <a href="recuperar-contraseña.php">¿Olvidaste tu contraseña?</a>
              </div>
            </div>
          </form>
        </div>
        <div class="modal-footer">
        </div>
      </div>
    </div>
  </div>
  <!-- Modal para registrarse -->
  <div class="modal fade" id="defaultModal2" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title" id="defaultModalLabel">Hazte nuevo miembro</h4>
        </div>
        <div class="modal-body">
          <form id="sign_up">
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">person</i>
              </span>
              <div class="form-line">
                <input type="text" class="form-control" id="txt_nombre" name="first-name" placeholder="Nombre" value="" required
                  autofocus>
              </div>
            </div>

            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">person</i>
              </span>
              <div class="form-line">
                <input type="text" class="form-control" id="txt_apellido" name="last-name" placeholder="Apellido"
                  required autofocus>
              </div>
            </div>

            <div class="input-group date" id="bs_datepicker_component_container">
              <span class="input-group-addon">
                <i class="material-icons">date_range</i>
              </span>
              <div class="form-line">
                <input type="text" class="form-control date" id="date_fecha" placeholder="Fecha de nacimiento" required
                  autofocus>
              </div>
            </div>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">email</i>
              </span>
              <div class="form-line">
                <input type="email" class="form-control" id="txt_correo" name="email" placeholder="Correo electrónico"
                  required>
              </div>
            </div>
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">phone_iphone</i>
              </span>
              <div class="form-line">
                <input type="text" id="txt_tefelono" name="phone" class="form-control mobile-phone-number"
                  placeholder="Ex: +504 9999-9999" required autofocus>
              </div>
            </div>
            <!-------------------------------------------------
            ---------------------------------------------------

            Inicio Aqui debe cargar los departamentos y municipios

            ---------------------------------------------------
            ------------------------------------------------->
            <div class="input-group">
              <span class="input-group-addon">
                <i class="material-icons">place</i>
              </span>
              <div class="form-line">
                <select class="form-control show-tick" id="int_municipio" required>

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
                  <input type="password" class="form-control"  name="password2" id="txt_contraseña" minlength="6" placeholder="Contraseña" required>
              </div>
          </div>
          <div class="input-group">
              <span class="input-group-addon">
                  <i class="material-icons">lock</i>
              </span>
              <div class="form-line">
                  <input type="password" class="form-control"  name="confirm" id="txt_contraseña2" minlength="6" placeholder="Confirme contraseña" required>
              </div>
          </div>
            <div class="form-group">
              <input type="checkbox" name="terms" id="terms" class="filled-in chk-col-pink" required>
              <label for="terms">Acepto los <a href="javascript:void(0);">terminos de usuario</a>.</label>
            </div>

            <button class="btn btn-block btn-lg bg-pink waves-effect" id="registrar" type="submit">Registrarse</button>

            <div class="m-t-25 m-b--5 align-center">
              <a a data-toggle="modal" data-target="#defaultModal" data-dismiss="modal">¿Ya eres miembro?</a>
            </div>
          </form>
        </div>
        <div class="modal-footer">
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

  <!-- Jquery Core Js -->
  <script src="plugins/jquery/jquery.min.js"></script>

  <!-- Bootstrap Core Js -->
  <script src="plugins/bootstrap/js/bootstrap.js"></script>

  <!-- Slimscroll Plugin Js -->
  <script src="plugins/jquery-slimscroll/jquery.slimscroll.js"></script>

  <!-- Waves Effect Plugin Js -->
  <script src="plugins/node-waves/waves.js"></script>

  <!-- Validation Plugin Js -->
  <script src="plugins/jquery-validation/jquery.validate.js"></script>

  <!-- Wait Me Plugin Js -->
  <script src="plugins/waitme/waitMe.js"></script>

  <!-- Custom Js -->
  <script src="js/admin.js"></script>

  <!-- Demo Js -->
  <script src="js/demo.js"></script>

  <!-- Input Mask Plugin Js -->
  <script src="plugins/jquery-inputmask/jquery.inputmask.bundle.js"></script>

  <!-- Bootstrap Tags Input Plugin Js -->
  <script src="plugins/bootstrap-tagsinput/bootstrap-tagsinput.js"></script>

  <!-- Autosize Plugin Js -->
  <script src="plugins/autosize/autosize.js"></script>

  <!-- Moment Plugin Js -->
  <script src="plugins/momentjs/moment.js"></script>

  <!-- Bootstrap Material Datetime Picker Plugin Js -->
  <script src="plugins/bootstrap-material-datetimepicker/js/bootstrap-material-datetimepicker.js"></script>

  <!-- Bootstrap Datepicker Plugin Js -->
  <script src="plugins/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>

  <!-- Custom Js -->
  <script src="js/pages/forms/basic-form-elements.js"></script>
  <script src="js/pages/ui/modals.js"></script>
  <script src="controlador/index.js"></script>
  <script src="js/pages/examples/sign-up.js"></script>
  <script src="js/pages/examples/sign-in.js"></script>

</body>

</html>