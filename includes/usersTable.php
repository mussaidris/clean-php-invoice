 <div class="container-fluid">
                <h3 class="text-dark mb-4">Manage Users</h3>
                <div class="card shadow">
                    <div class="card-header py-3">
                        <!--<p class="text-primary m-0 font-weight-bold">Company Info</p>-->
						
						<!-- Button to Open the Modal -->
						<button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#myModal">
  New User
</button>
                    </div>
                    <div class="card-body">
                        
						<?php
						
						$users=mysqli_query($con,"select *,groups.group_name from users,groups  where users.role_id=groups.id");
						?>
                        <div class="table-responsive mt-2"  role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable">
                                <thead>
                                    <tr>
									
                                        <th>User name</th>
                                        <th>Email</th>
                                        <th>Phone</th>
                                        <th>Role</th>
                                        <th>Name</th>
										<th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								
								while ($row=mysqli_fetch_array($users))
								{
									?>
                                    <tr>
                                        <td><img class="rounded-circle mr-2" width="30" height="30" src="assets/img/avatars/3a logo-01.jpg"><?php echo htmlentities($row['username']);?></td>
                                        <td><?php echo htmlentities($row['email']);?></td>
                                        <td><?php echo htmlentities($row['phone']);?></td>
                                        <td><?php echo htmlentities($row['group_name']);?></td>
                                        <td><?php echo htmlentities($row['firstname']." ".$row['lastname']);?></td>
                                        <td><td><a href="editUsers.php?id=<?php echo $row['id'];?>">Edit</a></td></td>
                                    </tr>
                                    <?php
								}
								?>
                                   
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>User name</td>
                                        <td>Email</td>
                                        <td>Phone</td>
                                        <td>Role</td>
                                        <td>Name</td>
										<th>Action</th>
                                        
                                </tfoot>
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
			
			


<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-xl modal-dialog-scrollable">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">New User</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <!--Modal body..-->
		
		<div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-5 d-none d-lg-flex">
                        <div class="flex-grow-1 bg-register-image" style="background-image: url(&quot;assets/img/dogs/3a logo-01.jpg&quot;);"></div>
                    </div>
                    <div class="col-lg-7">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Create an Account!</h4>
                            </div>
                            <form class="user" action="register.php" method="post">
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="FirstName" placeholder="First Name" name="first_name" required ></div>
                                    <div class="col-sm-6"><input class="form-control form-control-user" type="text" id="LastName" placeholder="Last Name" name="last_name" required ></div>
                                </div>
                                <div class="form-group"><input class="form-control form-control-user" type="text" id="username" aria-describedby="userHelp" placeholder="User name" name="username" required ></div>
								<div class="form-group"><input class="form-control form-control-user" type="email" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Email Address" name="email" required ></div>
                                <div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="password" id="PasswordInput" placeholder="Password" name="password" required></div>
                                    <!--<div class="col-sm-6"><input class="form-control form-control-user" type="password" id="exampleRepeatPasswordInput" placeholder="Repeat Password" name="password_repeat"></div>-->
                                </div>
								<div class="form-group row">
                                    <div class="col-sm-6 mb-3 mb-sm-0"><input class="form-control form-control-user" type="text" id="phone" placeholder="Phone number" name="phone"></div>
                                    <div class="col-sm-6">
									<label for="gender">Gender</label>
									<select class="form-control" name="gender" id="gender">
									    <option value="1" selected >Male </option>
										<option value="2">Female </option>
									</select>
									</div>
                                </div>
								<div class="form-group">
										   <label for="roles">Role</label>
										   <select class="form-control" name="roles" id="roles" required >
										   <option value="3" selected>value</option>
										   <option value="1" >value1</option>
										   <option value="2" >value2</option>
										   
										   </select>
										   </div><button class="btn btn-primary btn-block text-white btn-user" type="submit" name="submit" id="submit">Register Account</button>
                                <!--<hr><a class="btn btn-primary btn-block text-white btn-google btn-user" role="button"><i class="fab fa-google"></i>&nbsp; Register with Google</a><a class="btn btn-primary btn-block text-white btn-facebook btn-user" role="button"><i class="fab fa-facebook-f"></i>&nbsp; Register with Facebook</a>
                                <hr>-->
                            </form>
                            <!--<div class="text-center"><a class="small" href="forgot-password.html">Forgot Password?</a></div>-->
                            <!--<div class="text-center"><a class="small" href="login.html">Already have an account? Login!</a></div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
		
      </div>

      <!-- Modal footer -->
      <div class="modal-footer">
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      </div>

    </div>
  </div>
</div>
			
			
			