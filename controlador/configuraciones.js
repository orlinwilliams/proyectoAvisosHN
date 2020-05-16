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
});

