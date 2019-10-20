<?php

require_once("dbconn.php");

$facility_mfl = $_POST['facility_mfl'];   // department id

    if($facility_mfl < 1)
     {
        $query = "CALL js_MySQL_uSP_General_Aggregations()";
     }

     if ($facility_mfl != 0)
     {

           $query = "CALL js_MySQL_uSP_Facility_Aggregations_Filtered('".$facility_mfl."')";
     }

     $result = mysqli_query($connect, $query);


$aggregations_arr = array();

while($row = mysqli_fetch_array($result))
  {
    $registered = $row['registered'];
    $residents = $row['residents'];
    $matched = $row['matched'];
    $positive = $row['positive'];
    $with_ccc_no = $row['with_ccc_no'];

    $aggregations_arr[] = array("registered" => $registered, "residents" => $residents, "matched" => $matched,"positive" => $positive,"with_ccc_no" => $with_ccc_no);
}

// encoding array to json format
echo json_encode($aggregations_arr);

?>