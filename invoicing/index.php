<?php
 session_start();
error_reporting(0);
 include('../includes/config.php');
 $pagetitle="Invoicing";
 date_default_timezone_set('Asia/Riyadh');// change according timezone
    $logintime = date( 'y-m-d h:i:s A', time () );
	$vatper=0.15;
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
   // delete item to be here
   include('delete_item.php');
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
	<br/>
	<?php
		   if(in_array("vwinv",$permission))  { ?>
    <div class="container-fluid">
     <div class="card shadow-lg o-hidden border-0 my-5">
        <div class="card-header py-3 d-flex flex-row-reverse bg-default">
				
	
  </div>
		<div class="card-body"> 
			
					<?php if(in_array("crinv",$permission) || in_array("prinv",$permission)  ) { ?>
					
					          <div class="container">
                                <div class="nav-item dropdown float-right mr-auto pr-5"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="text-dark">Actions</span></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-left  " role="menu">
										<?php if(in_array("crinv",$permission)) { ?>
										<a class="dropdown-item" role="presentation" href="create_invoice.php">&nbsp;Create Invoice  إنشاءالفاتورة</a>
										
                                         <a
                                            class="dropdown-item" role="presentation" href="receipt_voucher.php">&nbsp;Manage Receipt Voucher ادارة سند قبض</a>
											<a
                                            class="dropdown-item" role="presentation" href="delivery_note.php">&nbsp;Manage Delivery Note  ادارة سند استلام</a>
											<?php if(in_array("prinv",$permission)) { ?>
											<a
                                            class="dropdown-item" role="presentation" href="print_list_invoices.php?option=1" target="_blank">&nbsp;<span ><i class="fas fa-print fa-sm text-dark"></i></span></a>
											<?php } } ?>
                                       
                                       </div>
                    </div></div> 
                   <span>&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</span>

  <?php  } ?>
    
    <br/>
       
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
   
    
    <br/>
      <?php
	    include('list_invoice_datatable.php');
     
      ?>
   
     <?php
		   }
		   else
            { ?>
            	
			<div>
			    <p> 
			    غير مسموح لك بمشاهدة هذه الصفحة بسبب الوصول المقيد من الإدارة. إذا كنت بحاجة إلى أي دعم ، فاتصل بمسؤول النظام أو الدعم الفني.
			    <br/>
			    You are not allowed to view this page due to restricted access  from the admin. If you need any support contact your system administrator or technical support.   </p>
			</div>
			<?php } ?>
    <br>
    <!--<footer class="container-fluid text-center">
      <p>Footer Text</p>
    </footer>-->
	</div>
	</div>
</div>
	 
  </body>
</html>
<?php } } ?>
<script type="text/javascript">
  $(document).ready(function(){
	  $('#data-table').DataTable();
    /*var table = $('#data-table').DataTable({
          "order":[],
          "columnDefs":[
          {
            "targets":[4, 5, 6],
            "orderable":false,
          },
        ],
        "pageLength": 25
        });
    $(document).on('click', '.delete', function(){
      var id = $(this).attr("id");
      if(confirm("Are you sure you want to remove this? هل أنت متأكد أنك تريد إزالة هذا"))
      {
        window.location.href="index.php?delete=1&id="+id;
      }
      else
      {
        return false;
      }
    });*/
  });

</script>

<script src="js/check_number_only.js"></script>
