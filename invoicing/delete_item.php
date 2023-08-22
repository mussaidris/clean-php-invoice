 <?php
 if(isset($_GET["delete"]) && isset($_GET["id"]))
  {
	  
	  $id= $_GET["id"];
    $result = mysqli_query($con,"DELETE FROM tbl_order_item WHERE order_id = $id");
     $result1 = mysqli_query($con,"DELETE FROM tbl_order WHERE order_id = $id");
	 if($result && $result1)
	 {
		 $logintime = date( 'Y-m-d H:i:s', time () );
			 $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Delete Invoice',$empid,'$fullname','$email','$logintime')");
    header("location:../invoicing");
	 }
	 else
	 {
		 echo "System error";
	 }
  }
  ?>