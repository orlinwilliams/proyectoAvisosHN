$(document).ready(function () {																//document
    categoria();																			//Llama la funcion municipios

    //Funcioón al presionar el boton de publicar en anuncio onclci
    $("#publicarArticulo").submit(function (event) {
        event.preventDefault();										            //Inicio de evento en el botón submit de registro
        console.log("Se ha presionado el boton publicar")
    /*        
        var FormData = new FormData($("#foto")[0]);
            var ruta = "/clases/vistas-index.php";
            $.ajax({
               url: ruta,
               type: "POST",
               data: FormData,
               contentType: false,
               processData: false,
               success: function(datos)
               {
                    $("#respuesta").html(datos);
               }  
            });    
    */        
        //orlin
        var dataImg= new FormData();		
        dataImg.append("fotos",$("#foto") [0].files[0]);
        dataImg.append("imagen",$("#publicarArticulo")[0].files[1]);
        dataImg.append("imagen",$("#publicarArticulo")[0].files[2]);
        dataImg.append("imagen",$("#publicarArticulo")[0].files[3]);
    
   
/*    
        $("#foto").on("change", function()){
            $("#vista-previa").html('');
            var archivos = document.getElementById('foto').files;
            var navegador = window.url || window-webkitURL;
            for(x=0; x<archivos.length; x++)
            {
                var size = archivos[x].size;
                var type = archivos[x].type;
                var name = archivos[x].name;
                if (size > 1024*1024) 
                {
                    $("#vista-previa").append("<p style='color: red>EL archivo "+name+" supera el maximo permitido 1MB </p>");      
                }else if(type != 'image/jpeg' && type != 'image/jpg' && type != 'image/png' && type != 'image/gif') {
                    $("#vista-previa").append("<p style='color: red>EL archivo "+name+" la imagen no es del tipo permitido </p>");      
                }else{
                    var objeto_url = navegador.createObjectURL(archivos[x]);
                    $("#vista-previa"),append("<img src="+objeto_url+" width='250' heigth='250'>");
                }
            }

        }   
*/
        var datos=    "nombre=" + $("#nombre").val() +
                     "&precio=" + $("#precio").val() +
                     "&estado=" + $("#estado").val() +
                     "&categoria=" + $("#categoria").val() +
                     "&descripcion=" + $("#descripcion").val();
                
        
        $.ajax({																//Inicio de Ajax
            url: "../clases/vistas-index.php?accion=2",
            method: "POST",
            data:datos,
            contentType: false,
			processData: false,
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

		