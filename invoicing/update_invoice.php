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

if(isset($_POST["update_invoice"]))
  {
    
      
      $order_id = intval($_GET["id"]);
      $total_items=$_POST["total_item"];
      $invno=$_GET['invno'];
      
      $statement = mysqli_query($con,"
                DELETE FROM tbl_order_item WHERE order_id = $order_id
            ");
         
      
      for($count=0; $count<$total_items; $count++)
      {
       
	   
       $item_name=trim($_POST["item_name"][$count]);
       $order_item_quantity= trim($_POST["order_item_quantity"][$count]);
       $order_item_price= trim($_POST["order_item_price"][$count]);
   
       $order_item_final_amount= trim($_POST["order_item_final_amount"][$count]);
	   
	   
        $statement = mysqli_query($con,"
          INSERT INTO tbl_order_item 
          (order_id, inv_reference,item_name, order_item_quantity, order_item_price, order_item_final_amount)
          VALUES ($order_id, '$invno','$item_name', $order_item_quantity, $order_item_price,  $order_item_final_amount)
        ");

      }
     // $order_total_tax = $order_total_tax1 + $order_total_tax2 + $order_total_tax3;
    
	   $order_date=$_POST["order_date"];
       $order_receiver_name= trim($_POST["order_receiver_name"]);
       $order_receiver_address= trim($_POST["order_receiver_address"]);
       $order_total_before_tax= trim($_POST["final_total_amt"]);
       $order_total_tax= trim($_POST["tax_total_amt"]);
            $discount=trim($_POST['discount']);
       $order_total_after_tax=trim($_POST["total_amt"]);
	   $paid_amt=floatval(trim($_POST["paid_amt"]));
	   $due_amt= floatval(trim($_POST["due_amt"]));
	   $payment_method= intval($_POST["payment_method"]);
	   	  if($due_amt==0)
			  {
			      	$order_status=1;
			  }
			  else if($paid_amt==0)
			  {
			      	$order_status=3;
			  }
			    else if($paid_amt>0)
			  {
			      	$order_status=2;
			  }
			  else
			  {
			      	$order_status= intval($_POST["order_status"]);
			  }

	   $total_inwords=trim($_POST["order_total_inwords"]);
	   $remarks= trim($_POST["remarks"]);
       $order_datetime= date("Y-m-d:H-i-s",time());
       $order_id= $order_id;
	
      $statement = mysqli_query($con,"
        UPDATE tbl_order 
        SET  order_date = '$order_date',
        updated_by='$fullname',
        update_email='$email',
        order_receiver_name = '$order_receiver_name', 
        order_receiver_address = '$order_receiver_address', 
        order_total_before_tax = $order_total_before_tax, 
         discount=$discount,
        order_total_tax = $order_total_tax, 
        order_total_after_tax = $order_total_after_tax ,
		paid_amt=$paid_amt,
		due_amt=$due_amt,
		payment_method='$payment_method',
		order_status=$order_status,
		total_inwords='$total_inwords',
		order_datetime='$order_datetime',
		remarks='$remarks'
        WHERE order_id = $order_id 
      ");
    
      
      $result = mysqli_query($con,"select * from tbl_order order by id desc" );
	  if($statement)
	  {
          $logintime = date( 'Y-m-d H:i:s', time () );
			 $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Update Invoice',$empid,'$fullname','$email','$logintime')");  
      header("location:../invoicing");
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
             <td colspan="2" align="left"><h2 style="margin-top:10.5px">Edit Invoice تعديل الفاتورة</h2></td>
            </tr>
            <tr>
                <td colspan="2">
                  <div class="row">
                    <div class="col-md-8">
                     <?php 
					   $order_id=  $_GET["id"];
                       $statement = mysqli_query($con,"
                             SELECT * FROM tbl_order 
                             WHERE order_id = $order_id
                                 LIMIT 1
                               ");
                     $row=mysqli_fetch_array($statement);
					 
					 ?>
					   <div class="form-group">
								   <label>Invoice Date </label><span class="text-danger">*</span><span class="float-right"> تاريخ الفاتورة</span>
                                    <input class="form-control" type="date" id="order_date"  name="order_date" max="<?php echo date('Y-m-d');?>" value="<?php echo $row["order_date"]; ?>" required />
					</div>
                        <b>Customer Details: تفاصيل العميل</b>
                         <label>Name</label><span class="float-right"> اسم </span>
                        <input type="text" name="order_receiver_name" id="order_receiver_name" class="form-control input-sm" value="<?php echo $row["order_receiver_name"]; ?>"     required  />
                          <div class="row">
                            <div class="col-md-6">
                                <label> Email</label><span class="float-right"> بريد الكتروني </span>
                                <input type="email" name="order_receiver_email" id="order_receiver_email" class="form-control input-sm" value="<?php echo $row["receiver_email"]; ?>" />
                            </div>
                            <div class="col-md-6">
                                <label> Phone Number</label><span class="float-right"> رقم جوال </span>
                                <input type="text" name="order_receiver_tel" id="order_receiver_tel" class="form-control input-sm" value="<?php echo $row["receiver_tel"]; ?>" />
                            </div>
                            
                        </div>
                        <label> Address</label><span class="float-right"> عنوان  </span>
                        <textarea name="order_receiver_address" id="order_receiver_address" class="form-control" ><?php echo $row["order_receiver_address"]; ?></textarea>
                        <br/>
                           <div class="row">
				 
				 
				  <div class="col-md-12" style="width:100%;overflow:auto; max-height:300px;">
                  <table id="invoice-item-table" class="table table-striped">
                    <tr>
                      <th width="10%">#</th>
                      <th width="45%">Description الوصف</th>
                      <th width="10%">Quantity العدد</th>
                      <th width="15%">Price السعر</th>
                      
                      <th width="20%">Total اجمالي</th>
                    
                    </tr>
                    <?php
					$order_id= $_GET["id"];
                    $statement = mysqli_query($con,"
                      SELECT * FROM tbl_order_item 
                      WHERE order_id = $order_id
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
                      <td><input type="text" name="order_item_price[]" id="order_item_price<?php echo $m; ?>" data-srno="<?php echo $m; ?>" class="form-control input-sm number_only order_item_price" value="<?php echo $sub_row["order_item_price"]; ?>"  required /></td>
               
                      <td><input type="text" name="order_item_final_amount[]" id="order_item_final_amount<?php echo $m; ?>" data-srno="<?php echo $m; ?>" readonly class="form-control input-sm order_item_final_amount"  value="<?php echo $sub_row["order_item_final_amount"]; ?>" /></td>
                     <td> <?php if($m>1) { ?><button type="button" name="remove_row" id="<?php echo $m; ?>" class="btn btn-danger btn-xs remove_row">X</button><?php } ?></td>
                    </tr>
					<?php } ?>
                  </table>
				  </div>
				  </div>
				 
                  <div align="right">
                    <button type="button" name="add_row" id="add_row" class="btn btn-success btn-sm">+ Add Item اضافة عنصر</button>
                  </div>
                    </div>
                     
					 <div class="col-md-4">
                    
                     
				<table class="table">
				<tr>
				 <td><b>Sub Total المجموع الفرعي</b></td>
                 <td><input type="text" name="final_total_amt" id="final_total_amt" data-srno="1"  class="form-control input-sm final_total_amt" readonly  value="<?php echo $row["order_total_before_tax"]; ?>" /></td>
				</tr>
					<tr>
				 <td><b>Discount  الخصم</b></td>
                 <td><input type="text" name="discount" id="discount" data-srno="1"  class="form-control input-sm number_only discount"   value="<?php echo $row["discount"]; ?>" /></td>
				</tr>
				<tr>
				 <td><b>Vat (15%) ضريبة القيمة المضافة</b> </td>
                 <td><input type="text" name="tax_total_amt" id="tax_total_amt" data-srno="1"  class="form-control input-sm tax_total_amt " readonly  value="<?php echo $row["order_total_tax"]; ?>" /><input type="hidden" name="vat_value" id="vat_value" data-srno="1"  class="form-control input-sm vat_value " value="0.15"/></td>
				</tr>
				<tr>
				 <td><b>Total Amt. المبلغ الإجمالي</b></td>
                 <td><input type="text" name="total_amt" id="total_amt" data-srno="1"  class="form-control input-sm total_amt" readonly  value="<?php echo $row["order_total_after_tax"]; ?>" /></td>
				</tr>
				<tr>
				 <td><b>Paid Amt. المدفوع</b> </td>
                 <td><input type="text" name="paid_amt" id="paid_amt" data-srno="1"  class="form-control input-sm number_only paid_amt"   value="<?php echo $row["paid_amt"]; ?>" required /></td>
				</tr>
				<tr>
				 <td><b>Due Amt. الباقي</b> </td>
                 <td><input type="text" name="due_amt" id="due_amt" data-srno="1"  class="form-control input-sm due_amt" readonly value="<?php echo $row["due_amt"]; ?>" /></td>
				</tr>
				<tr>
				 <td><b>Payment Method: طريقة الدفع</b> </td>
                 <td>

                      <select class="form-control" name="payment_method" id="payment_method" required>
                         <option value="1" <?php if($row['payment_method']==1) echo "selected"; ?>>Cash نقدي</option>
                         <option value="2" <?php if($row['payment_method']==2) echo "selected"; ?>>Bank Transfer حوالة بنكية</option>
                         <option value="3" <?php if($row['payment_method']==3) echo "selected"; ?>>Cheque الشيك</option>
                         <option value="4" <?php if($row['payment_method']==4) echo "selected"; ?>>Credit Card بطاقة الائتمان</option>
						 <option value="5" <?php if($row['payment_method']==5) echo "selected"; ?>>Debit Card بطاقة دين</option>
                      </select> 
				 </td>
				</tr>
				<tr>
				 <td><b>Status: الحالة</b> </td>
                 <td>

                      <select class="form-control" name="order_status" id="order_status" required>
                         <option value="1" <?php if($row['order_status']==1) echo "selected"; ?>>Paid مدفوع</option>
                         <option value="2" <?php if($row['order_status']==2) echo "selected"; ?>>Partially Paid مدفوعة جزئيا</option>
                         <option value="3" <?php if($row['order_status']==3) echo "selected"; ?>>Not paid غير مدفوع</option>
                         <option value="4" <?php if($row['order_status']==4) echo "selected"; ?>>Cancelled ألغيت</option>
						 
                      </select> 
				 </td>
				</tr>
				<tr>
				 <td colspan="2"><b>Total in words المجموع في الكلمات </b>
                 
				 <textarea class="form-control" rows="3" name="order_total_inwords" id="order_total_inwords" data-srno="1" ><?php echo $row["total_inwords"]; ?></textarea></td>
				</tr>
					<tr>
				 <td colspan="2"><b>Remarks ملاحظات </b>
                 
				 <textarea class="form-control" rows="3" name="remarks" id="remarks" data-srno="1" ><?php echo $row["remarks"]; ?></textarea></td>
				</tr>
				<tr>
				    
				    <td colspan="2">
				        	 <div align="right">
		        <input type="hidden" name="total_item" id="total_item" value="<?php echo $m; ?>"  />
                  <input type="hidden" name="order_id" id="order_id" value="<?php echo $row["order_id"]; ?>" />
                  <input type="submit" name="update_invoice" id="create_invoice" class="btn btn-info btn-block" value="Edit تعديل" />
              
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
	
        var final_total_amt = $('#final_total_amt').text();
        var count = $('#total_item').val();
        var vat_value=$('#vat_value').val();
        $(document).on('click', '#add_row', function(){
          count++;
          $('#total_item').val(count);
          var html_code = '';
          html_code += '<tr id="row_id_'+count+'">';
          html_code += '<td><span id="sr_no">'+count+'</span></td>';
          
          html_code += '<td><input type="text" name="item_name[]" id="item_name'+count+'" class="form-control input-sm" /></td>';
          
          html_code += '<td><input type="text" name="order_item_quantity[]" id="order_item_quantity'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_quantity" /></td>';
		  
          html_code += '<td><input type="text" name="order_item_price[]" id="order_item_price'+count+'" data-srno="'+count+'" class="form-control input-sm number_only order_item_price" /></td>';
        
          html_code += '<td><input type="text" name="order_item_final_amount[]" id="order_item_final_amount'+count+'" data-srno="'+count+'" readonly class="form-control input-sm order_item_final_amount" /></td>';
		  
          html_code += '<td><button type="button" name="remove_row" id="'+count+'" class="btn btn-danger btn-xs remove_row">X</button></td>';
          html_code += '</tr>';
          $('#invoice-item-table').append(html_code);
        });
        
        $(document).on('click', '.remove_row', function(){
          var row_id = $(this).attr("id");
          var total_item_amount = $('#order_item_final_amount'+row_id).val();
          var final_amount = $('#final_total_amt').text();
          var result_amount = parseFloat(final_amount) - parseFloat(total_item_amount);
          $('#final_total_amt').text(result_amount);
          $('#row_id_'+row_id).remove();
          count--;
          $('#total_item').val(count);
		  //cal_final_total(count);
		   calculateTotal();
        });


function calculateTotal(){
	var totalAmount = 0; 
	 var discount=$('#discount').val();
		 if(discount)
		 {
		     discount=parseFloat(discount);
		 }
		 else
		 {
		     discount=parseFloat(0.00);
		 }
	$("[id^='order_item_price']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("order_item_price",'');
		var price = $('#order_item_price'+id).val();
		var quantity  = $('#order_item_quantity'+id).val();
		var total=0.00;
		if(quantity && quantity>0 && price && price>=0) {
		 total = price*quantity;
		$('#order_item_final_amount'+id).val(parseFloat(total));
		totalAmount += total;
		}
		else
		{
		    $('#order_item_final_amount'+id).val(0.00);
		}
					
	});
	  
		  var subtotaldiscount=parseFloat(totalAmount-discount);
		  vat_amount=parseFloat(subtotaldiscount*parseFloat(vat_value));
		 total_amount=parseFloat(subtotaldiscount+vat_amount);
          $('#final_total_amt').val(totalAmount.toFixed(2));
		   $('#tax_total_amt').val(vat_amount.toFixed(2));
		   $('#total_amt').val(total_amount.toFixed(2));
		    $('#paid_amt').val(0.00);
			 $('#due_amt').val(total_amount.toFixed(2));
	
	

}



	
        
		 $(document).on('blur', '.order_item_quantity', function(){
          //cal_final_total(count);
           calculateTotal();
        });
		
        $(document).on('blur', '.order_item_price', function(){
          //cal_final_total(count);
           calculateTotal();
        });

      
        $(document).on('blur', '.paid_amt', function(){
				if($.trim($('#paid_amt').val())!=""){
			 if( parseFloat($.trim($('#paid_amt').val()))<=parseFloat($.trim($('#total_amt').val())))
			{
          $('#due_amt').val( parseFloat($('#total_amt').val()) - parseFloat($('#paid_amt').val()));
			}
			else
			{
			      alert("Paid amount can not be more than actual amount");
				$('#paid_amt').val(0.00);
				$('#due_amt').val($('#total_amt').val());
				return false;
			}
			}
			else{
			    $('#paid_amt').val(0.00);
			   	$('#due_amt').val($('#total_amt').val());
				
			}
        });
        
           $(document).on('blur', '.discount', function(){
			if($.trim($('#discount').val())!="")
			{
			    if(parseFloat($.trim($('#discount').val()))<=parseFloat($.trim($('#final_total_amt').val())))
			{
           //cal_final_total(count);
           calculateTotal();
			}
			else
			{
			    	alert("Discount amount is more than actual amount.");
                 return false; 
			}
			}
			else{
			    
			    $('#discount').val(0.00);
			    calculateTotal();
			}
        });
       

      });
	
	</script>
	<script src="../assets/js/check_number_only.js"></script>
	
	</body>
	</html>
	
<?php } } ?>