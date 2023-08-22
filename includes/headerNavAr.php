<section class="sticky-top ">
<nav class="navbar navbar-light navbar-expand-lg shadow mb-4 topbar  bg-primary pl-1 pr-0 pl-md-5" dir="rtl">
  <div class="container-fluid">
  
  <button class="navbar-toggler"  data-toggle="collapse" data-target="#navbarSupportedContent" >
   <span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse  bg-primary navMobile" id="navbarSupportedContent">
    <ul class="navbar-nav ml-auto">
       <li class="nav-item ">
         <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt text-white"></i></a>
      </li>
	 
	  <?php  if(in_array("vwinv",$permission)){ ?>
	  
      <li class="nav-item">
        <a class="nav-link text-white" href="invoicing">الفواتير</a>
      </li>
	   <?php } if(in_array("vwquote",$permission)){ ?>
	  <li class="nav-item">
        <a class="nav-link text-white" href="quotation">عرض أسعار</a>
      </li>
	   <?php } if(in_array("vwinv",$permission)){ ?>
	    <li class="nav-item">
        <a class="nav-link text-white" href="inventory">المخزون</a>
      </li>
	   <?php } ?>
	  <!--<li class="nav-item">
        <a class="nav-link text-white" href="purchase">شراء</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link text-white" href="expenses">مصروفات</a>
      </li>-->
	  <?php  if(in_array("vwagend",$permission)){ ?>
	   <li class="nav-item">
        <a class="nav-link text-white" href="agendas">جدول أعمال</a>
      </li>
	  <?php } ?>
	   <li class="nav-item">
        <a class="nav-link text-white" href="projects">المشاريع</a>
      </li>
     
       
    </ul>
   
 
  <ul class="navbar-nav mr-auto">
  <li class="nav-item">
        <a class="nav-link text-white" href="system_feedbacks.php">Feedback</a>
      </li>
  
  <?php if($roleid==1){ ?>
  <li class="nav-item dropdown no-arrow " role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="text-white">&nbsp;&nbsp;&nbsp;إعدادات</span></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in text-right" role="menu"><a class="dropdown-item" role="presentation" href="company"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;شركة</a>
                                         <a
                                            class="dropdown-item" role="presentation" href="employees"><i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;الموظفين</a>
                                        </div>
                    </div>
                    </li><?php } ?>
	     <li class="nav-item dropdown no-arrow " role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-inline d-lg-inline mr-2 text-white small"><?php echo $_SESSION["fname"]."  ".$_SESSION["lname"];?></span></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in text-right" role="menu"><a class="dropdown-item" role="presentation" href="account/profile.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;الملف الشخصي</a>
                                         <a
                                            class="dropdown-item" role="presentation" href="account/change-password.php"><i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;تغيير كلمة السر</a>
                                        <a
                                            class="dropdown-item" role="presentation" href="account/activitylog.php"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;سجل النشاطات</a>
                                            
                                            <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation" href="account/logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;تسجيل خروج</a></div>
                    </div>
                    </li>
					
  </ul>
  </div>
   </div>
</nav>
</section>