<?php  
   require("dbconn.php");
  $query = "CALL js_MySQL_SETS_Persons_WithAgeGroups()";
  $result = mysqli_query($connect, $query);
  //pre-declare the arrays to hold the values
  $male_result = array();
  $female_result = array();
  $category_names = array();

  while($row = mysqli_fetch_array($result))
   {

    $male_result[] = $row["Males"];
    $female_result[] = $row["Females"];
    $category_names[] = $row["Range"];
   }

//convert the aforementioned array values to list
$Male_List = implode(', ', $male_result);
$Female_List = implode(', ', $female_result);
$Category_List = json_encode($category_names,JSON_NUMERIC_CHECK);

//notice that we will need to print_r/echo each of these list items later

  //finally closing the database connection
  $result->free();
  mysqli_close($connect);
?>

<html>
<head>
<script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
<script src="https://code.highcharts.com/highcharts.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
</head>
<body>
<div id="container" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<script type="text/javascript">
// Data gathered from http://populationpyramid.net/germany/2015/

// Age categories
//var categories = [ <?php echo $Category_List; ?> ];
var categories = <?php echo $Category_List; ?>;


Highcharts.chart('container', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'SETS Registration Age-Sex Pyramid as at <?php echo date("Y"); ?>'
    },
    /*
    subtitle: {
        text: 'Source: <a href="http://populationpyramid.net/germany/2018/">Population Pyramids of the World from 1950 to 2100</a>'
    },
    */
    xAxis: [{
        categories: categories,
        reversed: false,
        labels: {
            step: 1
        }
    }, { // mirror axis on right side
        opposite: true,
        reversed: false,
        categories: categories,
        linkedTo: 0,
        labels: {
            step: 1
        }
    }],
    yAxis: {
        title: {
            text: 'Age groups'
        },
        labels: {
            formatter: function () {
                //return Math.abs(this.value) + '%';
                return Math.abs(this.value);
            }
        }
    },

    credits: 
     {
        enabled: false
     },

    plotOptions: 
      {
        series: {
            stacking: 'normal'
        }
    },

    tooltip: 
    {
        formatter: function ()
         {
            return '<b>' + this.series.name + ', age ' + this.point.category + '</b><br/>' +
                'Population: ' + Highcharts.numberFormat(Math.abs(this.point.y), 0);
        }
    },

    series: [{
        name: 'Male',
        data: [
            
            <?php print_r($Male_List); ?>

              ]
    }, {
        name: 'Female',
        data: 
        [
            <?php print_r($Female_List); ?>       
        ]
    }]
});
</script>
</body>
</html>