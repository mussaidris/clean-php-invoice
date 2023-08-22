<?php
session_start();
error_reporting(0);
 include('../includes/config.php');
  $_SESSION['errMsg']="";
     $_SESSION['successMsg']="";
$pagetitle="Forgot password";
  date_default_timezone_set("Asia/Riyadh");// change according timezone
 if(isset($_POST["submit"]))
 {
     
    
    
     $email=trim($_POST["email"]);
     $password1=trim("".rand(100,1000));
     $password=md5(trim($password1));
    
     $result=mysqli_query($con,"select * from employees where email='$email' ");
     
     if($row=mysqli_fetch_array($result))
     {
         
         $empid=$row['id'];
		 $fullname=$row['fname'].' '.$row['lname'];
         $update=mysqli_query($con,"update employees set password='$password' where email='$email'");
         if($update)
         {
             $logintime = date( 'Y-m-d H:i:s', time () );
             $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Forgot password',$empid,'$fullname','$email','$logintime')");
             $_SESSION['successMsg']= "Your password has been changed succeessfully.".$password1;
             $_SESSION['errMsg']="";
		 }    
         else
         {
           $_SESSION['errMsg']= "There is something wrong with the system. Please contact your administrator.";
            $_SESSION['successMsg']="";
         }
       
     }
     else{
       $_SESSION['errMsg']= "Incorrect email. This email is not registered.";
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

    <div class="container">
        
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-6 col-xl-6">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            
                            <div class="col-lg-12">
                                <div class="p-5">
                                    <div class="text-center">
                                        <img src="../assets/img/erprologo.jpg" width="300" height="250" class="img-responsive" >
                                       <h4 class="text-dark mb-4">Forgot Password? Don't Worry! هل نسيت كلمة المرور؟ لا تقلق! </h4>
                                        <p>Everyone forgets their password now and then. 
Just type the email address you used for signup and login and we will send you the temporary password to use. ينسى الجميع كلمة المرور الخاصة بهم بين الحين والآخر.
ما عليك سوى كتابة عنوان البريد الإلكتروني الذي استخدمته للتسجيل وتسجيل الدخول وسنرسل لك كلمة المرور المؤقتة لاستخدامها. </p>
                                        <?php if($_SESSION['successMsg']!="")
             { ?>
             
             <div class="alert alert-success alert-dismissible">
                 <button type="button" class="close" data-dismiss="alert">&times;</button>
              <strong>Success! نجاح</strong> <?php echo $_SESSION['successMsg']; ?>
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
                                    <?php if($_SESSION['successMsg']=="")
                                    { ?>
                                    <form class="user" id="passwordForm" method="post" >
                                        <div class="form-group"><input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address... أدخل عنوان البريد الالكتروني " name="email" maxlength="50" required ></div>
                                       <!-- <div class="form-group"><input class="form-control form-control-user" type="password" id="exampleInputPassword" placeholder="New Password" name="password" required ></div>-->
										
										
                                        <button  type="submit" class="btn btn-primary btn-block text-white btn-user"  id="submit" name="submit">Reset Password إعادة  كلمة المرور </button>
                                        
                                    </form>
                                    <?php } ?>
                                    <div class="text-center"><a class="small" href="../">Return to Login العودة لتسجيل الدخول </a></div>
                                    <!--<div class="text-center"><a class="small" href="admin-register.php">Create an Account!</a></div>-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php 
	 include('../includes/footer_sub_data.php'); ?>
	
	

</body>

</html>
