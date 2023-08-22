<?php
session_start();
error_reporting(0);
 include('../includes/config.php');
 $pagetitle="Delivery Note";
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
				if($_SESSION['lang']=="ar")
                  {
	              include('../includes/headerSubNavAr.php');
				  }
				  else{
				  include('../includes/headerSubNav.php'); }?>
	<br/><br/><br/><br><br>
    <div class="container-fluid">
	    <?php 
					   $order_id=  $_GET["id"];
                       $statement = mysqli_query($con,"
                             SELECT * FROM delivery_note 
                             WHERE id = '$order_id'
                                 LIMIT 1
                               ");
                     $row=mysqli_fetch_array($statement);
					 
					 ?>
        <div class="wrapper">
		<!-- Invoice details -->
		<div class="container-fluid">
          <table class="table table-striped">
		  <tr>
			<td colspan="2"> 
				<!--<a href="print_deliverynote.php?pdf=1&id=<?php echo $row["order_id"];?>" target="_blank"><span class="float-right"><i class="fas fa-print fa-2x text-dark "></i></span></a>-->
                </td>
			</tr>
            <tr>
             <td colspan="2" align="left"><h2 style="margin-top:10.5px">Delivery Note  Details  <span class="float-right"> نفاصيل سند استلام </span></h2></td>
            </tr>
			
            <tr>
                <td colspan="2">
                  <div class="row">
                    <div class="col-md-3">
                    
                        <b>Customer Details: تفاصيل العميل</b><br />
                        <p><?php echo $row["cust_name"]; ?></p><br>
						<p><?php echo $row["cust_email"]; ?></p><br>
						<p><?php echo $row["cust_tel"]; ?></p><br>
                        <p><?php echo $row["cust_address"]; ?></p>
                    </div>
                     <div class="col-md-3">
					 </div>
					 <div class="col-md-6">
                    <table id="invoice-details-table" class="table table-striped">
                     <td><b>Reference No.</b></td>
					<td><?php echo $row['reference']; ?></td>
					<td align="right"><b>رقم المرجع</b></td>
					</tr>
					 <tr>
					 <td><b>Delivery No.</b></td>
					<td><?php echo "DNN00".$row['id']; ?></td>
					<td align="right"><b>رقم التسليم</b></td>
					</tr>
					<tr>
					 <td><b>Delivery Date.</b></td>
					<td><?php echo $row['delivery_date']; ?></td>
					<td align="right"><b>تاريخ التسليم</b></td>
					</tr>
					<tr>
					 <td><b>Status</b></td>
					<td><?php echo $row['status']; ?></td>
					<td align="right"><b>الحالة</b></td>
					</tr>
						<tr>
					 <td><b>Prepared By</b></td>
					<td><?php  echo $row['prepared_by'];?></td>
					<td align="right"><b>  أعدت بواسطة  </b></td>
					</tr>
						<tr>
					 <td>Updated By</td>
					<td><?php  echo $row['updated_by'];?></td>
					<td align="right">   تعدلت بواسطة  </td>
					</tr>
                  </table>
                    
                    </div>
                  </div>
				  <hr>
                  <br />
				  
				   <div class="row">
				  <div class="col-md-3">
				  </div>
				 
				  <div class="col-md-9">
                     <table width="100%" border="1" cellpadding="5" cellspacing="0" >
       <tr style="background-color:grey;">
             <th width="10%">#</th>
             <th width="45%">الوصف Description </th>
             <th width="10%"> العدد Quantity </th>
             
                      
             <th align="right" width="30%"> ملاحظات Remarks  </th>
		
       </tr>
	 <?php
       
  $statement = mysqli_query($con,
   "SELECT * FROM delivery_item 
   WHERE delivery_id = $order_id"
  );

  $count = 0;
  $sumqty=0;
  while($sub_row=mysqli_fetch_array($statement))
  {
   $count++;
   ?>
   <tr>
    <td align="left"><?php echo $count; ?></td>
    <td align="left" style="word-break: break-all;"> <?php echo $sub_row["item_name"]; ?></td>
    <td align="center"><?php echo $sub_row["order_item_quantity"]; ?></td>
    
  
    <td align="right"><?php echo $sub_row["remarks"]; ?></td>
   </tr>
 
  
  <?php
  $sumqty=$sumqty+$sub_row["order_item_quantity"];
  }
  ?>
  <tr>
      <td><b>(<?php echo $count;?>) </b></td>
      <td align="right" >  Total items   مجموع العناصر </td>
      <td align="center"><b>(<?php echo $sumqty;?>)</b></td>
       <td ></td>
        
  </tr>
  <tr>
    <td >  Remarks</td>
	<td colspan="2"> <i> <?php echo nl2br($delivery['remarks']);?></i> </td>
	<td  align="right">ملاحظات </td>
	</tr>
	


   </table>
				  </div>
				  </div>
				 
				    </td>
              </tr>
			  </table>
			 
	     
		 </div>
		 <br>
	 <!-- Delivery note details -->
	 
	<!-- <div class="container-fluid">
	 <div class="card">
	 <div class="card-body">
	 <?php 
					   $order_id=trim("INV00".$row["order_id"]);
                       $statement = mysqli_query($con,"
                             SELECT * FROM delivery_note 
                             WHERE reference = '$order_id'
                                 
                               ");
                    
					 
					 ?>
   
				  <h3> Delivery Note Details <span class="float-right"> تفاصيل سند التسليم </span> </h3>
				
                  <table id="delivery-item-table" class="table table-striped">
                    <tr>
                      <th >Delivery #</th>
                      <th >Reference </th>
                      <th > Delivery Date </th>
                      <th >Suppervisor Name </th>
                       <th >Signed Date </th>
					    <th >Receiver Name </th>
						 <th >Receiver Contact </th>
						  <th >Status </th>
						   <th >Remarks </th>
                     
                     
                    </tr>
                    <?php
					
                    $m = 0;
                    while($sub_row=mysqli_fetch_array($statement))
                    {
                      $m = $m + 1;
					  
                    ?>
                    <tr >
                      <td><span id="sr_no"><?php echo trim("DNN00".$sub_row["id"]); ?></span></td>
                      <td><p><?php echo $sub_row["reference"]; ?></p></td>
                      <td><p><?php echo $sub_row["delivery_date"]; ?></p></td>
                      <td><p><?php echo $sub_row["supervisor_name"]; ?></p></td>
                      <td><p><?php echo $sub_row["signed_date"]; ?></p></td>
                      <td><p><?php echo $sub_row["receiver_name"]; ?></p></td>
                     <td><p><?php echo $sub_row["receiver_contact"]; ?></p></td>
					 <td><p><?php echo $sub_row["status"]; ?></p></td>
					 <td><p><?php echo nl2br($sub_row["remarks"]); ?></p></td>
                    </tr>
					<?php }
                     if($m==0){?>
					 <tr>
					 <td> No delivery note generated.</td>
					 </tr>
					<?php	 
					 }
					?>
                  </table>
				
			  
	     </div>
		 </div>
             </div> -->
        </div>
     
             
                 
	
	</div>
	
	
	</body>
	</html>
	
<?php } } ?>