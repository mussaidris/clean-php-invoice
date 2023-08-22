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

if(isset($_POST["create_receipt"]))
  {
    
      $receipt_date=$_POST['receipt_date'];
	  $received_from=$_POST['received_from'];
	  $amount=floatval($_POST['amount']);
	  $the_sum_of=$_POST['the_sum_of'];
	  $purpose=$_POST['purpose'];
	  $payment_method=intval($_POST['payment_method']);
	  $payment_details=$_POST['payment_details'];
	  $remarks=$_POST['remarks'];
      $datetime = date( 'Y-m-d H:i:s', time () );  
	  
$insertreceipt=mysqli_query($con,"insert into receipt_voucher(received_from,amount,amount_in_word,payment_method,payment_details,purpose,receipt_date,date_time,prepared_by,remarks) values('$received_from',$amount,'$the_sum_of',$payment_method,'$payment_details','$purpose','$receipt_date','$datetime','$fullname','$remarks')");	
if($insertreceipt)
{
	header("location:receipt_voucher.php");
    exit();
}	
else{
	echo "System error";
}
      
  }

  
   if(isset($_GET["delete"]) && isset($_GET["id"]))
  {
	  
	  $id= $_GET["id"];
    $result = mysqli_query($con,"DELETE FROM receipt_voucher WHERE id = $id");
    
	 if($result)
	 {
		 $logintime = date( 'Y-m-d H:i:s', time () );
			 $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Delete Receipt Voucher',$empid,'$fullname','$email','$logintime')");
 header("location:receipt_voucher.php");
 exit();
	 }
	 else
	 {
		 echo "System error";
	 }
  }
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
				  else
				  {
				  include('../includes/headerSubNav.php'); 
				  }?>
	<br/><br/><br/><br><br><br>
    <div class="container-fluid">

	   
        <div class="wrapper">
		<?php if(isset($_GET['update']) && isset($_GET['id']))
		{?>
          <div class="card">
             <div class="card-header"><h2 style="margin-top:10.5px">Update Receipt Voucher  <span class="float-right">  تعديل سند قبض  </span></h2></div>
           <div class="card-body">
               
                  <div class="row">
				  <div class="col-md-1"></div>
                    <div class="col-md-10">
					<form method="post" id="receipt_form">
                     <div class="form-group">
								   <label>Receipt Date </label><span class="text-danger">*</span><span class="float-right"> تاريخ</span>
                                    <input class="form-control" type="date" id="receipt_date"  name="receipt_date" max="<?php echo date('Y-m-d');?>" required />
					</div>
                        <div class="form-group">
								   <label>Received From </label><span class="text-danger">*</span><span class="float-right"> استلمت من</span>
                                    <input class="form-control" type="text" id="received_from"  name="received_from"  required />
					</div>
                    <div class="form-group">
								   <label>Amount </label><span class="text-danger">*</span><span class="float-right"> مبلغ</span>
                                    <input class="form-control number_only" type="text" id="amount"  name="amount"  required />
					</div>
                    <div class="form-group">
								   <label>The sum of </label><span class="text-danger">*</span><span class="float-right"> مبلغ وقدره فقط</span>
                                  <textarea class="form-control" rows="3" name="the_sum_of" id="the_sum_of" data-srno="1" required ></textarea>
					</div>
                    <div class="form-group">
								   <label>For the purpose of </label><span class="text-danger">*</span><span class="float-right"> وذلك لغرض</span>
                                  <textarea class="form-control" rows="3" name="purpose" id="purpose" data-srno="1" required ></textarea>
					</div>
                <div class="form-group">
								   <label>Payment Method </label><span class="text-danger">*</span><span class="float-right"> طريقة الدفع</span>
                                  <select class="form-control" name="payment_method" id="payment_method" required>
                         <option value="1" selected>Cash نقدي</option>
                         <option value="2" >Bank Transfer حوالة بنكية</option>
                         <option value="3" >Cheque الشيك</option>
                         <option value="4" >Credit Card بطاقة الائتمان</option>
						 <option value="5" >Debit Card بطاقة دين</option>
                      </select> 
					</div>
					 <div class="form-group">
								   <label>Payment details </label><span class="float-right"> تفاصيل الدفع</span>
                                  <textarea class="form-control" rows="3" name="payment_details" id="payment_details" data-srno="1"  ></textarea>
					</div>
					 <div class="form-group">
								   <label>Remarks </label><span class="float-right"> ملاحظات</span>
                                  <textarea class="form-control" rows="3" name="remarks" id="remarks" data-srno="1"  ></textarea>
					</div>
					 <div class="form-group">
								        <input type="submit" name="update_receipt" id="update_receipt" class="btn btn-info btn-block" value="Create إنشاء " />
					</div>
				
				
				     </form>
                    </div>
                  </div>
                 
				  </div>
		 </div>
		<?php }
		else if(isset($_GET['create'])){ ?>
		 <div class="card">
             <div class="card-header"><h2 style="margin-top:10.5px">Create Receipt Voucher  <span class="float-right"> انشء سند قبض  </span></h2></div>
           <div class="card-body">
               
                  <div class="row">
				  <div class="col-md-1"></div>
                    <div class="col-md-10">
					<form method="post" id="receipt_form">
                     <div class="form-group">
								   <label>Receipt Date </label><span class="text-danger">*</span><span class="float-right"> تاريخ</span>
                                    <input class="form-control" type="date" id="receipt_date"  name="receipt_date" max="<?php echo date('Y-m-d');?>" required />
					</div>
                        <div class="form-group">
								   <label>Received From </label><span class="text-danger">*</span><span class="float-right"> استلمت من</span>
                                    <input class="form-control" type="text" id="received_from"  name="received_from"  required />
					</div>
                    <div class="form-group">
								   <label>Amount </label><span class="text-danger">*</span><span class="float-right"> مبلغ</span>
                                    <input class="form-control number_only" type="text" id="amount"  name="amount"  required />
					</div>
                    <div class="form-group">
								   <label>The sum of </label><span class="text-danger">*</span><span class="float-right"> مبلغ وقدره فقط</span>
                                  <textarea class="form-control" rows="3" name="the_sum_of" id="the_sum_of" data-srno="1" required ></textarea>
					</div>
                    <div class="form-group">
								   <label>For the purpose of </label><span class="text-danger">*</span><span class="float-right"> وذلك لغرض</span>
                                  <textarea class="form-control" rows="3" name="purpose" id="purpose" data-srno="1" required ></textarea>
					</div>
                <div class="form-group">
								   <label>Payment Method </label><span class="text-danger">*</span><span class="float-right"> طريقة الدفع</span>
                                  <select class="form-control" name="payment_method" id="payment_method" required>
                         <option value="1" selected>Cash نقدي</option>
                         <option value="2" >Bank Transfer حوالة بنكية</option>
                         <option value="3" >Cheque الشيك</option>
                         <option value="4" >Credit Card بطاقة الائتمان</option>
						 <option value="5" >Debit Card بطاقة دين</option>
                      </select> 
					</div>
					 <div class="form-group">
								   <label>Payment details </label><span class="float-right"> تفاصيل الدفع</span>
                                  <textarea class="form-control" rows="3" name="payment_details" id="payment_details" data-srno="1" ></textarea>
					</div>
					 <div class="form-group">
								   <label>Remarks </label><span class="float-right"> ملاحظات</span>
                                  <textarea class="form-control" rows="3" name="remarks" id="remarks" data-srno="1"  ></textarea>
					</div>
					 <div class="form-group">
								        <input type="submit" name="create_receipt" id="create_receipt" class="btn btn-info btn-block" value="Create إنشاء " />
					</div>
				
				
				     </form>
                    </div>
                  </div>
                 
				  </div>
		 </div>
		
		<?php } 
else {		?>
        <div class="card">
		 <div class="card-header"><h2 style="margin-top:10.5px">Receipt Voucher  <span class="float-right">  سند قبض  </span></h2></div>
		  <div class="card-body">
		   <div align="right">
		  <a href="receipt_voucher.php?create=1" class="btn btn-success btn-sm">Create انشء </a>
		  </div>
		    <table id="data-table" class="table table-sm table-bordered table-striped">
        <thead>
          <tr>
            <th>Receipt No. رقم الفاتورة</th>
            <th>Receipt Date التاريخ</th>
            <th>Received From اسم العميل</th>
            <th>Amount إجمالي الفاتورة</th>
              
            <th>The sum of مبلغ مدفوع</th>
			<th>Purpose مبلغ مدفوع</th>
			<th>Payment مبلغ مستحق</th>
           	<th>Action الإجراء</th>
          </tr>
        </thead>
        <?php
		$result = mysqli_query($con,"
    SELECT * from receipt_voucher 
    ORDER BY id DESC
  ");

 

		
       
          while($row = mysqli_fetch_array($result))
          {
            ?>
              <tr>
                <td><a href="view_receipt.php?rid=<?php  echo $row['id'] ;?>"><?php  echo "REC00".$row['id'] ;?></a></td>
                <td><?php echo $row['receipt_date'];?></td>
                <td><?php echo $row['received_from'];?></td>
                <td><?php echo $row['amount'];?></td>
                	<td><?php echo nl2br($row['amount_in_word']);?></td>
				<td><?php echo nl2br($row['purpose']);?></td>
			<td><?php if($row["payment_method"]==1){ echo "Cash نقدي" ;}else if($row["payment_method"]==2){ echo "Bank Transfer حوالة بنكية" ;}else if($row["payment_method"]==3){ echo "Cheque الشيك" ;}else if($row["payment_method"]==4){ echo "Credit Card بطاقة الائتمان" ;}else if($row["payment_method"]==5){ echo "Debit Card بطاقة دين"; } ?></td>
                <td>
                    
                    <?php  if(in_array("prinv",$permission))  {?>
				<a href="print_receipt.php?pdf=1&id=<?php echo $row['id'];?>" target="_blank"><span ><i class="fas fa-print text-dark"></i></span></a>
				<?php } if(in_array("upinv",$permission))  {?>
                <a href="receipt_voucher.php?update=1&id=<?php echo $row['id'];?>"><span ><i class="fas fa-edit"></i></span></a>
                <?php } if(in_array("delinv",$permission))  {?>
                <a href="receipt_voucher.php?delete=1&id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" class="delete " onclick="return confirm('Are you sure you want to remove this? هل أنت متأكد أنك تريد إزالة هذا')"><span ><i class="fas fa-trash text-danger"></i></span></a>
                <?php } ?>
                </td>
              </tr>
            <?php
          }
       
        ?>
      </table>
		  
		  </div>
		</div>
	<?php } ?>
        </div>
  

	</div>
	<script type="text/javascript">
  $(document).ready(function(){
	  $('#data-table').DataTable();
   
  });

</script>
	<script src="../assets/js/check_number_only.js"></script>
	
	</body>
	</html>
	
<?php } } ?>