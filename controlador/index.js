$(document).ready(function () {																//document

	municipios();																			//Llama la funcion municipios

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



	//Funcioón al presionar el botón de iniciar sesión
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
					if (respuesta.tipo == 'Miembro' || respuesta.tipo == 'Administrador') {				
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
