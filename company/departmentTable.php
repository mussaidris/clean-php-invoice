  
 <div class="container-fluid">
                <h3 class="text-dark mb-4">Departments <span class="float-right">اقسام</span></h3>
                <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row-reverse bg-default">
                <?php   if(in_array("prsett",$permission)) { ?><a href="printDepartment.php" target="_blank"  class="btn btn-primary"> 
  Print طباعة
</a> <?php  } ?>
					 
     
                    </div>
                    <div class="card-body">
                        
						<?php
						
						$dept=mysqli_query($con,"select * from departments ");
						?>
                        <div class="table-responsive mt-2"  role="grid" aria-describedby="dataTable_info">
                            <table class="table table-striped my-0" id="dataTable">
                                <thead>
                                    <tr>
									<th>#</th>
                                        <th>Name اسم</th>
                                        <th>Status الحالة</th>
										<th>Action الإجراء</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								
								while ($row=mysqli_fetch_array($dept))
								{
									?>
                                    <tr>
                                       <td><?php echo htmlentities("DEP00".$row['id']);?></td>
                                        <td><?php echo htmlentities($row['dept_name']);?></td>
                                        <td><?php 
										if($row['status']==0)
										{ ?>
										<p class="text-success">Active  نشط</p>
									    <?php } else { ?>
										<p class="text-danger">Inactive  غير نشط</p>
										<?php } ?>  </td>
											 <td>
											 <?php if(in_array("upsett",$permission))
											 {?>
											 <a href="departments.php?did=<?php echo $row['id'];?>"><i class="fas fa-edit"></i></a>
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
                                        <th>Name اسم</th>
                                        <th>Status الحالة</th>
										<th>Action الإجراء</th>
                                    </tr>  
                                </tfoot>
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
			
	