$(document).ready(function () {
    municipios();																			
    misPublicaciones();
    categoria();

    
    //PUBLICAR ANUNCIOS
    Dropzone.autoDiscover = false;
    myDropzone = new Dropzone('div#cargarFotos', {
        addRemoveLinks: true,
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 4,
        acceptedFiles: 'image/*',
        maxFiles: 4,
        maxFilesize: 2,//tamaño maxino de imagen
        paramName: 'file',
        clickable: true,
        url: '../clases/mis-publicaciones.php?accion=2',
        init: function () {

            
            var myDropzone = this;
            //VALIDAR MININO DE TAMAÑO
            this.on("thumbnail",function(file){
                if(file.accepted!==false){
                    if(file.width<300||file.height<255){
                        myDropzone.removeFile(file);
                        $("#cuerpoModal").empty();																		
					    $("#cuerpoModal").html('Favor ingrese una imagen con un minimo de resolucion de 300x255');													
					    $("#ModalMensaje").modal("show");
                    }
                    
                }
            })
            // Update selector to match your button
            $("#publicarArticulo").submit(function (e) {
                event.stopPropagation();
                e.preventDefault();
                if ( $("#publicarArticulo").valid() ) {
                    myDropzone.processQueue();
                }
                return false;
            });
            
            this.on('sending', function (file, xhr, formData) {
                // Append all form inputs to the formData Dropzone will POST
                var data = $("#publicarArticulo").serializeArray();
                $.each(data, function (key, el) {
                    formData.append(el.name, el.value);
                });
                //console.log(formData);
    
            });
        },
        error: function (file, response){
            if ($.type(response) === "string")
                var message = response; //dropzone sends it's own error messages in string
            else
                var message = response.message;
            file.previewElement.classList.add("dz-error");
            _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i];
                _results.push(node.textContent = message);
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
        }
      
    });

});

categoria = function () {														//Inicio funcion para llenar las categorias
	$.ajax({																	//Inicio ajax categorias
		url: "../clases/vistas-index.php?accion=1",
		success: function (resultado) {
            $("#categoria").append(resultado);									//El resultado lo retorna como html
		},
		error: function (error) {
            console.log(error);
		}
	});																			//Fin ajax categorias

}			
municipios = function () {														//Inicio funcion para llenar los municipios
    $.ajax({																	//Inicio ajax municipios
        url: "../clases/index.php?accion=1",
        success: function (resultado) {
            $("#int_municipio").append(resultado);								//El resultado lo retorna como html
        },
        error: function (error) {
            console.log(error);
        }
    });																			//Fin ajax municipios
};
misPublicaciones = function () { //VISTA DE MIS PUBLIACIONES
    $.ajax({
        url: "../clases/mis-publicaciones.php?accion=5",
        success: function (resp) {
            let datos = JSON.parse(resp);
            //console.log(resp);
            var tarjetas = "";
            for (let item of datos) {//RECORRER EL JSON 
                tarjetas += "<div class='col-sm-6 col-md-6 col-lg-3'>"
                    + "<div class='carde'>"
                    + "<div class='card__image-holder'>"
                    + "<img class='card__image' src='"+item.fotos[0]+"' alt='Miniatura del anuncio' max-width='300px' height='255px'/>"
                    + "</div>"
                    + "<div class='card-title'>"
                    + "<a  href='#' class='toggle-info btn'>"
                    + "<span class='left'></span>"
                    + "<span class='right'></span>"
                    + "</a>"
                    + "<h2>" +
                    item.nombre
                    + "<small>L " + item.precio + "</small>"
                    + "</h2>"
                    + "</div>"
                    + "<div class='card-flap flap1'>"
                    + "<div class='card-description'>" +
                    item.descripcion
                    + "</div>"
                    + "<div class='card-flap flap2'>"
                    + "<div class='card-actions'>"
                    + "<button type='buttom' class='btn btn-warning waves-effect' onclick='cargarDatosEditar(" + item.idAnuncios + ")' data-toggle='modal' data-target='#editarPubli'>Editar</button>"
                    + "<button type='button' class='btn btn-danger waves-effect' onclick='eliminarPublicacion(" + item.idAnuncios + ")'>Borrar</button>"
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "</div>";
                $("#contenedorTarjetas").html(tarjetas);//INSERTA LAS TARJETAS
            }
            var zindex = 10;
            $("div.carde").click(function (e) {
                e.preventDefault();
                var isShowing = false;
                if ($(this).hasClass("show")) {
                    isShowing = true
                }
                if ($("div.cards").hasClass("showing")) {
                    // a card is already in view
                    $("div.carde.show")
                        .removeClass("show");
                    if (isShowing) {
                        // this card was showing - reset the grid
                        $("div.cards")
                            .removeClass("showing");
                    } else {
                        // this card isn't showing - get in with it
                        $(this)
                            .css({ zIndex: zindex })
                            .addClass("show");
                    }
                    zindex++;
                } else {
                    // no cards in view
                    $("div.cards")
                        .addClass("showing");
                    $(this)
                        .css({ zIndex: zindex })
                        .addClass("show");
                    zindex++;
                }
            });
        },
        error: function (error) {
            console.log(error);
        }
    });
};
cargarDatosEditar = function (parametros) { ////mostrar los datos en el modal del anuncio
    event.preventDefault();
    id = parametros;
    //var parametros= "idAnuncios= "+document.getElementById("txt_idanuncios").value;

    $.ajax({
        url: "../clases/mis-publicaciones.php?accion=7",
        method: "POST",
        data: "txt_idanuncios=" + id,
        success: function (resp) {
            let datos = JSON.parse(resp);
            console.log(datos);
            var modal = "";
            for (let item of datos) {//RECORRER EL JSON 
                modal += " <div id='form_validation'>"
                    + "<div class='form-group form-float'>"
                    + "<div class='form-line'>"
                    + "<input type='text' class='form-control' name='name' id='nombre_articulo' "
                    + "placeholder=" + item.nombre + " value=" + item.nombre + ">"
                    + "</div>"
                    + "</div>"
                    + "<div class='form-group form-float'>"
                    + " <div class='form-line'>"
                    + "  <input type='number' class='form-control money-dollar' name='name' id='precioArticulo' "
                    + "  placeholder=" + item.precio + " value=" + item.precio + " required>"
                    + " </div>"
                    + "</div>"
                    + "<div class='form-group form-float'>"
                    + "<div class='form-line'>"
                    + "	<select class='form-control show-tick' name='estado' id='estadoArt' "
                    + "placeholder=" + item.estadoArticulo + " value=" + item.estadoArticulo + " required>"
                    + "<option value='" + item.estadoArticulo + "'>" + item.estadoArticulo + "</option>"
                    + "<option value='Nuev'>Nuevo</option>"
                    + "<option value='Usado'>Usado</option>"
                    + "<option value='Restaurado'>Restaurado</option>"
                    + "<option value='Dañado'>Dañado</option>"
                    + "</select>"
                    + "</div>"
                    + "</div>"
                    + "<div class='form-group form-float'>"
                    + "<div class='form-line'>"
                    + "<select class='form-control show-tick' name='categoria' id='categoriaArt'  placeholder=" + item.nombreCategoria + " value=" + item.nombreCategoria + " required>"
                    + "<option value=" + item.nombreCategoria + ">" + item.nombreCategoria + "</option>"
                    + "</select>"
                    + "</div>"
                    + "</div>"
                    + "<div class='form-group form-float'>"
                    + "	<div class='form-line'>"
                    + "<textarea name='description' id='descripcionArt' cols='30' rows='4' placeholder=" + item.descripcion + " class='form-control no-resize'>" + item.descripcion + "</textarea>"
                    + "</div>"
                    + "</div>"
                    + "</div> "
                    + "<div class='modal-footer'>"
                    + " <button type='submit' class='btn btn-default waves-effect' id='enviar_datos_editar' onclick='enviarDatosEditar(" + item.idAnuncios + ")'>Publicar</button>"
                    + "<button class='btn bg-black waves-effect waves-light' data-dismiss='modal'>Cancelar</button>"
                    + "</div>";
                $("#muestra_datos_editar").html(modal);//INSERTA LAS TARJETAS
            }
        }
    });
};

enviarDatosEditar = function (parametros) {
    event.preventDefault();
    id = parametros;
    //Petición ajax para editar anuncios
    event.preventDefault();
    $.ajax({
        url: "../clases/mis-publicaciones.php?accion=6",										//Accion para editar anuncios
        method: "POST",
        data: "nombre_articulo=" + $("#nombre_articulo").val() +
            "&precio=" + $("#precioArticulo").val() +
            "&estado=" + $("#estadoArt").val() +
            "&categoria=" + $("#categoriaArt").val() +
            "&descripcion=" + $("#descripcionArt").val() +
            "&txt_idanuncios=" + id,
        success: function (resultado) {
            $("#cuerpoModal").empty();										//Vacia el cuerpo del modal de mensaje
            $("#cuerpoModal").html(resultado);								//Imprime el cuerpo del modal de mensaje					
            $("#ModalMensaje").modal("show");
            location.reload();

            //Despliega el modal con el modal
        }
    });
};

eliminarPublicacion = function (idAnuncio) { ////Eliminar el anuncio
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
            url: "../clases/mis-publicaciones.php?accion=4",
            method: "POST",
            data: "txt_idanuncios=" + idAnuncio,
            success: function (resp) {
                console.log(resp);
                swal("Borrado!",resp, "success" );
                window.setTimeout("location.reload()",2000);
            }
        });    
    });
};

