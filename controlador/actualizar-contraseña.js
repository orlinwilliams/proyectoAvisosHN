$(document).ready(function(){

    //validacion de formularios;
    $(function () {
        $('#recuperar_contraseña').validate({
            rules: {
                'confirm': {
                    equalTo: '[name="password2"]'
                }
            },
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

    // ENVIAR SOLICITUD DE RESTABLECER LA CONTRASEÑA POR CORREO
	$("#restablecer").submit(function (event) {
		event.preventDefault();
		$.ajax({
			url:"clases/index.php?accion=4",
			method:"POST",
			data:$("#restablecer").serialize(),
			success:function(resp){
				var result=JSON.parse(resp);
				//alert(resp);
				console.log(result);
				if(result.error==true){
					alert(result.mensaje);
				}
				else if(result.error==false){
					$("#cuerpoModal").empty();																					//Vacia el cuerpo del modal de mensaje
					$("#cuerpoModal").html('Se envio un correo a: '+result.correo+' favor siga las instrucciones para poder restablecer su contrseña');											//Imprime el cuerpo del modal de mensaje					
					$("#modalRecuperar").modal("hide");	
					$("#ModalMensaje").modal("show");																			//Despliega el modal con el modal
					
				}
				else{
					alert("error desconocido");
				}
			},
			error:function(error){
				//console.log(error);
			}
		});
	});		

    //RESTABLECER COONTRASEÑA MEDIANTE CORREO
	$("#recuperar_contraseña").submit(function(event){
		event.preventDefault();
		$.ajax({
			url:"../clases/perfil.php?accion=3",
			type:"POST",
			data:$("#recuperar_contraseña").serialize(),
			success:function(resp){
				console.log(resp);
				var respuesta=JSON.parse(resp);
				if(respuesta.error==false){
					$("#cuerpoModal").empty();																					//Vacia el cuerpo del modal de mensaje
					$("#cuerpoModal").html('Contraseña cambiada con éxito');													//Imprime el cuerpo del modal de mensaje					
					$("#ModalMensaje").modal("show");
					sleep(3000);																			//Despliega el modal con el modal
					location.href="../index.php";
				}
				else if(respuesta.error==true){
					$("#cuerpoModal").empty();																					//Vacia el cuerpo del modal de mensaje
					$("#cuerpoModal").html('Ha ocurrido un problema, intente de nuevo');										//Imprime el cuerpo del modal de mensaje					
					$("#ModalMensaje").modal("show");																			//Despliega el modal con el modal
					sleep(3000);
					alert(respuesta.mensaje);

				}
				else{
					alert("Error desconocido");
				}

			},
			error:function(error){
				console.log("Error en la petecion al server"+error);
			}



		})

	});
 


});