$(document).ready(function () {
	event.preventDefault();
	//VISTA DE IMAGEN DE PERFIL
	$.get("../clases/actualizarImagen.php?accion=1", function (resp) {
		//alert(resp);
		if (resp == null || resp == "") {
			$("#imagenPerfil").attr("src", "../images/user.png");
			$("#imagenPerfil1").attr("src", "../images/user.png");
		}
		else {
			$("#imagenPerfil").attr("src", resp);
			$("#imagenPerfil1").attr("src", resp);
		}
	});
	//DATOS PUBLICACIONES
	$.get("../clases/perfil.php?accion=5",(resp)=>{
		datos=JSON.parse(resp);
		//console.log(datos);
		$("#articulosPublicados").html(datos.cantidadAnuncio);
		$("#calificacionUsuario").html(datos.cantidadEstrellas);

	});

	$("#confirma-eliminar").click(function (event) {	//Petición ajax para dar de baja cuenta
		event.preventDefault();
		$.ajax({
			url: "../clases/perfil.php?accion=4",		//Accion para confirmar contraseña al dar de baja
			method: "POST",
			data: "txt_contrasenia_confi=" + $("#txt_contrasenia_confi").val(),
			success: function (resultado) {
				location.href = "../index.php";
			},
			error: function (error) {
				alert("ERROR " + error);
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
	
	municipios();
	misFavoritos();
																				//Llama la funcion municipios
	$('#txt_tefelono').inputmask('+999 9999-99-99', { placeholder: '+___ ____-__-__' });	//Da formato al telefono
	$('#txt_rtn').inputmask('****-****-*****', { placeholder: '____-____-_____' });			//Da formato al rtn
	$('#date_fecha').inputmask('dd/mm/yyyy', { placeholder: '__/__/____' });				//Da formato a la fecha
	//atualizar imagen de perfil 
	$("#imagenPerfil").click(function () {
		$("#imagenActualizar").click();
		$("#imagenActualizar").change(function (e) {
			e.preventDefault();
			var dataImg = new FormData();

			dataImg.append("imagen", $("#imagenActualizar")[0].files[0]);
			$.ajax({
				url: "../clases/actualizarImagen.php?accion=2",
				data: dataImg,
				type: "POST",
				//dataType:"text",
				contentType: false,
				processData: false,
				success: function (resp) {
					$("#imagenPerfil").attr("src", resp);
					$("#imagenPerfil1").attr("src", resp);
				},
				error: function (error) {
					alert("ERRROR EN ELA PETICION" + error);
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

misFavoritos=()=>{
	$.ajax({																	
		url: "../clases/perfil.php?accion=6",
		success: function (resp) {
			datos=JSON.parse(resp);
			filaUsuario="";
			if(datos.error==true){
				filaUsuario+=filaUsuario+="<li>"+
				"<div class='title'>"+
					"<p>No sigues a ningún usuario todavía</p>"+ 
				"</div>"+
				"</li>";
				$("#agregarFavoritos").html(filaUsuario);
			}
			else{
				
				for(let item of datos){
					filaUsuario+="<li>"+
                        "<div class='title'>"+
							"<i onclick='quitarFavorito("+item.idSeguido+")' style='cursor:pointer' title='ELIMINAR VENDEDOR DE FAVORITOS' class='material-icons'>favorite</i>"+
							"<a data-toggle='modal' data-target='#modalVendedor' onclick='infoVendedor("+item.idSeguido+")' style='color:grey; cursor:pointer'>"+item.nombreVendedor+"</a>"+
						"</div>"+
						"<div class='content'>"+
							"<p>"+item.seguidores+ "Seguidores</p>"+ 
						"</div>"+
					"</li>";
				}
				$("#agregarFavoritos").html(filaUsuario);
			}
			

		},
		error: function (error) {
			console.log(error);
		}
	});
}	

infoVendedor = function (idUsuario) {
	$.ajax({
	  url: "../clases/vistas-index.php?accion=5",
	  method: "GET",
	  data: "idUsuario=" + idUsuario,
	  success: function (resp) {
		var datos = JSON.parse(resp);
		//console.log(datos);
		historialAnuncios = "";
		for (var i = 0; i < datos.anunciosVendedor.length; i++) {
		  historialAnuncios +=
			"<li>" +
			"<div class='title'>" +
			datos.anunciosVendedor[i].nombreAnuncio +
			"</div>" +
			"<div class='content'>" +
			"<div style='float:left;'>" +
			datos.anunciosVendedor[i].fechaAnuncio +
			"</div>" +
			"<div style='margin-left:90%'>" +
			datos.anunciosVendedor[i].precioAnuncio +
			"</div>" +
			"</div>" +
			"</li>";
		}
		
		var nombreCompleto =datos.datosVendedor.pNombre + " " + datos.datosVendedor.pApellido;
		//console.log(datos);
		var modal =
		  "<div class='modal-header' style='text-align:center'>" +
		  "<h4 class='modal-title' id='defaultModalLabel'></h4>" +
		  "</div>" +
		  
		  "<div class='card profile-card'>" +
		  "<div class='profile-header'>&nbsp;</div>" +
		  "<div class='profile-body'>" +
		  "<div class='image-area'>" +
		  "<img src=" +
		  datos.datosVendedor.urlFoto +
		  " alt=" +
		  nombreCompleto +
		  " width='200px' height='200px' />" +
		  "</div>" +
		  "<div class='content-area'>" +
		  "<h3>" +
		  nombreCompleto +
		  "</h3>" +
		  "<p>" +
		  datos.datosVendedor.fechaRegistro +
		  "</p>" +
		  "<p>" +
		  datos.datosVendedor.tipoUsuario +
		  "</p>" +
		  "</div>" +
		  "</div>" +
		  "<div class='profile-footer'>" +
		  "<ul>" +
		  "<li>" +
		  "<span>Valoración</span>" +
		  "<span>" +
		  datos.datosVendedor.cantidadEstrellas +
		  "</span>" +
		  "</li>" +
		  "<li>" +
		  "<span>ArticulosPublicados</span>" +
		  "<span>" +
		  datos.datosVendedor.cantidadAnuncio +
		  "</span>" +
		  "</li>" +
		  "<li>" +
		  "<span>Correo Electrónico</span>" +
		  "<span>" +
		  datos.datosVendedor.correoElectronico +
		  "</span>" +
		  "</li>" +
		  "</ul>" +
		  "</div>" +
		  "</div>" +
		  "<div class='card card-about-me' style='max-height:400px; overflow-y:scroll;'>" +
		  "<div class='header' style='text-align:center'>" +
		  "<h2>HISTORIAL</h2>" +
		  "<small>(Se mantiene el registro de los últimos 90 días)</small>" +
		  "</div>" +
		  "<div class='body' style='height: auto;'>" +
		  "<ul>" +
		  historialAnuncios +
		  "</ul>" +
		  "</div>" +
		  "</div>" +
		  
		  "<div class='modal-footer'>" +
		  "<button type='button' class='btn btn-link waves-effect' data-toggle='modal' data-target='#defaultModal'" +
		  "data-dismiss='modal'>Cerrar</button>" +
		  "</div>" +
		  "<script src='https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js'></script>";
		$("#contenidoModalVendedor").empty();
		$("#contenidoModalVendedor").html(modal);
  
		
	  },
	  error: function (error) {
		console.log(error);
	  },
	});
  };

quitarFavorito=(idSeguido)=>{

showConfirmMessage();

function showConfirmMessage() {
    swal({
        title: "Estas seguro?",
        text: "Dejaras de seguir a este vendedor y dejaras de recibir notificaciones de sus publicaciones",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, Dejar de seguir!",
        closeOnConfirm: false
    }, function () {
		$.ajax({
			url: "../clases/vistas-index.php?accion=12",
			method: "POST",
			data: "idSeguido=" + idSeguido,
		
			success: function (resp) {
			  var datos = JSON.parse(resp);
			  if(datos.error==true){
				console.log(datos.mensaje);
			  }
			  if(datos.error==false){
				
				swal("Eliminado!", "Vendedor eliminado de mis favoritos.", "success");
				location.reload();
				
		
			  }
		
			
			},
			error:(error)=>{
			  console.log("ERROR EN SERVER");
			}
		  });
        
	});
	
}

	
  
  }  