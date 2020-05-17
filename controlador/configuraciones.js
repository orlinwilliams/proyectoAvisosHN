$(document).ready(function () {
  grupocategorias();
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
  //////////////////////////////////////////////////AGREGAR UN NUEVO GRUPO DE CATEGORIAS
  $("#agregarGrupo").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "../clases/configuraciones.php?accion=1",
      method: "POST",
      data: "grupo=" + $("#grupoCate").val(),
      success: function (resultado) {
        $("#grupoCategoria").empty();
        $("#grupoCategoria").append("<option></option>");
        $("#grupoCategoria1").empty();
        $("#grupoCategoria1").append("<option></option>");
        $("#grupoCategoria2").empty();
        $("#grupoCategoria2").append("<option></option>");
        grupocategorias();
        swal("Éxito!", resultado, "success");
      },
    });
  });
  //////////////////////////////////////////////////AGREGAR UNA NUEVA CATEGORIAS
  $("#agregarCategoria").click(function (event) {
    event.preventDefault();
    $.ajax({
      url: "../clases/configuraciones.php?accion=2",
      method: "POST",
      data:
        "grupo=" +
        $("#grupoCategoria1").val() +
        "&categoria=" +
        $("#agregarCat").val(),
      success: function (resultado) {
        swal("Éxito!", resultado, "success");
      },
    });
  });
  //////////////////////////////////////////////////CARGAR LA LISTA DE CATEGORÍAS SEGÚN EL GRUPO SELECCIONADO
  $("#grupoCategoria2").change(function () {
    $.ajax({
      data: "idGrupo=" + $("#grupoCategoria2").val(),
      url: "../clases/configuraciones.php?accion=5",
      method: "POST",
      success: function (respuesta) {
        let datos = JSON.parse(respuesta);
        if (datos.error == true) {
          swal("Cancelado", datos.mensaje, "error");
        } else {
          $("#listacategorias").empty();
          $("#listacategorias").append("<option></option>");
          $("#listacategorias").append(datos.HTML);
        }
      },
      error: function (error) {
        console.log(error);
      },
    });
  });
});
//////////////////////////////////////////////////FUNCIÓN PARA CARGAR LOS GRUPOS DE CATEGORIAS
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
    },
  });
};
