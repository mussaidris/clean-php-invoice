<?php
session_start();
error_reporting(0);
 include('includes/config.php');
  $pagetitle="Dashboard";
 date_default_timezone_set('Asia/Riyadh');// change according timezone
    $logintime = date( 'Y-m-d H:i:s', time () );
if(!isset($_SESSION['alogin']) || $_SESSION['alogin']=="")
{
	$_SESSION['alogin']="";
	session_unset();
	session_destroy();
	header("Location:/");
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
		header("Location:/");
		exit();
	}
	else{
	     $permission=unserialize($row['permission']);
		$roleid=$row['role_id'];
?>


<!DOCTYPE html>
<html    style="font-family: Cairo, sans-serif;">

<?php
include('includes/head_data.php');
?>


<body id="page-top" style="font-family: Cairo, sans-serif;color: rgb(0,0,0);">

   
			
                <!--  Here is top header navigation items-->
			   <?php 
				if($_SESSION['lang']=="ar")
                  {
	              include('includes/headerNavAr.php');
				  }
				  else{
				  include('includes/headerNav.php'); }?>
			   <br>
			   <section id="dashboard">
            <div class="container-fluid">
                <div class=" mb-4">
                    <h3 class="text-dark mb-0">Dashboard  <span class="float-right"> لوحة القيادة </span></h3><!--<a class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="generatereports.php" target="_blank"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report</a>--></div>
                    
                    
                    <!-- First row General overview -->
                    	<?php if($roleid==1)
						{?>							
                <div class="row">
                    <div class="col-md-6 col-xl-6 mb-4">
                        <div class="card shadow  py-2">
                              <div class="card-header  ">
                                <h6 class="text-dark font-weight-bold m-0">Invoices  <span class="float-right">  فواتير     </span> </h6>
                             
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        
                                        <?php 
                                        $paidinvoices=mysqli_query($con,"select count(*) as total  from tbl_order where order_status=1 ");
                                        $paidinvoicestotal=mysqli_query($con,"select format(sum(paid_amt),2) as total  from tbl_order where order_status=1 ");
                                      $numpaidinvoices=mysqli_fetch_array($paidinvoices);
                                      $sumpaidinvoices=mysqli_fetch_array($paidinvoicestotal);
									  
										$parpaidinvoices=mysqli_query($con,"select count(*) as total  from tbl_order where order_status=2 ");
                                        $parpaidinvoicestotal=mysqli_query($con,"select format(sum(paid_amt),2) as total  from tbl_order where order_status=2 ");
                                      $parnumpaidinvoices=mysqli_fetch_array($parpaidinvoices);
                                      $parsumpaidinvoices=mysqli_fetch_array($parpaidinvoicestotal);
									  
									  $notpaidinvoices=mysqli_query($con,"select count(*) as total  from tbl_order where order_status=3 ");
                                        $notpaidinvoicestotal=mysqli_query($con,"select format(sum(paid_amt),2) as total  from tbl_order where order_status=3 ");
                                      $notnumpaidinvoices=mysqli_fetch_array($notpaidinvoices);
                                      $notsumpaidinvoices=mysqli_fetch_array($notpaidinvoicestotal);
									  
									  $canpaidinvoices=mysqli_query($con,"select count(*) as total  from tbl_order where order_status=4 ");
                                        $canpaidinvoicestotal=mysqli_query($con,"select format(sum(paid_amt),2) as total  from tbl_order where order_status=4 ");
                                      $cannumpaidinvoices=mysqli_fetch_array($canpaidinvoices);
                                      $cansumpaidinvoices=mysqli_fetch_array($canpaidinvoicestotal);
										
                                        ?>
										  <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Paid مدفوع </span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										   
											  <span class="badge badge-success"><?php 
                                             echo htmlentities('('.$numpaidinvoices['total'].')');  ?></span>
											 
                                              <span class="badge badge-light"> <?php 
											  if($sumpaidinvoices['total']==null){
												  echo htmlentities('(0.00)');
											  }
											  else{
											  echo htmlentities('('.$sumpaidinvoices['total'].')'); } ?> </span>
											 
									   </div> 
									
								       <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Partially Paid مدفوعة جزئيا</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										   
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('('.$parnumpaidinvoices['total'].')');  ?></span>
											 
                                              <span class="badge badge-light"> <?php 
											  if($parsumpaidinvoices['total']==null){
												  echo htmlentities('(0.00)');
											  }
											  else{
											  echo htmlentities('('.$parsumpaidinvoices['total'].')'); } ?> </span>
											 
									   </div>  
									   
									     <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Not paid غير مدفوع </span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										   
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('('.$notnumpaidinvoices['total'].')');  ?></span>
											 
                                              <span class="badge badge-light"> <?php 
											  if($notsumpaidinvoices['total']==null){
												  echo htmlentities('(0.00)');
											  }
											  else{
											  echo htmlentities('('.$notsumpaidinvoices['total'].')'); } ?> </span>
											 
									   </div> 
									   
									      <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Cancelled ألغيت </span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										   
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('('.$cannumpaidinvoices['total'].')');  ?></span>
											 
                                              <span class="badge badge-light"> <?php 
											  if($cansumpaidinvoices['total']==null){
												  echo htmlentities('(0.00)');
											  }
											  else{
											  echo htmlentities('('.$cansumpaidinvoices['total'].')'); } ?> </span>
											 
									   </div>  
                                     
                                    </div>
                                    <div class="col-auto"><i class="fas fa-file-invoice-dollar fa-2x text-dark"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					 <div class="col-md-6 col-xl-6 mb-4">
                        <div class="card shadow  py-2">
                              <div class="card-header  ">
                                <h6 class="text-dark font-weight-bold m-0">Qoutations  <span class="float-right">  عرض اسعار     </span> </h6>
                             
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        
                                        <?php 
                                        $pendingquote=mysqli_query($con,"select count(*) as total  from tbl_quotation where order_status=1 ");
                                        $pendingquotetotal=mysqli_query($con,"select format(sum(order_total_before_tax),2) as total  from tbl_quotation where order_status=1 ");
                                      $numpendingquote=mysqli_fetch_array($pendingquote);
                                      $sumpendingquote=mysqli_fetch_array($pendingquotetotal);
									  
										$appquote=mysqli_query($con,"select count(*) as total  from tbl_quotation where order_status=2 ");
                                        $appquotetotal=mysqli_query($con,"select format(sum(order_total_before_tax),2) as total  from tbl_quotation where order_status=2 ");
                                      $numappquote=mysqli_fetch_array($appquote);
                                      $sumappquote=mysqli_fetch_array($appquotetotal);
									  
									 $canquote=mysqli_query($con,"select count(*) as total  from tbl_quotation where order_status=3 ");
                                        $canquotetotal=mysqli_query($con,"select format(sum(order_total_before_tax),2) as total  from tbl_quotation where order_status=3 ");
                                      $numcanquote=mysqli_fetch_array($canquote);
                                      $sumcanquote=mysqli_fetch_array($canquotetotal);
									  
									  $chquote=mysqli_query($con,"select count(*) as total  from tbl_quotation where order_status=4 ");
                                        $chquotetotal=mysqli_query($con,"select format(sum(paid_amt),2) as total  from tbl_quotation where order_status=4 ");
                                      $numchquote=mysqli_fetch_array($chquote);
                                      $sumchquote=mysqli_fetch_array($numchquote);
										
                                        ?>
									<div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Pending  قيد الانتظار </span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										   
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('('.$numpendingquote['total'].')');  ?></span>
											 
                                              <span class="badge badge-light"> <?php 
											  if($sumpendingquote['total']==null){
												  echo htmlentities('(0.00)');
											  }
											  else{
											  echo htmlentities('('.$sumpendingquote['total'].')'); } ?> </span>
											 
									   </div> 
									
								       <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Approved  معتمد</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										   
											  <span class="badge badge-success"><?php 
                                             echo htmlentities('('.$numappquote['total'].')');  ?></span>
											 
                                              <span class="badge badge-light"> <?php 
											  if($sumappquote['total']==null){
												  echo htmlentities('(0.00)');
											  }
											  else{
											  echo htmlentities('('.$sumappquote['total'].')'); } ?> </span>
											 
									   </div>  
									   
									     <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Cancelled   ألغيت </span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										   
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('('.$numcanquote['total'].')');  ?></span>
											 
                                              <span class="badge badge-light"> <?php 
											  if($sumcanquote['total']==null){
												  echo htmlentities('(0.00)');
											  }
											  else{
											  echo htmlentities('('.$sumcanquote['total'].')'); } ?> </span>
											 
									   </div> 
									   
									      <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Changed  تغير </span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										   
											  <span class="badge badge-dark"><?php 
                                             echo htmlentities('('.$numchquote['total'].')');  ?></span>
											 
                                              <span class="badge badge-light"> <?php 
											  if($sumchquote['total']==null){
												  echo htmlentities('(0.00)');
											  }
											  else{
											  echo htmlentities('('.$sumchquote['total'].')'); } ?> </span>
											 
									   </div>  
                                     
                                    </div>
                                    <div class="col-auto"><i class="fas fa-file-invoice fa-2x text-dark"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					<!--<div class="col-md-4 col-xl-4 mb-4">
                        <div class="card shadow  py-2">
                              <div class="card-header  ">
                                <h6 class="text-dark font-weight-bold m-0">Expenses  <span class="float-right">  المصروفات     </span> </h6>
                             
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        
                                        <?php 
										$thisyear=date('Y');
										$thismonth=date('m');
										$thisdate=date('Y-m-d');
                                        $expenses=mysqli_query($con,"select count(*) as total  from expenses  ");
                                        $totalexpenses=mysqli_query($con,"select format(sum(amount),2) as total  from expenses ");
                                         $numexpenses=mysqli_fetch_array($expenses);
                                         $sumexpenses=mysqli_fetch_array($totalexpenses);
										 
										  $thisyearexpenses=mysqli_query($con,"select count(*) as total  from expenses where Year(expensedate)=$thisyear  ");
                                        $thistotalexpenses=mysqli_query($con,"select format(sum(amount),2) as total  from expenses where Year(expensedate)=$thisyear ");
                                         $thisyearnumexpenses=mysqli_fetch_array($thisyearexpenses);
                                         $thisyearsumexpenses=mysqli_fetch_array($thisyeartotalexpenses);
										 
										 $thisquarterexpenses=mysqli_query($con,"select count(*) as total  from expenses where Year(expensedate)=$thisyear and Quarter(expensedate)= Quarter($thisdate) ");
                                        $thisquartertotalexpenses=mysqli_query($con,"select format(sum(amount),2) as total  from expenses where Year(expensedate)=$thisyear amd Quarter(expensedate)= Quarter($thisdate) ");
                                         $thisquarternumexpenses=mysqli_fetch_array($thisquarterexpenses);
                                         $thisquartersumexpenses=mysqli_fetch_array($thisquartertotalexpenses);
										 
									    $thismonthexpenses=mysqli_query($con,"select count(*) as total  from expenses where Year(expensedate)=$thisyear  ");
                                        $thismonthtotalexpenses=mysqli_query($con,"select format(sum(amount),2) as total  from expenses where Year(expensedate)=$thisyear amd Month(expensedate)=$thismonth ");
                                         $thismonthnumexpenses=mysqli_fetch_array($thismonthexpenses);
                                         $thismonthsumexpenses=mysqli_fetch_array($thismonthtotalexpenses);
										
                                        ?>
										  <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Total Expenses اجمالي المصروفات </span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										   
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('('.$numexpenses['total'].')');  ?></span>
											 
                                              <span class="badge badge-light"> <?php 
											  if($sumexpenses['total']==null){
												  echo htmlentities('(0.00)');
											  }
											  else{
											  echo htmlentities('('.$sumexpenses['total'].')'); } ?> </span>
											 
									   </div> 
									
								       <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>This year (<?php echo $thisyear;?>) expenses  مصروفات هذا العام</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										   
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('('.$thisyearnumexpenses['total'].')');  ?></span>
											 
                                              <span class="badge badge-light"> <?php 
											  if($thisyearsumexpenses['total']==null){
												  echo htmlentities('(0.00)');
											  }
											  else{
											  echo htmlentities('('.$thisyearsumexpenses['total'].')'); } ?> </span>
											 
									   </div>  
									   
									     <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>This quarter  هذا الربع </span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										   
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('('.$thisquarternumexpenses['total'].')');  ?></span>
											 
                                              <span class="badge badge-light"> <?php 
											  if($thisquartersumexpenses['total']==null){
												  echo htmlentities('(0.00)');
											  }
											  else{
											  echo htmlentities('('.$thisquartersumexpenses['total'].')'); } ?> </span>
											 
									   </div> 
									   
									   
									     <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>This month (<?php echo date('M');?>) مصروفات هذا شهر </span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										   
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('('.$thismonthnumexpenses['total'].')');  ?></span>
											 
                                              <span class="badge badge-light"> <?php 
											  if($thismonthsumexpenses['total']==null){
												  echo htmlentities('(0.00)');
											  }
											  else{
											  echo htmlentities('('.$thismonthsumexpenses['total'].')'); } ?> </span>
											 
									   </div> 
									   
									     
                                     
                                    </div>
                                    <div class="col-auto"><i class="fas fa-money-check fa-2x text-gray"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    </div> 
	<?php } ?>
                    
                    
                    
                    
                    
					<!-- Second row agendas reports -->
					<div class="d-none d-md-block">
					<h5 class="text-dark text-left">Agenda/Tasks overview<span class="float-right">  نظرة عامة على جدول الأعمال / المهام    </span> </h5></div>
					<div class="d-block d-md-none">
					<p class="text-dark text-left">Agenda/Tasks overview<br/><span class="float-right">  نظرة عامة على جدول الأعمال / المهام    </span> </p></div>
					<br/>
                <div class="row">
                    <div class="col-md-4 col-xl-4 mb-4">
                        <div class="card shadow border-left-danger py-2">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-danger font-weight-bold m-0">Urgent Agendas أجندات عاجلة </h6>
                             
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        
                                        <?php 
                                        $hightasks1=mysqli_query($con,"select count(*) as total  from tasks where priority=1 and status=1");
                                        $hightasks2=mysqli_query($con,"select count(*) as total  from tasks where priority=1 and status=2");
										$hightasks3=mysqli_query($con,"select count(*) as total  from tasks where priority=1 and status=3");
										$hightasks4=mysqli_query($con,"select count(*) as total  from tasks where priority=1 and status=4");
										$hightasks5=mysqli_query($con,"select count(*) as total  from tasks where priority=1 and status=5");
										$hightasks6=mysqli_query($con,"select count(*) as total  from tasks where priority=1 and status=6");
										
										
                                        ?>
										
										<?php if($row1=mysqli_fetch_array($hightasks1))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>High العاجلة ,New جديد</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row1['total']==0)
                                          { ?>
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=1&status=1"> <span class="badge badge-danger"><?php echo htmlentities($row1['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  
                                     <?php if($row2=mysqli_fetch_array($hightasks2))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>High العاجلة ,Inprogress في تقدم</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row2['total']==0)
                                          { ?>
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=1&status=2"> <span class="badge badge-danger"><?php echo htmlentities($row2['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
                                       
                                      <?php if($row3=mysqli_fetch_array($hightasks3))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>High العاجلة ,Completed اكتمل</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row3['total']==0)
                                          { ?>
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=1&status=3"> <span class="badge badge-danger"><?php echo htmlentities($row3['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row4=mysqli_fetch_array($hightasks4))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>High العاجلة ,Partially Complete أنجزت جزئيا</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row4['total']==0)
                                          { ?>
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=1&status=4"> <span class="badge badge-danger"><?php echo htmlentities($row4['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row5=mysqli_fetch_array($hightasks5))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>High العاجلة ,Changed مؤجل / متغير</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row5['total']==0)
                                          { ?>
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=1&status=5"> <span class="badge badge-danger"><?php echo htmlentities($row5['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row6=mysqli_fetch_array($hightasks6))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>High العاجلة ,Waiting for someone في انتظار شخص آخر</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row6['total']==0)
                                          { ?>
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=1&status=6"> <span class="badge badge-danger"><?php echo htmlentities($row6['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
                                       
                                    </div>
                                    <div class="col-auto"><i class="fas fa-arrow-up fa-2x text-danger"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
                    <div class="col-md-4 col-xl-4 mb-4">
                        <div class="card shadow border-left-warning py-2">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-warning font-weight-bold m-0">Normal Agendas الأجندات العادية</h6>
                             
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        
                                        <?php 
                                        $normaltasks1=mysqli_query($con,"select count(*) as total  from tasks where priority=2 and status=1 and assigned_to=$empid");
                                        $normaltasks2=mysqli_query($con,"select count(*) as total  from tasks where priority=2 and status=2 and assigned_to=$empid");
										$normaltasks3=mysqli_query($con,"select count(*) as total  from tasks where priority=2 and status=3 and assigned_to=$empid");
										$normaltasks4=mysqli_query($con,"select count(*) as total  from tasks where priority=2 and status=4 and assigned_to=$empid");
										$normaltasks5=mysqli_query($con,"select count(*) as total  from tasks where priority=2 and status=5 and assigned_to=$empid");
										$normaltasks6=mysqli_query($con,"select count(*) as total  from tasks where priority=2 and status=6 and assigned_to=$empid");
										
										
                                        ?>
										
										<?php if($row1=mysqli_fetch_array($normaltasks1))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Normal عادي ,New جديد</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row1['total']==0)
                                          { ?>
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=2&status=1"> <span class="badge badge-warning"><?php echo htmlentities($row1['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  
                                     <?php if($row2=mysqli_fetch_array($normaltasks2))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Normal عادي ,Inprogress في تقدم</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row2['total']==0)
                                          { ?>
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=2&status=2"> <span class="badge badge-warning"><?php echo htmlentities($row2['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
                                       
                                      <?php if($row3=mysqli_fetch_array($normaltasks3))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Normal عادي ,Completed اكتمل</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row3['total']==0)
                                          { ?>
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=2&status=3"> <span class="badge badge-warning"><?php echo htmlentities($row3['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row4=mysqli_fetch_array($normaltasks4))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Normal عادي ,Partially Complete أنجزت جزئيا</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row4['total']==0)
                                          { ?>
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=2&status=4"> <span class="badge badge-warning"><?php echo htmlentities($row4['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row5=mysqli_fetch_array($normaltasks5))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Normal عادي ,Changed مؤجل / متغير</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row5['total']==0)
                                          { ?>
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=2&status=5"> <span class="badge badge-warning"><?php echo htmlentities($row5['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row6=mysqli_fetch_array($normaltasks6))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Normal عادي ,Waiting for someone في انتظار شخص آخر</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row6['total']==0)
                                          { ?>
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=2&status=6"> <span class="badge badge-warning"><?php echo htmlentities($row6['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
                                       
                                    </div>
                                    <div class="col-auto"><i class="fas fa-arrow-right fa-2x text-warning"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
					
                       <div class="col-md-4 col-xl-4 mb-4">
                        <div class="card shadow border-left-info py-2">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-info font-weight-bold m-0">Low priority agendas الأجندات ذات الأولوية المنخفض</h6>
                               <!-- <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v text-success"></i></button>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--fade-in"
                                        role="menu">
                                        <a class="dropdown-item" role="presentation" href="" id="last30">&nbsp;Last 30 days</a><a class="dropdown-item" role="presentation" href="#">&nbsp;Another action</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation" href="#">&nbsp;Something else here</a></div>
                                </div>-->
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        
                                        <?php 
                                        $lowtasks1=mysqli_query($con,"select count(*) as total  from tasks where priority=3 and status=1 and assigned_to=$empid");
                                        $lowtasks2=mysqli_query($con,"select count(*) as total  from tasks where priority=3 and status=2 and assigned_to=$empid");
										$lowtasks3=mysqli_query($con,"select count(*) as total  from tasks where priority=3 and status=3 and assigned_to=$empid");
										$lowtasks4=mysqli_query($con,"select count(*) as total  from tasks where priority=3 and status=4 and assigned_to=$empid");
										$lowtasks5=mysqli_query($con,"select count(*) as total  from tasks where priority=3 and status=5 and assigned_to=$empid");
										$lowtasks6=mysqli_query($con,"select count(*) as total  from tasks where priority=3 and status=6 and assigned_to=$empid");
										
										
                                        ?>
										
										<?php if($row1=mysqli_fetch_array($lowtasks1))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Low أدنى ,New جديد</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row1['total']==0)
                                          { ?>
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=3&status=1"> <span class="badge badge-info"><?php echo htmlentities($row1['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  
                                     <?php if($row2=mysqli_fetch_array($lowtasks2))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Low أدنى ,Inprogress في تقدم</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row2['total']==0)
                                          { ?>
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=3&status=2"> <span class="badge badge-info"><?php echo htmlentities($row2['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
                                       
                                      <?php if($row3=mysqli_fetch_array($lowtasks3))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Low أدنى ,Completed اكتمل</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row3['total']==0)
                                          { ?>
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=3&status=3"> <span class="badge badge-info"><?php echo htmlentities($row3['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row4=mysqli_fetch_array($lowtasks4))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Low أدنى ,Partially Complete أنجزت جزئيا</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row4['total']==0)
                                          { ?>
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=3&status=4"> <span class="badge badge-info"><?php echo htmlentities($row4['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row5=mysqli_fetch_array($lowtasks5))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Low أدنى ,Changed مؤجل / متغير</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row5['total']==0 )
                                          { ?>
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=3&status=5"> <span class="badge badge-info"><?php echo htmlentities($row5['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row6=mysqli_fetch_array($lowtasks6))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Low أدنى ,Waiting for someone في انتظار شخص آخر</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row6['total']==0)
                                          { ?>
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=3&status=6"> <span class="badge badge-info"><?php echo htmlentities($row6['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
                                       
                                    </div>
                                    <div class="col-auto"><i class="fas fa-arrow-down fa-2x text-info"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

      
                </div>
                
                
                			<!-- Third  row projects and job orders reports -->
					
					<!--<h1 class="text-dark text-left">Projects and Job orders overview<span class="float-right">  نظرة عامة على المشاريع و امر اعمال    </span> </h1>
                <div class="row">
                    <div class="col-md-4 col-xl-4 mb-4">
                        <div class="card shadow border-left-danger py-2">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-danger font-weight-bold m-0">Urgent Agendas أجندات عاجلة </h6>
                             
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        
                                        <?php 
                                        $hightasks1=mysqli_query($con,"select count(*) as total  from tasks where priority=1 and status=1");
                                        $hightasks2=mysqli_query($con,"select count(*) as total  from tasks where priority=1 and status=2");
										$hightasks3=mysqli_query($con,"select count(*) as total  from tasks where priority=1 and status=3");
										$hightasks4=mysqli_query($con,"select count(*) as total  from tasks where priority=1 and status=4");
										$hightasks5=mysqli_query($con,"select count(*) as total  from tasks where priority=1 and status=5");
										$hightasks6=mysqli_query($con,"select count(*) as total  from tasks where priority=1 and status=6");
										
										
                                        ?>
										
										<?php if($row1=mysqli_fetch_array($hightasks1))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>High العاجلة ,New جديد</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row1['total']==0)
                                          { ?>
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=1&status=1"> <span class="badge badge-danger"><?php echo htmlentities($row1['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  
                                     <?php if($row2=mysqli_fetch_array($hightasks2))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>High العاجلة ,Inprogress في تقدم</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row2['total']==0)
                                          { ?>
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=1&status=2"> <span class="badge badge-danger"><?php echo htmlentities($row2['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
                                       
                                      <?php if($row3=mysqli_fetch_array($hightasks3))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>High العاجلة ,Completed اكتمل</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row3['total']==0)
                                          { ?>
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=1&status=3"> <span class="badge badge-danger"><?php echo htmlentities($row3['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row4=mysqli_fetch_array($hightasks4))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>High العاجلة ,Partially Complete أنجزت جزئيا</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row4['total']==0)
                                          { ?>
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=1&status=4"> <span class="badge badge-danger"><?php echo htmlentities($row4['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row5=mysqli_fetch_array($hightasks5))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>High العاجلة ,Changed مؤجل / متغير</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row5['total']==0)
                                          { ?>
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=1&status=5"> <span class="badge badge-danger"><?php echo htmlentities($row5['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row6=mysqli_fetch_array($hightasks6))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>High العاجلة ,Waiting for someone في انتظار شخص آخر</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row6['total']==0)
                                          { ?>
											  <span class="badge badge-danger"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=1&status=6"> <span class="badge badge-danger"><?php echo htmlentities($row6['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
                                       
                                    </div>
                                    <div class="col-auto"><i class="fas fa-arrow-up fa-2x text-danger"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
					
					
                    <div class="col-md-4 col-xl-4 mb-4">
                        <div class="card shadow border-left-warning py-2">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-warning font-weight-bold m-0">Normal Agendas الأجندات العادية</h6>
                             
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        
                                        <?php 
                                        $normaltasks1=mysqli_query($con,"select count(*) as total  from tasks where priority=2 and status=1 and assigned_to=$empid");
                                        $normaltasks2=mysqli_query($con,"select count(*) as total  from tasks where priority=2 and status=2 and assigned_to=$empid");
										$normaltasks3=mysqli_query($con,"select count(*) as total  from tasks where priority=2 and status=3 and assigned_to=$empid");
										$normaltasks4=mysqli_query($con,"select count(*) as total  from tasks where priority=2 and status=4 and assigned_to=$empid");
										$normaltasks5=mysqli_query($con,"select count(*) as total  from tasks where priority=2 and status=5 and assigned_to=$empid");
										$normaltasks6=mysqli_query($con,"select count(*) as total  from tasks where priority=2 and status=6 and assigned_to=$empid");
										
										
                                        ?>
										
										<?php if($row1=mysqli_fetch_array($normaltasks1))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Normal عادي ,New جديد</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row1['total']==0)
                                          { ?>
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=2&status=1"> <span class="badge badge-warning"><?php echo htmlentities($row1['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  
                                     <?php if($row2=mysqli_fetch_array($normaltasks2))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Normal عادي ,Inprogress في تقدم</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row2['total']==0)
                                          { ?>
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=2&status=2"> <span class="badge badge-warning"><?php echo htmlentities($row2['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
                                       
                                      <?php if($row3=mysqli_fetch_array($normaltasks3))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Normal عادي ,Completed اكتمل</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row3['total']==0)
                                          { ?>
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=2&status=3"> <span class="badge badge-warning"><?php echo htmlentities($row3['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row4=mysqli_fetch_array($normaltasks4))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Normal عادي ,Partially Complete أنجزت جزئيا</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row4['total']==0)
                                          { ?>
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=2&status=4"> <span class="badge badge-warning"><?php echo htmlentities($row4['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row5=mysqli_fetch_array($normaltasks5))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Normal عادي ,Changed مؤجل / متغير</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row5['total']==0)
                                          { ?>
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=2&status=5"> <span class="badge badge-warning"><?php echo htmlentities($row5['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row6=mysqli_fetch_array($normaltasks6))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Normal عادي ,Waiting for someone في انتظار شخص آخر</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row6['total']==0)
                                          { ?>
											  <span class="badge badge-warning"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=2&status=6"> <span class="badge badge-warning"><?php echo htmlentities($row6['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
                                       
                                    </div>
                                    <div class="col-auto"><i class="fas fa-arrow-right fa-2x text-warning"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
					
                       <div class="col-md-4 col-xl-4 mb-4">
                        <div class="card shadow border-left-info py-2">
                              <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-info font-weight-bold m-0">Low priority agendas الأجندات ذات الأولوية المنخفض</h6>
                               <!-- <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v text-success"></i></button>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--fade-in"
                                        role="menu">
                                        <a class="dropdown-item" role="presentation" href="" id="last30">&nbsp;Last 30 days</a><a class="dropdown-item" role="presentation" href="#">&nbsp;Another action</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation" href="#">&nbsp;Something else here</a></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        
                                        <?php 
                                        $lowtasks1=mysqli_query($con,"select count(*) as total  from tasks where priority=3 and status=1 and assigned_to=$empid");
                                        $lowtasks2=mysqli_query($con,"select count(*) as total  from tasks where priority=3 and status=2 and assigned_to=$empid");
										$lowtasks3=mysqli_query($con,"select count(*) as total  from tasks where priority=3 and status=3 and assigned_to=$empid");
										$lowtasks4=mysqli_query($con,"select count(*) as total  from tasks where priority=3 and status=4 and assigned_to=$empid");
										$lowtasks5=mysqli_query($con,"select count(*) as total  from tasks where priority=3 and status=5 and assigned_to=$empid");
										$lowtasks6=mysqli_query($con,"select count(*) as total  from tasks where priority=3 and status=6 and assigned_to=$empid");
										
										
                                        ?>
										
										<?php if($row1=mysqli_fetch_array($lowtasks1))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Low أدنى ,New جديد</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row1['total']==0)
                                          { ?>
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=3&status=1"> <span class="badge badge-info"><?php echo htmlentities($row1['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  
                                     <?php if($row2=mysqli_fetch_array($lowtasks2))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Low أدنى ,Inprogress في تقدم</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row2['total']==0)
                                          { ?>
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=3&status=2"> <span class="badge badge-info"><?php echo htmlentities($row2['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
                                       
                                      <?php if($row3=mysqli_fetch_array($lowtasks3))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Low أدنى ,Completed اكتمل</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row3['total']==0)
                                          { ?>
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=3&status=3"> <span class="badge badge-info"><?php echo htmlentities($row3['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row4=mysqli_fetch_array($lowtasks4))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Low أدنى ,Partially Complete أنجزت جزئيا</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row4['total']==0)
                                          { ?>
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=3&status=4"> <span class="badge badge-info"><?php echo htmlentities($row4['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row5=mysqli_fetch_array($lowtasks5))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Low أدنى ,Changed مؤجل / متغير</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row5['total']==0 )
                                          { ?>
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=3&status=5"> <span class="badge badge-info"><?php echo htmlentities($row5['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
									  
									  <?php if($row6=mysqli_fetch_array($lowtasks6))
										{?>
                                        <div class="text-uppercase text-dark font-weight-light text-xs mb-1"><span>Low أدنى ,Waiting for someone في انتظار شخص آخر</span></div>
                                        <div class="text-dark font-weight-light h5 mb-0">
										
										<?php
                                          if($row6['total']==0)
                                          { ?>
											  <span class="badge badge-info"><?php 
                                             echo htmlentities('0');  ?></span>
											 <?php }
											 else
                                              {?>
                                         <a href="agendas/taskmanage.php?priority=3&status=6"> <span class="badge badge-info"><?php echo htmlentities($row6['total']);
                                     
                                       ?></span></a>
											  <?php } ?>
									   </div> 
                                      <?php } ?>
                                       
                                    </div>
                                    <div class="col-auto"><i class="fas fa-arrow-down fa-2x text-info"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>

      
                </div>-->
                
                
	
        </div>
        </section>
   
   <!-- footer  -->
        <?php
		   include('includes/footer.php');
		   ?>
    <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    <?php 
	 include('includes/footer_data.php'); ?>
	
	
</body>

</html>
<?php
}
}
?>