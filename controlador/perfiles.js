

$(document).ready(function () {							
	event.preventDefault();			
		//VISTA DE IMAGEN DE PERFIL
	$.get("../clases/actualizarImagen.php?accion=1",function(resp){
		//alert(resp);
		if(resp==null||resp==""){
		
			$("#imagenPerfil").attr("src","../images/user.png");
			$("#imagenPerfil1").attr("src","../images/user.png");
		}
		else{
			$("#imagenPerfil").attr("src",resp);
			$("#imagenPerfil1").attr("src",resp);
		}
		
	});

	$('button[type="button"]').attr('disabled', 'disabled');									//Desactiva botones de guardar al cargar la página
	$('input[type="text"]').change(function () {												//Si hay cambios en el formulario activos botones de guardar
		$('button[type="button"]').removeAttr('disabled');
	});
	$('input[type="password"]').change(function () {												//Si hay cambios en el formulario activos botones de guardar
		$('button[type="button"]').removeAttr('disabled');
	});
	


	municipios();																			//Llama la funcion municipios

	$('#txt_tefelono').inputmask('+999 9999-99-99', { placeholder: '+___ ____-__-__' });	//Da formato al telefono
	$('#txt_rtn').inputmask('****-****-*****', { placeholder: '____-____-_____' });			//Da formato al rtn
	$('#date_fecha').inputmask('dd/mm/yyyy', { placeholder: '__/__/____' });				//Da formato a la fecha

	
	//atualizar imagen de perfil 
	$("#imagenPerfil").click(function(){
		$("#imagenActualizar").click();
		$("#imagenActualizar").change(function(e){
			e.preventDefault();
			var dataImg= new FormData();
			
			dataImg.append("imagen",$("#imagenActualizar")[0].files[0]);
			$.ajax({
				url:"../clases/actualizarImagen.php?accion=2",
				data:dataImg,
				type:"POST",
				//dataType:"text",
				contentType: false,
				processData: false,
				success:function(resp){
					
					
					$("#imagenPerfil").attr("src",resp);
					
					$("#imagenPerfil1").attr("src",resp);
					
	
				},
				
				error:function(error){
					alert("ERRROR EN ELA PETICION"+error);
				}
	
	
			})
	
		});
	
	})	



	$("#editar").click(function (event) {												//Petición ajax para guardar cambios en el perfil
		event.preventDefault();
		$.ajax({
			url: "../clases/perfil.php?accion=1",										//Accion para editar perfil
			method: "POST",
			data: "txt_nombre=" + $("#txt_nombre").val() +
				"&txt_apellido=" + $("#txt_apellido").val() +
				"&txt_correo=" + $("#txt_correo").val() +
				"&date_fecha=" + $("#date_fecha").val() +
				"&int_municipio=" + $("#int_municipio").val() +
				"&txt_tefelono=" + $("#txt_tefelono").val() +
				"&txt_rtn=" + $("#txt_rtn").val(),
			success: function (resultado) {
				$("#cuerpoModal").empty();										//Vacia el cuerpo del modal de mensaje
				$("#cuerpoModal").html(resultado);								//Imprime el cuerpo del modal de mensaje					
				$("#ModalMensaje").modal("show");								//Despliega el modal con el modal
			}
		});
	});

	$("#cambiar").click(function (event) {										//Petición ajax para guardar cambios en el perfil
		event.preventDefault();
		$.ajax({
			url: "../clases/perfil.php?accion=2",								//Accion para cambiar contraseña
			method: "POST",
			data: "contraseñaActual=" + $("#contraseñaActual").val() +
				"&txt_contraseña=" + $("#txt_contraseña").val() +
				"&txt_contraseña2=" + $("#txt_contraseña2").val(),
			success: function (resultado) {
				$("#cuerpoModal").empty();										//Vacia el cuerpo del modal de mensaje
				$("#cuerpoModal").html(resultado);								//Imprime el cuerpo del modal de mensaje					
				$("#ModalMensaje").modal("show");								//Despliega el modal con el modal
			}
		});
	});


});																				//document


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




