<?php
session_start();
error_reporting(0);
 include('../includes/config.php');
  $pagetitle="Company";
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
		if(isset($_POST['submit']))
		{
		    $company=str_replace("'","\'",trim($_POST['cname']));
			$crn=str_replace("'","\'",trim($_POST['crn']));
			$vatn=str_replace("'","\'",trim($_POST['vatn']));
		    $address=str_replace("'","\'",trim($_POST['address']));
		    $phone=str_replace("'","\'",trim($_POST['phone']));
		    $homephone=str_replace("'","\'",trim($_POST['mobile']));
			$fax=str_replace("'","\'",trim($_POST['faxn']));
			 $pobox=str_replace("'","\'",trim($_POST['pobox']));
			  $zipcode=str_replace("'","\'",trim($_POST['zipcode']));
		    $cemail=trim($_POST['email']);
		    $website=str_replace("'","\'",trim($_POST['website']));
			 $message=str_replace("'","\'",trim($_POST['message']));
		    $comp=mysqli_query($con,"update company set company_name='$company',cr_no='$crn',vat_number='$vatn',address='$address',phone='$phone',mobile='$homephone',fax='$fax',pobox='$pobox',zipcode='$zipcode',email='$cemail',website='$website',message='$message'");
		    if(!$comp)
		    {
		         $_SESSION['errMsg']='Something is wrong with database, please check with your Administrator or technical support.';
		          $_SESSION['successMsg']="";
		    }
		    else
		    {
		           $logintime = date( 'Y-m-d H:i:s', time () );
             $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Campany update',$empid,'$fullname','$email','$logintime')");
		    }
           
		    
		}
		
?>

<!DOCTYPE html>
<html  style="font-family: Cairo, sans-serif;">

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
				  include('../includes/headerSubNav.php'); }
               
                 	$company=mysqli_query($con,"select * from company limit 1");
                 	$comp=mysqli_fetch_array($company);
				  ?>
                  	 <!--Edit Dependant  -->
                 <br><br><br>
                 <?php  if(in_array("vwsett",$permission))  { ?>
             <div class="container-fluid">
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
               <?php } 
			
		   include('companyTable.php');
		 
			   ?>
              
              
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
		</div>   
    </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a></div>
    <?php 
	 include('../includes/footer_sub_data.php'); ?>
	
		<script>
	$(document).ready(function(){
         
    $('.number_only').keypress(function(e){
                 return isNumbers(e, this); 
                     
                 });
  
         function isNumbers(evt, element) 
            {
               var charCode = (evt.which) ? evt.which : event.keyCode;
    if ((charCode != 46 || $(element).val().indexOf('.') != -1) && (charCode < 48 || charCode > 57))
                  return false;
				 
               return true;
            }
      
    
       
            
        });



	
	
	</script>

	
</body>

</html>

<?php
	}
	
}
?>