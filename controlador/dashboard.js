$(document).ready(function () {
  $('#bs_datepicker_range_container').datepicker({
    format: "dd/mm/yyyy",
});
  datosDia();
  capturaCanvas();
  graficosInicio();
  comparaAños();
  rangoFechas();
  $("#actualizaDatosDia").hide();
  $("#inicioGraficas").click(() => {
    eliminaCanvas();
    creaCanvas();
    capturaCanvas();
    graficosInicio();
  });
});

var datosDia = () => {
  setInterval(function () {
    $.ajax({
      beforeSend: function () {
        $("#actualizaDatosDia").show();
      },
      url: "../clases/dashboard.php?accion=1",
      type: "POST",
      success: function (resp) {
        var datos = JSON.parse(resp);
        $("#nuevosUsuarios").html(datos.cantidadUsuarios);
        $("#nuevosAnuncios").html(datos.cantidadAnuncios);
        $("#nuevasDenuncias").html(datos.cantidadDenuncias);
        $("#nuevosComentarios").html(datos.cantidadComentarios);
        console.log(resp);
        $("#actualizaDatosDia").hide(2000);
      },
      error: function (error) {
        alert("ERRROR EN ELA PETICION" + error);
      },
    });
  }, 60000); //TIEMPO DE ACTUALIZACION
};
var eliminaCanvas = () => {
  $("#graficaPublicaciones").remove();
  $("#graficaCategorias").remove();
  $("#graficaLugares").remove();
  $("#graficaUsuarios").remove();
};
var creaCanvas = () => {
  $("#agregaCanvas1").html(
    "<canvas id='graficaPublicaciones' height='150' ></canvas>"
  );
  $("#agregaCanvas2").html(
    "<canvas id='graficaCategorias' height='150' ></canvas>"
  );
  $("#agregaCanvas3").html(
    "<canvas id='graficaLugares' height='150' ></canvas>"
  );
  $("#agregaCanvas4").html(
    "<canvas id='graficaUsuarios' height='150' ></canvas>"
  );
};
var comparaAños = () => {
  
  $("#filtrarAños").click((e) => {
    var año1 = $("#año1").val();
    var año2 = $("#año2").val();  

    if (año1 != año2) {
      
      if(año1==""){
        console.log("datos vacios");
      }
      else if(año2==""){
        console.log("datos vacios");
      }
      else{

        e.preventDefault();
        eliminaCanvas();
        creaCanvas();
        capturaCanvas();
        $.ajax({
          url: "../clases/dashboard.php?accion=3",
          data: "anio1=" + año1 + "&anio2=" + año2,
          type: "POST",
          success: (resp) => {
            datos = JSON.parse(resp);
            //console.log(datos);
            meses = [
              "Enero",
              "Febrero",
              "Marzo",
              "Abril",
              "Mayo",
              "Junio",
              "Julio",
              "Agosto",
              "Septiembre",
              "Octubre",
              "Noviembre",
              "Diciembre",
            ];
  
            dataPublicaciones2019 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  
            for (var key in datos.anio1.publicaciones) {
              for (var key1 in meses) {
                if (key == meses[key1]) {
                  dataPublicaciones2019[key1] = datos.anio1.publicaciones[key];
                }
              }
            }
  
            dataPublicaciones2020 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  
            for (var key in datos.anio2.publicaciones) {
              for (var key1 in meses) {
                if (key == meses[key1]) {
                  dataPublicaciones2020[key1] = datos.anio2.publicaciones[key];
                }
              }
            }
  
            var chart = new Chart(graficaPublicaciones, {
              type: "bar",
              data: {
                labels: meses,
                datasets: [
                  {
                    label: datos.anio1.anio,
                    data: dataPublicaciones2019,
                    backgroundColor: "rgba(0,0,255,0.5)",
                  },
                  {
                    label: datos.anio2.anio,
                    data: dataPublicaciones2020,
                    backgroundColor: "rgba(233, 30, 99, 0.5)",
                  },
                ],
              },
              options: {
                responsive: true,
                scales: {
                  yAxes: [
                    {
                      ticks: {
                        beginAtZero: true,
                      },
                    },
                  ],
                },
              },
            });
  
            categorias2019 = [];
            categorias2020 = [];
  
            valoresCategorias2019 = [];
            valoresCategorias2020 = [];
  
            for (var key in datos.anio1.categorias) {
              categorias2019.push(key);
            }
            for (var key in datos.anio2.categorias) {
              categorias2020.push(key);
            }
            categorias = categorias2019.concat(categorias2020);
  
            Array.prototype.unique = (function (a) {
              return function () {
                return this.filter(a);
              };
            })(function (a, b, c) {
              return c.indexOf(a, b + 1) < 0;
            });
            var categoriasFinal = categorias.unique();
  
            for (var key in datos.anio1.categorias) {
              for (var key1 in categoriasFinal) {
                if (key == categoriasFinal[key1]) {
                  valoresCategorias2019[key1] = datos.anio1.categorias[key];
                }
              }
            }
            for (var key in datos.anio2.categorias) {
              for (var key1 in categoriasFinal) {
                if (key == categoriasFinal[key1]) {
                  valoresCategorias2020[key1] = datos.anio2.categorias[key];
                }
              }
            }
  
            var chart = new Chart(graficaCategorias, {
              type: "bar",
              data: {
                labels: categoriasFinal,
                datasets: [
                  {
                    label: datos.anio1.anio,
                    data: valoresCategorias2019,
                    backgroundColor: "rgba(0,255,0,0.5)",
                  },
                  {
                    label: datos.anio2.anio,
                    data: valoresCategorias2020,
                    backgroundColor: "rgba(0,0,255,0.5)",
                  },
                ],
              },
              options: {
                responsive: true,
                scales: {
                  yAxes: [
                    {
                      ticks: {
                        beginAtZero: true,
                      },
                    },
                  ],
                },
              },
            });
  
            lugares2019 = [];
            lugares2020 = [];
  
            valoresLugares2019 = [];
            valoresLugares2020 = [];
  
            for (var key in datos.anio1.lugar) {
              lugares2019.push(key);
            }
            for (var key in datos.anio2.lugar) {
              lugares2020.push(key);
            }
            lugares = lugares2019.concat(lugares2020);
  
            var lugaresFinal = lugares.unique();
  
            for (var key in datos.anio1.lugar) {
              for (var key1 in lugaresFinal) {
                if (key == lugaresFinal[key1]) {
                  valoresLugares2019[key1] = datos.anio1.lugar[key];
                }
              }
            }
            for (var key in datos.anio2.lugar) {
              for (var key1 in lugaresFinal) {
                if (key == lugaresFinal[key1]) {
                  valoresLugares2020[key1] = datos.anio2.lugar[key];
                }
              }
            }
  
            var chart = new Chart(graficaLugares, {
              type: "bar",
              data: {
                labels: lugaresFinal,
                datasets: [
                  {
                    label:datos.anio1.anio,
                    data: valoresLugares2019,
                    backgroundColor: "rgba(149, 99, 141,0.5)",
                  },
                  {
                    label: datos.anio2.anio,
                    data: valoresLugares2020,
                    backgroundColor: "rgba(0,0,255,0.5)",
                  },
                ],
              },
              options: {
                responsive: true,
                scales: {
                  yAxes: [
                    {
                      ticks: {
                        beginAtZero: true,
                      },
                    },
                  ],
                },
              },
            });
  
            dataUsuarios2019 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  
            for (var key in datos.anio1.usuario) {
              for (var key1 in meses) {
                if (key == meses[key1]) {
                  dataUsuarios2019[key1] = datos.anio1.usuario[key];
                }
              }
            }
  
            dataUsuarios2020 = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];
  
            for (var key in datos.anio2.usuario) {
              for (var key1 in meses) {
                if (key == meses[key1]) {
                  dataUsuarios2020[key1] = datos.anio2.usuario[key];
                }
              }
            }
  
            var chart = new Chart(graficaUsuarios, {
              type: "bar",
              data: {
                labels: meses,
                datasets: [
                  {
                    label: datos.anio1.anio,
                    data: dataUsuarios2019,
                    backgroundColor: "rgba(213, 211, 61,0.7)",
                  },
                  {
                    label: datos.anio2.anio,
                    data: dataUsuarios2020,
                    backgroundColor: "rgba(0,0,255,0.5)",
                  },
                ],
              },
              options: {
                responsive: true,
                scales: {
                  yAxes: [
                    {
                      ticks: {
                        beginAtZero: true,
                      },
                    },
                  ],
                },
              },
            });
          },
        });
      }
      
    } else {
      console.log("años iguales");
    }
  });
};
var capturaCanvas = () => {
  let graficaPublicaciones = document
    .getElementById("graficaPublicaciones")
    .getContext("2d");
  let graficaCategorias = document
    .getElementById("graficaCategorias")
    .getContext("2d");
  let graficaLugares = document
    .getElementById("graficaLugares")
    .getContext("2d");
  let graficaUsuarios = document
    .getElementById("graficaUsuarios")
    .getContext("2d");
};
var graficosInicio = () => {
  const añoActual = "2020";
  $.ajax({
    url: "../clases/dashboard.php?accion=2",
    type: "POST",
    success: function (resp) {
      var datos = JSON.parse(resp);
      meses = [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre",
      ];

      dataPublicaciones = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

      for (var key in datos.publicaciones) {
        for (var key1 in meses) {
          if (key == meses[key1]) {
            dataPublicaciones[key1] = datos.publicaciones[key];
          }
        }
      }

      var chart = new Chart(graficaPublicaciones, {
        //PUBLICACIONES
        type: "bar",
        data: {
          labels: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
          ],
          datasets: [
            {
              label: añoActual,
              data: dataPublicaciones,
              backgroundColor: "rgba(0, 188, 212, 0.5)",
            },
          ],
        },
        options: {
          responsive: true,
          scales: {
            yAxes: [
              {
                ticks: {
                  beginAtZero: true,
                },
              },
            ],
          },
        },
      });

      categorias = [];
      valoresCategorias = [];
      for (var key in datos.categorias) {
        categorias.push(key);
        valoresCategorias.push(datos.categorias[key]);
      }

      var chart = new Chart(graficaCategorias, {
        //GRAFICA POR CATEGORIAS
        type: "bar",
        data: {
          labels: categorias,
          datasets: [
            {
              label: añoActual,
              data: valoresCategorias,
              backgroundColor: "rgba(0,255,0,0.5)",
            },
          ],
        },
        options: {
          responsive: true,
          scales: {
            yAxes: [
              {
                ticks: {
                  beginAtZero: true,
                },
              },
            ],
          },
        },
      });

      lugares = [];
      valoresLugares = [];
      for (var key in datos.lugar) {
        lugares.push(key);
        valoresLugares.push(datos.lugar[key]);
      }
      var chart = new Chart(graficaLugares, {
        //GRAFICA POR LUGARES
        type: "bar",
        data: {
          labels: lugares,
          datasets: [
            {
              label: añoActual,
              data: valoresLugares,
              backgroundColor: "rgba(149, 99, 141,0.5)",
            },
          ],
        },
        options: {
          responsive: true,
          scales: {
            yAxes: [
              {
                ticks: {
                  beginAtZero: true,
                },
              },
            ],
          },
        },
      });

      dataUsuarios = [0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0];

      for (var key in datos.usuario) {
        for (var key1 in meses) {
          if (key == meses[key1]) {
            dataUsuarios[key1] = datos.usuario[key];
          }
        }
      }
      var chart = new Chart(graficaUsuarios, {
        //GRAFICA DE USUARIOS
        type: "bar",
        data: {
          labels: [
            "Enero",
            "Febrero",
            "Marzo",
            "Abril",
            "Mayo",
            "Junio",
            "Julio",
            "Agosto",
            "Septiembre",
            "Octubre",
            "Noviembre",
            "Diciembre",
          ],
          datasets: [
            {
              label: añoActual,
              data: dataUsuarios,
              backgroundColor: "rgba(213, 211, 61,0.7)",
            },
          ],
        },
        options: {
          responsive: true,
          scales: {
            yAxes: [
              {
                ticks: {
                  beginAtZero: true,
                },
              },
            ],
          },
        },
      });
    },
    error: function (error) {
      alert("ERRROR EN ELA PETICION" + error);
    },
  });
};
var rangoFechas=()=>{
  $("#rangoFechas").click(function(){
    fechaInicio=$("#fechaInicio").val();
    fechaFinal=$("#fechaFinal").val();

    fechaInicio2=$("#fechaInicio").val().substring(0,2);
    fechaFinal2=$("#fechaFinal").val().substring(0,2);
    console.log(fechaInicio+"  "+fechaFinal);
    $("#muestraGraficasRangoFechas").hide();
    
    $.ajax({
      url: "../clases/dashboard.php?accion=4",
      type: "POST",
      data:"fecha1="+fechaInicio+"&fecha2="+fechaFinal,
      success: function (resp) {
        //console.log(resp)
        var datos = JSON.parse(resp);
        $("#largeModalLabel").html(fechaInicio+" A "+fechaFinal );
        $("#nuevosUsuarios2").html(datos.infobox.cantidadUsuarios);
        $("#nuevosAnuncios2").html(datos.infobox.cantidadAnuncios);
        $("#nuevasDenuncias2").html(datos.infobox.cantidadDenuncias);
        $("#nuevosComentarios2").html(datos.infobox.cantidadComentarios);
        comparaFechas=fechaFinal2-fechaInicio2;
        if(comparaFechas<=7){
          if(typeof datos.grafico!="undefined"){
            $("#muestraGraficasRangoFechas").show();
            rangoFinal=fechaInicio+" a "+fechaFinal;

            dias = [
              "Lunes",
              "Martes",
              "Miercoles",
              "Jueves",
              "Viernes",
              "Sábado",
              "Domingo"
            ];
      
            dataPublicaciones = [0, 0, 0, 0, 0, 0, 0];
      
            for (var key in datos.grafico) {
              for (var key1 in dias) {
                if (key == dias[key1]) {
                  dataPublicaciones[key1] = datos.grafico[key].publicaciones;
                }
              }
            }

            let graficaPublicaciones = document
            .getElementById("graficaPublicaciones2")
            .getContext("2d");

            var chart = new Chart(graficaPublicaciones2, {
              //PUBLICACIONES
              type: "bar",
              data: {
                labels:dias,
                datasets: [
                  {
                    label: rangoFinal,
                    data: dataPublicaciones,
                    backgroundColor: "rgba(0, 188, 212, 0.5)",
                  },
                ],
              },
              options: {
                responsive: true,
                scales: {
                  yAxes: [
                    {
                      ticks: {
                        beginAtZero: true,
                      },
                    },
                  ],
                },
              },
            });

            /*let graficaCategorias = document
            .getElementById("graficaCategorias2")
            .getContext("2d");
            
            etiquetasCategoria=[];
            valoresCategorias=[];
            for(var key in datos.grafico){
              //console.log(key);
              for (var key1 in datos.grafico[key].categorias){
                //console.log(key1)
                etiquetasCategoria.push(key1);
                
              }
              
            }

            //console.log(etiquetasCategoria)

            Array.prototype.unique = (function (a) {
              return function () {
                return this.filter(a);
              };
            })(function (a, b, c) {
              return c.indexOf(a, b + 1) < 0;
            });
            var etiquetasFinal = etiquetasCategoria.unique();
            console.log(etiquetasFinal)
            var suma=0;
            for (var key in datos.grafico) {
              
              for(var key1 in datos.grafico[key].categorias){ 

                for (var key2 in etiquetasFinal) {
                  if (etiquetasFinal[key2] == key1) {
                    suma+=parseInt(datos.grafico[key].categorias[key1]);
                    
                  }
                }
                
              }
              valoresCategorias.push(suma);
            }
            console.log(suma);

            var chart = new Chart(graficaCategorias, {
              type: "bar",
              data: {
                labels: etiquetasFinal,
                datasets: [
                  {
                    label: rangoFinal,
                    data: valoresCategorias,
                    backgroundColor: "rgba(0,255,0,0.5)",
                  }
                ],
              },
              options: {
                responsive: true,
                scales: {
                  yAxes: [
                    {
                      ticks: {
                        beginAtZero: true,
                      },
                    },
                  ],
                },
              },
            });*/
            



          }
          

          //console.log(comparaFechas);

        }
        

      console.log(datos)
      },
      error: function (error) {
        alert("ERRROR EN ELA PETICION" + error);
      },
    });    

  })

}
