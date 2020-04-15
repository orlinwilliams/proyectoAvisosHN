$(document).ready(function () {																//document
    categoria();
    publicacionesInicio();			
    Dropzone.autoDiscover = false; 
    myDropzone = new Dropzone('div#subirFotos', {
        addRemoveLinks: true,
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 4,
        paramName: 'file',
        clickable: true,
        url: '../clases/mis-publicaciones.php?accion=2',
        init: function () {
    
            var myDropzone = this;
            //valide minimum size image
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

cargarArticulo = function(idAnuncio){
    event.preventDefault();
    $.ajax({
        url: "../clases/vistas-index.php?accion=4",
        method: "GET",
        data: "idAnuncio="+idAnuncio,
        success: function(resultado){
            let datos = JSON.parse(resultado);
            var img = "";
            for (var i=0; i<(datos.info.fotos).length; i++){
                img += "<img src='"+datos.info.fotos[i]+"'/>";
            }
            $("#infoArticulo").empty();
            $("#infoArticulo").html(
                "<div class='row'>"
                    +"<div class='col-md-7 col-sm-12 col-xs-12 izquierdo'>"
                        +"<div class='fotorama' data-width='100%' data-ratio='700/467' data-minwidth='400' data-maxwidth='1000' data-minheight='300' data-maxheight='100%' data-nav='thumbs' data-fit='cover' data-loop='true'>"
                            +img
                        +"</div>"
                    +"</div>"
                    +"<div class='col-md-5 col-sm-12 col-xs-12 derecho'>"
                        +"<div>"
                            +"<p class='font-categoria'><a class='links-categorias' href='#'>Categoria</a> > <a class='links-categorias' href='#'>"+datos.info.nombregrupo+"</a>> <a class='links-categorias' href='#'>"+datos.info.nombreCategoria+"</a></p>"
                        +"</div>"
                        +"<div>"
                            +"<p class='titulo'>"+datos.info.nombre+"</p>"
                        +"</div>"
                        +"<div class='precio'>"
                            +"<p class='font-precio'>"+datos.info.precio+"</p>"
                        +"</div>"
                        +"<div class='estado'>"
                            +"<p class='font-estado'><strong>Estado:</strong> "+datos.info.estadoArticulo+"</p>"
                            +"<p class='font-estado'><strong>Lugar:</strong> "+datos.info.municipio+"</p>"
                        +"</div>"
                        +"<div class='descripcion'>"
                            +"<p class='font-descripcion'><strong>Descripción:</strong></p>"
                            +"<p class='parrafo'>"+datos.info.descripcion+"</p>"
                        +"</div>"
                        +"<div class='vendedor'>"
                            +"<p class='font-vendedor'>Información del vendedor</p>"
                        +"<div class='div-imagen'>"
                            +"<a aria-label='Foto del vendedor' href='#' data-toggle='modal' data-target='#modalVendedor' data-dismiss='modal' onclick=infoVendedor("+datos.info.idUsuario+")> <img class='imagen-vendedor' src='"+datos.info.urlFoto+"' alt=''> </a>"
                        +"</div>"
                        +"<div class='div-nombre'>"
                            +"<p class='font-vendedor'><a data-toggle='modal' data-target='#modalVendedor' data-dismiss='modal'>"+datos.info.nombreUsuario+"</a></p>"
                            +"<p class='registro-de-vendedor'>Unido desde "+datos.info.fechaRegistro+"</p>"
                            +"<div class='demo-google-material-icon' style='color:black;'>"
                                +"<span class='icon-name' style='font-size:22px'><strong>Valoración:&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</strong>"+datos.info.cantidadEstrellas+"</span>"
                                    +"<i class='material-icons md-18'>star_rate</i>"
                            +"</div>"
                            +"<div class='demo-google-material-icon pb-5' style='color:black;'>"
                                +"<i class='material-icons md-24'>phone</i>"
                                    +"<span class='icon-name' style='font-size:22px'><strong>+"+datos.info.numTelefono+"</strong></span>"
                            +"</div>"
                            +"<br>"
                            +"<div>"
                                +"<div style='text-align:center;'>"
                                    +"<button class='btn btn-info btn-lg waves-effect' type='submit'>CONTACTAR</button>"
                                +"</div>"
                            +"</div>"
                        +"</div>"
                    +"</div>"
                +"</div>"
            +"</div>"
            +"<script src='https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js'></script>");
        }
    });
};

publicacionesInicio = function () { //PUBLICACIONES DE INICIO USUARIO
    $.ajax({
        url: "../clases/vistas-index.php?accion=3",
        success: function (resp) {
            let datos = JSON.parse(resp);
            var tarjetas = "";
            for (let item of datos) {//RECORRER EL JSON 
                tarjetas += "<div class='col-sm-6 col-md-6 col-lg-3'>"
                    + "<div class='carde'>"
                    + "<div class='card__image-holder'>"
                    + "<img class='card__image' src='" + item.fotos[0] + "' alt='Miniatura del anuncio' width='300px;' height='255px;'/>"
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
                    + "<a href='#' class='btn' data-toggle='modal' data-target='#defaultModal' onclick='cargarArticulo("+item.idAnuncios+")'>Ver</a>"
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "</div>";
                $("#contenedorTarjeta").html(tarjetas);//INSERTA LAS TARJETAS
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



$(function () {
    $('#publicarArticulo').validate({
        highlight: function (input) {
            console.log(input);
            $(input).parents('.form-line').addClass('error');
        },
        unhighlight: function (input) {
            $(input).parents('.form-line').removeClass('error');
        },
        errorPlacement: function (error, element) {
            $(element).parents('.input-group').append(error);
            $(element).parents('.form-group').append(error);
        }
    });
});




		