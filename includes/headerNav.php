<section class="sticky-top ">
<nav class="navbar navbar-light navbar-expand-lg shadow mb-4 topbar  bg-primary p-1" >
   <div class="container-fluid">
  
  <button class="navbar-toggler"  data-toggle="collapse" data-target="#navbarSupportedContent" >
   <span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse bg-primary navMobile" id="navbarSupportedContent">
    
    <ul class="navbar-nav mr-auto ">
      <li class="nav-item ">
         <a class="nav-link" href="dashboard.php"><i class="fas fa-tachometer-alt text-white"></i></a>
      </li>
	 
	  <?php  if(in_array("vwinv",$permission)){  ?>
	  
      <li class="nav-item">
        <a class="nav-link text-white" href="invoicing">Invoicing</a>
      </li>
	  <?php } if(in_array("vwquote",$permission)){ ?>
	  <li class="nav-item">
        <a class="nav-link text-white" href="quotation">Quotation</a>
      </li>
	<?php } if(in_array("vwinv",$permission)){ ?>
	   <li class="nav-item">
        <a class="nav-link text-white" href="inventory">Inventory</a>
      </li>
	<?php } ?>
	  <!-- <li class="nav-item">
        <a class="nav-link text-white" href="purchase">Purchase</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link text-white" href="expenses">Expenses</a>
      </li>-->
	  <?php  if(in_array("vwagend",$permission)){ ?>
	   <li class="nav-item">
        <a class="nav-link text-white" href="agendas">Agendas</a>
      </li>
	  <?php } ?>
	  
	   <li class="nav-item">
        <a class="nav-link text-white" href="projects">Projects</a>
      </li>
  <!--<li class="nav-item dropdown no-arrow mx-1" role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="badge badge-danger badge-counter">3+</span><i class="fas fa-bell fa-fw"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in"
                                        role="menu">
                                        <h6 class="dropdown-header">alerts center</h6>
                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="mr-3">
                                                <div class="bg-primary icon-circle"><i class="fas fa-file-alt text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 12, 2019</span>
                                                <p>A new monthly report is ready to download!</p>
                                            </div>
                                        </a>
                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="mr-3">
                                                <div class="bg-success icon-circle"><i class="fas fa-donate text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 7, 2019</span>
                                                <p>$290.29 has been deposited into your account!</p>
                                            </div>
                                        </a>
                                        <a class="d-flex align-items-center dropdown-item" href="#">
                                            <div class="mr-3">
                                                <div class="bg-warning icon-circle"><i class="fas fa-exclamation-triangle text-white"></i></div>
                                            </div>
                                            <div><span class="small text-gray-500">December 2, 2019</span>
                                                <p>Spending Alert: We've noticed unusually high spending for your account.</p>
                                            </div>
                                        </a><a class="text-center dropdown-item small text-gray-500" href="#">Show All Alerts</a></div>
                                </div>
                            </li>-->
        
    </ul>
   
        
        <ul class="navbar-nav ml-auto" >
  
   <li class="nav-item">
        <a class="nav-link text-white" href="system_feedbacks.php">Feedback</a>
      </li>
  
  <?php if($roleid==1){ ?>
  
 <li class="nav-item dropdown no-arrow" >
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="text-white">Settings</span></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu"><a class="dropdown-item" role="presentation" href="company"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Company</a>
                                         <a
                                            class="dropdown-item" role="presentation" href="employees"><i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Employees</a>
                                       </div>
                    </div>
  </li><?php } ?>
	     <li class="nav-item dropdown no-arrow d-block ">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-block mr-2 text-white small"><?php echo $_SESSION["fname"]."  ".$_SESSION["lname"];?></span></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu"><a class="dropdown-item" role="presentation" href="account/profile.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a>
                                         <a
                                            class="dropdown-item" role="presentation" href="account/change-password.php"><i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Change password</a>
                                        <a
                                            class="dropdown-item" role="presentation" href="account/activitylog.php"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Activity log</a>
                                           <!-- <a
                                            class="dropdown-item" role="presentation" href="notifications.php"><i class="fas fa-envelope fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Notifications</a>-->
                                            <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation" href="account/logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a></div>
                    </div>
                    </li>
				
  </ul>
 
  
  </div>
 
  </div>
</nav>
</section>

   