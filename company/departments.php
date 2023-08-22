<?php
session_start();
error_reporting(0);
 include('../includes/config.php');
  $pagetitle="Departments";
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
	   	$_SESSION['alogin']="";
	session_unset();
	session_destroy();
	header("Location:../");
		exit();
	}
	else{
	
	 $permission=unserialize($row['permission']);
	 $roleid=$row['role_id'];
			 if(isset($_POST["submit"]))
 {
	 $deptname=$_POST['dname'];
	 $status=0;
	 
        $check=mysqli_query($con,"select * from departments where dept_name='$deptname'" );
		
		if($row=mysqli_fetch_array($check))
		{
			$_SESSION['errMsg']= "This department is already available.";
			$_SESSION['successMsg']="";
		}
		else{
		  $result=mysqli_query($con,"insert into departments(dept_name,status) values('$deptname',$status)" );
		  if(!$result)
		  {
			  $_SESSION['errMsg']= "Please check your system , something is wrong  or contact your administrator.";
		     $_SESSION['successMsg']="";
		  }
		 else{
			 $logintime = date( 'Y-m-d H:i:s', time () );
			 $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Add Department',$empid,'$fullname','$email','$logintime')");
			header("Location:departments.php");
		exit();
		 }
		
		}
 }
 			 if(isset($_POST["update"]))
 {
	 $deptname=trim($_POST['dname']);
	 $status=intval($_POST['status']);
	 $id=$_GET['did'];
        $check=mysqli_query($con,"select * from departments where dept_name='$deptname' and id<>$id" );
		
		if($row=mysqli_fetch_array($check))
		{
			$_SESSION['errMsg']= "This department is already available.";
			$_SESSION['successMsg']="";
		}
		else{
		  $result=mysqli_query($con,"update departments set dept_name='$deptname',status=$status where id=$id" );
		  if(!$result)
		  {
			  $_SESSION['errMsg']= "Please check your system , something is wrong  or contact your administrator.";
		     $_SESSION['successMsg']="";
		  }
		 else{
			 $logintime = date( 'Y-m-d H:i:s', time () );
			 $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Update Department',$empid,'$fullname','$email','$logintime')");
			header("Location:departments.php");
		exit();
		 }
		
		}
 }
			 
		
		
?>

<!DOCTYPE html>
<html style="font-family: Cairo, sans-serif;">

<?php
include('../includes/head_sub_data.php');
?>

<body id="page-top" style="font-family: Cairo, sans-serif;color: rgb(0,0,0);">
    <div id="wrapper">
        
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <!-- here top header nav items -->
				
				 <?php 
				if($_SESSION['lang']=="ar")
                  {
	              include('../includes/headerSubNavAr.php');
				  }
				  else{
				  include('../includes/headerSubNav.php'); }?>
				 
             <!-- Table based contents -->
			 <br><br><br><br>
			 <?php  if(in_array("vwsett",$permission))  { ?>
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
              <strong>Warning!  تنبيه<</strong> <?php echo $_SESSION['errMsg']; ?>
               </div>
               <?php } ?>
			    <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-2 ">
                      
                    </div>
                    <div class="col-lg-8">
					 <div class="p-5">

                            <form class="company"  method="post">
                            	<div class="text-left">
                                <h3 >Add department  <span class="float-right">إضافة قسم</span></h3>
                            </div>
                            <hr/>
							<?php if(isset($_GET['did']))
							{
								$id=$_GET['did'];
								$deptu=mysqli_query($con,"select * from departments where id=$id");
								$depr=mysqli_fetch_array($deptu);
								?>
                                <div class="form-group row">
								<div class="col-sm-12">
								<label >Department name<span class="text-danger">*</span></label><span class="float-right">اسم القسم</span>
                                    <input class="form-control " type="text" id="dname" value="<?php echo htmlentities($depr['dept_name']);?>" name="dname" maxlength="255" required />
									<label >Status<span class="text-danger">*</span></label><span class="float-right">الحالة</span>
									<select class="form-control" name="status" id="status" required>
									    
                                            <option value="0" <?php if($depr['status']==0) echo "selected";?>>Active نشيط</option>
                                            <option value="1" <?php if($depr['status']==1) echo "selected";?>>In Active غير نشط</option>
                                            
                                     </select> 
									 <button class="btn btn-primary btn-sm text-white btn-user float-right" type="submit" name="update" id="update">Update<span class="float-right">تحديث</span></button>
									</div>
									
							
                                </div>
							<?php } else{
								?>
								 <div class="form-group row">
								<div class="col-sm-12">
								<label >Department name<span class="text-danger">*</span></label><span class="float-right">اسم القسم</span>
                                    <input class="form-control " type="text" id="dname"  name="dname" maxlength="255" required />
									<button class="btn btn-primary btn-sm text-white btn-user float-right" type="submit" name="submit" id="submit">Save<span class="float-right">حفظ</span></button>
									</div>
									
							
                                </div>
								<?php
							} ?>
							     
                           
                            </form>
                             </div>
                         <?php
		                include('departmentTable.php');
		                  ?>
                           
                        </div>
                    </div>
                </div>
            </div>
             <?php } else
            { ?>
            	
			<div>
			    <p> 
			    غير مسموح لك بمشاهدة هذه الصفحة بسبب الوصول المقيد من الإدارة. إذا كنت بحاجة إلى أي دعم ، فاتصل بمسؤول النظام أو الدعم الفني.
			    <br/>
			    You are not allowed to view this page due to restricted access  from the admin. If you need any support contact your system administrator or technical support.   </p>
			</div>
			<?php } ?>
			   
		  
        </div>
        <!-- footer  -->
        <?php
		   include('../includes/footer.php');
		   ?>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
   <?php 
	 include('../includes/footer_sub_data.php'); ?>
    
    
	
		<script>
	$(document).ready(function(){

    $('#dataTable').DataTable( );
       // var deptid = $(this).val();

  
    

});
	
	
	</script>
	
</body>

</html>

<?php
	}
	}

?>