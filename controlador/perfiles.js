$(document).ready(function () {																//document

	municipios();																			//Llama la funcion municipios

	$('#txt_tefelono').inputmask('+504 9999-99-99', { placeholder: '+___ ____-__-__' });	//Da formato al telefono
	$('#txt_rtn').inputmask('0801-1996-01667', { placeholder: '____-____-_____' });			//Da formato al rtn
    $('#date_fecha').inputmask('dd/mm/yyyy', { placeholder: '__/__/____' });				//Da formato a la fecha

	$("#imagenPerfil").click(function(){
		$("#imagenActualizar").click();
		$("#imagenActualizar").change(function(e){
			e.preventDefault();
			var dataImg= new FormData();
			
			dataImg.append("imagen",$("#imagenActualizar")[0].files[0]);
			$.ajax({
				url:"../clases/actualizarImagen.php",
				data:dataImg,
				type:"POST",
				//dataType:"text",
				contentType: false,
				processData: false,
				success:function(resp){
					//alert(resp)
					
					$("#imagenPerfil").attr("src",resp);
					
					$("#imagenPerfil1").attr("src",resp);
					//location.hrf="";
					//console.log(resp);
	
				},
				
				error:function(error){
					alert("ERRROR EN ELA PETICION"+error);
				}
	
	
			})
	
		});
	
	})																	//Fin funcion para llenar los municipios

	





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




