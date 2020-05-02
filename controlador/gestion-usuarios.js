$(document).ready(function () {
  cargarDatos();
});
///////////////////////////////////////////// FUNCION PARA CARGAR TODOS LOS DATOS
cargarDatos = function () {
  $.ajax({
    url: "../clases/gestion-usuarios.php?accion=1",
    method: "GET",
    success: function (respuesta) {
      let datos = JSON.parse(respuesta);
      var filas = "";
      if (datos.error == true) {
        console.log(datos.mensaje);
        showAutoCloseTimerMessage();
        function showAutoCloseTimerMessage() {
          swal({
            title: "Mensaje",
            text:
              "No has publicado todavia, utiliza el boton de publicar anuncio de la parte inferior derecha",
            timer: 4500,
            showConfirmButton: false,
          });
        }
      }
      else{
        for(let row of datos){
          filas += "<tr>"+
                      "<td>"+row.idUsuario+"</td>"+
                      "<td>"+row.nombre+"</td>"+
                      "<td>"+row.correoElectronico+"</td>"+
                      "<td>+"+row.numTelefono+"</td>"+
                      "<td>"+row.tipoUsuario+"</td>"+
                      "<td>"+row.fechaRegistro+"</td>"+
                      "<td>"+row.publicaciones+"</td>"+
                      "<td>"+row.denuncias+"</td>"+
                      "<td style=' text-align:center;'>"+
                        "<button type='button' class='btn bg-red waves-effect' onclick='eliminarUsuario("+row.idUsuario+")'>"+
                          "<i class='material-icons'>delete_forever</i>"+
                        "</button>"+
                      "</td>"+
                    "</tr>";
        }
        $("#tabla").empty();
        $("#tabla").html(filas);//INSERTA LAS TARJETAS
        
      }
      $(function () {
        $(".js-basic-example").DataTable({
          retrieve: true,
          responsive: true,
        });
      });
    },
  });
};
///////////////////////////////////////////// FUNCION PARA ELIMINAR USUARIO
eliminarUsuario = function (idUsuario) {
  console.log(idUsuario);
  event.preventDefault();
  swal(
    {
      title: "¿Estás seguro?",
      text: "¡No podrá revertir este cambio!",
      type: "warning",
      showCancelButton: true,
      confirmButtonColor: "#DD6B55",
      confirmButtonText: "Si, quiero borrarlo!",
      closeOnConfirm: false,
    },
    function () {
      $.ajax({
        url: '../clases/gestion-usuarios.php?accion=2',
        method: 'POST',
        data: "idUsuario="+idUsuario,
        success:function (respuesta) {
          console.log(respuesta);
          cargarDatos();
          swal("Borrado!",respuesta, "success" );
        },
      });
    }
  );
};
