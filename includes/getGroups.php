<?php
  include('config.php');
  $groups=mysqli_query($con,"select * from groups");
  $users_arr = array();
 
    while( $row = mysqli_fetch_array($groups) ){
      $groupid = $row['id'];
      $name = $row['group_name'];

    $users_arr[] = array("id" => $groupid, "name" => $name);
}

// encoding array to json format
echo json_encode($users_arr);


?>