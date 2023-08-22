 <div class="container-fluid">
              
                <div class="card shadow">
                    <div id="buttons" class="card-header py-3 d-flex flex-row-reverse bg-default">
                  <!--<a href="permissions.php"   class="btn btn-primary" > 
  Roles
</a>
   <a href="printEmployees.php" target="_blank"  class="btn btn-primary" data-toggle="tooltip" data-placement="top" title="Print Employees"> 
  <i class="fas fa-print"></i>
</a>-->
     
                    </div>
                    <div class="card-body">
                        
						<?php
						
						$employees=mysqli_query($con,"select employees.*,groups.group_name from employees inner join groups  on  employees.role_id=groups.id ");
						?>
                        <div class="table-responsive mt-2"  role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable">
                                <thead>
                                    <tr>
									      <th>#</th>
                                        <th>Name</th>
										<th>Email</th>
                                        <th>Position</th>
                                        <th>Education</th>
										<th>Type</th>
                                        <th>Joined On</th>
									    <th>Status</th>
										<th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								
								while ($row=mysqli_fetch_array($employees))
								{
									?>
                                    <tr>
									<td><?php echo htmlentities($row['id']);?></td>
                                       <td><?php echo htmlentities($row['fname']." ".$row['mname']." ".$row['lname']);?></td>
                                        <td><?php echo htmlentities($row['email']);?></td>
                                        <td><?php echo htmlentities($row['group_name']);?></td>
                                        <td><?php echo htmlentities($row['education']);?></td>
										<td><?php
                                        $emptype=mysqli_query($con,"select * from emptype where id=".$row['emptype']." limit 1");
                                        $etype=mysqli_fetch_array($emptype);

										echo htmlentities($etype['emptype']);?></td>
									    <td><?php if($row['joinedon']=='0000-00-00')
										{
										}else {echo htmlentities(date('m-d-Y',strtotime($row['joinedon'])));}?></td>
										<td>
									   
									
									 <?php
										if($row['status']==1)
										 {?>
										 <p class="text-success">Active</p>
										 <?php
										
										 }
										 else 
										 {?>
									 
											<p class="text-danger">Inactive</p>
											<?php
											 
											}
										 ?>
									   
									 </td>
										    
											 <td>
											 
											 <a  href="editEmployee.php?id=<?php echo $row['id'];?>"><i class="fas fa-edit"></i>Edit</a><a  class="text-danger" href="employees.php?id=<?php echo $row['id'];?>&action=1" onClick="return confirm('Are you sure you want  to delete?\nMake sure it will not be recovered once deleted.')"><i class="fas fa-trash-alt"></i>Delete</a></td>
											
                                        
                                    </tr>
                                    <?php
								}
								?>
                                   
                                </tbody>
                                <tfoot>
                                    <tr>
                                           <th>#</th>
                                        <th>Name</th>
										<th>Email</th>
                                        <th>Position</th>
                                        <th>Education</th>
										<th>Type</th>
                                        <th>Joined On</th>
									    <th>Status</th>
										<th>Action</th>
                                        
                                        
                                </tfoot>
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
			
	<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-xl " role="document">
    <div class="modal-content">

      <!-- Modal Header -->
      <div class="modal-header">
        <h4 class="modal-title">New Employee</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <!--Modal body..-->
		
		<div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                 <div class="row">
                    <div class="col-lg-1 d-none d-lg-flex">
                       
                    </div>
                    <div class="col-lg-10">
                        <div class="p-5">
                            <!--<div class="text-center">
                                <h4 class="text-dark mb-4">Create employee</h4>
                            </div>-->
                            <form class="employee" action="createEmployee.php" method="post">
                                <div class="form-group row">
								<div class="col-sm-4">
								<label >First name</label>
                                    <input class="form-control " type="text" id="fname" placeholder="First Name" name="fname" required >
									</div>
									<div class="col-sm-4">
									<label >Middle Initial</label>
                                    <input class="form-control " type="text" id="mname" placeholder="Middle Initial" name="mname" >
									</div>
									
									<div class="col-sm-4">
									<label >Last name</label>
                                    <input class="form-control " type="text" id="lname" placeholder="Last Name" name="lname" required >
									</div>
                                </div>
                            
								<div class="form-group row">
						
							    
									<div class="col-sm-4">
									<label for="roles">Position</label>
									<select class="form-control" name="roles" id="roles" required>
									    <option value="" selected >Select position.....</option>
											<?php
						
						                 $roles=mysqli_query($con,"select * from groups where status=1 ");
										 while ($row=mysqli_fetch_array($roles))
								          {
						                ?>
										<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['group_name']);?></option>
										  <?php } ?>
										
									</select>
									</div>
									
									<div class="col-sm-4">
									<label for="emptype">Employee Time Type</label>
									<select class="form-control" name="emptype" id="emptype" required>
									 <option value="" selected >Select type.....</option>
											<?php
						
						                 $emptype=mysqli_query($con,"select * from emptype where status=1 ");
										 while ($row=mysqli_fetch_array($emptype))
								          {
						                ?>
										<option value="<?php echo htmlentities($row['id']);?>"><?php echo htmlentities($row['emptype']);?></option>
										  <?php } ?>
									</select>
									</div>
                                    <div class="col-sm-4">
									<label >Education</label>
									<input class="form-control" type="text" id="education" placeholder="Education" name="education" required >
									</div>
                                </div>
								<div class="form-group row">
							<div class="col-sm-6">
							       <label >Joined Date</label>
                                    <input class="form-control" type="date" id="joineddate" placeholder="Joined On" name="joineddate" required >
									</div>
									<div class="col-sm-6">
									<label for="status">Status</label>
									<select class="form-control" name="status" id="status" required>
									 <option value="" selected >Select.....</option>
									<option value="1" >Active</option>
									<option value="2" >Inactive</option>
									</select>
									</div>
									
                                </div>
								<div class="form-group row">
							<div class="col-sm-6">
							       <label >Email</label>
                                    <input class="form-control" type="email" id="email" placeholder="Email" name="email" required >
									</div>
									<div class="col-sm-6">
									<label >Password</label>
									<input class="form-control" type="password" id="password" placeholder="Password" name="password" required >
									</div>
									
                                </div>
							
							
										   <button class="btn btn-primary btn-block text-white btn-user" type="submit" name="submit" id="submit">Save Employee</button>
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
					