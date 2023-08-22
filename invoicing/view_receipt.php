<?php
session_start();
error_reporting(0);
 include('../includes/config.php');
 $pagetitle="Receipt Voucher";
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
					   $order_id=  $_GET["rid"];
                       $statement = mysqli_query($con,"
                             SELECT * FROM receipt_voucher 
                             WHERE id = $order_id
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
				<a href="print_receipt.php?pdf=1&id=<?php echo $row["id"];?>" target="_blank"><span class="float-right"><i class="fas fa-print fa-2x text-dark "></i></span></a>
                </td>
			</tr>
            <tr>
             <td colspan="2" align="left"><h2 style="margin-top:10.5px">Receipt Details  <span class="float-right">  </span></h2></td>
            </tr>
			
            <tr>
                <td colspan="2">
                  <div class="row">
                    <div class="col-md-3">
                    
                        <b>Customer Details: تفاصيل العميل</b><br />
                        <p><?php echo $row["order_receiver_name"]; ?></p><br>
						<p><?php echo $row["receiver_email"]; ?></p><br>
						<p><?php echo $row["receiver_tel"]; ?></p><br>
                        <p><?php echo $row["order_receiver_address"]; ?></p>
                    </div>
                     <div class="col-md-3">
					 </div>
					 <div class="col-md-6">
                    <table id="invoice-details-table" class="table table-striped">
                    <tr>
					 <td>Invoice No.</td>
					<td><?php echo "INV00".$row["order_id"]; ?></td>
					<td>رقم الفاتورة</td>
					</tr>
					 <tr>
					 <td>Invoice Date.</td>
					<td><?php echo $row["order_date"]; ?></td>
					<td>التاريخ</td>
					</tr>
					 <tr>
					 <td>Payment</td>
					<td><?php if($row["payment_method"]==1){ echo "Cash نقدي" ;}else if($row["payment_method"]==2){ echo "Bank Transfer حوالة بنكية" ;}else if($row["payment_method"]==3){ echo "Cheque الشيك" ;}else if($row["payment_method"]==4){ echo "Credit Card بطاقة الائتمان" ;}else if($row["payment_method"]==5){ echo "Debit Card بطاقة دين"; } ?></td>
					<td>الدفع</td>
					</tr>
					<tr>
					 <td>Status</td>
					<td><?php if($row["order_status"]==1){ echo "Paid مدفوع" ;}else if($row["order_status"]==2){ echo "Partially Paid مدفوعة جزئيا" ;}else if($row["order_status"]==3){ echo "Not paid غير مدفوع" ;}else if($row["order_status"]==4){ echo "Cancelled ألغيت" ;} ?></td>
					<td>الحالة</td>
					</tr>
						<tr>
					 <td>Prepared By</td>
					<td><?php  echo $row['prepared_by'];?></td>
					<td align="right">  أعدت بواسطة  </td>
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
                  <table id="invoice-item-table" class="table table-striped">
                    <tr>
                      <th width="10%">#</th>
                      <th width="45%">الوصف Description </th>
                      <th width="10%"> العدد Quantity </th>
                      <th width="15%">السعر Price </th>
                      
                      <th width="20%">اجمالي Total </th>
                     
                    </tr>
                    <?php
					$order_id= $_GET["id"];
                    $statement = mysqli_query($con,"
                      SELECT * FROM tbl_order_item 
                      WHERE order_id = '$order_id'
                    ");
                  
                    
                    $m = 0;
                    while($sub_row=mysqli_fetch_array($statement))
                    {
                      $m = $m + 1;
					  
                    ?>
                    <tr >
                      <td><span id="sr_no"><?php echo $m; ?></span></td>
                      <td><p><?php echo $sub_row["item_name"]; ?></p></td>
                      <td><p><?php echo $sub_row["order_item_quantity"]; ?></p></td>
                      <td><p><?php echo $sub_row["order_item_price"]; ?></></td>
               
                      <td><p><?php echo $sub_row["order_item_final_amount"]; ?></p></td>
                     
                    </tr>
					<?php } ?>
                  </table>
				  </div>
				  </div>
				 
				    </td>
              </tr>
			  </table>
			   
	     
		 </div>
		
     
     
	</div>
	
	
	</body>
	</html>
	
<?php } } ?>