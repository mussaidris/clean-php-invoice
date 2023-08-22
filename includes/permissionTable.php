 <div class="container-fluid">
                <h3 class="text-dark mb-4">Roles Management</h3>
                <div class="card shadow">
                    <div id="buttons" class="card-header py-3 d-flex flex-row-reverse bg-default">
                      <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
  New Role دور جديد
					</button> 
                    </div>
                    <div class="card-body">
                        
						<?php
						
						$roles=mysqli_query($con,"select * from groups  ");
						?>
                        <div class="table-responsive mt-2"  role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable">
                                <thead>
                                    <tr>
									
                                        <th>#</th>
                                        <th>Role</th>
                                         <th>Permissions</th>
										<th>Action</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								
								while ($row=mysqli_fetch_array($roles))
								{
									?>
                                    <tr>
                                       <td><?php echo htmlentities($row['id']);?></td>
                                        <td><?php echo htmlentities($row['group_name']);?></td>
                                          <td><?php 
										  
										  $per=unserialize($row['permission']);
										   $len=count($per);
										  $permit="";
										  for($i=0;$i<$len;$i++)
										  {
											  if($i!=0 && $i%4==0)
											  {
											  $permit.=",".$per[$i]."\n";
											  }
											  else
											  {
												  $permit.=",".$per[$i];
											  }
										  }
										   echo htmlentities($permit);
										   ?>
									
										</td>
											 <td>
											<?php if(in_array("viewOrder",$per))
											{ ?>
											 <a href="editRole.php?id=<?php echo $row['id'];?>"><i class="fas fa-edit"></i>Edit</a>
											<?php } ?>
											 </td>
                                        
                                    </tr>
                                    <?php
								}
								?>
                                   
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>Role</th>
                                         <th>Permissions</th>
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
        <h4 class="modal-title">New Role and permission</h4>
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>

      <!-- Modal body -->
      <div class="modal-body">
        <!--Modal body..-->
		
		<div class="card shadow-lg o-hidden border-0 my-5">
            <div class="card-body p-0">
                <div class="row">
                    <div class="col-lg-2 d-none d-lg-flex">
                       
                    </div>
                    <div class="col-lg-8">
                        <div class="p-5">
                            <div class="text-center">
                                <h4 class="text-dark mb-4">Create role</h4>
                            </div>
                            <form class="role"  method="post">
                               
                                  <div class="form-group">
                  <label for="group_name">Role Name</label>
                  <input type="text" class="form-control" id="group_name" name="group_name" placeholder="Enter role name" required>
                </div>
                <div class="form-group">
                  <label for="permission">Permission</label>

                  <table class="table table-responsive">
                    <thead>
                      <tr>
                        <th></th>
                        <th>Create</th>
                        <th>Update</th>
                        <th>View</th>
                        <th>Delete</th>
						<th>Print</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Employees</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createEmployee" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateEmployee" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewEmployee" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteEmployee" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printEmployee" class="minimal"></td>
                      </tr>
					  <tr>
                        <td>Roles/Permissions</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createRole" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateRole" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewRole" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteRole" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printRole" class="minimal"></td>
                      </tr>
                      <tr>
                        <td>Invoice</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createInvoice" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateInvoice" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewInvoice" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteInvoice" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printInvoice" class="minimal"></td>
                      </tr>
					   <tr>
                        <td>Quotation</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createQuote" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateQuote" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewQuote" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteQuote" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printQuote" class="minimal"></td>
                      </tr>
					
					   <tr>
                        <td>Purchase</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createPurchase" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updatePurchase" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewPurchase" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deletePurchase" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printPurchase" class="minimal"></td>
                      </tr>
					    <tr>
                        <td>Member Notifications</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createNotification" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateNotification" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewNotification" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteNotification" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printNotification" class="minimal"></td>
                      </tr>
					   <tr>
                        <td>Communications</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="sendEmail" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateEmail" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewEmail" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteEmail" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printEmail" class="minimal"></td>
                      </tr>
					   <tr>
					   <td>Expense</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createExpense" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateExpense" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewExpense" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteExpense" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printExpense" class="minimal"></td>
                      </tr>
					     <tr>
					   <td>Income</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createIncome" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateIncome" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewIncome" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteIncome" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printIncome" class="minimal"></td>
                      </tr>
					   <tr>
                        <td>Facility</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createFacility" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateFacility" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewFacility" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteFacility" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printFacility" class="minimal"></td>
                      </tr>
					  <tr>
					   <td>Donations/Contributions</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createDonation" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateDonation" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewDonation" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteDonation" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printDonation" class="minimal"></td>
                      </tr>
					  
					   
					   <td>Employees Time Types</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createEmpTypes" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateEmpTypes" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewEmpTypes" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteEmpTypes" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printEmpTypes" class="minimal"></td>
                      </tr>
					   <tr>
					   <td>Chart of Accounts</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createChartAccounts" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateChartAccounts" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewChartAccounts" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deleteChartAccounts" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printChartAccounts" class="minimal"></td>
                      </tr>
                      <tr>
					   <td>Payment Methods</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="createPaymentMethods" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updatePaymentMethods" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewPaymentMethods" class="minimal"></td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="deletePaymentMethods" class="minimal"></td>
						 <td><input type="checkbox" name="permission[]" id="permission" value="printPaymentMethods" class="minimal"></td>
                      </tr>
                      <tr>
             <td>Reports</td>
                        <td>-</td>
                        <td>-</td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="viewReports" class="minimal"></td>
                        <td>-</td>
             <td><input type="checkbox" name="permission[]" id="permission" value="printReports" class="minimal"></td>
                      </tr>
                      <tr>
                        <td>Company</td>
                        <td> - </td>
                        <td><input type="checkbox" name="permission[]" id="permission" value="updateCompany" class="minimal"></td>
                        <td> - </td>
                        <td> - </td>
                      </tr>
              <tr>
                    </tbody>
                  </table>
                  
                </div>
							
										   
										   
										   <button class="btn btn-primary btn-block text-white btn-user" type="submit" name="submit" id="submit">Save Role</button>
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
					