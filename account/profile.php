<?php
session_start();
error_reporting(0);
 include('../includes/config.php');
  $pagetitle="Profile";
  date_default_timezone_set("Asia/Riyadh");// change according timezonee
    $logintime = date( 'Y-m-d H:i:s', time () );
    $_SESSION['errMsg']="";
     $_SESSION['successMsg']="";
if(!isset($_SESSION['alogin']) || $_SESSION['alogin']=="")
{
	$_SESSION['alogin']="";
	session_unset();
	session_destroy();
	header("Location:../");
		exit();
}
else{
	
	$email=trim($_SESSION['alogin']);
	$empid=intval($_SESSION['emplid']);
	$fullname=trim($_SESSION['fname']." ".$_SESSION['lname']);
	$result=mysqli_query($con,"select * from employees where email='$email'");
	$row=mysqli_fetch_array($result);
	if(!$row)
	{
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
<html   style="font-family: Cairo, sans-serif;">

<?php
include('../includes/head_sub_data.php');
?>

<body id="page-top" style="font-family: Cairo, sans-serif;color: rgb(0,0,0);">

    <div id="wrapper">
        
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
			
                <!--  Here is top header navigation items-->
			   <?php 
				if($_SESSION['lang']=="ar")
                  {
	              include('../includes/headerSubNavAr.php');
				  }
				  else{
				  include('../includes/headerSubNav.php'); }?>
				  <br><br><br><br><br>
		<div class="container-fluid">	
			<div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-1 d-none d-lg-flex">
                       
                    </div>
                    <div class="col-lg-10">
                        <div class="p-5">
                            <div class="text-left">
                                <h3 class="text-dark mb-4">Profile <span class="float-right"> بيانات الشخصية</span></h3>
							    <?php if($_SESSION['successMsg']!="")
             { ?>
             
             <div class="alert alert-success alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Success! نجاح!</strong> <?php echo $_SESSION['successMsg']; ?>
               </div>
               <?php }
               else if($_SESSION['errMsg']!="")
               {
             
               ?>
               <div class="alert alert-success alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Warning! تنبيه</strong> <?php echo $_SESSION['errMsg']; ?>
               </div>
               <?php } ?>
                            </div>
							<?php
							$eid=$empid;
							 $employee=mysqli_query($con,"select * from employees where id=$eid limit 1");
								$empr=mysqli_fetch_array($employee);
							$permission=unserialize($empr['permission']);
								
							?>
                            <form class="tasks"  method="post">
                                <div class="form-group row">
								<div class="col-sm-6">
								<label >First Name <span class="text-danger">*</span></label><span class="float-right">الاسم الاول</span>
                                    <input class="form-control " type="text" id="fname" value="<?php echo $empr['fname'];?>" name="fname" readonly >
									</div>
									<div class="col-sm-6">
									<label >Last Name <span class="text-danger">*</span></label><span class="float-right">اسم العائلة</span>
                                    <input class="form-control " type="text" id="lname" value="<?php echo $empr['lname'];?>" name="lname" readonly >
									</div>
                                </div>
                               
							<div class="form-group row">
							<div class="col-sm-6">
							<?php
							$cid=$empr['company'];
							$did=$empr['section'];
							 $comp=mysqli_query($con,"select id,company_name from company where id=$cid limit 1");
								$compr=mysqli_fetch_array($comp);
								 $dept=mysqli_query($con,"select id,dept_name from departments  ");
								
							?>
							<label >Company <span class="text-danger">*</span></label><span class="float-right">شركة</span>
                                    <select class="form-control" name="company" id="company" readonly>
									    
                                            <option value="<?php echo $compr['id'] ;?>" ><?php echo $compr['company_name'] ;?></option>
                                            
                                     </select> 
									</div>
									<div class="col-sm-6">
									<label >Section/Department <span class="text-danger">*</span></label><span class="float-right">قسم</span>
									<select class="form-control" name="dept" id="dept" readonly >
									      <?php
										  while($deptr=mysqli_fetch_array($dept))
										  {?>
                                            <option value="<?php echo $deptr['id'] ;?>" <?php if($deptr['id']==$did) echo "selected";?>><?php echo $deptr['dept_name'] ;?></option>
										  <?php } ?>
                                     </select>
									 </div>
									
                                </div>
								<div class="form-group row">
							<div class="col-sm-6">
							<label >ID Number </label><span class="float-right">رقم الهوية</span>
                                    <input class="form-control" type="text" id="idno" value="<?php echo $empr['id_no'];?>" name="idno" readonly >
									</div>
									<div class="col-sm-6">
									<label >Job Title <span class="text-danger">*</span></label><span class="float-right">المسمى الوظيفي</span>
									<input class="form-control" type="text" id="jobtitle" value="<?php echo $empr['jobtitle'];?>" name="jobtitle" readonly >
									</div>
									
                                </div>
                               
								<div class="form-group row">
                                    <div class="col-sm-6">
									<label for="roles">Role <span class="text-danger">*</span></label><span class="float-right">دور</span>
									<select class="form-control" name="roles" id="roles" readonly>
									    <option value="1" <?php if($empr['role_id']==1) echo "selected";?> >Administrator  إداري  </option>
										<option value="2" <?php if($empr['role_id']==2) echo "selected";?>>Standard User    </option>
									
										
									</select>
									</div>
                                    
									<div class="col-sm-6">
									<label for="mobile">Mobile Number <span class="text-danger">*</span></label><span class="float-right">رقم الجوال </span>
									<input class="form-control number_only" type="text" id="mobile" value="<?php echo $empr['contact_no'];?>" name="mobile" readonly >
									</div>
								
								
                                </div>
								<div class="form-group row">
							<div class="col-sm-8">
							      <label >Email <span class="text-danger">*</span></label><span class="float-right">البريد الإلكتروني </span>
                                    <input class="form-control" type="text" id="email" value="<?php echo $empr['email'];?>" name="email" readonly >
									</div>
									
									
                                </div>
							
								
								<div class="form-group">
								 <label >Address<span class="text-danger">*</span> </label><span class="float-right">عنوان</span>
                                    <textarea class="form-control" rows="7" id="address"  name="address" readonly ><?php echo $empr['address'];?></textarea>
									
                                </div>
							   
										  
                               
                            </form>
                         
                        </div>
				
                    </div>
                </div>
            </div>
        </div>
		
		
				
			
			</div>
            </div>
         
             <?php
		   include('../includes/footer.php');
		   ?>
              </div> <a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
  <?php 
	 include('../includes/footer_sub_data.php'); ?>
	
	
	
</body>

</html>

<?php
	}
	}

?>