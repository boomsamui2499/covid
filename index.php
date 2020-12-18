<script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>

<!DOCTYPE HTML>
<html>

<head>

    <script>
        window.onload = function() {
            axios.get(`https://disease.sh/v3/covid-19/nyt/counties?lastdays=30`, {}).then(function(response) {
                let data = response.data;

                data.forEach(x => {
                    x.label = x.date;
                    x.y = x.cases;
                })
                let temp = [];
                let curDate = data[0].date;
                let results = [];
                for (const item of data) {
                    if (item.date === curDate) {
                        temp.push(item)
                    } else {
                        curDate = item.date
                        results.push(temp)
                        temp = []
                        temp.push(item)
                    }
                    // console.log(item)
                }
                console.log(results)
                showgraph(results, "bar", "chartContainer", {
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

        async function showgraph(data, formatgraph, idforshowgraph) {
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
                // data.forEach(x => {
                //     dataCovid.push({
                //         "label": x.county,
                //         "y": x.cases,

                //     })
                // })


            }

            function timeout(ms) {
                return new Promise(resolve => setTimeout(resolve, ms));
            }
            for (const test of data) {
                var chart = new CanvasJS.Chart("chartContainer", {
                    theme: "dark2",
                    animationEnabled: true,
                    exportEnabled: true,
                    title: {

                        text: `covid19 30 day ${test[0].date}`
                    },
                    axisX: {
                        gridThickness: 0,
                        tickLength: 0,
                        lineThickness: 0,
                        labelFormatter: function() {
                            return " ";
                        }
                    },
                    axisY2: {
                        titleFontSize: 14,
                        includeZero: true,
                        suffix: ""
                    },
                    data: [{
                        type: "bar",
                        yValueFormatString: "#,###.## cases",
                        dataPoints: test.map(a => ({
                            "label": a.county,
                            "y": a.cases,
                            ...a
                        }))

                    }]
                });
                chart.render();
                await timeout(1000);
                chart.destroy();


            }
        }
    </script>
</head>

<body>
    <div id="chartContainer" style="height: 650; width: 100%;"></div>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
</body>

</html>