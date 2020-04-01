

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
	misPublicaciones();
	$("#confirma-eliminar").click(function (event) {	//Petición ajax para dar de baja cuenta
		event.preventDefault();
		$.ajax({
			url: "../clases/perfil.php?accion=4",		//Accion para confirmar contraseña al dar de baja
			method: "POST",
			data: "txt_contrasenia_confi=" + $("#txt_contrasenia_confi").val() ,
			success: function (resultado) {
                location.href ="../index.php";			
			},
			error:function(error){
				alert("ERROR "+error);
			}
		});
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

misPublicaciones=function(){ //VISTA DE MIS PUBLIACIONES
	$.ajax({																	
		url: "../clases/perfil.php?accion=5",
		success: function (resp) {
			let datos=JSON.parse(resp);
			var tarjetas="";
			for(let item of datos){//RECORRER EL JSON 
				tarjetas+="<div class='col-sm-6 col-md-6 col-lg-3 cards'>"
				+"<div class='card'>"
				+  "<div class='card__image-holder'>"
					+"<img class='card__image' src='../images/5e82b609678c10101241D3' alt='Miniatura del anuncio' max-width='100%;' height='auto;'/>"
				  +"</div>"
				  +"<div class='card-title'>"
					+"<a href='#' class='toggle-info btn'>"
					  +"<span class='left'></span>"
					  +"<span class='right'></span>"
					+"</a>"
					+"<h2>"+
					  item.nombre
					  +"<small>"+item.precio+"</small>"
					+"</h2>"
				  +"</div>"
				  +"<div class='card-flap flap1'>"
					+"<div class='card-description'>"+
					item.descripcion
					+"</div>"
					+"<div class='card-flap flap2'>"
					  +"<div class='card-actions'>"
						+"<a href='#' class='btn'>VER</a>"
					  +"</div>"
					+"</div>"
				  +"</div>"
				+"</div>"
			  +"</div>" ;
			  $("#contenedorTarjetas").html(tarjetas);//INSERTA LAS TARJETAS
			}
			
			//console.log(datos);
			//alert(typeof(datos));
			
		},
		error: function (error) {
			console.log(error);
		}
	});																			
}




