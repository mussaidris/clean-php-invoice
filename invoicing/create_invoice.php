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


if(isset($_POST["create_invoice"]))
  { 
   
    
	  
          $order_date =$_POST["order_date"];
          $order_receiver_name= trim($_POST["order_receiver_name"]);
          $order_receiver_email= trim($_POST["order_receiver_email"]);
          $order_receiver_tel= trim($_POST["order_receiver_tel"]);
          $order_receiver_address= trim($_POST["order_receiver_address"]);
          $order_total_before_tax= trim($_POST["final_total_amt"]);
          $discount=floatval(trim($_POST['discount']));
          $order_total_tax= trim($_POST["tax_total_amt"]);
         
          $order_total_after_tax=trim($_POST["total_amt"]);
		    $paid_amt=floatval(trim($_POST["paid_amt"]));
			  $due_amt= floatval(trim($_POST["due_amt"]));
			   $payment_method=intval($_POST["payment_method"]);
				
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
          $order_datetime=date("Y-m-d:H-i-s",time());
	      $inv_reference="INV".md5(date("YmdHis",time()).$empid);
	  
	  
	  $insert_invoice=mysqli_query($con,"
      INSERT INTO tbl_order 
        ( inv_reference,order_date, prepared_by,empemail,order_receiver_name,receiver_email,receiver_tel, order_receiver_address, order_total_before_tax,discount,  order_total_tax, order_total_after_tax,paid_amt,due_amt,payment_method,order_status,total_inwords, order_datetime,remarks)
        VALUES ( '$inv_reference','$order_date', '$fullname','$email','$order_receiver_name','$order_receiver_email','$order_receiver_tel', '$order_receiver_address', $order_total_before_tax,$discount,  $order_total_tax, $order_total_after_tax,$paid_amt,$due_amt,$payment_method,$order_status,'$total_inwords', '$order_datetime','$remarks')
    ");
  
if($insert_invoice)
   {
      $select_id = mysqli_query($con,"SELECT * from tbl_order where inv_reference='$inv_reference' limit 1");
      $order_row = mysqli_fetch_array($select_id);
	  $order_id=$order_row['order_id'];

      for($count=0; $count<$_POST["total_item"]; $count++)
      {
       
	   
       $item_name=trim($_POST["item_name"][$count]);
       $order_item_quantity=trim($_POST["order_item_quantity"][$count]);
       $order_item_price= trim($_POST["order_item_price"][$count]);
   
       $order_item_final_amount= trim($_POST["order_item_final_amount"][$count]);
	   
        $insert_invoice_item = mysqli_query($con,"
          INSERT INTO tbl_order_item 
          (order_id,inv_reference, item_name, order_item_quantity, order_item_price, order_item_final_amount)
          VALUES ($order_id, '$inv_reference','$item_name', $order_item_quantity, $order_item_price,  $order_item_final_amount)
        ");

      }
	  $logintime = date( 'Y-m-d H:i:s', time () );
			 $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Create Invoice',$empid,'$fullname','$email','$logintime')");
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
             <td colspan="2" align="left"><h2 style="margin-top:10.5px">Create Invoice  <span class="float-right"> إنشاءالفاتورة  </span></h2></td>
            </tr>
            <tr>
                <td colspan="2">
                  <div class="row">
                    <div class="col-md-8">
                     <div class="form-group">
								   <label>Invoice Date </label><span class="text-danger">*</span><span class="float-right"> تاريخ الفاتورة</span>
                                    <input class="form-control" type="date" id="order_date"  name="order_date" max="<?php echo date('Y-m-d');?>" required />
					</div>
                        <b>Customer Details: تفاصيل العميل</b><br />
                    <label>Name</label><span class="float-right"> اسم </span>
                        <input type="text" name="order_receiver_name" id="order_receiver_name" class="form-control input-sm"      required  />
                        <div class="row">
                            <div class="col-md-6">
                                <label> Email</label><span class="float-right"> بريد الكتروني </span>
                                <input type="email" name="order_receiver_email" id="order_receiver_email" class="form-control input-sm"  />
                            </div>
                            <div class="col-md-6">
                                <label> Phone Number</label><span class="float-right"> رقم جوال </span>
                                <input type="text" name="order_receiver_tel" id="order_receiver_tel" class="form-control input-sm"  />
                            </div>
                            
                        </div>
                        <label> Address</label><span class="float-right"> عنوان  </span>
                        <textarea name="order_receiver_address" id="order_receiver_address" class="form-control" ></textarea>
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
                  
                  
                
                    <tr >
                      <td><span id="sr_no">1</span></td>
                      <td><input type="text" name="item_name[]" id="item_name1" class="form-control input-sm"  required /></td>
                      <td><input type="text" name="order_item_quantity[]" id="order_item_quantity1" data-srno="1" class="form-control input-sm number_only order_item_quantity"  required /></td>
                      <td><input type="text" name="order_item_price[]" id="order_item_price1" data-srno="1" class="form-control input-sm number_only order_item_price"   required /></td>
               
                      <td><input type="text" name="order_item_final_amount[]" id="order_item_final_amount1" data-srno="1" readonly class="form-control input-sm order_item_final_amount"  /></td>
                     
                    </tr>
				
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
                 <td><input type="text" name="final_total_amt" id="final_total_amt" data-srno="1"  class="form-control input-sm final_total_amt" readonly  placeholder="0.00" /></td>
				</tr>
					<tr>
				 <td><b>Discount  الخصم</b></td>
                 <td><input type="text" name="discount" id="discount" data-srno="1"  class="form-control input-sm number_only discount"   placeholder="0.00" /></td>
				</tr>
				<tr>
				 <td><b>Vat (15%) ضريبة القيمة المضافة</b> </td>
                 <td><input type="text" name="tax_total_amt" id="tax_total_amt" data-srno="1"  class="form-control input-sm tax_total_amt " readonly  placeholder="0.00" /><input type="hidden" name="vat_value" id="vat_value" data-srno="1"  class="form-control input-sm vat_value " value="0.15"/></td>
				</tr>
				<tr>
				 <td><b>Total Amt. المبلغ الإجمالي</b></td>
                 <td><input type="text" name="total_amt" id="total_amt" data-srno="1"  class="form-control input-sm total_amt" readonly  placeholder="0.00" /></td>
				</tr>
				<tr>
				 <td><b>Paid Amt. المدفوع</b> </td>
                 <td><input type="text" name="paid_amt" id="paid_amt" data-srno="1"  class="form-control input-sm number_only paid_amt"   placeholder="0.00" required /></td>
				</tr>
				<tr>
				 <td><b>Due Amt. الباقي</b> </td>
                 <td><input type="text" name="due_amt" id="due_amt" data-srno="1"  class="form-control input-sm due_amt" readonly placeholder="0.00" /></td>
				</tr>
				<tr>
				 <td><b>Payment Method: طريقة الدفع</b> </td>
                 <td>

                      <select class="form-control" name="payment_method" id="payment_method" required>
                         <option value="1" selected>Cash نقدي</option>
                         <option value="2" >Bank Transfer حوالة بنكية</option>
                         <option value="3" >Cheque الشيك</option>
                         <option value="4" >Credit Card بطاقة الائتمان</option>
						 <option value="5" >Debit Card بطاقة دين</option>
                      </select> 
				 </td>
				</tr>
				<tr>
				 <td><b>Status: الحالة</b> </td>
                 <td>

                      <select class="form-control" name="order_status" id="order_status" required>
                         <option value="1" selected>Paid مدفوع</option>
                         <option value="2" >Partially Paid مدفوعة جزئيا</option>
                         <option value="3" >Not paid غير مدفوع</option>
                         <option value="4" >Cancelled ألغيت</option>
						 
                      </select> 
				 </td>
				</tr>
				<tr>
				 <td colspan="2"><b>Total in words المجموع في الكلمات </b>
                 
				 <textarea class="form-control" rows="3" name="order_total_inwords" id="order_total_inwords" data-srno="1" ></textarea></td>
				</tr>
					<tr>
				 <td colspan="2"><b>Remarks ملاحظات </b>
                 
				 <textarea class="form-control" rows="3" name="remarks" id="remarks" data-srno="1" ></textarea></td>
				</tr>
				<tr>
				    
				    <td colspan="2">
				        	 <div align="right">
		        <input type="hidden" name="total_item" id="total_item" value="1"  />
                  
                  <input type="submit" name="create_invoice" id="create_invoice" class="btn btn-info btn-block" value="Create إنشاء " />
              
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
	
	<script>
	 $(document).ready(function(){
        var final_total_amt = parseFloat($('#final_total_amt').text());
		var vat_value=parseFloat($('#vat_value').val());
        var count = 1;
        
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