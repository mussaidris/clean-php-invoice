<?php
session_start();
error_reporting(0);
 include('../includes/config.php');
 $_SESSION['errMsg']="";
 $_SESSION['successMsg']="";
  $pagetitle="Change password";
 date_default_timezone_set('Asia/Riyadh');// change according timezone
 
 
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
     
    
  
    $empid=$_SESSION['emplid'];
    $fullname=$_SESSION['fname'].' '.$_SESSION['lname'];
     $email=trim($_POST["email"]);
      $password1=trim($_POST["password"]);
     $password=md5(trim($_POST["password"]));
    
     $result=mysqli_query($con,"select * from employees where email='$email' limit 1");
     
     if($row=mysqli_fetch_array($result))
     {
         
         $update=mysqli_query($con,"update employees set password='$password' where email='$email'");
         if(!$update)
         {
           $_SESSION['errMsg']= "There is something wrong with the system. Please contact your administrator. هناك خطأ ما في النظام. الرجاء الاتصال بالمسؤول.";
           $_SESSION['successMsg']="";
         }
         else
         {
              $logintime = date( 'Y-m-d H:i:s', time () );
             $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Change Password',$empid,'$fullname','$email','$logintime')");
             $_SESSION['successMsg']= "Your password has been changed succeessfully. تم تغيير كلمة المرور الخاصة بك بنجاح.";
             $_SESSION['errMsg']="";
           header("Location:dashboard.php");
		exit();
         }
		 mysqli_close($con);
       
     }
     else{
       $_SESSION['errMsg']= "Incorrect email. This email is not registered. غير صحيح البريد الإلكتروني. هذا البريد الإلكتروني غير مسجل.";
       $_SESSION['successMsg']="";
     }
 }


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
				  <br><br><br><br>
             <div class="container-fluid">
            <?php if($_SESSION['successMsg']!="")
             { ?>
             
             <div class="alert alert-success alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Success! نجاح</strong> <?php echo $_SESSION['successMsg']; ?>
               </div>
               <?php }
               if($_SESSION['errMsg']!="")
             {
               ?>
               <div class="alert alert-success alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Warning! تنبيه</strong> <?php echo $_SESSION['errMsg']; ?>
               </div>
               <?php } ?>
               <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                           
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <?php if($_SESSION['successMsg']=="")
                                    { ?>
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Change password  تغيير كلمة السر</h4>
                                    </div>
                                  
                                    <form class="user" id="passwordForm" method="post" >
                                        <div class="form-group"><input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email" maxlength="50" required ></div>
                                        <div class="form-group"><input class="form-control form-control-user" type="password" id="exampleInputPassword" placeholder="New Password" name="password" maxlength="32" required ></div>
										
										
                                        <button  type="submit" class="btn btn-primary btn-block text-white btn-user"  id="submit" name="submit">Change Password تغيير كلمة السر</button>
                                        
                                    </form>
									<?php } ?>
                                   
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div> 
           
            </div>
        </div>
		</div>
		</div>
        <!-- footer  -->
        <?php
		   include('../includes/footer.php');
		   ?>
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
    <?php 
	 include('../includes/footer_sub_data.php'); ?>
	
	

</body>

</html>
<?php } } ?>
