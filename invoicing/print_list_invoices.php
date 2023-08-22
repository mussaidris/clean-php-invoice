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
	 <td  colspan="3" align="center" class="text-danger" style="font-size:24px"><b> قائمة الفواتير <br/>List of Invoices </b> </td>
	 
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

        
     <h5 class="float-right"><?php echo date('d-m-Y H:i:s',time());?> </h5>
     <table id="data-table" class="table table-sm table-bordered table-striped">
        <thead>
          <tr>
            <th>Invoice No. رقم الفاتورة</th>
            <th>Invoice Date التاريخ</th>
            <th>Customer Name اسم العميل</th>
            <th>Invoice Total إجمالي الفاتورة</th>
              
            <th>Paid Amt. مبلغ مدفوع</th>
			<th>Due Amt. مبلغ مستحق</th>
          <th >Total Vat Amt. اجمالي الضريبة</th>
		  <th>Status  الحالة </th>
          </tr>
        </thead>
        <?php
		$result = mysqli_query($con,"
    SELECT order_id,inv_reference,order_date,order_receiver_name,format(order_total_after_tax,2) as order_total_after_tax ,format(paid_amt,2) as paid_amt,format(due_amt,2) as due_amt,format(order_total_tax,2) as order_total_tax,order_status FROM tbl_order 
    ORDER BY order_id DESC
  ");

 

		
       
          while($row = mysqli_fetch_array($result))
          {
            ?>
              <tr>
                <td><?php  echo "INV00".$row['order_id'] ;?></a></td>
                <td><?php echo $row['order_date'];?></td>
                <td><?php echo $row['order_receiver_name'];?></td>
                <td><?php echo $row['order_total_after_tax'];?></td>
                	<td><?php echo $row['paid_amt'];?></td>
				<td><?php echo $row['due_amt'];?></td>
            <td><?php echo $row['order_total_tax'];?></td>
			<td><?php if($row["order_status"]==1){ echo "Paid مدفوع" ;}else if($row["order_status"]==2){ echo "Partially Paid مدفوعة جزئيا" ;}else if($row["order_status"]==3){ echo "Not paid غير مدفوع" ;}else if($row["order_status"]==4){ echo "Cancelled ألغيت" ;} ?></td>
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