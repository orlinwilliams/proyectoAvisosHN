$(function () {
  $(".js-basic-example").DataTable({
    responsive: true,
  });
});
///////////////////////////////////////////// FUNCION PARA ELIMINAR LAS PUBLICACIONES
function eliminarPublicacion(params) {
  console.log(params);
}
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
