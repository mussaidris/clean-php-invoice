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
   
	<div class="container-fluid">
	<?php
	
if(isset($_GET["id"]) && isset($_GET["reference"]))
{

 
 $order_id= $_GET["id"];
 $reference=$_GET['reference'];

     $deliverydata=mysqli_query($con,"select * from delivery_note where id=$order_id limit 1");
     


 while($delivery=mysqli_fetch_array($deliverydata))
 {
 
	
$dnno="DNN00".$delivery['id'];
     $ddate=$delivery['delivery_date'];
	 $prepared_by=$delivery['prepared_by'];
	 if($delivery['status']==0)
				{
				$status="Pending";
				}
				else if($delivery['status']==1)
				{
					$status="Delivered";
				}
				else 
				{
					$status="Changed";
				}
	 
 $company=mysqli_query($con,"select * from company limit 1");
 $comp=mysqli_fetch_array($company);



 ?>

    	      <table width="100%" border="0" cellpadding="5" cellspacing="0" >
    <tr>
     <td  align="left" style="font-size:18px">
	 <b><?php echo $comp["company_name"]; ?></b>
	 <h6><?php echo $comp["email"]; ?></6>
	 <h6><?php if($comp['cr_no']) echo "C.R : ".$comp["cr_no"]; ?></h6>
	 <h6><?php if($comp['website']) echo $comp["website"]; ?></h6>
	 <h6><?php echo $comp["address"]; ?></h6>
	 </td>
	 <td  align="center" style="font-size:18px"><img src="../assets/img/erprologo.jpg" width="150px" height="100px" /></td>
	  <td  align="right" style="font-size:18px">
	 <b><?php echo $comp["arabic_name"]; ?></b>
	 <h6><?php echo $comp["email"]; ?></h6>
	 <h6><?php if($comp['cr_no']) echo $comp["cr_no"]." : س.ت"; ?></h6>
	 <h6><?php if($comp['website']) echo $comp["website"]; ?></h6>
	 <h6><?php echo $comp["arabic_address"]; ?></h6>
	 </td>
    </tr>
   <tr>
	 <td  colspan="3" align="center" class="text-danger" style="font-size:18px"><b> سند استلام<br/>Delivery Note </b> </td>
	</tr>
   
	<tr>
	 <td  colspan="3" align="center" style="font-size:18px"><hr/></td>
	</tr>
	</table>
	<table width="100%" border="0" cellpadding="5" cellspacing="0" >
  
     
       <tr>
        <td width="45%">
         <b>To الى,</b>
		         <table width="100%" border="0" cellpadding="5" cellspacing="0" >
                    <tr>
					
					<td><b><?php echo $delivery["cust_name"]; ?></b><?php if($delivery["cust_email"]){echo "<br/>".$delivery["cust_email"];} ?><?php if($delivery["cust_tel"]){echo "<br/>".$delivery["cust_tel"];} ?><?php if($delivery["cust_address"]){echo "<br/>".$delivery["cust_address"];} ?></td>
					
					</tr>
				
				</table>
					
                 
        </td>
		<td width="10%"></td>
        <td  align="right" width="45%">
        
        <table class="table table-striped table-sm table-borderless" >
                    <tr>
					 <td><b>Reference No.</b></td>
					<td><?php echo $reference; ?></td>
					<td align="right"><b>رقم المرجع</b></td>
					</tr>
					 <tr>
					 <td><b>Delivery No.</b></td>
					<td><?php echo $dnno; ?></td>
					<td align="right"><b>رقم التسليم</b></td>
					</tr>
					<tr>
					 <td><b>Delivery Date.</b></td>
					<td><?php echo $ddate; ?></td>
					<td align="right"><b>تاريخ التسليم</b></td>
					</tr>
					<!--<tr>
					 <td><b>Status</b></td>
					<td><?php echo $status; ?></td>
					<td align="right"><b>الحالة</b></td>
					</tr>
						<tr>
					 <td><b>Prepared By</b></td>
					<td><?php  echo $prepared_by;?></td>
					<td align="right"><b>  أعدت بواسطة  </b></td>
					</tr>
						<tr>
					 <td><b>Updated By</b></td>
					<td><?php  echo $delivery['updated_by'];?></td>
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
	
  <tr>
    <td colspan="4">
        <table width="100%" border="1" cellpadding="5" cellspacing="0" >
      <tr>  
  <td >Receiver Name:</td>
  <td align="center" >
  <?php if($delivery['receiver_name'])
  { echo $delivery['receiver_name'];}
  else{ 
  
  echo ".................................";}?></td>
  <td align="right" >:اسم مستلم</td>
  
   <td >Supervisor Name:</td>
  <td align="center" ><?php if($delivery['supervisor_name'])
  { echo $delivery['supervisor_name'];}
  else{ 
  
  echo ".................................";}?></td>
  <td align="right" >: اسم المشرف</td>
  
  </tr>
   <tr>
  <td>Receiver Signature:</td>
    <td align="center" >.................................</td>
  <td align="right" >:توقيع المستلم</td>
  
  <td > Supervisor Signature:</td>
    <td align="center" >.................................</td>
  <td align="right" >:توقيع المشرف</td>
  </tr>
 <tr>
  <td >Date:</td>
    <td align="center" >.................................</td>
  <td align="right" >:تاريخ</td>
   <td >Date:</td>
    <td align="center" >.................................</td>
  <td align="right" >:تاريخ</td>
  </tr>
  
  
  </table>
  
 </td>
 </tr>

   </table>
    <hr>
  <p class="float-right">
  . تم إنشاء سند التسليم هذه من نظام ، يُرجى إبلاغ الشخص المسؤول عن أي استفسارات
  </p>
  <p> This delivery note  has been generated from a system please inform reponsible person for any queries.</p>
  <hr>
 
  
</div>
  
 
  
 <?php
 }

 echo "<script>window.print();</script>";
 

 
}
?>



</body>
	</html>
	
<?php } } ?>