<?php
session_start();
error_reporting(0);
 include('../includes/config.php');
 $pagetitle="Departments";
 date_default_timezone_set('Asia/Riyadh');// change according timezone
    $logintime = date( 'y-m-d h:i:s A', time () );
	
if(!isset($_SESSION['alogin']) || $_SESSION['alogin']=="")
{
		$_SESSION['alogin']="";
	session_unset();
	session_destroy();
	header("Location:../");
		exit();
}
else{
	$email=$_SESSION['alogin'];
	$empid=$_SESSION['emplid'];
	$fullname=$_SESSION['fname']." ".$_SESSION['lname'];
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
<html style="font-family: Cairo, sans-serif;">
  <?php
include('../includes/head_sub_data.php');
?>
	<?php
	    include('../includes/footer_sub_data.php');
      
      ?>
 
  <body id="page-top" style="font-family: Cairo, sans-serif;color: rgb(0,0,0);">
   
	
	<?php
	

 $company=mysqli_query($con,"select * from company limit 1");
 $comp=mysqli_fetch_array($company);



 ?>
 <div class="container-fluid">
   <table width="100%" border="0" cellpadding="5" cellspacing="0">
    <tr>
     <td  align="left" style="font-size:18px">
	 <b><?php echo $comp["company_name"]; ?></b>
	 <h6><?php echo $comp["email"]; ?></h6>
	 <h6><?php if($comp['cr_no']) echo "C.R : ".$comp["cr_no"]; ?></h6>
	 <h6><?php if($comp['phone']) echo $comp["phone"]; ?></h6>
	 <h6><?php if($comp['website']) echo $comp["website"]; ?></h6>
	 <h6><?php echo $comp["address"]; ?></h6>
	 </td>
	 <td  align="center" style="font-size:18px"><img src="../assets/img/erprologo.jpg" width="150px" height="100px" /></td>
	  <td  align="right" style="font-size:18px">
	 <b><?php echo $comp["arabic_name"]; ?></b>
	 <h6><?php echo $comp["email"]; ?></h6>
	 <h6><?php if($comp['cr_no']) echo $comp["cr_no"].":  س.ت "; ?></h6>
	 <h6><?php if($comp['phone']) echo $comp["phone"]; ?></h6>
	 <h6><?php if($comp['website']) echo $comp["website"]; ?></h6>
	 <h6><?php echo $comp["arabic_address"]; ?></h6>
	 </td>
    </tr>
    <tr>
	 <td  colspan="3" align="center" class="text-danger" style="font-size:18px"><b> اقسام <br/>Departments </b> </td>
	</tr>
</table>
    
      <table class="table my-0" id="dataTable">
                                <thead>
                                    <tr>
									<th>#</th>
                                        <th>Name اسم</th>
                                        <th>Status الحالة</th>
									
                                        
                                    </tr>
                                </thead>
                                <tbody>
								<?php
									$dept=mysqli_query($con,"select * from departments ");
								while ($row=mysqli_fetch_array($dept))
								{
									?>
                                    <tr>
                                       <td><?php echo htmlentities($row['id']);?></td>
                                        <td><?php echo htmlentities($row['dept_name']);?></td>
                                        <td><?php 
										if($row['status']==0)
										{ ?>
										<p class="text-success">Active</p>
									    <?php } else { ?>
										<p class="text-danger">Inactive</p>
										<?php } ?>  </td>
											
                                        
                                    </tr>
                                    <?php
								}
								?>
                                   
                                </tbody>
                              
      
     <tr> <td colspan="8" class="text-center"><b>*** The end  انتهأ ***</b> </td></tr>
   </table>
   </div>
 
  
 <?php


 echo "<script>window.print();</script>";
 

?>



</body>
	</html>
	
<?php } } ?>