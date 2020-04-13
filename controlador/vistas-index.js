$(document).ready(function () {																//document
    categoria();
    publicacionesInicio();			
    																//Llama la funcion municipios
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
                    + "<a href='#' class='btn' data-toggle='modal' data-target='#defaultModal'>Ver</a>"
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
																	//Fin funcion para llenar las categorias
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




		