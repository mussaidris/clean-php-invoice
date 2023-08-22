<section class="sticky-top ">
<nav class="navbar navbar-light navbar-expand-lg shadow mb-4 topbar  bg-primary p-1" >
  
  <div class="container-fluid">
  
  <button class="navbar-toggler"  data-toggle="collapse" data-target="#navbarSupportedContent" >
   <span class="sr-only">Toggle navigation</span><span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse bg-primary" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
        <li class="nav-item ">
         <a class="nav-link" href="../dashboard.php"><i class="fas fa-tachometer-alt text-white"></i></a>
      </li>
	 
	  <?php  if(in_array("vwinv",$permission)){?>
      <li class="nav-item">
        <a class="nav-link text-white" href="../invoicing">Invoicing</a>
      </li>
	  <?php } if(in_array("vwquote",$permission)){ ?>
	  <li class="nav-item">
        <a class="nav-link text-white" href="../quotation">Quotation</a>
      </li>
	  <?php } if(in_array("vwinv",$permission)){ ?>
	   <li class="nav-item">
        <a class="nav-link text-white" href="../inventory">Inventory</a>
      </li>
	  <?php } ?>
	  <!-- <li class="nav-item">
        <a class="nav-link text-white" href="../purchase">Purchase</a>
      </li>
	  <li class="nav-item">
        <a class="nav-link text-white" href="../expenses">Expenses</a>
      </li>-->
	   <?php  if(in_array("vwagend",$permission)){ ?>
	   <li class="nav-item">
        <a class="nav-link text-white" href="../agendas">Agendas</a>
      </li>
	   <?php } ?>
	   <li class="nav-item">
        <a class="nav-link text-white" href="../projects">Projects</a>
      </li>
      <!--<li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Dropdown
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="#">Action</a>
          <a class="dropdown-item" href="#">Another action</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="#">Something else here</a>
        </div>
      </li>-->
       
    </ul>
   
  
  <ul class="navbar-nav ml-auto">
  <li class="nav-item">
        <a class="nav-link text-white" href="../system_feedbacks.php">Feedback</a>
      </li>
  
  <?php if($roleid==1){ ?>
  <li class="nav-item dropdown no-arrow " role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="text-white">&nbsp;&nbsp;&nbsp;Settings</span></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu"><a class="dropdown-item" role="presentation" href="../company"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Company</a>
                                         <a
                                            class="dropdown-item" role="presentation" href="../employees"><i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Employees</a>
                                      </div>
                    </div>
                    </li><?php } ?>
	     <li class="nav-item dropdown no-arrow " role="presentation">
                                <div class="nav-item dropdown no-arrow"><a class="dropdown-toggle nav-link" data-toggle="dropdown" aria-expanded="false" href="#"><span class="d-inline d-lg-inline mr-2 text-white small"><?php echo $_SESSION["fname"]."  ".$_SESSION["lname"];?></span></a>
                                    <div
                                        class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu"><a class="dropdown-item" role="presentation" href="../account/profile.php"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a>
                                         <a
                                            class="dropdown-item" role="presentation" href="../account/change-password.php"><i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Change password</a>
                                        <a
                                            class="dropdown-item" role="presentation" href="../account/activitylog.php"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Activity log</a>
                                            <!--<a
                                            class="dropdown-item" role="presentation" href="../notifications.php"><i class="fas fa-envelope fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Notifications</a>-->
                                            <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation" href="../account/logout.php"><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</a></div>
                    </div>
                    </li>
					<!--<li class="nav-item">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  </li>-->
  </ul>
  </div>
  </div>
</nav>
</section>