$(function () {
    $(".js-basic-example").DataTable({
      responsive: true,
    });
  });
  ///////////////////////////////////////////// FUNCION PARA ELIMINAR USUARIO
  eliminarUsuario = function (idUsuario) { ////Eliminar el anuncio
    console.log(idUsuario);
    event.preventDefault();
    swal({
        title: "¿Estás seguro?",
        text: "¡No podrá revertir este cambio!",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Si, quiero borrarlo!",
        closeOnConfirm: false
    }, function () {
      swal("Borrado!",idUsuario, "success" );
          //////////AQUI DEBE IR LA PETICION AJAX
    });
  };
  