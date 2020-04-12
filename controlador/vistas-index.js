$(document).ready(function () {																//document
    categoria();																			//Llama la funcion municipios
    //Configuracion de Parametros de DROPZONE 
    Dropzone.autoDiscover = false;
    //var arrayImg=[];
    
    myDropzone = new Dropzone('div#subirFotos', {
        addRemoveLinks: true,
        autoProcessQueue: false,
        uploadMultiple: true,
        acceptedFiles: 'image/*',
        parallelUploads: 4,
        maxFiles: 4,
        maxFilesize: 2,//tamaño maxino de imagen
        paramName: 'file',
        clickable: true,
        url: '../clases/mis-publicaciones.php?accion=2',
        init: function () {
    
            var myDropzone = this;
            var myDropzone = this;
            //VALIDAR MININO DE TAMAÑO
            this.on("thumbnail",function(file){
                if(file.accepted!==false){
                    if(file.width<300||file.height<255){
                        myDropzone.removeFile(file);
                        $("#cuerpoModal").empty();																		
					    $("#cuerpoModal").html('Favor ingrese una imagen con un minimo de resolucion de 300x255');													
					    $("#ModalMensaje").modal("show");
                    }
                    
                }
            })

            // Update selector to match your button
            $("#publicarArticulo").submit(function (e) {
                event.stopPropagation();
                e.preventDefault();
                if ( $("#publicarArticulo").valid() ) {
                    myDropzone.processQueue();
                }
                return false;
            });
    
            this.on('sending', function (file, xhr, formData) {
                // Append all form inputs to the formData Dropzone will POST
                var data = $("#publicarArticulo").serializeArray();
                $.each(data, function (key, el) {
                    formData.append(el.name, el.value);
                });
                //console.log(formData);
    
            });
        },
        error: function (file, response){
            if ($.type(response) === "string")
                var message = response; //dropzone sends it's own error messages in string
            else
                var message = response.message;
            file.previewElement.classList.add("dz-error");
            _ref = file.previewElement.querySelectorAll("[data-dz-errormessage]");
            _results = [];
            for (_i = 0, _len = _ref.length; _i < _len; _i++) {
                node = _ref[_i];
                _results.push(node.textContent = message);
            }
            return _results;
        },
        successmultiple: function (file, response) {
            console.log(file, response);
            //$modal.modal("show");
        },
        completemultiple: function (file, response) {
            console.log(file, response, "completemultiple");
            //$modal.modal("show");
        },
        reset: function () {
            console.log("resetFiles");
            //this.removeAllFiles(true);
        }
      
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


		