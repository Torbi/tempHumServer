
//borde göra en chart klass med funktioner som kan ändra labels o skit, jquery?

//Hämtar data asynkront med hjälp av ajax från databasen, lägger in det i chartens datasets och labels och updaterar den sedan
//Den körs i slutet av window.onload samt varje gång som controllern får ett nytt värde och lägger in det i databasen
function updateData(myChart, days){

//om någon har tryckt på en knapp för att välja ett annat intervall
//läggs den parametern på i urlen
//det tas sedan emot i funktionen renderChartData i chartController
    console.log("den här madderfakkern körs");
    var url = "chart/renderChartData";
    if(days != "")  {
      url = url + "/" + days;
    }
   $.ajax({
     type: "POST",
     url: url,
     success: function(data) {
       var res = JSON.parse(data);
       console.log(res);
       //rensar chartens arrayer
       myChart.data.labels = [];
       myChart.data.datasets[0].data = [];
       myChart.data.datasets[1].data = [];
       myChart.update();

       for(var i = 0; i < res.length; i++) {
         //lägger in värdena i chartens data arrayer
         myChart.data.labels.push(res[i][0]);
         myChart.data.datasets[0].data.push(res[i][1]);
         myChart.data.datasets[1].data.push(res[i][2]);
         myChart.update();
       }
     },
     error: function(data) {
       console.log("error with creating chart");
       console.log(data);
     }
   });
  }

/*Skapar en tom chart när sidan laddats in kallar sedan på funktionen updateData */
window.onload = function(){
  console.log("document ready körs");

  var options = {
    responsive: true,
    title: {
      display: true,
      text: "Temperatur över tid",
    },
    legend: {
      display: false
    },
    scales: {
      yAxes: [{
        ticks: {
          beginAtZero: true,
        },
        scaleLabel: {
          display: true,
          labelString: 'Temperatur och luftfuktighet',
          fontSize: 20
        }
      }],
      xAxes: [{
        scaleLabel: {
          display: true,
          labelString: 'Datum',
          fontSize: 20,
        }
      }]
    },
    animation: {
      animation: true,
      animationSteps: 60,
      easing: "linear",

    },
    pointDot: true,
    pointHitDetectionRadius: 20,
  }

  var data = {
    labels: [],
    datasets: [{
      data: [],
      borderWidth: 1,
      label: 'Temperatur',
      fillColor: "rgba(151,187,205,0.25)",
      strokeColor: "rgba(151,187,205,1)",
      pointColor: "rgba(151,187,205,1)",
      pointStrokeColor: "#fff",
      pointHighlightFill: "#fff",
      pointHighlightStroke: "rgba(151,187,205,1)",
      backgroundColor: "rgba(255, 93, 64, 0.6)",
      pointBorderColor: "black",
      pointBackgroundColor: "#40ffbc",
    }, {
      label: "Hum",
      data: [],
      fillColor: "rgba(151,187,205,0.2)",
      strokeColor: "rgba(151,187,205,1)",
      pointColor: "rgba(151,187,205,1)",
      pointStrokeColor: "#fff",
      pointHighlightFill: "#fff",
      pointHighlightStroke: "rgba(151,187,205,1)",
      backgroundColor: "rgba(64, 226, 255,0.4)",
      pointBorderColor: "black",
      pointBackgroundColor: "#40ffbc",
    }
  ]
}

  var ctx_live = document.getElementById("canvasChart").getContext("2d");
  var myChart = new Chart(ctx_live, {
    type: 'line',
    data: data,
    options: options
  });
    updateData(myChart, 69);
  // setInterval(updateData(myChart , 69), 5000);

  var day = document.getElementById('btnDag');
  var vecka = document.getElementById('btnVecka');
  var month = document.getElementById('btnMonth');

    day.addEventListener("click", function()  {
      console.log("hit 1");
      updateData(myChart, 1);
    });

    vecka.addEventListener("click", function()  {
      console.log("hit 7");
      updateData(myChart, 7);
    });

    month.addEventListener("click", function()  {
      console.log("hit 30");
      updateData(myChart, 30);
    });
}
