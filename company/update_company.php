<?php
session_start();
error_reporting(0);
 include('../includes/config.php');
  $pagetitle="Update Company";
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
		    $companyar=str_replace("'","\'",trim($_POST['carname']));
			$crn=str_replace("'","\'",trim($_POST['crn']));
			$vatn=str_replace("'","\'",trim($_POST['vatn']));
		    $address=str_replace("'","\'",trim($_POST['address']));
		    $addressar=str_replace("'","\'",trim($_POST['addressar']));
		    $phone=str_replace("'","\'",trim($_POST['phone']));
		    $homephone=str_replace("'","\'",trim($_POST['mobile']));
			$fax=str_replace("'","\'",trim($_POST['faxn']));
			 $pobox=str_replace("'","\'",trim($_POST['pobox']));
			  $zipcode=str_replace("'","\'",trim($_POST['zipcode']));
		    $cemail=trim($_POST['email']);
		    $website=str_replace("'","\'",trim($_POST['website']));
			 $message=str_replace("'","\'",trim($_POST['message']));
		    $comp=mysqli_query($con,"update company set company_name='$company',arabic_name='$companyar',cr_no='$crn',vat_number='$vatn',address='$address',arabic_address='$addressar',phone='$phone',mobile='$homephone',fax='$fax',pobox='$pobox',zipcode='$zipcode',email='$cemail',website='$website',message='$message'");
		    if(!$comp)
		    {
		         $_SESSION['errMsg']='Something is wrong with database, please check with your Administrator or technical support.';
		          $_SESSION['successMsg']="";
		    }
		    else
		    {
		           $logintime = date( 'Y-m-d H:i:s', time () );
             $log=mysqli_query($con,"insert into employeelogs(activity,empl_id,f_name,email,act_date_time) values('Company update',$empid,'$fullname','$email','$logintime')");
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
                   $id=$_GET['cid'];
                 	$company=mysqli_query($con,"select * from company  where id=$id limit 1");
                 	$comp=mysqli_fetch_array($company);
				  ?>
                  	 <!--Edit Dependant  -->
                 <br><br><br>
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
               <?php } ?>
              
               
				 <div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-1 d-none d-lg-flex">
                       
                    </div>
                    <div class="col-lg-10">
                        <div class="p-5">

                            <form class="company"  method="post">
                            	<div class="text-left">
                                <h3 >Update Company Information  <span class="float-right">تحديث معلومات الشركة</span></h3>
                            </div>
                            <hr/>
                                <div class="form-group row">
								<div class="col-sm-12">
								    <div class="form-group row">
								        <div class="col-sm-6">
								            	<label >Company name<span class="text-danger">*</span></label>
                                    <input class="form-control " type="text" id="cname" value="<?php echo htmlentities($comp['company_name']);?>" name="cname" maxlength="100" required >
								        </div>
								        <div class="col-sm-6">
								            	<label ><span class="text-danger">*</span></label><span class="float-right">اسم الشركة</span>
                                    <input class="form-control " type="text" id="carname" value="<?php echo htmlentities($comp['arabic_name']);?>" name="carname" maxlength="100" required >
								        </div>
								    </div>
							
								</div>
									<div class="col-sm-6">
								<label >CR Number </label><span class="float-right">رقم السجل التجاري</span>
                                    <input class="form-control " type="text" id="crn" value="<?php echo htmlentities($comp['cr_no']);?>" name="crn" maxlength="20"  >
									</div>
									<div class="col-sm-6">
								<label >VAT Number  </label><span class="float-right">رقم ضريبة القيمة المضافة</span>
                                    <input class="form-control " type="text" id="vatn" value="<?php echo htmlentities($comp['vat_number']);?>" name="vatn" maxlength="15"  >
									</div>
									<div class="col-sm-12">
									    <div class="form-group row">
								        <div class="col-sm-6">
								            <label >Address<span class="text-danger">*</span></label>
                                    <textarea class="form-control " rows="3" id="address"  name="address"  required><?php echo htmlentities($comp['address']);?></textarea>
								        </div>
								         <div class="col-sm-6">
								            <label ><span class="text-danger">*</span></label><span class="float-right">عنوان</span>
                                    <textarea class="form-control " rows="3" id="addressar"  name="addressar"  required><?php echo htmlentities($comp['arabic_address']);?></textarea>
								        </div>  
								        </div>
									
									</div>
									
									<div class="col-sm-4">
									<label >Phone<span class="text-danger">*</span></label><span class="float-right">هاتف</span>
                                    <input class="form-control " type="text" id="phone" value="<?php echo htmlentities($comp['phone']);?>" name="phone" maxlength="20" required >
									</div>
										<div class="col-sm-4">
									<label >Mobile</label><span class="float-right">جوال</span>
                                    <input class="form-control " type="text" id="mobile" value="<?php echo htmlentities($comp['mobile']);?>" name="mobile" maxlength="20" >
									</div>
									<div class="col-sm-4">
									<label >Fax</label><span class="float-right">فاكس</span>
                                    <input class="form-control " type="text" id="faxn" value="<?php echo htmlentities($comp['fax']);?>" name="faxn" maxlength="20" >
									</div>
                                </div>
                               <div class="form-group row">
								<div class="col-sm-6">
								<label >PO.Box</label><span class="float-right">صندوق البريد</span>
                                    <input class="form-control " type="text" id="pobox" value="<?php echo htmlentities($comp['pobox']);?>" name="pobox"  >
									</div>
									<div class="col-sm-6">
								<label >Zip Code</label><span class="float-right">الرمز البريدي</span>
                                    <input class="form-control " type="text" id="zipcode" value="<?php echo htmlentities($comp['zipcode']);?>" name="zipcode" >
									</div>
									
									
									
                                </div>
                                  <div class="form-group row">
								<div class="col-sm-6">
								<label >Email<span class="text-danger">*</span></label><span class="float-right">البريد الإلكتروني</span>
                                    <input class="form-control " type="email" id="email" value="<?php echo htmlentities($comp['email']);?>" name="email" maxlength="100" required >
									</div>
									<div class="col-sm-6">
								<label >Website</label><span class="float-right">موقع الكتروني</span>
                                    <input class="form-control " type="text" id="website" value="<?php echo htmlentities($comp['website']);?>" name="website" maxlength="100" >
									</div>
									
									<div class="col-sm-12">
								<label >Message</label><span class="float-right">رسالة</span>
                                    <textarea class="form-control " rows="7" id="message"  name="message"  ><?php echo htmlentities($comp['message']);?></textarea>
									</div>
									
                                </div>
								
                                </div>
                             
							
										   <button class="btn btn-primary btn-sm text-white btn-user float-right" type="submit" name="submit" id="submit">Update<span class="float-right">تحديث</span></button>
                            
                            </form>
                           
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