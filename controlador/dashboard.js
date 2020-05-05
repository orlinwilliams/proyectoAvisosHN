$(document).ready(function () {
  capturaCanvas();
  graficosInicio();
  comparaAños();
  $("#actualizaDatosDia").hide();
  datosDia();
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
      type: "GET",
      success: function (resp) {
        var datos = JSON.parse(resp);
        $("#nuevosUsuarios").html(datos.cantidadUsuarios);
        $("#nuevosAnuncios").html(datos.cantidadAnuncios);
        console.log(resp);
        $("#actualizaDatosDia").hide(2000);
      },
      error: function (error) {
        alert("ERRROR EN ELA PETICION" + error);
      },
    });
  }, 9000);
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
      e.preventDefault();
      eliminaCanvas();
      creaCanvas();
      capturaCanvas();

      var chart = new Chart(graficaPublicaciones, {
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
              label: "2019",
              data: [100, 90, 85, 70, 80, 90, 25, 30, 68, 90, 60, 50],
              backgroundColor: "rgba(0,0,255,0.5)",
            },
            {
              label: "2020",
              data: [100, 90, 85, 70, 63, 65, 40, 30, 68, 40, 90, 40],
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

      var chart = new Chart(graficaCategorias, {
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
              label: "2019",
              data: [100, 90, 85, 70, 80, 90, 25, 30, 68, 90, 60, 50],
              backgroundColor: "rgba(0,255,0,0.5)",
            },
            {
              label: "2020",
              data: [100, 90, 85, 70, 63, 65, 40, 30, 68, 40, 90, 40],
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
      var chart = new Chart(graficaLugares, {
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
              label: "2019",
              data: [100, 90, 85, 70, 80, 90, 25, 30, 68, 90, 60, 50],
              backgroundColor: "rgba(149, 99, 141,0.5)",
            },
            {
              label: "2020",
              data: [100, 90, 85, 70, 63, 65, 40, 30, 68, 40, 90, 40],
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
      var chart = new Chart(graficaUsuarios, {
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
              label: "2019",
              data: [100, 90, 85, 70, 80, 90, 25, 30, 68, 90, 60, 50],
              backgroundColor: "rgba(213, 211, 61,0.7)",
            },
            {
              label: "2020",
              data: [100, 90, 85, 70, 63, 65, 40, 30, 68, 40, 90, 40],
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
  var chart = new Chart(graficaPublicaciones, {
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
          label: "2019",
          data: [100, 90, 85, 70, 80, 90, 25, 30, 68, 90, 60, 50],
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

  var chart = new Chart(graficaCategorias, {
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
          label: "2019",
          data: [100, 90, 85, 70, 80, 90, 25, 30, 68, 90, 60, 50],
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
  var chart = new Chart(graficaLugares, {
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
          label: "2019",
          data: [100, 90, 85, 70, 80, 90, 25, 30, 68, 90, 60, 50],
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
  var chart = new Chart(graficaUsuarios, {
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
          label: "2019",
          data: [100, 90, 85, 70, 80, 90, 25, 30, 68, 90, 60, 50],
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
};

//---------------------------------------------//
/*var chart=new Chart(graficaPublicaciones,{
    type:"bar",
    data:{
      labels:["Enero",
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
      "Diciembre"],
      datasets:[{
        label:"2019",
        data:[100,90,85,70,80,90,25,30,68,90,60,50],
        backgroundColor: "rgba(0, 188, 212, 0.5)",
      },
      {
        label:"2020",
        data:[100,90,85,70,63,65,40,30,68,40,90,40],
        backgroundColor: "rgba(233, 30, 99, 0.5)",
      }
    ]
    },
    options:{
      responsive: true,
      scales:{
        yAxes:[{
          ticks:{
            beginAtZero:true
          }
        }]
      }

    }
      
    
  })

  var chart=new Chart(graficaCategorias,{
    type:"bar",
    data:{
      labels:["Enero",
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
      "Diciembre"],
      datasets:[{
        label:"2019",
        data:[100,90,85,70,80,90,25,30,68,90,60,50],
        backgroundColor: "rgba(0,255,0,0.5)",
      },
      {
        label:"2020",
        data:[100,90,85,70,63,65,40,30,68,40,90,40],
        backgroundColor: "rgba(0,0,255,0.5)",
      }
    ]
    },
    options:{
      responsive: true,
      scales:{
        yAxes:[{
          ticks:{
            beginAtZero:true
          }
        }]
      }

    }
      
    
  })
  var chart=new Chart(graficaLugares,{
    type:"bar",
    data:{
      labels:["Enero",
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
      "Diciembre"],
      datasets:[{
        label:"2019",
        data:[100,90,85,70,80,90,25,30,68,90,60,50],
        backgroundColor: "rgba(149, 99, 141,0.5)",
      },
      {
        label:"2020",
        data:[100,90,85,70,63,65,40,30,68,40,90,40],
        backgroundColor: "rgba(0,0,255,0.5)",
      }
    ]
    },
    options:{
      responsive: true,
      scales:{
        yAxes:[{
          ticks:{
            beginAtZero:true
          }
        }]
      }

    }
      
    
  })
  var chart=new Chart(graficaUsuarios,{
    type:"bar",
    data:{
      labels:["Enero",
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
      "Diciembre"],
      datasets:[{
        label:"2019",
        data:[100,90,85,70,80,90,25,30,68,90,60,50],
        backgroundColor: "rgba(213, 211, 61,0.7)",
      },
      {
        label:"2020",
        data:[100,90,85,70,63,65,40,30,68,40,90,40],
        backgroundColor: "rgba(0,0,255,0.5)",
      }
    ]
    },
    options:{
      responsive: true,
      scales:{
        yAxes:[{
          ticks:{
            beginAtZero:true
          }
        }]
      }

    }
      
    
  })*/

//labels: ["Electrónica","Casa y Jardín","Moda","Deportes","Motor","Coleccionismo","Joyería y Belleza","Ocio","Otras categorías"],
