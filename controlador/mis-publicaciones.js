$(document).ready(function () {
  municipios2();
  misPublicaciones();
  categoria2();
  $().button(".toggle");

  //PUBLICAR ANUNCIOS
  Dropzone.autoDiscover = false;
  myDropzone = new Dropzone("div#cargarFotos", {
    addRemoveLinks: true,
    autoProcessQueue: false,
    uploadMultiple: true,
    parallelUploads: 4,
    acceptedFiles: "image/*",
    maxFiles: 10, //CANTIDAD DE IMAGES
    maxFilesize: 2, //tamaño maxino de imagen
    paramName: "file",
    clickable: true,
    url: "../clases/mis-publicaciones.php?accion=2",
    init: function () {
      var myDropzone = this;
      //VALIDAR MININO DE TAMAÑO
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
      this.on("success", function (file, response) {
        //alert("Anuncio publicado correctamente");
        $("#modalArticulo").hide("slow");
        showSuccessMessage();
        function showSuccessMessage() {
          swal(
            "Anuncio publicado Correctamente!",
            "Presiona ok para seguir navengando!",
            "success"
          );
          $("button.confirm").click(() => {
            location.reload();
          });
        }
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
  //BUSCADOR
  $("#buscaAnuncio").keyup(function () {
    var value = $("#buscaAnuncio").val();
    //console.log(value);
      if(value==""){
        console.log("palabra sin sentido");
      }
      else if(value==" "){
        console.log("palabra sin sentido");
      }
      else if(value.length<2){
        console.log("palabra sin sentido");
      }
      else{

        $.ajax({
          url: "../clases/buscador.php?accion=2",
          method: "POST",
          data: "value=" + value,
          success: function (resp) {
            let datos = JSON.parse(resp);
            //console.log(resp);
            var tarjetas = "";
            if (datos.error == true) {
              console.log(datos.mensaje);
            } else {
              for (let item of datos) {
                //RECORRER EL JSON
                tarjetas +=
                  "<div class='col-sm-6 col-md-6 col-lg-4'>" +
                  "<div class='carde'>" +
                  "<div class='card__image-holder'>" +
                  "<img class='card__image' src='" +
                  item.fotos[0] +
                  "' alt='Miniatura del anuncio' max-width='320px' height='255px'/>" +
                  "</div>" +
                  "<div class='card-title'>" +
                  "<a  href='#' class='toggle-info btn'>" +
                  "<span class='left'></span>" +
                  "<span class='right'></span>" +
                  "</a>" +
                  "<h2>" +
                  item.nombre +
                  "<small>" +
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
                  "<button type='buttom' class='btn btn-warning waves-effect' onclick='cargarDatosFormulario(" +
                  item.idAnuncios +
                  ")' data-toggle='modal' data-target='#editarPubli'>Editar</button>" +
                  "<button type='button' class='btn btn-danger waves-effect' onclick='eliminarPublicacion(" +
                  item.idAnuncios +
                  ")'>Borrar</button>" +
                  "</div>" +
                  "</div>" +
                  "</div>" +
                  "</div>" +
                  "</div>";
                $("#contenedorTarjetas").empty();
                $("#contenedorTarjetas").html(tarjetas); //INSERTA LAS TARJETAS
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
          },
        });

      }
  });
});

categoria2 = function () {
  //Inicio funcion para llenar las categorias
  $.ajax({
    //Inicio ajax categorias
    url: "../clases/vistas-index.php?accion=1",
    success: function (resultado) {
      $("#categoria").append(resultado);
      $("#categoriaArt").append(resultado);
      //El resultado lo retorna como html
    },
    error: function (error) {
      console.log(error);
    },
  }); //Fin ajax categorias
};

municipios2 = function () {
  
  //Inicio funcion para llenar los municipios
  $.ajax({
    //Inicio ajax municipios
    url: "../clases/vistas-index.php?accion=2",
    success: function (resultado) {
      //console.log(resultado);
      
      $("#lugarMunicipios").append(resultado);
    },
    error: function (error) {
      console.log(error);
    },
  }); //Fin ajax municipios
}; //Fin funcion para llenar los municipios

misPublicaciones = function () {
  //VISTA DE MIS PUBLIACIONES
  $.ajax({
    url: "../clases/mis-publicaciones.php?accion=5",
    success: function (resp) {
      let datos = JSON.parse(resp);
      //console.log(resp);
      var tarjetas = "";
      if (datos.error == true) {
        console.log(datos.mensaje);
        showAutoCloseTimerMessage();
        function showAutoCloseTimerMessage() {
          swal({
            title: "Mensaje",
            text:
              "No has publicado todavia, utiliza el boton de publicar anuncio de la parte inferior derecha",
            timer: 4500,
            showConfirmButton: false,
          });
        }
      } else {
        for (let item of datos) {
          //RECORRER EL JSON
          tarjetas +=
            "<div class='col-sm-6 col-md-6 col-lg-4'>" +
            "<div class='carde'>" +
            "<div class='card__image-holder'>" +
            "<img class='card__image' src='" +
            item.fotos[0] +
            "' alt='Miniatura del anuncio' max-width='320px' height='255px'/>" +
            "</div>" +
            "<div class='card-title'>" +
            "<a  href='#' class='toggle-info btn'>" +
            "<span class='left'></span>" +
            "<span class='right'></span>" +
            "</a>" +
            "<h2>" +
            item.nombre +
            "<small>" +
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
            "<button type='buttom' class='btn btn-warning waves-effect' onclick='cargarDatosFormulario(" +
            item.idAnuncios +
            ")' data-toggle='modal' data-target='#editarPubli'>Editar</button>" +
            "<button type='button' class='btn btn-danger waves-effect' onclick='eliminarPublicacion(" +
            item.idAnuncios +
            ")'>Borrar</button>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>" +
            "</div>";
          $("#contenedorTarjetas").html(tarjetas); //INSERTA LAS TARJETAS
        }
        //var zindex = 1;
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
    },
  });
};
eliminarPublicacion = function (idAnuncio) {
  ////Eliminar el anuncio
  event.preventDefault();
  swal(
    {
      title: "¿Estás seguro?",
      text:
        "<p>¡No podrá revertir este cambio!</p>" +
        "<p>¡Por favor cuentanos por qué la borras!</p>" +
        "<br>"+
        "<div class='row'>"+
            "<div class='col-md-2'>"+
            "</div>"+
            "<div class='col-md-8'>"+
                "<div class='form-group form-float'>" +
                    "<div class='form-line'>" +
                        "<select class='form-control show-tick' id='razon' placeholder='Eliga una opción por favor'>" +
                            "<option value=''></option>" +
                            "<option value='Vendido'>Vendido</option>" +
                            "<option value='Cambié de parecer, no quiero ponerlo en venta'>Cambié de parecer, no quiero ponerlo en venta</option>" +
                            "<option value='Porque quiero'>Porque quiero</option>" +
                            "<option value='Otra razón'>Otra razón</option>" +
                        "</select>" +
                    "</div>" +
                "</div>" +
            "</div>"+
            "<div class='col-md-2'>"+
            "</div>"+
        "</div>",
      html: true,
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Si, quiero borrarlo!",
      closeOnConfirm: false,
    },
    function () {
        let razon= $("#razon").val();
        console.log(razon);
      $.ajax({
        url: "../clases/mis-publicaciones.php?accion=4",
        method: "POST",
        data: "txt_idanuncios=" + idAnuncio + "&razon=" + razon,
        success: function (resp) {
          console.log(resp);
          swal("Borrado!", resp, "success");
          window.setTimeout("location.reload()", 2000);
        },
      });
    }
  );
};