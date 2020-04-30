$(function () {
  $(".js-basic-example").DataTable({
    responsive: true,
  });
});
///////////////////////////////////////////// FUNCION PARA ELIMINAR LAS PUBLICACIONES
eliminarPublicacion = function (idAnuncio) {
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
      $.ajax({
          url: "../clases/mis-publicaciones.php?accion=4",
          method: "POST",
          data: "txt_idanuncios=" + idAnuncio,
          success: function (resp) {
              console.log(resp);
              swal("Borrado!",resp, "success" );
              //window.setTimeout("location.reload()",2000);
          }
      });    
  });
};
//////////////////////////////////////////// DATATIME PICKER WITH MOMENTS
$(function () {
  //Textarea auto growth
  autosize($("textarea.auto-growth"));
  //Datetimepicker plugin
  $(".datetimepicker").bootstrapMaterialDatePicker({
    format: "YYYY-MM-DD HH:mm",
    clearButton: true,
    weekStart: 1,
  });
});
