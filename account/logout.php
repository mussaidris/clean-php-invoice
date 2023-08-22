<?php
session_start();
error_reporting(0);
include("../includes/config.php");
date_default_timezone_set("Asia/Riyadh");// change according timezone
if(!isset($_SESSION['alogin']) || $_SESSION['alogin']=="")
{
	$_SESSION['alogin']="";
	session_unset();
	session_destroy();
	header("Location:../");
		exit();
}
else
{
$logouttime = date( 'Y-m-d H:i:s', time () );
$uip=$_SERVER['REMOTE_ADDR'];
$logintime=$_SESSION['logintime'];
$user_id=$_SESSION['alogin'];
$empid=intval($_SESSION['emplid']);
$fullname=$_SESSION['fname'].' '.$_SESSION['lname'];
$log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Logout',$empid,'$fullname','$user_id','$logouttime')");
		
		
//mysqli_query($con,"update counter set logoutpage=logoutpage+1;");
$_SESSION['alogin']="";
session_unset();
session_destroy();
//$_SESSION['errmsg']="You have successfully logout";
	header("Location:../");
		exit();
}
?>


