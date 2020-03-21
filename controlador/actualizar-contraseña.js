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

    // ENVIAR UN CORREO
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
					alert("Se envio un correo a:"+result.correo);
				}
				else{
					alert("error desconocido");
				}
			},
			error:function(error){
				console.log(error);
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
					alert(respuesta.mensaje)
				}
				else if(respuesta.error==true){
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