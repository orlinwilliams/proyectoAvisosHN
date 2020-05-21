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
		swal(
			{
			  title: "¿Estás seguro?",
			  text: "¡Estás a punto de eliminar tu cuenta!",
			  type: "warning",
			  showCancelButton: true,
			  confirmButtonColor: "#2196F3",
			  confirmButtonText: "Si, quiero eliminarme!",
			  closeOnConfirm: false,
			},
			function () {
				$.ajax({
					url: "../clases/perfil.php?accion=4",		//Accion para confirmar contraseña al dar de baja
					method: "POST",
					data: "txt_contrasenia_confi=" + $("#txt_contrasenia_confi").val(),
					success: function (resultado) {
						let datos = JSON.parse(resultado);
						var mensaje1 = "";
						if (datos.error == true) {
								swal("Cancelado", datos.mensaje, "error");
								
						} if(datos.error==false) {
							showSuccessMessage();
							function showSuccessMessage() {
								swal("Éxito!", datos.mensaje, "success");
								$("button.confirm").click(() => {
									location.href = "../index.php";
								});
							}
						}
					},
					error: function (error) {
						alert("ERROR " + error);
					}
				});
			}
		  );
		
	});
	$('button[type="button"]').attr('disabled', 'disabled');									//Desactiva botones de guardar al cargar la página
	$('input[type="text"]').change(function () {												//Si hay cambios en el formulario activos botones de guardar
		$('button[type="button"]').removeAttr('disabled');
	});
	$("#int_municipio").change(()=>{
		$('button[type="button"]').removeAttr('disabled');
	})
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
				let datos = JSON.parse(resultado);
				if(datos.error==true){
					swal("Cancelado", datos.mensaje, "error")
				}
				else{
					swal("Éxito", datos.mensaje, "success")
				}
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
				let datos = JSON.parse(resultado);
				if(datos.error==true){
					swal("Cancelado", datos.mensaje, "error")
				}
				else{
					swal("Éxito", datos.mensaje, "success")
				}
				/*$("#cuerpoModal").empty();										//Vacia el cuerpo del modal de mensaje
				$("#cuerpoModal").html(resultado);								//Imprime el cuerpo del modal de mensaje					
				$("#ModalMensaje").modal("show");								//Despliega el modal con el modal*/
			}
		});
	});

	//BUSCADOR
	$("#buscaAnuncio").keyup(function(){
		var value=$("#buscaAnuncio").val();
		//console.log(value);
		$.ajax({
			url: "../clases/buscador.php?accion=1",
			method:'POST',
			data:"value="+value,
			success: function (resp) {
	
				let datos = JSON.parse(resp);
				//console.log(resp);
				var tarjetas = "";
				if(datos.error==true){
					console.log(datos.mensaje);
				}
				else{
					for (let item of datos) {
						//RECORRER EL JSON
						tarjetas +=
						  "<div class='col-sm-6 col-md-6 col-lg-4'>" +
						  "<div class='carde'>" +
						  "<div class='card__image-holder'>" +
						  "<img class='card__image' src='" +
						  item.fotos[0] +
						  "' alt='Miniatura del anuncio' width='320px;' height='255px;'/>" +
						  "</div>" +
						  "<div class='card-title'>" +
						  "<a  href='#' class='toggle-info btn'>" +
						  "<span class='left'></span>" +
						  "<span class='right'></span>" +
						  "</a>" +
						  "<h2>" +
						  item.nombre +
						  "<small>" +
						  item.precio +
						  "</small>" +
						  "</h2>" +
						  "</div>" +
						  "<div class='card-flap flap1'>" +
						  "<div class='card-description'>" +
						  item.descripcion +
						  "</div>" +
						  "<div class='card-flap flap2'>" +
						  "<div class='card-actions'>" +
						  "<a href='#' class='btn' data-toggle='modal' data-target='#defaultModal' onclick='cargarArticulo(" +
						  item.idAnuncios +
						  ")'>Ver</a>" +
						  "</div>" +
						  "</div>" +
						  "</div>" +
						  "</div>" +
						  "</div>";
						  
						$("#contenedorTarjetas").html(tarjetas); //INSERTA LAS TARJETAS
						
					}
					$("div.carde").click(function (e) {
						e.preventDefault();
						var isShowing = false;
						if ($(this).hasClass("show")) {
						  isShowing = true;
						}
						if ($("div.cards").hasClass("showing")) {
						  // a card is already in view
						  $("div.carde.show").removeClass("show");
						  if (isShowing) {
							// this card was showing - reset the grid
							$("div.cards").removeClass("showing");
						  } else {
							// this card isn't showing - get in with it
							$(this).css({ zIndex: 1 }).addClass("show");
						  }
						  //zindex++;
						} else {
						  // no cards in view
						  $("div.cards").addClass("showing");
						  $(this).css({ zIndex: 2 }).addClass("show");
						  //zindex++;
						}
					});
				}
			},
			error: function (error) {
				console.log(error);
			}
		});	
	  })



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
							"<i onclick='quitarFavorito2("+item.idSeguido+")' style='cursor:pointer' title='ELIMINAR VENDEDOR DE FAVORITOS' class='material-icons'>favorite</i>"+
							"<a data-toggle='modal' data-target='#modalVendedor2' onclick='infoVendedor2("+item.idSeguido+")' style='color:grey; cursor:pointer'>"+item.nombreVendedor+"</a>"+
						"</div>"+
						"<div class='content'>"+
							"<p>"+item.seguidores+ " Seguidores</p>"+ 
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

infoVendedor2 = function (idUsuario) {
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
		  "<button type='button' class='btn btn-link waves-effect' " +
		  "data-dismiss='modal'>Cerrar</button>" +
		  "</div>" +
		  "<script src='https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js'></script>";
		$("#contenidoModalVendedor2").empty();
		$("#contenidoModalVendedor2").html(modal);
  
		
	  },
	  error: function (error) {
		console.log(error);
	  },
	});
  };

quitarFavorito2=(idSeguido)=>{

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
cargarArticulo = function (idAnuncio) {
	event.preventDefault();
	$.ajax({
	  url: "../clases/vistas-index.php?accion=4",
	  method: "GET",
	  data: "idAnuncio=" + idAnuncio,
	  success: function (resultado) {
		let datos = JSON.parse(resultado);
		console.log(datos.info);
		var img = "";
		for (var i = 0; i < datos.info.fotos.length; i++) {
		  img += "<img src='" + datos.info.fotos[i] + "'/>";
		}
		if(datos.info.sigueVendedor==true){
		  var iconoFavorito="<i style='cursor:pointer' onclick=quitarFavorito(" +datos.info.idUsuario+") class='material-icons' title='QUITAR FAVORITO'>favorite</i>";
		}
		else{
		  var iconoFavorito="<i style='cursor:pointer' onclick=agregarFavorito(" +datos.info.idUsuario+") class='material-icons' title='AGREGAR A FAVORITO'>favorite_border</i>";
		}
		$("#infoArticulo").empty();
		$("#infoArticulo").html(
		  "<div class='row'>" +
			"<div class='col-md-7 col-sm-12 col-xs-12 izquierdo'>" +
			"<div class='fotorama' data-width='100%' data-ratio='700/467' data-minwidth='400' data-maxwidth='1000' data-minheight='300' data-maxheight='100%' data-nav='thumbs' data-fit='cover' data-loop='true'>" +
			img +
			"</div>" +
			"</div>" +
			"<div class='col-md-5 col-sm-12 col-xs-12 derecho'>" +
			"<div class='demo-google-material-icon'>" +
			"<p class='font-categoria'><a class='links-categorias' href='#'>Categoria</a> <i class='material-icons' style='font-size:12px'>last_page</i>"+
			"<span class='icon-name'><a class='links-categorias' href='#'>"+datos.info.nombregrupo +"</a></span>" +
			" <i class='material-icons' style='font-size:12px'>last_page</i><a class='links-categorias' href='#'>" +
			datos.info.nombreCategoria +
			"</a></p>" +
			"<ul class='header-dropdown m-r--5' style='margin-top:-30px; margin-left:88%;  list-style:none;'>" +
			"<li class='dropdown'>" +
			"<a href='javascript:void(0);' class='dropdown-toggle' data-toggle='dropdown' role='button' aria-haspopup='true' aria-expanded='false'>" +
			"<i class='material-icons'>more_vert</i>" +
			"</a>" +
			"<ul class='dropdown-menu pull-right'>" +
			"<li><a href='#' data-toggle='modal' data-target='#denuncias'>Denunciar</a></li>" +
			"<li><a href='#' data-toggle='modal' data-target='#modalCompartir'>Compartir</a></li>" +
			"</ul>" +
			"</li>" +
			"</ul>" +
			"<div>" +
			"<p class='titulo'>" +
			datos.info.nombre +
			"</p>" +
			"</div>" +
			"<div class='precio'>" +
			"<p class='font-precio'>" +
			datos.info.precio +
			"</p>" +
			"</div>" +
			"<div class='estado'>" +
			"<p class='font-estado'><strong>Estado:</strong> " +
			datos.info.estadoArticulo +
			"</p>" +
			"<p class='font-estado'><strong>Lugar:</strong> " +
			datos.info.municipio +
			"</p>" +
			"</div>" +
			"<div class='descripcion'>" +
			"<p class='font-descripcion'><strong>Descripción:</strong></p>" +
			"<p class='parrafo'>" +
			datos.info.descripcion +
			"</p>" +
			"</div>" +
			"<div class='vendedor'>" +
			"<p class='font-vendedor'>Información del vendedor</p>" +
			"<div class='div-imagen col-lg-12 col-sm-12 col-xs-12' style=''>" +
			"<a class='col-lg-3 col-sm-3 col-xs-3' aria-label='Foto del vendedor' data-toggle='modal'  data-target='#modalVendedor' data-dismiss='modal' onclick=infoVendedor(" +
			datos.info.idUsuario +
			")>" +
			"<img class='imagen-vendedor' title='VER LA INFORMACION DEL VENDEDOR' style='cursor:pointer' src='" +
			datos.info.urlFoto +
			"'> </a>" +
			"<div class='col-lg-7 col-sm-7 col-xs-7'>" +
			"<p class='font-vendedor'><a data-toggle='modal' style='cursor:pointer' title='VER LA INFORMACION DEL VENDEDOR' data-target='#modalVendedor' data-dismiss='modal' onclick=infoVendedor(" +
			datos.info.idUsuario +
			")>" +
			datos.info.nombreUsuario +
			"</a></p>" +
			"<p class='registro-de-vendedor'>Unido desde " +
			datos.info.fechaRegistro +
			"</p>" +
			"</div>" +
			"<div class='demo-google-material-icon  col-lg-2 col-sm-2 col-xs-2' id='iconoFavorito'></div>" +
			"</div>" +
			"</div>" +
			"<div class='div-nombre col-lg-12' style='margin:0px; padding:0px; margin-top: 10px'>" +
			"<div class='demo-google-material-icon col-lg-12' style='color:black; padding:0px; margin-bottom:15px'>" +
			"<span class='icon-name col-lg-6' style='font-size:22px; padding:0px; text-align:center'><strong>Valoración: </strong>" +
			datos.info.valoración +
			"</span>" +
			"<script>$('#estrella').starrr({rating:" +
			datos.info.valoración +
			",change:function(e,valor){console.log(valor); var estrellas=valor; $.ajax({url:'../clases/vistas-index.php?accion=9',method: 'post', data: 'valoracion='+estrellas,success: function(resp){console.log(resp)}})}});</script>" +
			"<span class='col-lg-6' style='padding:0px; text-align:center' id='estrella'></span>" +
			"</div>" +
			"<br>"+
			"<div class='demo-google-material-icon pb-5' style='color:black;'>" +
			"<i class='material-icons md-24'>phone</i>" +
			"<span class='icon-name' style='font-size:22px; text-align:cente'><strong>+" +
			datos.info.numTelefono +
			"</strong></span>" +
			"</div>" +
			"<br>" +
			"<div>" +
			"<div style='text-align:center;'>" +
			"<button class='btn btn-info btn-lg waves-effect' type='submit' data-toggle='modal' data-target='#modalContacto'onclick='cargarDatosContacto(" +
			idAnuncio +
			")' >CONTACTAR</button>" +
			"</div>" +
			"</div>" +
			"</div>" +
			"</div>" +
			"</div>" +
			"</div>" +
			"<script src='https://cdnjs.cloudflare.com/ajax/libs/fotorama/4.6.4/fotorama.js'></script>"
		);
		$("#iconoFavorito").html(iconoFavorito);
	  },
	});
  };
  enviarCorreoContacto = function (parametros) {
	event.preventDefault();
	id = parametros;
	//Petición ajax enviar correo al vendedor
	event.preventDefault();
	$.ajax({
	  url: "../clases/vistas-index.php?accion=7", //Accion para editar anuncios
	  method: "POST",
	  data: "mensaje1=" + $("#mensaje1").val() + "&idanuncio3=" + id,
	  success: function (resultado) {
		$("#cuerpoModal").empty(); //Vacia el cuerpo del modal de mensaje
		$("#cuerpoModal").html(resultado); //Imprime el cuerpo del modal de mensaje
		$("#ModalMensaje").modal("show");
		location.reload();
  
		//Despliega el modal con el modal
	  },
	});
  }; 
  agregarFavorito=(idUsuario)=>{
	//alert("prueba bien"+ idUsuario);
  
	$.ajax({
	  url: "../clases/vistas-index.php?accion=11",
	  method: "POST",
	  data: "idSeguido=" + idUsuario,
  
	  success: function (resp) {
		var datos = JSON.parse(resp);
		if(datos.error==true){
		  alert(datos.mensaje);
		}
		if(datos.error==false){
		  alert(datos.mensaje);
		  $("#iconoFavorito").html("<i style='cursor:pointer' onclick=quitarFavorito("+datos.idSeguido +") class='material-icons' title='QUITAR FAVORITO'>favorite</i>");
		  
  
		}
  
	  
	  },
	  error:(error)=>{
		console.log("ERROR EN SERVER");
	  }
	});
  
  }
  
  quitarFavorito=(idSeguido)=>{
	$.ajax({
	  url: "../clases/vistas-index.php?accion=12",
	  method: "POST",
	  data: "idSeguido=" + idSeguido,
  
	  success: function (resp) {
		var datos = JSON.parse(resp);
		if(datos.error==true){
		  alert(datos.mensaje);
		}
		if(datos.error==false){
		  alert(datos.mensaje);
		  $("#iconoFavorito").html("<i style='cursor:pointer' onclick=agregarFavorito("+datos.idSeguido +") class='material-icons' title='AGREGAR FAVORITO'>favorite_border</i>");
		  
  
		}
  
	  
	  },
	  error:(error)=>{
		console.log("ERROR EN SERVER");
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
		console.log(datos);
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
		comentarios = "";
		if (datos.comentariosVendedor.error == true) {
		  comentarios =
			"<li>" +
			"<div class='title'>" +
			"</div>" +
			"<div class='content'>" +
			"<div>" +
			"<p>" +
			"Sin comentarios todavia" +
			"</p>" +
			"</div>" +
			"</div>" +
			"</li>";
		} else {
		  for (var i = 0; i < datos.comentariosVendedor.length; i++) {
			comentarios +=
			  "<li>" +
			  "<div class='title'>" +
			  datos.comentariosVendedor[i].nombreComprador +
			  "</div>" +
			  "<div class='content'>" +
			  "<div>" +
			  "<p>" +
			  datos.comentariosVendedor[i].comentario +
			  "</p>" +
			  "</div>" +
			  "</div>" +
			  "</li>";
		  }
		}
		var nombreCompleto =
		  datos.datosVendedor.pNombre + " " + datos.datosVendedor.pApellido;
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
		  "<h2>Últimos comentarios</h2>" +
		  "<p><button type='button' class='btn bg-light-green btn-circle waves-effect waves-circle waves-float' data-toggle='collapse' href='#collapseExample' id='botonComentario' aria-expanded='false'" +
		  "aria-controls='collapseExample'>" +
		  "<i class='material-icons'>chat</i>" +
		  "</button></p>" +
		  "<div class='collapse' id='collapseExample'>" +
		  "<div class='well'>" +
		  "<textarea id='comentario' name='comentario' cols='30' rows='4' class='form-control no-resize'></textarea>" +
		  "</div>" +
		  "<button id='enviarComentario' class='btn btn-default waves-effect'>AGREGAR COMENTARIO</button>" +
		  "</div>" +
		  "<p id='mensajeComentario'></p>" +
		  "</div>" +
		  "<div class='body' style='height: auto;'>" +
		  "<ul id='agregarComentario'>" +
		  comentarios +
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
  
		$("#enviarComentario").click(function (e) {
		  e.preventDefault();
		  comentario = $("#comentario").val();
		  if (comentario != "" && comentario != null) {
			$.ajax({
			  url: "../clases/vistas-index.php?accion=8",
			  method: "POST",
			  data: "comentario=" + comentario + "&idUsuario=" + idUsuario,
			  success: function (resp) {
				//console.log(resp);
				datos = JSON.parse(resp);
				if (datos.error == false) {
				  $("#agregarComentario").prepend(
					"<li>" +
					  "<div class='title'>" +
					  datos.nombreComprador +
					  "</div>" +
					  "<div class='content'>" +
					  "<div>" +
					  "<p>" +
					  comentario +
					  "</p>" +
					  "</div>" +
					  "</div>" +
					  "</li>"
				  );
				  //console.log("comentario agregado con exito");
				  $("#mensajeComentario").html(datos.mensaje);
				  $("#comentario").val("");
				  $("#botonComentario").click();
				}
				if (datos.error == true) {
				  $("#mensajeComentario").html(datos.mensaje);
				  $("#comentario").val("");
				  $("#botonComentario").click();
				}
			  },
			  error: function (error) {
				console.log(error);
			  },
			});
		  } else {
			$("#mensajeComentario").html("Favor ingrese su comentario");
		  }
		});
	  },
	  error: function (error) {
		console.log(error);
	  },
	});
  };
  cargarDatosContacto = function (parametros) {
	////mostrar los datos en el de contacto con vendedor
	event.preventDefault();
	id = parametros;
	$.ajax({
	  url: "../clases/vistas-index.php?accion=6",
	  method: "POST",
	  data: "idAnuncio2=" + id,
  
	  success: function (resp) {
		let dato = resp;
		console.log(dato);
		var modal = "";
		modal +=
		  "<div class='form-group'>" +
		  "<div class='form-line' id='descrip'>" +
		  "<textarea rows='2' id='mensaje1' class='form-control no-resize' placeholder=''>Me siento interesado en el articulo" +
		  dato +
		  "</textarea>" +
		  "</div>" +
		  "</div>" +
		  "<div class='modal-footer'>" +
		  "<button type='button' class='btn btn-link  waves-effect' onclick='enviarCorreoContacto(" +
		  id +
		  ")'>ENVIAR</button>" +
		  "<button type='button' class='btn btn-link  bg-red waves-effect' data-dismiss='modal'>CANCELAR</button>" +
		  "</div>";
		$("#descrip").empty(modal);
		$("#descrip").html(modal);
	  },
	});
  };