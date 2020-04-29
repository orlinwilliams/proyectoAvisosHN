$(function () {
  new Chart(document.getElementById("bar_chart").getContext("2d"),getChartJs("bar"));
  new Chart(document.getElementById("bar_chart_2").getContext("2d"),getChartJs("bar_2"));
  new Chart(document.getElementById("pie_chart").getContext("2d"),getChartJs("pie"));
  new Chart(document.getElementById("pie_chart_2").getContext("2d"),getChartJs("pie_2"));
});

function getChartJs(type) {
  var config = null;

  if (type === "bar") {
    config = {
      type: "bar",
      data: {
        labels: ["Electrónica","Casa y Jardín","Moda","Deportes","Motor","Coleccionismo","Joyería y Belleza","Ocio","Otras categorías"],
        datasets: [{
            label: "Grupo de categoría",
            data: [100, 59, 80, 81, 56, 55, 40, 30, 60],
            backgroundColor: "rgba(0, 188, 212, 0.8)",
          }],
      },
      options: {
        responsive: true,
        legend: false,
      },
    };
  } else if (type === "bar_2") {
    config = {
      type: "bar",
      data: {
        labels: [
          "Lunes",
          "Martes",
          "Miércoles",
          "Jueves",
          "Viernes",
          "Sábado",
          "Domingo",
        ],
        datasets: [
          {
            label: "Publicaciones por día",
            data: [59, 79, 35, 25, 100, 85, 25],
            backgroundColor: "rgba(233, 30, 99, 0.8)",
          },
        ],
      },
      options: {
        responsive: true,
        legend: false,
      },
    };
  } else if (type === "pie") {
    config = {
      type: "pie",
      data: {
        datasets: [
          {
            data: [369, 150, 203, 255, 218, 396, 216, 199, 239, 400, 299, 135],
            backgroundColor: ["rgba(214,154,0,0.7)", "rgba(255,5,5,0.7)", "rgba(5,75,255,0.7)", "rgba(255,92,0,0.7)", "rgba(0,209,255,0.7)", "rgba(102,0,0,0.7)", "rgba(189,0,255,0.7)", "rgba(0,112,99,0.7)", "rgba(5,0,255,0.7)", "rgba(255,0,0,0.7)", "rgba(75,196,196,0.92)", "rgba(97,0,0,0.92)"],
          },
        ],
        labels: ["Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre"],
      },
      options: {
        responsive: true,
        legend: false,
      },
    };
  } else if (type === "pie_2") {
    config = {
      type: "pie",
      data: {
        datasets: [
          {
            data: [369, 150, 203, 255, 218, 396, 216, 199, 239, 400, 299, 135, 100, 125, 153, 262, 145, 63],
            backgroundColor: ["rgba(5,75,255,0.7)", "rgba(214,154,0,0.7)", "rgba(255,92,0,0.7)", "rgba(0,209,255,0.7)", "rgba(255,5,5,0.7)", "rgba(189,0,255,0.7)", "rgba(0,112,99,0.7)", "rgba(5,0,255,0.7)", "rgba(102,0,0,0.7)", "rgba(75,196,196,0.92)", "rgba(255,0,0,0.7)", "rgba(97,0,0,0.92)", "rgba(80, 20, 86, 0.8)", "rgba(250, 166, 161, 0.7)", "rgba(240, 213, 92, 0.7)", "rgba(51, 58, 84, 0.6)", "rgba(114, 249, 64, 0.8)", "rgba(253, 245, 79, 0.9)"],
          },
        ],
        labels: ["Atlántida","Colón","Comayagua","Copán","Cortés","Choluteca","El Paraíso","Francisco Morazán","Gracias a Dios","Intibucá","Islas de la Bahía","La Paz","Lempira","Ocotepeque","Olancho","Santa Bárbara","Valle","Yoro"],
      },
      options: {
        responsive: true,
        legend: false,
      },
    };
  }
  
  return config;
}

