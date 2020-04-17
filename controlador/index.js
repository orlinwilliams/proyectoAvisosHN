$(document).ready(function () {																//document
	municipios();	
	publicacionesInicioIndex();																		//Llama la funcion municipios

	$('#txt_tefelono').inputmask('+504 9999-99-99', { placeholder: '+___ ____-__-__' });	//Da formato al telefono
	$('#date_fecha').inputmask('dd/mm/yyyy', { placeholder: '__/__/____' });				//Da formato a la fecha

	
	//Funcioón al presionar el botón de registro
	$("#sign_up").submit(function (event) {										//Inicio de evento en el botón submit de registro

		event.preventDefault();

		$.ajax({																//Inicio de Ajax
			url: "clases/index.php?accion=2",
			method: "POST",
			data: "txt_nombre=" + $("#txt_nombre").val() +
				"&txt_apellido=" + $("#txt_apellido").val() +
				"&date_fecha=" + $("#date_fecha").val() +
				"&txt_correo=" + $("#txt_correo").val() +
				"&txt_tefelono=" + $("#txt_tefelono").val() +
				"&int_municipio=" + $("#int_municipio").val() +
				"&txt_contraseña=" + $("#txt_contraseña").val() +
				"&txt_contraseña2=" + $("#txt_contraseña2").val(),

			success: function (resultado) {
				console.log(resultado);
				$("#cuerpoModal").empty();										//Vacia el cuerpo del modal de mensaje
				$("#cuerpoModal").html(resultado);								//Imprime el cuerpo del modal de mensaje					
				$("#ModalMensaje").modal("show");								//Despliega el modal con el modal
			},
			error: function (error) {
				console.log(error);
			}
		});																		//Fin de Ajax 
	});																			//Fin de evento en el botón submit de registro



	//Función al presionar el botón de iniciar sesión
	$("#sign_in").submit(function (event) {										//Inicio de evento en el botón submit de registro

		event.preventDefault();

		$.ajax({																//Inicio de Ajax
			url: "clases/index.php?accion=3",
			method: "POST",
			data: "correo=" + $("#correo").val() +
				"&password=" + $("#password").val(),
			success: function (resultado) {
				respuesta = JSON.parse(resultado);									//Parsea el arreglo a JSON
				if (!respuesta.error) {												//Si no hay error entonces..
					if (respuesta.estado == 0) {				
						$("#cuerpoModal").empty();																					//Vacia el cuerpo del modal de mensaje
						$("#cuerpoModal").html('Por favor asegurate de que tu cuenta esté validada');								//Imprime el cuerpo del modal de mensaje					
						$("#ModalMensaje").modal("show");
					}
					else{
						location.href = "vistas/index.php";
					}

				}
				else {
					$("#cuerpoModal").empty();																					//Vacia el cuerpo del modal de mensaje
					$("#cuerpoModal").html('No existe un usuario con las credenciales ingresadas');								//Imprime el cuerpo del modal de mensaje					
					$("#ModalMensaje").modal("show");																			//Despliega el modal con el modal
				}
			},
			error: function (error) {
				console.log(error);
			}
		});																		//Fin de Ajax 
	});																			//Fin de evento en el botón submit de registro
});																				//document


publicacionesInicioIndex = function () { //PUBLICACIONES DE INICIO
    $.ajax({
        url: "clases/index.php?accion=5",
        success: function (resp) {
            let datos = JSON.parse(resp);
            var tarjetas = "";
            for (let item of datos) {//RECORRER EL JSON 
                tarjetas += "<div class='col-sm-6 col-md-6 col-lg-4'>"
                    + "<div class='carde'>"
                    + "<div class='card__image-holder'>"
                    + "<img class='card__image' src='" + item.fotos[0] + "' alt='Miniatura del anuncio' width='320px;' height='255px;'/>"
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
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "</div>"
                    + "</div>";
                $("#tarjeta").html(tarjetas);//INSERTA LAS TARJETAS
            }

            //var zindex = 1;
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
                            .css({ zIndex: 1 })
                            .addClass("show");
                    }
                    //zindex++;
                } else {
                    // no cards in view
                    $("div.cards")
                        .addClass("showing");
                    $(this)
                        .css({ zIndex: 2 })
                        .addClass("show");
                    //zindex++;
                }

            });
        },
        error: function (error) {
            console.log(error);
        }
    });
};

municipios = function () {														//Inicio funcion para llenar los municipios
	$.ajax({																	//Inicio ajax municipios
		url: "clases/index.php?accion=1",
		success: function (resultado) {
			$("#int_municipio").append(resultado);								//El resultado lo retorna como html
		},
		error: function (error) {
			console.log(error);
		}
	});																			//Fin ajax municipios

}																				//Fin funcion para llenar los municipios
