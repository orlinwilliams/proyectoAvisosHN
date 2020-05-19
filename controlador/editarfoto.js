
categoria = function () {														//Inicio funcion para llenar las categorias
	$.ajax({																	//Inicio ajax categorias
		url: "../clases/vistas-index.php?accion=1",
		success: function (resultado) {
            $("#categoriaActualizar").append(resultado);
            $("#categoria").append(resultado);
            									//El resultado lo retorna como html
		},
		error: function (error) {
            console.log(error);
		}
	});																			

}

//FUNCION QUE EJECUTA LA OPCION EDITAR Y HACE CALLBACKK PARA CREAR MODAL CON LOS DATOS
cargarDatosFormulario=function(id){
    $.ajax({
        url: "../clases/editarfoto.php?accion=1",
        method: "POST",
        data: "txt_idanuncios=" + id,
        success: function (resp) {
            categoria();
            let datos = JSON.parse(resp);
            console.log(datos);
            cargarFotosEditar(id,resp);// se ejecuta la funcion con esos parametros
            //console.log(datos.info);
        }
    });
}

//CREAR EL FORMULARIO CON LOS DATOS
cargarFotosEditar = function (id,callback ) {
    
    let datos =JSON.parse(callback);
    console.log(datos);
    categoria();
    municipios();
    
    var myDropzoneModal="<form id='formularioDropzone'>"
                +"<hr style='margin-top:0px;'>"
                +"<h5 class='modal-title' style='text-align:center'> Edita tus imagenes </h5>"
                +"<hr>"
                +"<div action='/' id='subirFotos' class='dropzone' enctype='multipart/form-data'>"
                    +"<div class='dz-message'>"
                        +"<div class='drag-icon-cph'>"
                            +"<i class='material-icons'>touch_app</i>"
                        +"</div>"
                    +"<h3>Arrastra hacia aquí tus fotos o da click para seleccionar.</h3>"
                        +"<em>(Es <strong>obligatorio</strong> subir al menos una foto del articulo.)</em>"
                +"</div>"
                    +"<div class='fallback'>"
                        +"<input name='file' type='file' accept='image/*' requerid />"
                    +"</div>"
                +"</div>"
                +"<br>"
                +"<div class='buttom-demo' style='text-align: right' >"
                    +"<button type='submit'  style='display:inline-block' class='btn btn-default btn-sm waves-effect'>ACTUALIZAR IMAGEN</button>"
                  +"</div>"
                +"</form><br></br>" 
               +"<form id='editarPublicacion'>"
                +"<hr style='margin-top:2px;'>"
                    +"<h5 class='modal-title' style='text-align:center'> Edita tus datos</h5>"
                    +"<hr>"
                +"<div id='muestra_datos_editar'>"
                +"<div id='form_validationActualizar'>"
                +"<div class='form-group form-float'>"
                    +"<div class='form-line'>"
                    +"<input type='text' class='form-control' id='nombreActualizar' value='"+datos.info.nombre +"' name='nombre'  required>"                        
                    +"</div>"
                +"</div>"
                
                +"<div class=' form-group form-float'style='display:flex'>"
                +"<div class='form-group form-float' style='margin:0px; margin-right:5px; padding:0px; width:150px'>"
                +"<div class='form-line'>"
                +"<select class='form-control show-tick' name='moneda' id='monedaActualizar' required>"
                +"<option value='" + datos.moneda + "'>" + datos.moneda + "</option>"
                +"<option value='L ' >L</option>"
                +"<option value='$ '>$</option>"
                +"</select>"
                +"</div>"
                +"</div>"
                +"<div class='form-group form-float' style='margin:0px; padding:0px; width:400px'>"
                +"<div class='form-line'>"
                +"<input type='number' min='0'class='form-control money-dollar' id='precioActualizar'"
                + "placeholder='" + datos.price+ "' value='" + datos.price + "' required>"
                +"</div>"
                +"</div>"
                +"</div>"
                +"<div class='form-group form-float'>"
                    +"<div class='form-line'>"
                    +"<select class='form-control show-tick name='estado' id='estadoArticulo' required>"
                        + "<option value='" + datos.info.estadoArticulo + "'>" + datos.info.estadoArticulo + "</option>"
                        +"<option value='Nuevo'>Nuevo</option>"
                        +"<option value='Usado'>Usado</option>"
                        +"<option value='Restaurado'>Restaurado</option>"
                        +"<option value='Dañado'>Dañado</option>"
                    +"</select>"
                    +"</div>"
                +"</div>"
                +"<div class='form-group form-float'>"
                    +"<div class='form-line'>"
                    +"<select class='form-control show-tick' name='categoria' id='categoriaActualizar'  required>"
                    +"<option value='" + datos.info.nombreCategoria + "'>" + datos.info.nombreCategoria + "</option>"
                    +"</select>"
                    +"<label class='form-label'></label>"
                    +"</div>"
                +"</div>"
                +"<div class='form-group form-float'>"//LUGAR
                    +"<div class='form-line'>"
                    +"<select class='form-control show-tick' name='categoria' id='lugarActualizar'  required>"
                    +"<option value='" + datos.info.municipio + "'>" + datos.info.municipio + "</option>"
                    +"</select>"
                    +"<label class='form-label'></label>"
                    +"</div>"
                +"</div>"
                +"<div class='form-group form-float'>"
                    +"<div class='form-line'>"
                    +"<textarea name='descripcion' cols='30' rows='4' id='descripcionActualizar' value='"+datos.info.descripcion+"' class='form-control no-resize'>"+datos.info.descripcion+"</textarea>"
                    +"</div>"
                +"</div>"
                +"<div class='modal-footer'>"
                    +"<button type='submit' id='publicarActualizar' class='btn btn-default waves-effect'>Actualizar</button>"
                    +"<button class='btn bg-black waves-effect waves-light' data-dismiss='modal'id='cancelarActualizarArticulo'>Cancelar</button>"
                +"</div>"
            +"</div>"
                +"</div>"
                +"</form '>" ;      
                      
                $("#agregarFormularios").html(myDropzoneModal);
                
            //ajax enviar datos

    $("#editarPublicacion").submit(function(event){
        console.log($("#categoriaActualizar").val());
        event.preventDefault();
        $.ajax({
            url: "../clases/mis-publicaciones.php?accion=6",										//Accion para editar anuncios
            method: "POST",
            data: "nombre=" + $("#nombreActualizar").val() +
                "&precio=" + $("#precioActualizar").val() +
                "&moneda=" + $("#monedaActualizar").val() +
                "&estado=" + $("#estadoArticulo").val() +
                "&categoriaAct=" + $("#categoriaActualizar").val() +
                "&descripcion=" + $("#descripcionActualizar").val() +
                "&municipio=" + $("#lugarActualizar").val() +
                "&txt_idanuncios=" + id,

            success: function (resultado) {
                $("#cuerpoModal").empty();										//Vacia el cuerpo del modal de mensaje
                $("#cuerpoModal").html(resultado);								//Imprime el cuerpo del modal de mensaje					
                $("#ModalMensaje").modal("show");
                location.reload();
    
                //Despliega el modal con el modal
            }
        });
    
    })
    
    Dropzone.autoDiscover = false;
    var myDropzone = new Dropzone("div#subirFotos", {
        addRemoveLinks: true,
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 4,
        acceptedFiles: 'image/*',
        maxFiles: 4,
        maxFilesize: 2,//tamaño maxino de imagen
        clickable: true,
        paramName: 'file',
        url: "../clases/editarfoto.php?accion=3",
        accept: function(file, done) {
            console.log(file);
            return done();
          },
        
        init:function(){
             myDropzone = this;

        
            this.on('removedfile', function(file) {
                    //console.log(file.name+id);
                    $.ajax({
                    url: "../clases/editarfoto.php?accion=2",
                    method: 'POST',
                    data: {nombre: file.name,id:id},
                    success: function(resp){
                        console.log(resp);
                        datos=JSON.parse(resp);
                        if(datos.error==false){
                            alert(datos.mensaje);
                            
                        }
                        if(datos.error==true){
                            alert(datos.mensaje);
                        }
                    },
                    error:function(error){
                        console.log("error en: "+error);
                    }
                });
            
                           
            });

            $.each(datos.fotos, function(key,value) {
                var mockFile = { name: value.name, size: value.size,accept:true } ;
               
                
                myDropzone.emit("addedfile", mockFile);
                myDropzone.createThumbnailFromUrl(mockFile, value.path);
                myDropzone.emit("thumbnail", mockFile, value.path);
                myDropzone.emit("complete", mockFile);
                myDropzone.files.push(mockFile);      
            });
            console.log(myDropzone.files);
            //console.log(myDropzone.getAcceptedFiles());
            //console.log(myDropzone.processQueue());
            
            
            

            //envio de formulario
            $("#formularioDropzone").submit(function (e) {
                event.stopPropagation();
                e.preventDefault();
                myDropzone.processQueue();
                
            });
        
            
            this.on('sending', function (file, xhr, formData) {
                // Append all form inputs to the formData Dropzone will POST
                formData.append("idAnuncio", id);
                /*formData.append("nombre", $("#nombreActualizar").val());
                formData.append("precio", $("#precioActualizar").val());
                formData.append("estado", $("#estadoArticulo").val());
                formData.append("categoria", $("#categoriaActualizar").val());
                formData.append("descripcion", $("#descripcionActualizar").val());*/
    
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

}

municipios = function () {
    //Inicio funcion para llenar los municipios
    $.ajax({
      //Inicio ajax municipios
      url: "../clases/vistas-index.php?accion=2",
      success: function (resultado) {
        //console.log(resultado);
        
        $("#lugarActualizar").append(resultado);
      },
      error: function (error) {
        console.log(error);
      },
    }); //Fin ajax municipios
  }; //Fin funcion para llenar los municipios

