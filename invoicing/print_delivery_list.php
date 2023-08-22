<?php
session_start();
error_reporting(0);
 include('../includes/config.php');
 $pagetitle="Invoicing";
 date_default_timezone_set('Asia/Riyadh');// change according timezone
    $logintime = date( 'Y-m-d H:i:s', time () );
	
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
	
if(isset($_GET["option"]))
{

 $company=mysqli_query($con,"select * from company limit 1");
 $comp=mysqli_fetch_array($company);

 

 
 ?>
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
	 <td  colspan="3" align="center" class="text-danger" style="font-size:24px"><b> قائمة سند التسليم <br/>List of Delivery Notes </b> </td>
	 
	</tr>
	
	<tr>
	 <td  colspan="3" align="center" style="font-size:18px"><hr/></td>
	</tr>
	</table>

        
     <h5 class="float-right"><?php echo date('d-m-Y H:i:s',time());?> </h5>
    <table id="deliverynote-table" class="table table-sm table-bordered table-striped">
        <thead>
          <tr>
		     <th>Delivery No. رقم التسليم</th>
            <th>Reference المرجع</th>
			 <th>Customer العميل</th>
            <th>Delivery Date التاريخ</th>
            <th>Supervisor Name اسم المشرف</th>
			<th>Receiver Name اسم المستلم</th>
			<th>Status الحالة</th>
           
          </tr>
        </thead>
        <?php
		$result = mysqli_query($con,"
    SELECT * from  delivery_note 
    ORDER BY id DESC
  ");

 

		
       
          while($row = mysqli_fetch_array($result))
          {
            ?>
              <tr>
                <td><?php  echo "DNN00".$row['id'] ;?></a></td>
                <td><?php echo $row['reference'];?></td>
				<td><?php echo $row['cust_name'];?></td>
                <td><?php echo $row['delivery_date'];?></td>
                <td><b><?php echo $row['supervisor_name'];?></b></td>
                	<td><b><?php echo $row['receiver_name'];?></b></td>
				<td><b><?php 
				if($row['status']==0)
				{
				echo "Pending";
				}
				else if($row['status']==1)
				{
					echo "Delivered";
				}
				else 
				{
					echo "Changed";
				}?></b></td>
             
              </tr>
            <?php
          }
       
        ?>
      </table>
	  
	  <hr>
	  <p class="text-center"> ***** The end  النهاية  ***** </p>
 
  
  
  
 <?php


 echo "<script>window.print();</script>";

}
?>



</body>
	</html>
	
<?php } } ?>