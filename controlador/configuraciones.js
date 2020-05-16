$(document).ready(function () {
  //////////////////////////////////////////////////CANTIDAD DE DIAS PARA UNA PUBLICACION
  $("#agregarDias").click(function (event) {
    event.preventDefault();

    swal(
      {
        title: "¿Estás seguro?",
        text: "¡Estás a punto de cambiar la cantidad de días!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#2196F3",
        confirmButtonText: "Si, quiero cambiarlo!",
        closeOnConfirm: false,
      },
      function () {
        $.ajax({
          url: "../clases/configuraciones.php?accion=3",
          method: "POST",
          data: "dias=" + $("#cantidad_dias").val(),
          success: function (resultado) {
            let datos = JSON.parse(resultado);
            if (datos.error == true) {
              swal("Cancelado", datos.mensaje, "error");
            } else {
              swal("Éxito!", datos.mensaje, "success");
            }
          },
        });
      }
    );
  });
  $("#agregarGrupo").click(function (event) {								
		event.preventDefault();
		$.ajax({																
			url: "../clases/configuraciones.php?accion=1",
			method: "POST",
      data: "grupo=" + $("#grupoCate").val(),			
			success: function (resultado) {
        console.log(resultado);
       
          $("#cuerpoModal").empty();																		
          $("#cuerpoModal").html(resultado);													
          $("#ModalMensaje").modal("show");
        
        
      },
		});																	
  });
  
  $("#agregarCategoria").click(function (event) {								
		event.preventDefault();
		$.ajax({																
			url: "../clases/configuraciones.php?accion=2",
			method: "POST",
      data: "grupo=" + $("#grupoCategoria1").val()+
            "&categoria=" + $("#agregarCat").val(),			
			success: function (resultado) {
        console.log(resultado);
       
          $("#cuerpoModal").empty();																		
          $("#cuerpoModal").html(resultado);													
          $("#ModalMensaje").modal("show");
        
        
      },
		});																	
	});


grupocategorias();
categorias();

});

grupocategorias = function () {	
	$.ajax({							
		url: "../clases/configuraciones.php?accion=4",
		success: function (resultado) {
            $("#grupoCategoria").append(resultado);
            $("#grupoCategoria1").append(resultado);
            $("#grupoCategoria2").append(resultado);
		},
		error: function (error) {
            console.log(error);
		}
	});																			

}
categorias = function () {	
	$.ajax({							
		url: "../clases/configuraciones.php?accion=5",
		success: function (resultado) {
            $("#listacategorias").append(resultado);
            
		},
		error: function (error) {
            console.log(error);
		}
	});																			

}