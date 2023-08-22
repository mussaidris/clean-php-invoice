<?php
session_start();
error_reporting(0);
 include('includes/config.php');
 $_SESSION['msg']="";
 $pagetitle="Dashboard";
  date_default_timezone_set("Asia/Riyadh");// change according timezone
 if(isset($_SESSION['alogin']) && $_SESSION['alogin']!="")
 {
     	 header("Location:dashboard.php");
		 exit();
		
 }
 else
 {
 if(isset($_POST["submit"]))
 {
	 
	
   
	 $email=trim($_POST["email"]);
	 $password=md5(trim($_POST["password"]));
	 $language=$_POST["language"];
	 $result=mysqli_query($con,"select * from employees where email='$email' and password='$password'");
	 
	 if($row=mysqli_fetch_array($result))
	 {
		 $logintime = date( 'Y-m-d H:i:s', time () );
		 $fname=$row['fname'];
		 $lname=$row['lname'];
		 $fullname=$fname.' '.$lname;
		 $empid=$row['id'];
		 $roleid=$row['role_id'];
		 $_SESSION['emplid']=$empid;
		  $_SESSION['roleid']=$roleid;
		  $_SESSION['lang']=$language;
		  
		 
		 $_SESSION['msg']="";
         $_SESSION['alogin']=$email;
		  $_SESSION['fname']=$fname;
		  $_SESSION['lname']=$lname;
         $_SESSION['logintime']=$logintime;
         $_SESSION['user_ip']=$_SERVER['REMOTE_ADDR'];
		  
		 $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Login access',$empid,'$fullname','$email','$logintime')");
		mysqli_close($con);
		 header("Location:dashboard.php");
		 exit();
		
	
	 }
	 else{
	     $_SESSION['msg']="Incorrect email or password.";
	 }
 }


?>


<!DOCTYPE html>
<html  style="font-family: Cairo, sans-serif;">

<?php
include('includes/head_data.php');
?>

<body class="page-top" style="font-family: Cairo, sans-serif;color: rgb(0,0,0);">
    <div class="container">
	
	
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                           
                            <div class="col-lg-12">
                                <div class="p-3">
                                    <div class="text-center"><img src="assets/img/erprologo.jpg" width="300" height="150" class="img-responsive" ></div>
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Welcome to Er Pro Talents Management System Er Pro Talents مرحبًا بكم في نظام إدارة</h4>
										    <?php if($_SESSION['msg']!="")
                                            { ?>
             
                                            <div class="alert alert-danger alert-dismissible">
                                                <button type="button" class="close" data-dismiss="alert">&times;</button>
                                                 <strong>Warning! تنبيه</strong> <?php echo $_SESSION['msg']; ?>
                                            </div>
											<?php } ?>
                                    </div>
									
                                    <form class="user" id="loginForm"  method="post">
                                        <div class="form-group"><input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address... أدخل عنوان البريد الالكتروني " name="email" maxlength="50" required ></div>
                                        <div class="form-group"><input class="form-control form-control-user" type="password" id="exampleInputPassword" placeholder="Password كلمه المرور " name="password" maxlength="32" required ></div>
										<div class="form-group">
										<label for="lang1">Language لغة</label>
									<select class="form-control" name="language" id="language" required>
									    <option value="en" selected >English </option>
										<option value="ar">عربي </option>
										
										
									</select>
										</div>
										
                                        <button class="btn btn-primary btn-block text-white btn-user" type="submit" id="submit" name="submit"><i class="fas fa-sign-in-alt fa-3x"></i></button>
                                        
                                    </form>
                                    <div class="text-center"><a class="small" href="account/forgot-password.php">Forgot Password? هل نسيت كلمة المرور؟</a></div>
                                    <!--<div class="text-center"><a class="small" href="admin-register.php">Create an Account!</a></div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
    <script src="assets/js/chart.min.js"></script>
    <script src="assets/js/bs-init.js"></script>
    <script src="assets/bootstrap/jquery.easing.js"></script>
    <script src="assets/js/theme.js"></script>
	
	

</body>

</html>
<?php } ?>
