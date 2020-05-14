$(document).ready(function () {
  //////////////////////////////////////////////////CANTIDAD DE DIAS PARA UNA PUBLICACION
  $("#agregarDias").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "../clases/configuraciones.php?accion=3",
      method: "POST",
      data: "dias=" + $("#cantidad_dias").val(),
      success: function (resultado) {
          let datos = JSON.parse(resultado);
          if(datos.error == true){
            swal("Cancelado", "No ha ingresado la cantidad de días", "error");
          }
          else{
            swal("Éxito!", datos.mensaje, "success");
          }
      },
    });
  });
});
