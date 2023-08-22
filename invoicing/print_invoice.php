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
   
	<div class="container-fluid">
	<?php
	
if(isset($_GET["pdf"]) && isset($_GET["id"]))
{

 $company=mysqli_query($con,"select * from company limit 1");
 $comp=mysqli_fetch_array($company);
 $order_id= $_GET["id"];
 
 $statement = mysqli_query($con,"
  SELECT *,format(order_total_before_tax,2) as order_total_before_tax,format(order_total_tax,2) as order_total_tax,format(discount,2) as discount,format(order_total_after_tax,2) as order_total_after_tax,format(paid_amt,2) as paid_amt,format(due_amt,2) as due_amt FROM tbl_order 
  WHERE order_id = $order_id
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
	 <td  colspan="3" align="center" class="text-danger" style="font-size:24px"><b> فاتورة <br/>Invoice </b> </td>
	 
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
         <b>To الى,</b>
		   <table id="customer-details-table"width="100%" border="0" cellpadding="5" cellspacing="0">
                    <tr>
					
					<td><b><?php echo $row["order_receiver_name"]; ?></b>
					<?php if($row["receiver_email"]){echo "<br/>".$row["receiver_email"];} ?><?php if($row["receiver_tel"]){echo "<br/>".$row["receiver_tel"];} ?><?php if($row["receiver_address"]){echo "<br/>".$row["receiver_address"];} ?></td>
					
					</tr>
				
					
                  </table>
        </td>
		<td width="10%"></td>
        <td width="45%">
         
        
        <table id="invoice-details-table" class="table table-striped table-sm">
                    <tr>
					 <td><b>Invoice No.</b></td>
					<td><?php echo "INV00".$row["order_id"]; ?></td>
					<td align="right"><b>رقم الفاتورة</b></td>
					</tr>
					 <tr>
					 <td><b>Invoice Date.</b></td>
					<td><?php echo $row["order_date"]; ?></td>
					<td align="right"><b>التاريخ</b></td>
					</tr>
					 <tr>
					 <td><b>Payment</b></td>
					<td><?php if($row["payment_method"]==1){ echo "Cash نقدي" ;}else if($row["payment_method"]==2){ echo "Bank Transfer حوالة بنكية" ;}else if($row["payment_method"]==3){ echo "Cheque الشيك" ;}else if($row["payment_method"]==4){ echo "Credit Card بطاقة الائتمان" ;}else if($row["payment_method"]==5){ echo "Debit Card بطاقة دين"; } ?></td>
					<td align="right"><b>الدفع</b></td>
					</tr>
					<!--<tr>
					 <td><b>Status</b></td>
					<td><?php if($row["order_status"]==1){ echo "Paid مدفوع" ;}else if($row["order_status"]==2){ echo "Partially Paid مدفوعة جزئيا" ;}else if($row["order_status"]==3){ echo "Not paid غير مدفوع" ;}else if($row["order_status"]==4){ echo "Cancelled ألغيت" ;} ?></td>
					<td align="right"><b>الحالة</b></td>
					</tr>-->
						<!--<tr>
					 <td><b>Prepared By</b></td>
					<td><?php  echo $row['prepared_by'];?></td>
					<td align="right"><b>  أعدت بواسطة  </b></td>
					</tr>
						<tr>
					 <td><b>Updated By</b></td>
					<td><?php  echo $row['updated_by'];?></td>
					<td align="right"><b>   تعدلت بواسطة  </b></td>
					</tr>-->
                  </table>
		</td>
       </tr>
      </table>
     	  <hr/>
	    <div ><h4><i>Thank you for giving us opportunity to serve you. <span class="float-right">  شكرً لإعطائنا الفرصة لخدمتكم </i>         </span> </h4>
      
  </div>
  <hr/>
	 
      <table width="100%" border="1" cellpadding="5" cellspacing="0">
       <tr style="background-color:grey;">
             <th width="10%">#</th>
             <th width="45%">الوصف Description </th>
             <th width="10%"> العدد Quantity </th>
             <th width="15%"> السعر Price </th>
                      
             <th width="20%"> اجماليTotal </th>
		
       </tr>
	 <?php
       
  $statement = mysqli_query($con,
   "SELECT item_name,format(order_item_quantity,2) as order_item_quantity,format(order_item_price,2) as order_item_price,format(order_item_final_amount,2) as order_item_final_amount FROM tbl_order_item 
   WHERE order_id = $order_id"
  );

  $count = 0;
  while($sub_row=mysqli_fetch_array($statement))
  {
   $count++;
   ?>
   <tr>
    <td align="left"><?php echo $count; ?></td>
    <td align="left" style="word-break: break-all;"> <?php echo $sub_row["item_name"]; ?></td>
    <td align="center"><?php echo $sub_row["order_item_quantity"]; ?></td>
    <td align="center"><?php echo $sub_row["order_item_price"]; ?></td>
  
    <td align="center"><?php echo $sub_row["order_item_final_amount"]; ?></td>
   </tr>
  
  <?php
  }
  ?>
 
  </table>
   
  
   <br>
  <table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
  <td align="left" rowspan="6" colspan="6">  Bank details:
  <hr/><p class="float-right"><?php echo $row["total_inwords"];?></p>
  <?php if($row['remarks'])
  {?>
  <hr/>
   <h3 >Remarks <span class="float-right">  ملاحظات </span></h3>
   <p><?php echo nl2br($row["remarks"]);?></p>
   <?php    
  }?>
  <p class="float-right"><?php echo $row["total_inwords"];?></p>
  </td>
   <td align="right" colspan="8"><b >Sub Total المجموع </b></td>
   <td align="right"><b ><?php echo $row["order_total_before_tax"];?></b></td>
  </tr>
  <tr>
   <td align="right" colspan="8"><b class="text-danger">Discount الخصم</b></td>
   <td align="right"><b class="text-danger"><?php echo $row["discount"]; ?></b></td>
  </tr>
  <tr>
   <td align="right" colspan="8"><b>Total Vat Amt. اجمالي الضريبة</b></td>
   <td align="right"><b><?php echo $row["order_total_tax"]; ?></b></td>
  </tr>
  <tr>
   <td align="right" colspan="8"><b>Total Amt. الأجمالي </b></td>
   <td align="right"><b><?php echo $row["order_total_after_tax"]; ?></b></td>
  </tr>
  <tr>
   <td align="right" colspan="8"><b>Paid Amt. المدفوع</b></td>
   <td align="right"><b><?php echo $row["paid_amt"]; ?></b></td>
  </tr>
  <tr>
   <td align="right" colspan="8"><b>Due Amt. الباقي</b></td>
   <td align="right"><b><?php echo $row["due_amt"]; ?></b></td>
  </tr>
   
  </table>
  <hr>
  <p class="float-right">
  .تم إنشاء هذه الفاتورة من نظام ، يُرجى إبلاغ الشخص المسؤول عن أي استفسار
  </p>
  <p> This invoice has been generated from a system please inform reponsible person for any queries.</p>
  
  
 <?php
 }
 

 echo "<script>window.print();</script>";

}
?>
</div>


</body>
	</html>
	
<?php } } ?>