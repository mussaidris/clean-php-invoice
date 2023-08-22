<?php
session_start();
error_reporting(0);
 include('../includes/config.php');
 $pagetitle="Delivery Notes";
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
    
      
      $order_id = intval($_GET["id"]);
      $total_items=$_POST["total_item"];
      $reference=$_GET['reference'];
      
      $statement = mysqli_query($con,"
                DELETE FROM delivery_item WHERE delivery_id = $order_id
            ");
         
      
      for($count=0; $count<$total_items; $count++)
      {
       
	   
       $item_name=trim($_POST["item_name"][$count]);
       $order_item_quantity= trim($_POST["order_item_quantity"][$count]);
      
   
       $remarks= trim($_POST["remarks"][$count]);
	   
	   
        $statement = mysqli_query($con,"
          INSERT INTO delivery_item 
          (delivery_id,item_name, order_item_quantity, remarks)
          VALUES ($order_id,'$item_name', $order_item_quantity, '$remarks')
        ");

      }
    
    
 $delivery_date=$_POST['delivery_date'];
  $remarks=$_POST['remarks'];
   $receiver_name=$_POST['receiver_name'];
   $receiver_contact=$_POST['receiver_contact'];
   $supervisor_name=$_POST['supervisor_name'];
   
  $updated_by="EMP00".$empid." ".$fullname;
  $updated_on=date('Y-m-d H:i:s',time());
  $status=intval($_POST['status']);
 $updatedelivery=mysqli_query($con,"update  delivery_note set delivery_date='$delivery_date',updated_by='$updated_by',updated_on='$updated_on',receiver_name='$receiver_name',receiver_contact='$receiver_contact',supervisor_name='$supervisor_name',status=$status,remarks='$remarks' where id=$order_id");
    
      
      
	  if($updatedelivery)
	  {
          $logintime = date( 'Y-m-d H:i:s', time () );
			 $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Update Delivery Note',$empid,'$fullname','$email','$logintime')");  
      header("location:delivery_note.php");
	  }
	  else{
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
				  else{
				  include('../includes/headerSubNav.php'); }?>
	<br/><br/><br/>
    <div class="container-fluid">
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
				
						   $statement = mysqli_query($con,"
                             SELECT * FROM delivery_note 
                             WHERE id = $order_id
                                 LIMIT 1
                               "); 
					
                     $row=mysqli_fetch_array($statement);
					 
					 ?>
					   <div class="form-group">
								   <label>Delivery Date </label><span class="text-danger">*</span><span class="float-right"> تاريخ استلام</span>
                                    <input class="form-control" type="date" id="delivery_date"  name="delivery_date"  value="<?php echo $row['delivery_date'];?>"   required />
                                    <label>Receiver Name </label><span class="float-right"> اسم المستلم  </span>
									<input class="form-control" type="text" id="receiver_name"  name="receiver_name"   value="<?php echo $row['receiver_name'];?>" />
									<label>Receiver Contact </label><span class="float-right">  النواصل </span>
									<input class="form-control" type="text" id="receiver_contact"  name="receiver_contact"   value="<?php echo $row['receiver_contact'];?>" />
									<label>Supervisor Name </label><span class="float-right"> اسم المشرف  </span>
									<input class="form-control" type="text" id="supervisor_name"  name="supervisor_name"  value="<?php echo $row['supervisor_name'];?>"  />
									
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
				
						   $statement = mysqli_query($con,"
                      SELECT * FROM delivery_item 
                      WHERE delivery_id = $order_id
                    "); 
					
                  
                    
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
				 <td  colspan="2"><b>Status: الحالة</b> 
                 

                      <select class="form-control" name="status" id="status" required>
                         <option value="0" <?php if($row['status']==0) echo "selected"; ?>> Pending</option>
                         <option value="1" <?php if($row['status']==1) echo "selected"; ?>> Delivered</option>
                         <option value="2" <?php if($row['status']==2) echo "selected"; ?>> Changed</option>
                        
						 
                      </select> 
				</td>
				</tr>
					<tr>
				 <td colspan="2"><b>Remarks ملاحظات </b>
                 
				 <textarea class="form-control" rows="3" name="remarks" id="remarks" data-srno="1" ><?php echo $row['remarks']; ?></textarea></td>
				</tr>
				
				<tr>
				    
				    <td colspan="2">
				        	 <div align="right">
		        <input type="hidden" name="total_item" id="total_item" value="<?php echo $m; ?>"  />
                 
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