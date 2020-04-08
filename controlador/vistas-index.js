$(document).ready(function () {																//document
    categoria();																			//Llama la funcion municipios

    
     
    
    //Configuracion de Parametros de DROPZONE 
    var arrayImg=[];
    Dropzone.options.subirFotos={
        
        maxfilezise:2,
        uploadMultiple:true,
        autoProcessQueue:true,
        maxThumbnailFilesize:2,
        acceptedFiles:"image/*",
        maxFiles:4,
        addRemoveLinks:true,
        autoProcessQueue:true,
        accept: function(file, done) {// ARCHIVOS ACEPTADOS
            //console.log(file);
            arrayImg.push(file);
            done();
        },
    };
    
      
    
    $("#publicarArticulo").submit(function (event) {
        event.preventDefault();
        event.stopPropagation();										            
        
        var dataImg= new FormData();
        

        //DATOS SERELIAZADOS 	
        //var datos=   "nombre=" + $("#nombre").val() +
        //             "&precio=" + $("#precio").val() +
        //             "&estado=" + $("#estado").val() +
        //             "&categoria=" + $("#categoria").val() +
        //             "&descripcion=" + $("#descripcion").val();
        
        
        //AQUI SE DEBE AGREGAR LOS DATOS Y EL ARREGLO DE IMAGES PARA ENVIAR AL SERVIDOR
        dataImg.append("nombre",$("#nombre").val());
        dataImg.append("precio",$("#precio").val());
        dataImg.append("estado",$("#estado").val());
        dataImg.append("categoria",$("#categoria").val());
        dataImg.append("descripcion",$("#descripcion").val());
        
        console.log(arrayImg);
        dataImg.append("File",arrayImg);// SE INTENTA AGREGAR ARREGLO DE DATOS
        
        $.ajax({															
            url: "../clases/vistas-index.php?accion=2",
            method: "POST",
            data:dataImg,//SE ENVIA TODO EL DATAFORM  AL SERVER
            contentType: false,
            processData: false,
            cache: false, 
            success: function (resultado) {
                console.log(resultado);
                $("#cuerpoModal").empty();										
                $("#cuerpoModal").html(resultado);								
                $("#ModalMensaje").modal("show");								
            },
            error: function (error) {
                console.log(error);
            }
        });																	
    });
    





});


categoria = function () {														//Inicio funcion para llenar las categorias
	$.ajax({																	//Inicio ajax categorias
		url: "../clases/vistas-index.php?accion=1",
		success: function (resultado) {
            $("#categoria").append(resultado);									//El resultado lo retorna como html
		},
		error: function (error) {
            console.log(error);
		}
	});																			//Fin ajax categorias

}			
																	//Fin funcion para llenar las categorias
$(function () {
    $('#publicarArticulo').validate({
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


		