$(document).ready(function () {
  //document
  municipios();
  categoria();
  publicacionesInicio();
  Dropzone.autoDiscover = false;
  myDropzone = new Dropzone("div#subirFotos", {
    addRemoveLinks: true,
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 100,
    maxFiles: 4,
    paramName: "file",
    clickable: true,
    url: "../clases/mis-publicaciones.php?accion=2",
    init: function () {
      var myDropzone = this;
      //valide minimum size image
      this.on("thumbnail", function (file) {
        if (file.accepted !== false) {
          if (file.width < 300 || file.height < 255) {
            myDropzone.removeFile(file);
            $("#cuerpoModal").empty();
            $("#cuerpoModal").html(
              "Favor ingrese una imagen con un minimo de resolucion de 300x255"
            );
            $("#ModalMensaje").modal("show");
          }
        }
      });

      // Update selector to match your button
      $("#publicarArticulo").submit(function (e) {
        event.stopPropagation();
        e.preventDefault();
        if ($("#publicarArticulo").valid()) {
          myDropzone.processQueue();
        }
        return false;
      });

      this.on("sending", function (file, xhr, formData) {
        // Append all form inputs to the formData Dropzone will POST
        var data = $("#publicarArticulo").serializeArray();
        $.each(data, function (key, el) {
          formData.append(el.name, el.value);
        });
        //console.log(formData);
      });
    },
    error: function (file, response) {
      if ($.type(response) === "string") var message = response;
      //dropzone sends it's own error messages in string
      else var message = response.message;
      file.previewElement.classList.add("dz-error");
      _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
      _results = [];
      for (_i = 0, _len = _ref.length; _i < _len; _i++) {
        node = _ref[_i];
        _results.push((node.textContent = message));
      }
      return _results;
    },
    successmultiple: function (file, response) {
      console.log(file, response);
      //$modal.modal("show");
    },
    completemultiple: function (file, response) {
      console.log(file, response, "completemultiple");
      //$modal.modal("show");
    },
    reset: function () {
      console.log("resetFiles");
      //this.removeAllFiles(true);
    },
  });

  var rangeSlider = document.getElementById("nouislider_range_example");
  noUiSlider.create(rangeSlider, {
    start: [0, 25000],
    connect: true,
    range: {
      min: 0,
      max: 100000,
    },
  });
  getNoUISliderValue(rangeSlider, false);

  //BUSCADOR
  $("#buscaAnuncio").keyup(function(){
    var value=$("#buscaAnuncio").val();
    //console.log(value);
    $.ajax({
        url: "../clases/buscador.php?accion=1",
        method:'POST',
        data:"value="+value,
        success: function (resp) {

            let datos = JSON.parse(resp);
            //console.log(resp);
            var tarjetas = "";
            if(datos.error==true){
                console.log("no se encontraron coincidencias");
            }
            else{
                for (let item of datos) {
                    //RECORRER EL JSON
                    tarjetas +=
                      "<div class='col-sm-6 col-md-6 col-lg-4'>" +
                      "<div class='carde'>" +
                      "<div class='card__image-holder'>" +
                      "<img class='card__image' src='" +
                      item.fotos[0] +
                      "' alt='Miniatura del anuncio' width='320px;' height='255px;'/>" +
                      "</div>" +
                      "<div class='card-title'>" +
                      "<a  href='#' class='toggle-info btn'>" +
                      "<span class='left'></span>" +
                      "<span class='right'></span>" +
                      "</a>" +
                      "<h2>" +
                      item.nombre +
                      "<small>L " +
                      item.precio +
                      "</small>" +
                      "</h2>" +
                      "</div>" +
                      "<div class='card-flap flap1'>" +
                      "<div class='card-description'>" +
                      item.descripcion +
                      "</div>" +
                      "<div class='card-flap flap2'>" +
                      "<div class='card-actions'>" +
                      "<a href='#' class='btn' data-toggle='modal' data-target='#defaultModal' onclick='cargarArticulo(" +
                      item.idAnuncios +
                      ")'>Ver</a>" +
                      "</div>" +
                      "</div>" +
                      "</div>" +
                      "</div>" +
                      "</div>";
                    $("#contenedorTarjeta").html(tarjetas); //INSERTA LAS TARJETAS
                    
                }
                $("div.carde").click(function (e) {
                    e.preventDefault();
                    var isShowing = false;
                    if ($(this).hasClass("show")) {
                      isShowing = true;
                    }
                    if ($("div.cards").hasClass("showing")) {
                      // a card is already in view
                      $("div.carde.show").removeClass("show");
                      if (isShowing) {
                        // this card was showing - reset the grid
                        $("div.cards").removeClass("showing");
                      } else {
                        // this card isn't showing - get in with it
                        $(this).css({ zIndex: 1 }).addClass("show");
                      }
                      //zindex++;
                    } else {
                      // no cards in view
                      $("div.cards").addClass("showing");
                      $(this).css({ zIndex: 2 }).addClass("show");
                      //zindex++;
                    }
                });



            }
            

            
        },
        error: function (error) {
            console.log(error);
        }
    });	
})







});

categoria = function () {
  //Inicio funcion para llenar las categorias
  $.ajax({
    //Inicio ajax categorias
    url: "../clases/vistas-index.php?accion=1",
    success: function (resultado) {
        //console.log(resultado);
      $("#f-categoria").append(resultado); //El resultado lo retorna como html
      $("#categoria").append(resultado); //El resultado lo retorna como html
    },
    error: function (error) {
      console.log(error);
    },
  }); //Fin ajax categorias
};

infoVendedor = function (idUsuario) {
  $.ajax({
    url: "../clases/vistas-index.php?accion=5",
    method: "GET",
    data: "idUsuario=" + idUsuario,
    success: function (resp) {
      var datos = JSON.parse(resp);
      console.log(datos);
      historialAnuncios="";

      for (var i = 0; i < datos.anunciosVendedor.length; i++) {
        historialAnuncios+="<li>" +
          "<div class='title'>" +
          datos.anunciosVendedor[i].nombreAnuncio +
          "</div>" +
          "<div class='content'>" +
          "<div style='float:left;'>" +
          datos.anunciosVendedor[i].fechaAnuncio +
          "</div>" +
          "<div style='margin-left:90%'>" +
         "L "+datos.anunciosVendedor[i].precioAnuncio +
          "</div>" +
          "</div>" +
          "</li>";
      }
      comentarios="";
      if(datos.comentariosVendedor.error==true){
        comentarios="<li>" +
        "<div class='title'>" +
        "</div>" +
        "<div class='content'>" +
        "<div>" +
        "<p>"+
        "Sin comentarios todavia"+
        "</p>" +
        "</div>" +
        "</div>" +
        "</li>" ;
      }
      else{
        for (var i = 0; i < datos.comentariosVendedor.length; i++) {
          comentarios+="<li>" +
          "<div class='title'>" +
          datos.comentariosVendedor[i].nombreComprador +
          "</div>" +
          "<div class='content'>" +
          "<div>" +
          "<p>"+
          datos.comentariosVendedor[i].comentario+
          "</p>" +
          "</div>" +
          "</div>" +
          "</li>" ;
  
  
        }
      }
      
      
      
      
      var nombreCompleto = datos.datosVendedor.pNombre + " " + datos.datosVendedor.pApellido;
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
        "<p><button type='button' class='btn bg-light-green btn-circle waves-effect waves-circle waves-float' data-toggle='collapse' href='#collapseExample' id='botonComentario' aria-expanded='false'"+
        "aria-controls='collapseExample'>"+
        "<i class='material-icons'>chat</i>"+
        "</button></p>"+
        "<div class='collapse' id='collapseExample'>"+
        "<div class='well'>"+
        "<textarea id='comentario' name='comentario' cols='30' rows='4' class='form-control no-resize'></textarea>"+ 
        "</div>"+
        "<button id='enviarComentario' class='btn btn-default waves-effect'>AGREGAR COMENTARIO</button>"+
        "</div>"+
        "<p id='mensajeComentario'></p>"+
        "</div>" +
        "<div class='body' style='height: auto;'>" +
        "<ul id='agregarComentario'>" +
        comentarios+
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
        historialAnuncios+
        "</ul>" +
        "</div>" +
        "</div>" +
        "</div>" +
        "<div class='modal-footer'>" +
        "<button type='button' class='btn btn-link waves-effect' data-toggle='modal' data-target='#defaultModal'" +
        "data-dismiss='modal'>Cerrar</button>" +
        "</div>" +
        "<script src='https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js'></script>";
      $("#contenidoModalVendedor").empty();
      $("#contenidoModalVendedor").html(modal);

      $("#enviarComentario").click(function(e){
        e.preventDefault();
        comentario=$("#comentario").val();
        if(comentario!="" && comentario!=null){
          $.ajax({
            url:"../clases/vistas-index.php?accion=8",
            method: "POST",
            data: "comentario="+comentario+"&idUsuario="+idUsuario,
            success:function(resp){
              //console.log(resp);
              datos=JSON.parse(resp);
              if(datos.error==false){
                $("#agregarComentario").prepend("<li>" +
                "<div class='title'>" +
                datos.nombreComprador+
                "</div>" +
                "<div class='content'>" +
                "<div>" +
                "<p>"+
                comentario+
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
              if(datos.error==true){
                $("#mensajeComentario").html(datos.mensaje);
                $("#comentario").val("");
                $("#botonComentario").click();
              }


  
            },
            error:function(error){
              console.log(error);
  
            }
    
          });
        }
        else{
          $("#mensajeComentario").html("Favor ingrese su comentario");
        }
        
      })
      
    },
 

    error: function (error) {
      console.log(error);
    },
  });
};


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
              "<p class='font-categoria'><a class='links-categorias' href='#'>Categoria</a> <a class='links-categorias' href='#'>" + datos.info.nombregrupo + "</a> <a class='links-categorias' href='#'>" + datos.info.nombreCategoria +"</a></p>" +
                "<ul class='header-dropdown m-r--5' style='margin-top:-30px; margin-left:88%;  list-style:none;'>"+
                  "<li class='dropdown'>"+
                      "<a href='javascript:void(0);' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>"+
                          "<i class='material-icons'>more_vert</i>"+
                      "</a>"+
                      "<ul class='dropdown-menu pull-right'>"+
                          "<li><a href='javascript:void(0);'>Denunciar</a></li>"+
                          "<li><a href='javascript:void(0);'>Agregar a favoritos</a></li>"+                    
                      "</ul>"+
                  "</li>"+
              "</ul>"+
          "<div>" +
            "<p class='titulo'>" + datos.info.nombre +
            "</p>" +
          "</div>" +
          "<div class='precio'>" +
            "<p class='font-precio'>" + datos.info.precio +"</p>" +
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
          "<span class='icon-name' style='font-size:22px'><strong>Valoración:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>" + datos.info.valoración +"</span>" +
          "<script>$('#estrella').starrr({rating:" + datos.info.valoración +",change:function(e,valor){console.log(valor); var estrellas=valor; $.ajax({url:'../clases/vistas-index.php?accion=9',method: 'post', data: 'valoracion='+estrellas,success: function(resp){console.log(resp)}})}});</script>"+
          "<span id='estrella'></span>"+
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

publicacionesInicio = function () {
  //PUBLICACIONES DE INICIO USUARIO
  $.ajax({
    url: "../clases/vistas-index.php?accion=3",
    success: function (resp) {
      let datos = JSON.parse(resp);
      var tarjetas = "";
      for (let item of datos) {
        //RECORRER EL JSON
        tarjetas +=
          "<div class='col-sm-6 col-md-6 col-lg-4'>" +
          "<div class='carde'>" +
          "<div class='card__image-holder'>" +
          "<img class='card__image' src='" +
          item.fotos[0] +
          "' alt='Miniatura del anuncio' width='320px;' height='255px;'/>" +
          "</div>" +
          "<div class='card-title'>" +
          "<a  href='#' class='toggle-info btn'>" +
          "<span class='left'></span>" +
          "<span class='right'></span>" +
          "</a>" +
          "<h2>" +
          item.nombre +
          "<small>L " +
          item.precio +
          "</small>" +
          "</h2>" +
          "</div>" +
          "<div class='card-flap flap1'>" +
          "<div class='card-description'>" +
          item.descripcion +
          "</div>" +
          "<div class='card-flap flap2'>" +
          "<div class='card-actions'>" +
          "<a href='#' class='btn' data-toggle='modal' data-target='#defaultModal' onclick='cargarArticulo(" +
          item.idAnuncios +
          ")'>Ver</a>" +
          "</div>" +
          "</div>" +
          "</div>" +
          "</div>" +
          "</div>";
        $("#contenedorTarjeta").html(tarjetas); //INSERTA LAS TARJETAS
      }

      //var zindex = 10;
      $("div.carde").click(function (e) {
        e.preventDefault();
        var isShowing = false;
        if ($(this).hasClass("show")) {
          isShowing = true;
        }
        if ($("div.cards").hasClass("showing")) {
          // a card is already in view
          $("div.carde.show").removeClass("show");
          if (isShowing) {
            // this card was showing - reset the grid
            $("div.cards").removeClass("showing");
          } else {
            // this card isn't showing - get in with it
            $(this).css({ zIndex: 1 }).addClass("show");
          }
          //zindex++;
        } else {
          // no cards in view
          $("div.cards").addClass("showing");
          $(this).css({ zIndex: 2 }).addClass("show");
          //zindex++;
        }
      });
    },
    error: function (error) {
      console.log(error);
    },
  });
};

cargarDatosContacto = function (parametros) {
  ////mostrar los datos en el de contacto con vendedor
  event.preventDefault();
  id = parametros;
  $.ajax({
    url: "../clases/vistas-index.php?accion=6",
    method: "POST",
    data: "idAnuncio2=" + id,

    success: function (resp) {
      let dato = resp;
      console.log(dato);
      var modal = "";
      modal +=
        "<div class='form-group'>" +
        "<div class='form-line' id='descrip'>" +
        "<textarea rows='2' id='mensaje1' class='form-control no-resize' placeholder=''>Me siento interesado en el articulo" +
        dato +
        "</textarea>" +
        "</div>" +
        "</div>" +
        "<div class='modal-footer'>" +
        "<button type='button' class='btn btn-link  waves-effect' onclick='enviarCorreoContacto(" +
        id +
        ")'>ENVIAR</button>" +
        "<button type='button' class='btn btn-link  bg-red waves-effect' data-dismiss='modal'>CANCELAR</button>" +
        "</div>";
      $("#descrip").html(modal);
    },
  });
};

enviarCorreoContacto = function (parametros) {
  event.preventDefault();
  id = parametros;
  //Petición ajax enviar correo al vendedor
  event.preventDefault();
  $.ajax({
    url: "../clases/vistas-index.php?accion=7", //Accion para editar anuncios
    method: "POST",
    data: "mensaje1=" + $("#mensaje1").val() + "&idanuncio3=" + id,
    success: function (resultado) {
      $("#cuerpoModal").empty(); //Vacia el cuerpo del modal de mensaje
      $("#cuerpoModal").html(resultado); //Imprime el cuerpo del modal de mensaje
      $("#ModalMensaje").modal("show");
      location.reload();

      //Despliega el modal con el modal
    },
  });
};

$(function () {
  $("#publicarArticulo").validate({
    highlight: function (input) {
      console.log(input);
      $(input).parents(".form-line").addClass("error");
    },
    unhighlight: function (input) {
      $(input).parents(".form-line").removeClass("error");
    },
    errorPlacement: function (error, element) {
      $(element).parents(".input-group").append(error);
      $(element).parents(".form-group").append(error);
    },
  });
});
//Get noUISlider Value and write on
function getNoUISliderValue(slider, percentage) {
    slider.noUiSlider.on('update', function () {
        var val = slider.noUiSlider.get();
        if (percentage) {
            val = +parseInt(val);
            val += '%';
        }
        $(slider).parent().find('span.js-nouislider-value').text("L "+val);
    });
}

municipios = function () {														//Inicio funcion para llenar los municipios
	$.ajax({																	//Inicio ajax municipios
		url: "../clases/vistas-index.php?accion=2",
		success: function (resultado) {
      //console.log(resultado);
			$("#lugar").append(resultado);								//El resultado lo retorna como html
		},
		error: function (error) {
			console.log(error);
		}
	});																			//Fin ajax municipios

}																				              //Fin funcion para llenar los municipios