$(document).ready(function () {																//document
    categoria();																			//Llama la funcion municipios

    
     
    //Configuracion de DROPZONE 
    Dropzone.options.subirFotos={
        maxfilezise:2,
        maxThumbnailFilesize:2,
        acceptedFiles:"image/*",
        maxFiles:4,
        addRemoveLinks:true,
        accept: function(file, done) {
            console.log(file.name);
            fileImg = file.name;
            done();    // !Very important
        },
        

    };
    $("#publicarArticulo").submit(function (event) {
        event.preventDefault();
        event.stopPropagation();										            //Inicio de evento en el botón submit de registro
        console.log("Se ha presionado el boton publicar");
        

    
        var dataImg= new FormData();		
        //var datos=   "nombre=" + $("#nombre").val() +
        //             "&precio=" + $("#precio").val() +
        //             "&estado=" + $("#estado").val() +
        //             "&categoria=" + $("#categoria").val() +
        //             "&descripcion=" + $("#descripcion").val();
        
        //archivos.append($('#subirFotos')[0].dropzone.getAcceptedFiles());
        //archivos.append($('#subirFotos')[0].dropzone.getAcceptedFiles()[0]);
        //archivos.append($('#subirFotos')[0].dropzone.getAcceptedFiles()[0]);
        //archivos.append($('#subirFotos')[0].dropzone.getAcceptedFiles()[0]);
        
        //AQUI SE DEBE AGREGAR EL ARREGLO DE IMAGES PARA ENVIAR AL SERVIDOR
        //dataImg.append("fotos",imgFile);
        dataImg.append("nombre",$("#nombre").val());
        dataImg.append("precio",$("#precio").val());
        dataImg.append("estado",$("#estado").val());
        dataImg.append("categoria",$("#categoria").val());
        dataImg.append("descripcion",$("#descripcion").val());
        
        
        $.ajax({															
            url: "../clases/vistas-index.php?accion=2",
            method: "POST",
            data:dataImg,//SE ENVIA TODA LA AL SERVER
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


		