$(document).ready(function () {																//document

	municipios();																			//Llama la funcion municipios

	$('#txt_tefelono').inputmask('+504 9999-99-99', { placeholder: '+___ ____-__-__' });	//Da formato al telefono
    $('#date_fecha').inputmask('dd/mm/yyyy', { placeholder: '__/__/____' });				//Da formato a la fecha
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

}																				//Fin funcion para llenar los municipios
