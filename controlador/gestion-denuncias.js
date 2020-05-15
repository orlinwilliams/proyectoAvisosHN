///////////////////////////////////////////// CARGAR EL DOM
$(document).ready(function () {
  tablaGestionDenuncias();
});
///////////////////////////////////////////// FUNCION PARA ELIMINAR PUBLICACIÓN
eliminarPublicacion = function (idAnuncio, idUsuario) { 
  event.preventDefault();
  swal({
      title: "¿Estás seguro?",
      text: "¡No podrá revertir este cambio!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Si, quiero borrarlo!",
      closeOnConfirm: false
  }, function () {
      $.ajax({
          url: "../clases/gestion-denuncias.php?accion=2",
          method: "POST",
          data: "txt_idanuncios=" + idAnuncio+
          "&txt_idusuario=" + idUsuario,
          success: function (resp) {
              console.log(resp);
              swal("Borrado!",resp, "success");
              tablaGestionDenuncias();
          },
      });    
  });
};
///////////////////////////////////////////// FUNCION PARA ELIMINAR USUARIO
eliminarUsuario = function (idUsuario) {
  console.log(idUsuario);
  event.preventDefault();
  swal(
    {
      title: "¿Estás seguro?",
      text: "¡No podrá revertir este cambio!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Si, quiero borrarlo!",
      closeOnConfirm: false,
    },
    function () {
      swal("Borrado!", idUsuario, "success");
      $.ajax({
        url: '../clases/gestion-usuarios.php?accion=2',
        method: 'POST',
        data: "idUsuario="+idUsuario,
        success:function (respuesta) {
          console.log(respuesta);
          cargarDatos();
          swal("Borrado!",respuesta, "success" );
        },
      });
    }
  );
};
/////////////////////////////////////////////VISTA DE LA TABLA DENUNCIAS
tablaGestionDenuncias = function () {
  $.ajax({
    url: "../clases/gestion-denuncias.php?accion=1",
    success: function (resp) {
    let datos = JSON.parse(resp);
    var filas = "";
    let i=0;
    for (let item of datos) {
      //RECORRER EL JSON
      filas +="<tr>"+
      "<td>"+item.idDenuncias+"</td>"+
      "<td>"+item.descripcion+"</td>"+
      "<td>"+item.comentarios+"</td>"+        
      "<td><a href='a' data-toggle='modal' data-target='#modalVendedor' onclick='infoVendedor("+item.idUsuario+")'>"+item.pNombre+"</a></td>"+
      "<td><a href='a' data-toggle='modal' data-target='#defaultModal' onclick='cargarArticulo("+item.idAnuncios+")'>"+item.nombre+"</a></td>"+
      "<td>"+
      "<button type='button' class='btn bg-red waves-effect' onclick='eliminarPublicacion("+item.idAnuncios+","+item.idUsuario+")'>"+
      "<i class='material-icons'>delete_forever</i>"+
      "</button>"+
      "</td>"+
      "<td style=' text-align:center;''> <button type='button' class='btn bg-red waves-effect' onclick='eliminarUsuario("+item.idUsuario+")'>"+
      "<i class='material-icons'>delete_forever</i>"+
      "</button></td>"+
      "</tr>"
      ;
      $("#tablaDenuncias").html(filas);
      //////////////////////////////////////////// DATATIME PICKER WITH MOMENTS
      i=i+1;
    }
    ///////////////////////////////////////////// FUNCIÓN PARA LA INICIALIZACIÓN DE LA TABLA
    $(function () {
      $(".js-basic-example").DataTable({
        retrieve: true,
        responsive: true,
      });
    });
    $(function () {
      //Textarea auto growth
      autosize($("textarea.auto-growth"));
      //Datetimepicker plugin
      $(".datetimepicker").bootstrapMaterialDatePicker({
        format: "YYYY-MM-DD HH:mm",
        clearButton: true,
        weekStart: 1,
        linkField : "fecha1" ,
      });
    });
  },
  error: function (error) {
    console.log(error);
  },
});
};
///////////////////////////////////////////// FUNCION PARA CARGAR LA INFORMACIÓN DEL ARTÍCULO
cargarArticulo = function (idAnuncio) {
  event.preventDefault();
  $.ajax({
    url: "../clases/vistas-index.php?accion=4",
    method: "GET",
    data: "idAnuncio=" + idAnuncio,
    success: function (resultado) {
      let datos = JSON.parse(resultado);
      var img = "";
      for (var i = 0; i < datos.info.fotos.length; i++) {
        img += "<img src='" + datos.info.fotos[i] + "'/>";
      }
      $("#infoArticulo").empty();
      $("#infoArticulo").html(
        "<div class='row'>" +
          "<div class='col-md-7 col-sm-12 col-xs-12 izquierdo'>" +
          "<div class='fotorama' data-width='100%' data-ratio='700/467' data-minwidth='400' data-maxwidth='1000' data-minheight='300' data-maxheight='100%' data-nav='thumbs' data-fit='cover' data-loop='true'>" +
          img +
          "</div>" +
          "</div>" +
          "<div class='col-md-5 col-sm-12 col-xs-12 derecho'>" +
          "<div>" +
          "<p class='font-categoria'><a class='links-categorias' href='#'>Categoria</a> <a class='links-categorias' href='#'>" +
          datos.info.nombregrupo +
          "</a> <a class='links-categorias' href='#'>" +
          datos.info.nombreCategoria +
          "</a></p>" +
          "<ul class='header-dropdown m-r--5' style='margin-top:-30px; margin-left:88%;  list-style:none;'>" +
          "<li class='dropdown'>" +
          "<a href='javascript:void(0);' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>" +
          "<i class='material-icons'>more_vert</i>" +
          "</a>" +
          "<ul class='dropdown-menu pull-right'>" +
          "<li><a href='#' data-toggle='modal' data-target='#denuncias'>Denunciar</a></li>" +
          "<li><a href='javascript:void(0);'>Agregar a favoritos</a></li>" +
          "<li><a href='#' data-toggle='modal' data-target='#modalCompartir'>Compartir</a></li>" +
          "</ul>" +
          "</li>" +
          "</ul>" +
          "<div>" +
          "<p class='titulo'>" +
          datos.info.nombre +
          "</p>" +
          "</div>" +
          "<div class='precio'>" +
          "<p class='font-precio'>" +
          datos.info.precio +
          "</p>" +
          "</div>" +
          "<div class='estado'>" +
          "<p class='font-estado'><strong>Estado:</strong> " +
          datos.info.estadoArticulo +
          "</p>" +
          "<p class='font-estado'><strong>Lugar:</strong> " +
          datos.info.municipio +
          "</p>" +
          "</div>" +
          "<div class='descripcion'>" +
          "<p class='font-descripcion'><strong>Descripción:</strong></p>" +
          "<p class='parrafo'>" +
          datos.info.descripcion +
          "</p>" +
          "</div>" +
          "<div class='vendedor'>" +
          "<p class='font-vendedor'>Información del vendedor</p>" +
          "<div class='div-imagen'>" +
          "<a aria-label='Foto del vendedor' data-toggle='modal'  data-target='#modalVendedor' data-dismiss='modal' onclick=infoVendedor(" +
          datos.info.idUsuario +
          ")>" +
          "<img class='imagen-vendedor' src='" +
          datos.info.urlFoto +
          "' alt=''> </a>" +
          "</div>" +
          "<div class='div-nombre'>" +
          "<p class='font-vendedor'><a data-toggle='modal' data-target='#modalVendedor' data-dismiss='modal' onclick=infoVendedor(" +
          datos.info.idUsuario +
          ")>" +
          datos.info.nombreUsuario +
          "</a></p>" +
          "<p class='registro-de-vendedor'>Unido desde " +
          datos.info.fechaRegistro +
          "</p>" +
          "<div class='demo-google-material-icon' style='color:black;'>" +
          "<span class='icon-name' style='font-size:22px'><strong>Valoración:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>" +
          datos.info.valoración +
          "</span>" +
          "<script>$('#estrella').starrr({rating:" +
          datos.info.valoración +
          ",change:function(e,valor){console.log(valor); var estrellas=valor; $.ajax({url:'../clases/vistas-index.php?accion=9',method: 'post', data: 'valoracion='+estrellas,success: function(resp){console.log(resp)}})}});</script>" +
          "<span id='estrella'></span>" +
          "</div>" +
          "<div class='demo-google-material-icon pb-5' style='color:black;'>" +
          "<i class='material-icons md-24'>phone</i>" +
          "<span class='icon-name' style='font-size:22px'><strong>+" +
          datos.info.numTelefono +
          "</strong></span>" +
          "</div>" +
          "<br>" +
          "<div>" +
          "<div style='text-align:center;'>" +
          "<button class='btn btn-info btn-lg waves-effect' type='submit' data-toggle='modal' data-target='#modalContacto'onclick='cargarDatosContacto(" +
          idAnuncio +
          ")' >CONTACTAR</button>" +
          "</div>" +
          "</div>" +
          "</div>" +
          "</div>" +
          "</div>" +
          "</div>" +
          "<script src='https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js'></script>"
      );
    },
  });
};
///////////////////////////////////////////// FUNCION PARA CARGAR LA INFORMACIÓN DEL VENDEDOR
infoVendedor = function (idUsuario) {
  $.ajax({
    url: "../clases/vistas-index.php?accion=5",
    method: "GET",
    data: "idUsuario=" + idUsuario,
    success: function (resp) {
      var datos = JSON.parse(resp);
      historialAnuncios = "";
      for (var i = 0; i < datos.anunciosVendedor.length; i++) {
        historialAnuncios +=
          "<li>" +
          "<div class='title'>" +
          datos.anunciosVendedor[i].nombreAnuncio +
          "</div>" +
          "<div class='content'>" +
          "<div style='float:left;'>" +
          datos.anunciosVendedor[i].fechaAnuncio +
          "</div>" +
          "<div style='margin-left:90%'>" +
          "L " +
          datos.anunciosVendedor[i].precioAnuncio +
          "</div>" +
          "</div>" +
          "</li>";
      }
      comentarios = "";
      if (datos.comentariosVendedor.error == true) {
        comentarios =
          "<li>" +
          "<div class='title'>" +
          "</div>" +
          "<div class='content'>" +
          "<div>" +
          "<p>" +
          "Sin comentarios todavia" +
          "</p>" +
          "</div>" +
          "</div>" +
          "</li>";
      } else {
        for (var i = 0; i < datos.comentariosVendedor.length; i++) {
          comentarios +=
            "<li>" +
            "<div class='title'>" +
            datos.comentariosVendedor[i].nombreComprador +
            "</div>" +
            "<div class='content'>" +
            "<div>" +
            "<p>" +
            datos.comentariosVendedor[i].comentario +
            "</p>" +
            "</div>" +
            "</div>" +
            "</li>";
        }
      }
      var nombreCompleto =
        datos.datosVendedor.pNombre + " " + datos.datosVendedor.pApellido;
      //console.log(datos);
      var modal =
        "<div class='modal-header' style='text-align:center'>" +
        "<h4 class='modal-title' id='defaultModalLabel'></h4>" +
        "</div>" +
        "<div class='modal-body modal-body-per'>" +
        "<div class='card profile-card'>" +
        "<div class='profile-header'>&nbsp;</div>" +
        "<div class='profile-body'>" +
        "<div class='image-area'>" +
        "<img src=" +
        datos.datosVendedor.urlFoto +
        " alt=" +
        nombreCompleto +
        " width='200px' height='200px' />" +
        "</div>" +
        "<div class='content-area'>" +
        "<h3>" +
        nombreCompleto +
        "</h3>" +
        "<p>" +
        datos.datosVendedor.fechaRegistro +
        "</p>" +
        "<p>" +
        datos.datosVendedor.tipoUsuario +
        "</p>" +
        "</div>" +
        "</div>" +
        "<div class='profile-footer'>" +
        "<ul>" +
        "<li>" +
        "<span>Valoración</span>" +
        "<span>" +
        datos.datosVendedor.cantidadEstrellas +
        "</span>" +
        "</li>" +
        "<li>" +
        "<span>ArticulosPublicados</span>" +
        "<span>" +
        datos.datosVendedor.cantidadAnuncio +
        "</span>" +
        "</li>" +
        "<li>" +
        "<span>Correo Electrónico</span>" +
        "<span>" +
        datos.datosVendedor.correoElectronico +
        "</span>" +
        "</li>" +
        "</ul>" +
        "</div>" +
        "</div>" +
        "<div class='card card-about-me' style='max-height:400px; overflow-y:scroll;'>" +
        "<div class='header' style='text-align:center'>" +
        "<h2>Últimos comentarios</h2>" +
        "<p><button type='button' class='btn bg-light-green btn-circle waves-effect waves-circle waves-float' data-toggle='collapse' href='#collapseExample' id='botonComentario' aria-expanded='false'" +
        "aria-controls='collapseExample'>" +
        "<i class='material-icons'>chat</i>" +
        "</button></p>" +
        "<div class='collapse' id='collapseExample'>" +
        "<div class='well'>" +
        "<textarea id='comentario' name='comentario' cols='30' rows='4' class='form-control no-resize'></textarea>" +
        "</div>" +
        "<button id='enviarComentario' class='btn btn-default waves-effect'>AGREGAR COMENTARIO</button>" +
        "</div>" +
        "<p id='mensajeComentario'></p>" +
        "</div>" +
        "<div class='body' style='height: auto;'>" +
        "<ul id='agregarComentario'>" +
        comentarios +
        "</ul>" +
        "</div>" +
        "</div>" +
        "<div class='card card-about-me' style='max-height:400px; overflow-y:scroll;'>" +
        "<div class='header' style='text-align:center'>" +
        "<h2>HISTORIAL</h2>" +
        "<small>(Se mantiene el registro de los últimos 90 días)</small>" +
        "</div>" +
        "<div class='body' style='height: auto;'>" +
        "<ul>" +
        historialAnuncios +
        "</ul>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "<div class='modal-footer'>" +
        "<button type='button' class='btn btn-link waves-effect'" +
        "data-dismiss='modal'>Cerrar</button>" +
        "</div>";
      $("#contenidoModalVendedor").empty();
      $("#contenidoModalVendedor").html(modal);

      $("#enviarComentario").click(function (e) {
        e.preventDefault();
        comentario = $("#comentario").val();
        if (comentario != "" && comentario != null) {
          $.ajax({
            url: "../clases/vistas-index.php?accion=8",
            method: "POST",
            data: "comentario=" + comentario + "&idUsuario=" + idUsuario,
            success: function (resp) {
              //console.log(resp);
              datos = JSON.parse(resp);
              if (datos.error == false) {
                $("#agregarComentario").prepend(
                  "<li>" +
                    "<div class='title'>" +
                    datos.nombreComprador +
                    "</div>" +
                    "<div class='content'>" +
                    "<div>" +
                    "<p>" +
                    comentario +
                    "</p>" +
                    "</div>" +
                    "</div>" +
                    "</li>"
                );
                //console.log("comentario agregado con exito");
                $("#mensajeComentario").html(datos.mensaje);
                $("#comentario").val("");
                $("#botonComentario").click();
              }
              if (datos.error == true) {
                $("#mensajeComentario").html(datos.mensaje);
                $("#comentario").val("");
                $("#botonComentario").click();
              }
            },
            error: function (error) {
              console.log(error);
            },
          });
        } else {
          $("#mensajeComentario").html("Favor ingrese su comentario");
        }
      });
    },
    error: function (error) {
      console.log(error);
    },
  });
};