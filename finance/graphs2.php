<!DOCTYPE html>
<html>
<head>
  <meta http-equiv="content-type" content="text/html; charset=UTF-8">
  <title>amCharts tutorial: Loading external data</title>
<script src="js/amcharts/amcharts/amcharts.js" type="text/javascript"></script>
<script src="js/amcharts/amcharts/pie.js" type="text/javascript"></script>
</head>
<body>
  
  <script>

    $.ajax({
    url: "http://localhost/jimsfinance/finance/data.php",
    cache: false,
    type: "POST",
    dataType: "json",
    timeout:3000,
    success : function (data) {
   var chart = AmCharts.makeChart( "chartdiv", {
  "type": "pie",
  "theme": "light",
  "dataProvider":data,
  "valueField": "amount",
  "titleField": "accname",
  "outlineAlpha": 0.4,
  "depth3D": 15,
  "balloonText": "[[title]]<br><span style='font-size:14px'><b>[[value]]</b> ([[percents]]%)</span>",
  "angle": 30,
  "export": {
    "enabled": true
  }
});
    }
       });

  </script>
</body>
</html>

