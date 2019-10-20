<?php

require("dbconn.php");
  $query = "CALL js_MySQL_uSP_Facility_Aggregations()";
  $result = mysqli_query($connect, $query);
  //pre-declare the arrays to hold the values
  $facility = array();
  $registered = array();
  $residents = array();
  $matched = array();
  $positive = array();
  $with_ccc_no = array();

  while($row = mysqli_fetch_array($result))
   {
    $registered[] = $row["registered"];
    $residents[] = $row["residents"];
    $matched[] = $row["matched"];
    $positive[] = $row["positive"];
    $with_ccc_no[] = $row["with_ccc_no"];
    $facility[] = $row["facility"];
   }


	$registered = json_encode($registered,JSON_NUMERIC_CHECK);

    $residents = json_encode($residents,JSON_NUMERIC_CHECK);

    $matched = json_encode($matched,JSON_NUMERIC_CHECK);

    $positive = json_encode($positive,JSON_NUMERIC_CHECK);

    $with_ccc_no = json_encode($with_ccc_no,JSON_NUMERIC_CHECK);
    

?>


<!DOCTYPE html>

<html>

<head>

	<title>HighChart</title>

	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.js"></script>
	<script src="https://code.highcharts.com/highcharts.js"></script>
    <script src="https://code.highcharts.com/modules/exporting.js"></script>
    <script src="https://code.highcharts.com/modules/export-data.js"></script>

</head>

<body>


<script type="text/javascript">


$(function () { 


    var data_registered = <?php echo $registered; ?>;

    var data_residents = <?php echo $residents; ?>;

    var data_matched = <?php echo $matched; ?>;

    var data_positive = <?php echo $positive; ?>;

    var data_with_ccc_no = <?php echo $with_ccc_no; ?>;


    $('#container').highcharts({

        chart: {

            type: 'column'

        },

        title: {

            text: 'Registration, HDSS Match and Linkage to Care'

        },


        credits: 
         {
           
           enabled: false
         },

         

        xAxis: {

            //categories: ['Bar-Sauri','Ogero','Siala', 'Gongo','Aluor','Uriri','Nyawara','Rera','Asayi','Masogo','Dienya','Sirembe','Akala','Wagai']

            categories: <?php echo json_encode($facility,JSON_NUMERIC_CHECK); ?>,

            labels: 
              {
                  rotation: 300
              }
              
              /*
              title: 
              {
                  text:'SETS facilities'
              }

              */

        },

        yAxis: {

            title: {

                text: 'Count'

            }

        },

        useHTML:true,

        series: [{

            name: 'Registered',

            data: data_registered

        }, 
        
        {

            name: 'Residents',

            data: data_residents

        },

           {

               name: 'Matched',

               data: data_matched

            },

            {
               
                name: 'Positive',

                data: data_positive

            },

              {
               
                 name: 'Linked to Care',

                 data: data_with_ccc_no

             }

        ]

    });

});


</script>


<div class="container">

	<br/>

	

    <div class="row">

        <div class="col-md-10 col-md-offset-1">

            <div class="panel panel-default">

               <!-- <div class="panel-heading">Dashboard</div>  -->

                <div class="panel-body">

                    <div id="container"></div>

                </div>

            </div>

        </div>

    </div>

</div>


</body>

</html>