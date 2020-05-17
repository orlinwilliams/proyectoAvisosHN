$(document).ready(function () {
  datosDia();
  tablaGestionPublicaciones();
});
///////////////////////////////////////////// FUNCION QUE SE EJECUTA AL HACER UN CAMBIO EN LA FECHA Y AL ACTUALIZA
mifuncionFecha = function (m) {
  var l = "";
  var x = $("#" + m + "").val();
  console.log(x);

  l += "<input type='hidden' readonly id='fecha1' value='" + x + "'>";
  $("#fecha2").html(l);

  $.ajax({
    url: "../clases/gestionpublicaciones.php?accion=3",
    method: "POST",
    data:
      "txt_idanuncio=" +
      $("#fechaidanuncio" + m + "").val() +
      "&fechaactualizada=" +
      $("#fecha1").val(),
    success: function (resp) {
      console.log(resp);
      tablaGestionPublicaciones();
    },
  });
};
///////////////////////////////////////////// FUNCION PARA ELIMINAR LAS PUBLICACIONES
eliminarPublicacion = function (idAnuncio, idUsuario) {
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
        url: "../clases/gestionpublicaciones.php?accion=2",
        method: "POST",
        data: "txt_idanuncios=" + idAnuncio + "&txt_idusuario=" + idUsuario,
        success: function (resp) {
          console.log(resp);
          swal("Borrado!", resp, "success");
          tablaGestionPublicaciones();
        },
      });
    }
  );
};
/////////////////////////////////////////////INSERTAR DATOS EN LA TABLA
tablaGestionPublicaciones = function () {
  //PUBLICACIONES DE INICIO USUARIO
  $.ajax({
    url: "../clases/gestionpublicaciones.php?accion=1",
    success: function (resp) {
      let datos = JSON.parse(resp);
      var filas = "";
      let i = 0;
      for (let item of datos) {
        //RECORRER EL JSON
        filas +=
          "<tr>" +
          "<td>" +
          item.nombre +
          "</td>" +
          "<td>" +
          item.nombreCategoria +
          "</td>" +
          "<td>" +
          item.precio +
          "</td>" +
          "<td>" +
          item.nombreVendedor +
          "</td>" +
          "<td>" +
          item.fechaPublicacion +
          "</td>" +
          "<td>" +
          "<div class='form-group'>" +
          "<input type='text' id='" +
          i +
          "' onchange='mifuncionFecha(" +
          i +
          ")'  class='datetimepicker form-control' placeholder='" +
          item.fechaLimite +
          "' value='' >" +
          "<!--EN EL VALUE DEBE CARGAR LA HORA DE LA BASE DE DATOS-->" +
          "<input type='hidden' readonly='readonly' id='fechaidanuncio" +
          i +
          "' value='" +
          item.idAnuncios +
          "'>" +
          "<div type='hidden' readonly id='fecha2' value=''></div>" +
          "</div>" +
          "</td>" +
          "<td style=' text-align:center;''> <button type='button' class='btn bg-red waves-effect' onclick='eliminarPublicacion(" +
          item.idAnuncios +
          "," +
          item.idUsuario +
          ")'>" +
          "<i class='material-icons'>delete_forever</i>" +
          "</button></td>" +
          "</tr>";
        $("#tablaPublicaciones").html(filas);
        //////////////////////////////////////////// DATATIME PICKER WITH MOMENTS
        i = i + 1;
      }
      ///////////////////////////////////////////// FUNCIÓN PARA LA INICIALIZACIÓN DE LA TABLA
      $(function () {
        $(".js-basic-example").DataTable({
          retrieve: true,
          responsive: true,
        });
      });
      $(function () {
        //Textarea auto growth
        autosize($("textarea.auto-growth"));
        //Datetimepicker plugin
        $(".datetimepicker").bootstrapMaterialDatePicker({
          format: "YYYY-MM-DD HH:mm",
          clearButton: true,
          weekStart: 1,
          linkField: "fecha1",
        });
      });
    },
    error: function (error) {
      console.log(error);
    },
  });
};
/////////////////////////////////////////////CARGA LA INFORMACION EN LOS INFOBOX
var datosDia = () => {
    $.ajax({
      beforeSend: function () {
        $("#actualizaDatosDia").show();
      },
      url: "../clases/gestionpublicaciones.php?accion=4",
      type: "POST",
      success: function (resp) {
        console.log(resp);
        var datos = JSON.parse(resp);
        $("#vendidos").html(datos.vendidos);
        $("#cambiarParecer").html(datos.cambiarParecer);
        $("#anunciosBorrados").html(datos.borrados);
        $("#porqueQuiero").html(datos.porqueQuiero);
        $("#otraRazon").html(datos.otraRazon);
        console.log(resp);
        $("#actualizaDatosDia").hide(2000);
      },
      error: function (error) {
        alert("ERRROR EN ELA PETICION" + error);
      },
    });
};
