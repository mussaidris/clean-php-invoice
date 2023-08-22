<?php
  include('config.php');
  $employee=mysqli_query($con,"select * from employees");
  $empl_arr = array();

    while( $row = mysqli_fetch_array($employee) ){
      $emplid = $row['id'];
      $name = $row['fname']." ".$row['lname'];

    $empl_arr[] = array("id" => $emplid, "name" => $name);
}

// encoding array to json format
echo json_encode($empl_arr);


?>