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
   
	<div class="container-fluid">
	<?php
	
if(isset($_GET["pdf"]) && isset($_GET["id"]))
{

 $company=mysqli_query($con,"select * from company limit 1");
 $comp=mysqli_fetch_array($company);
 $order_id= $_GET["id"];
 
 $statement = mysqli_query($con,"
  SELECT *,format(amount,2) as amount from receipt_voucher 
  WHERE id = $order_id
  LIMIT 1
 ");
 

 while($row=mysqli_fetch_array($statement))
 {
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
	 <td  colspan="3" align="center" class="text-danger" style="font-size:24px"><b>  سند قبض  <br/> Receipt Voucher     </b> </td>
	 
	</tr>
	<?php if($comp['vat_number']) {
	
	 ?>
	<tr>
	    <td align="center"> <b>VAT Number</b></td>
	    <td align="center"> <b class="text-center text-danger"><?php echo $comp['vat_number'];?></b></td>
	    <td align="center"> <b>رقم ضريبة القيمة المضافة</b></td>
	</tr>
	<?php } ?>
	<tr>
	 <td  colspan="3" align="center" style="font-size:18px"><hr/></td>
	</tr>
	</table>

      <table width="100%" cellpadding="5">
       <tr>
        <td width="45%">
         
        </td>
		<td width="10%"></td>
        <td width="45%">
         
        
        <table id="invoice-details-table" class="table table-striped table-sm">
                    <tr>
					 <td><b>Receipt No.</b></td>
					<td><?php echo "REC00".$row["id"]; ?></td>
					<td align="right"><b>   رقم سند </b></td>
					</tr>
					 <tr>
					 <td><b>Receipt Date.</b></td>
					<td><?php echo $row["receipt_date"]; ?></td>
					<td align="right"><b>التاريخ</b></td>
					</tr>
					 <tr>
					 <td><b>Payment</b></td>
					<td><?php if($row["payment_method"]==1){ echo "Cash نقدي" ;}else if($row["payment_method"]==2){ echo "Bank Transfer حوالة بنكية" ;}else if($row["payment_method"]==3){ echo "Cheque الشيك" ;}else if($row["payment_method"]==4){ echo "Credit Card بطاقة الائتمان" ;}else if($row["payment_method"]==5){ echo "Debit Card بطاقة دين"; 
					} if($row['payment_details'])
					{
					    echo "\n".$row['payment_details'];
					}
					?></td>
					<td align="right"><b>الدفع</b></td>
					</tr>
				  <tr>
					 <td><b>Amount</b></td>
					<td><b><?php echo $row["amount"]; ?></b></td>
					<td align="right"><b> مبلغ </b></td>
					</tr>
                  </table>
		</td>
       </tr>
      </table>
      
         <table  class="table table-striped table-sm">
                    <tr>
					 <td><b>Received from</b></td>
					<td><?php echo $row["received_from"]; ?></td>
					<td align="right"><b>   استلمنا من السيد/ السادة </b></td>
					</tr>
					 <tr>
					 <td><b>The sum of</b></td>
					<td><?php echo $row["amount_in_word"]; ?></td>
					<td align="right"><b> مبلغ وقدره فقط  </b></td>
					</tr>
					 <tr>
					 <td><b>For the purpose of</b></td>
					<td><?php echo nl2br($row['purpose']); ?></td>
					<td align="right"><b> وذلك لقرض </b></td>
					</tr>
				
				<?php if($row['remarks'])
				{?>
					 <tr>
					 <td><b>Remarks</b></td>
					<td><?php echo nl2br($row['remarks']); ?></td>
					<td align="right"><b> ملاحظات </b></td>
					</tr>
				   <?php  
				}?>
					
				
                  </table>
   
  <hr/>
  <br/><br/>
  <div>
         <table  class="table table-borderless table-sm">
               
				
					<tr align="center">
					 <td><b>GM المدير العام  </b></td>
					<td><b>Acc. محاسب </b></td>
					<td ><b>  Casheir  امين الصنضوق   </b></td>
					</tr>
						<tr align="center">
					 <td>......................</td>
					 <td>......................</td>
					 <td>......................</td>
					</tr>
				
                  </table>
  </div>
	 <hr/>
   <div ><h6><i>Thank you for giving us opportunity to serve you. <span class="float-right">  شكرً لإعطائنا الفرصة لخدمتكم </i>   
   </span> </h6>
      
  </div>
  
  
 <?php
 }
 

 echo "<script>window.print();</script>";

}
?>
</div>


</body>
	</html>
	
<?php } } ?>