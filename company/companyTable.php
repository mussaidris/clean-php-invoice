  <br><br><br><br>
 
 <div class="container-fluid">
                <h3 class="text-dark mb-4">Companies<span class="float-right">  الشركات  </span> </h3>
                <div class="card shadow">
                    <div class="card-header py-3 d-flex flex-row-reverse bg-default">
          <?php  if(in_array("crsett",$permission))  { ?><a href="departments.php"   class="btn btn-primary"> 
  Manage Departments إدارة الأقسام
</a> <?php } ?>
					 
     
                    </div>
                    <div class="card-body">
                        
						<?php
						
						$companies=mysqli_query($con,"select * from company ");
						?>
                        <div class="table-responsive mt-2"  role="grid" aria-describedby="dataTable_info">
                            <table class="table table-striped my-0" id="dataTable">
                                <thead>
                                    <tr>
									
                                        <th>Name اسم</th>
                                        <th>CR Number رقم السجل التجاري</th>
                                        <th>Phone هاتف</th>
								
										<th>Email البريد الإلكتروني</th>
										
                                        <th>Address عنوان</th>
                                        
										<th>Action الإجراء</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
								<?php
								
								while ($row=mysqli_fetch_array($companies))
								{
									?>
                                    <tr>
                                       <td><?php echo htmlentities($row['company_name'].' '.$row['arabic_name']);?></td>
                                        <td><?php echo htmlentities($row['cr_no']);?></td>
                                        <td><?php echo htmlentities($row['phone']);?></td>
                                        <td><?php echo htmlentities($row['email']);?></td>
										<td><?php echo htmlentities($row['address'].' '.$row['arabic_address']);?></td>
									    
										    
											 <td>
											 <?php 
											 if(in_array("prsett",$permission))
											 { ?>
											<!-- <a href="print_company.php"><span ><i class="fas fa-print text-dark"></i></span></a>-->
											 <?php }
											 if(in_array("prsett",$permission))
											 {?>
											 <a href="update_company.php?cid=<?php echo $row['id'];?>"><i class="fas fa-edit"></i></a>
											 <?php } ?>
										</td>
                                        
                                    </tr>
                                    <?php
								}
								?>
                                   
                                </tbody>
                               
                            </table>
                        </div>
                       
                    </div>
                </div>
            </div>
           
            
            
			
	