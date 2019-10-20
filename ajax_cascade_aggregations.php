<?php

require_once("dbconn.php");

$facility_mfl = $_POST['facility_mfl'];

   $query = "CALL js_MySQL_uSP_Facility_Aggregations_Filtered('".$facility_mfl."')";

     $result = mysqli_query($connect, $query);

        if (mysqli_num_rows($result) > 0) 
           {
               $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
                   echo json_encode(['rows' => $data, 'response' => true]);
           } 
       
              else 
                {
          
                      echo json_encode(['response' => false]);
          
                }

          //finally free result set and close the MySQL connection
         
          $result->free();
        mysqli_close($connect);

?>
