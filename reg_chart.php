<?php

  require("dbconn.php");
  $query = "CALL js_MySQL_uSP_Facility_Aggregations()";
  $res = mysqli_query($connect, $query);
    //$rows = array(); 

$category = array();
$category['name'] = 'facility';
 
$series1 = array();
$series1['name'] = 'registered';
 
$series2 = array();
$series2['name'] = 'residents';
 
$series3 = array();
$series3['name'] = 'matched';

$series4 = array();
$series4['name'] = 'positive';

$series5 = array();
$series5['name'] = 'with_ccc_no';


while($r = mysqli_fetch_array($res)) 
{
    $category['data'][] = $r['facility'];
    $series1['data'][] = $r['registered'];
    $series2['data'][] = $r['residents'];
    $series3['data'][] = $r['matched'];  
    $series4['data'][] = $r['positive']; 
    $series5['data'][] = $r['with_ccc_no'];  
}

$result = array();
array_push($result,$category);
array_push($result,$series1);
array_push($result,$series2);
array_push($result,$series3);
array_push($result,$series4);
array_push($result,$series5);

print json_encode($result, JSON_NUMERIC_CHECK);
 
//$result->free();
mysqli_close($con);    

  
?>