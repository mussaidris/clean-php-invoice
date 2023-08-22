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

if(isset($_POST["save_delivery"]))
  {
    
      $order_id= $_GET["id"];
 $reference=$_GET['reference'];

 $dnno = "DNN".md5(date( 'YmdHis', time () ).$empid);
 $delivery_date=$_POST['delivery_date'];
  $remarks=$_POST['remarks'];
   $cust_name=$_POST['cust_name'];
   $cust_add=$_POST['cust_add'];
   $cust_email=$_POST['cust_email'];
   $cust_tel=$_POST['cust_tel'];
  $prepared_by="EMP00".$empid." ".$fullname;
 $insertdelivery=mysqli_query($con,"insert into delivery_note(reference,delivery_reference,delivery_date,cust_name,cust_address,cust_email,cust_tel,prepared_by,status,remarks) values('$reference','$dnno','$delivery_date','$cust_name','$cust_address','$cust_email','$cust_tel','$prepared_by',0,'$remarks')");
 if($insertdelivery)
 {
     $deliverydata=mysqli_query($con,"select * from delivery_note where delivery_reference='$dnno' limit 1");
     $delivery=mysqli_fetch_array($deliverydata);
	 $delivery_id=$delivery['id'];
     $dnno="DNN00".$delivery_id;
     $ddate=$delivery['delivery_date'];
      
      for($count=0; $count<$_POST['total_item']; $count++)
      {
       
	   
       $item_name=trim($_POST["item_name"][$count]);
       $order_item_quantity= trim($_POST["order_item_quantity"][$count]);
       $remark=trim($_POST["remark"][$count]);
        $statement = mysqli_query($con,"
          INSERT INTO delivery_item 
          (delivery_id,item_name, order_item_quantity,remarks)
          VALUES ($delivery_id,'$item_name', $order_item_quantity, '$remark')
        ");

      }
   
       $logintime = date( 'Y-m-d H:i:s', time () );
			 $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Create Invoice',$empid,'$fullname','$email','$logintime')");
      $result = mysqli_query($con,"select * from tbl_order order by id desc" );
            
      header("location:delivery_note.php");
  }
  }
  
   if(isset($_GET["delete"]) && isset($_GET["id"]))
  {
	  
	  $id= $_GET["id"];
    $result = mysqli_query($con,"DELETE FROM delivery_item WHERE delivery_id = $id");
     $result1 = mysqli_query($con,"DELETE FROM delivery_note WHERE id = $id");
	 if($result && $result1)
	 {
		 $logintime = date( 'Y-m-d H:i:s', time () );
			 $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Delete Delivery Note',$empid,'$fullname','$email','$logintime')");
    header("location:delivery_note.php");
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
	<div class="card shadow  py-2">
                              <div class="card-header  "> </div>
							  <div class="card-body"> 
	<?php if(isset($_GET['id']) && isset($_GET['reference']) && isset($_GET['ref_type']))
	{?>
	   <form method="post" id="invoice_form">
        <div class="wrapper">
          <table class="table table-striped">
            <tr>
             <td colspan="2" align="left"><h2 style="margin-top:10.5px">Create Delivery Note <span class="float-right">   انشأ سند استلام  </span></h2></td>
            </tr>
            <tr>
                <td colspan="2">
                  <div class="row">
                    <div class="col-md-8">
                     <?php 
					   $order_id=  $_GET["id"];
					   $ref=$_GET['ref_type'];
					   if($ref==1)
					   {
                       $statement = mysqli_query($con,"
                             SELECT * FROM tbl_order 
                             WHERE order_id = $order_id
                                 LIMIT 1
                               ");
					   }
					   else{
						   $statement = mysqli_query($con,"
                             SELECT * FROM tbl_quotation 
                             WHERE order_id = $order_id
                                 LIMIT 1
                               "); 
					   }
                     $row=mysqli_fetch_array($statement);
					 
					 ?>
					   <div class="form-group">
								   <label>Delivery Date </label><span class="text-danger">*</span><span class="float-right"> تاريخ استلام</span>
                                    <input class="form-control" type="date" id="delivery_date"  name="delivery_date"   required />
									<input class="form-control" type="hidden" id="cust_name"  name="cust_name"   value="<?php echo $row['order_receiver_name'];?>" />
									<input class="form-control" type="hidden" id="cust_email"  name="cust_email"   value="<?php echo $row['receiver_email'];?>" />
									<input class="form-control" type="hidden" id="cust_tel"  name="cust_tel"  value="<?php echo $row['receiver_tel'];?>"  />
									<input class="form-control" type="hidden" id="cust_add"  name="cust_add"   value="<?php echo $row['order_receiver_address'];?>" />
					</div>
                      
                           <div class="row">
				 
				 
				  <div class="col-md-12" style="width:100%;overflow:auto; max-height:300px;">
                  <table id="invoice-item-table" class="table table-striped">
                    <tr>
                      <th width="5%">#</th>
                      <th width="45%">Description الوصف</th>
                      <th width="10%">Quantity العدد</th>
                      <th width="40%">Remarks  ملاحظات </th>
                     
                    
                    </tr>
                    <?php
					 if($ref==1)
					   {
                    $statement = mysqli_query($con,"
                      SELECT * FROM tbl_order_item 
                      WHERE order_id = $order_id
                    ");
					   }
					   else{
						   $statement = mysqli_query($con,"
                      SELECT * FROM tbl_quotation_item 
                      WHERE order_id = $order_id
                    "); 
					   }
                  
                    
                    $m = 0;
                    while($sub_row=mysqli_fetch_array($statement))
                    {
                      $m = $m + 1;
					  
                    ?>
                    <tr <?php if($m>1){?>id="row_id_<?php echo $m; ?>" <?php } ?>>
                      <td><span id="sr_no"><?php echo $m; ?></span></td>
                      <td><input type="text" name="item_name[]" id="item_name<?php echo $m; ?>" class="form-control input-sm" value="<?php echo $sub_row["item_name"]; ?>" required /></td>
                      <td><input type="text" name="order_item_quantity[]" id="order_item_quantity<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only order_item_quantity" value = "<?php echo $sub_row["order_item_quantity"]; ?>" required /></td>
                        <td> <textarea class="form-control" rows="1" name="remark[]" id="remark<?php echo $m; ?>" data-srno="1" > </textarea></td>
						<td> <?php if($m>1) { ?><button type="button" name="remove_row" id="<?php echo $m; ?>" class="btn btn-danger btn-xs remove_row">X</button><?php } ?></td>
                    </tr>
					<?php } ?>
                  </table>
				  </div>
				  </div>
				
                    </div>
                     
					 <div class="col-md-4">
                    
                     
				<table class="table">
			
					<tr>
				 <td colspan="2"><b>Remarks ملاحظات </b>
                 
				 <textarea class="form-control" rows="3" name="remarks" id="remarks" data-srno="1" ><?php echo $row["remarks"]; ?></textarea></td>
				</tr>
				<tr>
				    
				    <td colspan="2">
				        	 <div align="right">
		        <input type="hidden" name="total_item" id="total_item" value="<?php echo $m; ?>"  />
                  <input type="hidden" name="order_id" id="order_id" value="<?php echo $row["order_id"]; ?>" />
                  <input type="submit" name="save_delivery" id="save_delivery" class="btn btn-info btn-block" value="Save حفظ" />
              
		 </div>
				    </td>
				</tr>
				</table>
				
				 
                    </div>
                  </div>
                  <br />
				  
				
				    </td>
              </tr>
			  </table>
			
	     
	
	 
              
        </div>
      </form>
	<?php }
else{
	?>
	<br/><br/>
	  <div align="right">
        <a href="print_delivery_list.php?option=1" class="btn btn-success btn-sm" target="_blank">Print طباعة</a>
		<!--<span ><a href="delivery_note.php" class="btn btn-secondary btn-sm">Manage Delivery Note  ادارة سند استلام</a></span>-->
		<?php if($roleid==1){ ?>
		 <!--<span class="dropdown">
  <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
    Actions
  </button>
  <div class="dropdown-menu">
  <div class="row">
  <div class="col-md-4">
    <a class="dropdown-item" href="viewTasks.php?filter=1">Today's invoices </a>
    <a class="dropdown-item" href="viewTasks.php?filter=2">Last 7 days</a>
    <a class="dropdown-item" href="viewTasks.php?filter=3">Last 30 days</a>
	<a class="dropdown-item" href="viewTasks.php?filter=4">This Month</a>
	<a class="dropdown-item" href="viewTasks.php?filter=5">Last Month</a>
	<a class="dropdown-item" href="viewTasks.php?filter=6">This Quarter</a>
	<a class="dropdown-item" href="viewTasks.php?filter=7">Last Quarter</a>
	<a class="dropdown-item" href="viewTasks.php?filter=8">This year</a>
	<a class="dropdown-item" href="viewTasks.php?filter=4">Last year</a>
	</div>
	
	<div class="col-md-8">
	<form method="post">
	<div class="form-group">
	<label>From Date</label><span><input type="text" id="from_date" name="from_date" /> </span>
	<label>To Date</label><span><input type="text" id="to_date" name="to_date" /> </span>
	 <button class="btn btn-primary btn-block text-white btn-user" type="submit" name="submit" id="submit">Search</button>
	 </div>
	</form>
	</div>
	</div>
	</div>
	</span>-->
		<?php } ?>
      </div>
	  <br />
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
           	<th>Action الإجراء</th>
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
                <td><a href="view_deliverynote.php?dnno=<?php  echo $row['delivery_reference'] ;?>&id=<?php  echo $row['id'] ;?>"><?php  echo "DNN00".$row['id'] ;?></a></td>
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
                <td>
                    <?php if(in_array("prinv",$permission))  {?>
                    <a href="print_deliverynote.php?reference=<?php echo $row['reference'];?>&id=<?php echo $row['id'];?>" target="_blank" ><span ><i class="fas fa-print"></i></span></a>
                    <?php } if(in_array("upinv",$permission))  {?>
                <a href="update_deliverynote.php?reference=<?php  echo $row['reference'] ;?>&id=<?php echo $row['id'];?>"><span ><i class="fas fa-edit"></i></span></a>
                <?php } if(in_array("delinv",$permission))  {?>
                <a href="delivery_note.php?delete=1&id=<?php echo $row['id'];?>" id="<?php echo $row['id'];?>" class="delete " onclick="return confirm('Are you sure you want to remove this? هل أنت متأكد أنك تريد إزالة هذا')"><span ><i class="fas fa-trash text-danger"></i></span></a>
                <?php } ?>
                </td>
              </tr>
            <?php
          }
       
        ?>
      </table>

<?php } ?>	
          </div>       
	</div>
	</div>
	<script >
	$(document).ready(function(){
		$('#deliverynote-table').DataTable();
	var count= $('#total_item').val();
       
        
        $(document).on('click', '.remove_row', function(){
          var row_id = $(this).attr("id");
          
          $('#row_id_'+row_id).remove();
          count--;
          $('#total_item').val(count);
		  
        });

      });
	
	</script>
	<script src="../assets/js/check_number_only.js"></script>
	
	</body>
	</html>
	
<?php } } ?>