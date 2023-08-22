<?php
session_start();
error_reporting(0);
 include('../includes/config.php');
  $pagetitle="Activity Logs";
  date_default_timezone_set("Asia/Riyadh");// change according timezonee
    $logintime = date( 'Y-m-d H:i:s', time () );
    $_SESSION['errMsg']="";
     $_SESSION['successMsg']="";
if(!isset($_SESSION['alogin']) || $_SESSION['alogin']=="")
{
	$_SESSION['alogin']="";
	session_unset();
	session_destroy();
	header("Location:../");
		exit();
}
else{
	
	
	$email=trim($_SESSION['alogin']);
	$empid=intval($_SESSION['emplid']);
	$fullname=trim($_SESSION['fname']." ".$_SESSION['lname']);
	$result=mysqli_query($con,"select * from employees where email='$email'");
	$row=mysqli_fetch_array($result);
	if(!$row)
	{
		$_SESSION['alogin']="";
	    session_unset();
		session_destroy();
		header("Location:../");
		exit();
	}
	else{
        $permission=unserialize($row['permission']);
		$roleid=$row['role_id'];
?>

<!DOCTYPE html>
<html   style="font-family: Cairo, sans-serif;">

<?php
include('../includes/head_sub_data.php');
?>

<body id="page-top" style="font-family: Cairo, sans-serif;color: rgb(0,0,0);">

    <div id="wrapper">
        
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
			
                <!--  Here is top header navigation items-->
			   <?php 
				if($_SESSION['lang']=="ar")
                  {
	              include('../includes/headerSubNavAr.php');
				  }
				  else{
				  include('../includes/headerSubNav.php'); }?>
           
             <!-- Table based contents -->
		  <br><br><br><br><br>
 <div class="container-fluid">
               
                <div class="card shadow">
                 
                    <div class="card-body">
                        
						<?php
						
						$logs=mysqli_query($con,"select * from employeelogs where empl_id=$empid ");
						?>
                        <div class="table-responsive mt-2"  role="grid" aria-describedby="dataTable_info">
                            <table class="table table-striped my-0" id="dataTable">
                                <thead>
                                    <tr>
									
                                        <th>#</th>
                                        <th>Activity</th>
                                        <th>Employee ID </th>
								
										<th>Email</th>
										
                                        <th>Full Name</th>
                                        
										<th>Date</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								
								while ($row=mysqli_fetch_array($logs))
								{
									?>
                                    <tr>
                                       <td><?php echo htmlentities($row['id']);?></td>
                                        <td><?php echo htmlentities($row['activity']);?></td>
                                        <td><?php echo htmlentities("EMP00".$row['empl_id']);?></td>
                                        <td><?php echo htmlentities($row['email']);?></td>
										<td><?php echo htmlentities($row['f_name']);?></td>
									    
										<td><?php echo htmlentities($row['act_date_time']);?></td>
                                        
                                    </tr>
                                    <?php
								}
								?>
                                   
                                </tbody>
                               
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
			
	
        </div>
        <!-- footer  -->
        <?php
		   include('../includes/footer.php');
		   ?>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
    <?php 
	 include('../includes/footer_sub_data.php'); ?>
		<script>
	$(document).ready(function(){

    $('#dataTable').DataTable();

    

});
	
	</script>
	
	
</body>

</html>

<?php
	}
	}

?>