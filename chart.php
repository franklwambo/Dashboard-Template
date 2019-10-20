<!-- Departmental visits go here  -->

<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Highcharts Pie Chart</title>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
var options = {
chart: {
renderTo: 'container',
plotBackgroundColor: null,
plotBorderWidth: null,
plotShadow: false
},
title: {
text: 'Visit count per department- All facilities'
},
tooltip: {
formatter: function() {
return '<b>'+ this.point.name +'</b>: '+ this.point.y +'';
//use the blow code if you desire values returned in terms of percentages
//return '<b>'+ this.point.name +'</b>: '+ this.percentage +' %';
}
},
plotOptions: {
pie: {
allowPointSelect: true,
cursor: 'pointer',
dataLabels: {
enabled: true,
color: '#000000',
connectorColor: '#000000',
formatter: function() {
return '<b>'+ this.point.name +'</b>: '+ this.point.y +'';
}
}
}
},
credits: {
    enabled: false
},
series: [{
type: 'pie',
name: 'Visit counts',
data: []
}]
}
 
$.getJSON("visit_data.php", function(json) {
options.series[0].data = json;
chart = new Highcharts.Chart(options);
});
 
 
 
});
</script>
<script src="http://code.highcharts.com/highcharts.js"></script>
<script src="http://code.highcharts.com/modules/exporting.js"></script>
</head>
<body>
<div id="container" style="min-width: 400px; height: 400px; margin: 0 auto"></div>
</body>
</html>



