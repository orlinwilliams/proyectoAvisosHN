$(document).ready(function () {

    var nonLinearSlider = document.getElementById('nouislider_range_example');
    var nodes = [
        document.getElementById('lower-value'), // 0
        document.getElementById('upper-value')  // 1
    ];
    
    nonLinearSlider.noUiSlider.on('update', function (values, handle) {
      nodes[handle].value = values[handle];
      });

   
      
})

publicacionesFiltradas = function () {
    //PUBLICACIONES FILTRADAS
    
    $.ajax({
        data:"flugar=" + $("#f-lugar").val() +
             "&fcategoria=" + $("#f-categoria").val() +
             "&valoracion=" + $("#valoracion").val() +
             "&tipovendedor=" + $("#tipoven").val() +
             "&minimo=" +$("#lower-value").val() +
             "&maximo=" +  $("#upper-value").val(),
        url: "../clases/filtros.php?accion=1",
        
      success: function (resp) {
        let datos = JSON.parse(resp);
        var tarjetasFiltradas = "";
        var mensaje = "";
        if (datos.error == true) {
          //console.log("no se encontraron coincidencias");
          mensaje+="<h2> "+datos.mensaje+"</h2>"
          $("#contenedorTarjeta").html(mensaje);
        } else {
            for (let item of datos) {
              //RECORRER EL JSON
              tarjetasFiltradas +=
                "<div class='col-sm-6 col-md-6 col-lg-4'>" +
                "<div class='carde'>" +
                "<div class='card__image-holder'>" +
                "<img class='card__image' src='" +
                item.fotos[0] +
                "' alt='Miniatura del anuncio' width='320px;' height='255px;'/>" +
                "</div>" +
                "<div class='card-title'>" +
                "<a  href='#' class='toggle-info btn'>" +
                "<span class='left'></span>" +
                "<span class='right'></span>" +
                "</a>" +
                "<h2>" +
                item.nombre +
                "<small>" +
                item.precio +
                "</small>" +
                "</h2>" +
                "</div>" +
                "<div class='card-flap flap1'>" +
                "<div class='card-description'>" +
                item.descripcion +
                "</div>" +
                "<div class='card-flap flap2'>" +
                "<div class='card-actions'>" +
                "<a href='#' class='btn' data-toggle='modal' data-target='#defaultModal' onclick='cargarArticulo(" +
                item.idAnuncios +
                ")'>Ver</a>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>" +
                "</div>";
              $("#contenedorTarjeta").html(tarjetasFiltradas); //INSERTA LAS TARJETAS
              
            }
         }
  
        //var zindex = 10;
        $("div.carde").click(function (e) {
          e.preventDefault();
          var isShowing = false;
          if ($(this).hasClass("show")) {
            isShowing = true;
          }
          if ($("div.cards").hasClass("showing")) {
            // a card is already in view
            $("div.carde.show").removeClass("show");
            if (isShowing) {
              // this card was showing - reset the grid
              $("div.cards").removeClass("showing");
            } else {
              // this card isn't showing - get in with it
              $(this).css({ zIndex: 1 }).addClass("show");
            }
            //zindex++;
          } else {
            // no cards in view
            $("div.cards").addClass("showing");
            $(this).css({ zIndex: 2 }).addClass("show");
            //zindex++;
          }
        });
      },
     
      error: function (error) {
        console.log(error);
        
    },
    });
  };