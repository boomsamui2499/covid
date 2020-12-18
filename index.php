<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<!DOCTYPE HTML>
<html>
<head>
 
<script>


window.onload = function () {
  axios.get(`https://disease.sh/v3/covid-19/nyt/states?lastdays=30`, {
                  
                })
                .then(function(response) {
                    let data = response.data;
                    console.log(data)
                    data.forEach(x => {
                        x.y = x.y;
                    })

                    showgraph(data, "bar", "chartContainer", {
                        cursor: "pointer",
                        fontSize: 16,
                        horizontalAlign: "right",
                        verticalAlign: "center",
                    }, {
                        title: "วันที่ (ปี-เดือน-วัน)",
                        valueFormatString: "DD MMM,YY",
                    });

                });

        }
            function showgraph(data, formatgraph, idforshowgraph) {
                
                let dataCovid = [];
                let setdata;
                let settitle;
                let setlegend;
                let setaxisX;
                if (idforshowgraph == "chartContainer") {
                    setaxisX = {
                        title: "วันที่ (ปี-เดือน-วัน)",
                        stacked: true,

                        valueFormatString: "DD MMM,YY"
                    }

                    settitle = {
                        text: "กราฟสรุปข้อมูลรายวัน",
                        display: false,

                    }
                    setlegend = {
                        cursor: "pointer",
                        fontSize: 16,
                        itemclick: function(e) {
                            if (typeof(e.dataSeries.visible) === "undefined" || e.dataSeries.visible) {
                                e.dataSeries.visible = false;
                            } else {
                                e.dataSeries.visible = true;
                            }

                            e.chart.render();
                        }
                    }
                    data.forEach(x => {
                        dataCovid.push({
                            "label": x.state,
                            "y": x.cases
                        })
                    })

                   
                }
var chart = new CanvasJS.Chart("chartContainer",{
  theme: "dark2", // "light1", "light2", "dark1"
  animationEnabled: true,
  exportEnabled: true,
  height: 900,
  title: {
    text: "Covid 2020"
  },
  axisX: {
    margin: 10,
    labelPlacement: "inside",
    tickPlacement: "inside"
  },
  axisY2: {
    titleFontSize: 14,
    includeZero: true,
    suffix: ""
  },
  data: [{
    type: "bar",
    axisYType: "secondary",
    yValueFormatString: "#,###.##",
    // indexLabel: "{y}",
    dataPoints: dataCovid
    
  }]
});
chart.render();
  
}
</script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>
</html>