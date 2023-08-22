  <table id="data-table" class="table table-sm table-bordered table-striped">
        <thead>
          <tr>
            <th>Invoice No. رقم الفاتورة</th>
            <th>Invoice Date التاريخ</th>
            <th>Customer Name اسم العميل</th>
            <th>Invoice Total إجمالي الفاتورة</th>
              
            <th>Paid Amt. مبلغ مدفوع</th>
			<th>Due Amt. مبلغ مستحق</th>
           	<th>Action الإجراء</th>
          </tr>
        </thead>
        <?php
		$result = mysqli_query($con,"
    SELECT order_id,inv_reference,order_date,order_receiver_name,format(order_total_after_tax,2) as order_total_after_tax ,format(paid_amt,2) as paid_amt,format(due_amt,2) as due_amt FROM tbl_order 
    ORDER BY order_id DESC
  ");

 

		
       
          while($row = mysqli_fetch_array($result))
          {
            ?>
              <tr>
                <td><a href="view_invoice.php?invno=<?php  echo $row['inv_reference'] ;?>&id=<?php  echo $row['order_id'] ;?>"><?php  echo "INV00".$row['order_id'] ;?></a></td>
                <td><?php echo $row['order_date'];?></td>
                <td><?php echo $row['order_receiver_name'];?></td>
                <td><b><?php echo $row['order_total_after_tax'];?></b></td>
                	<td><b><?php echo $row['paid_amt'];?></b></td>
				<td><b><?php echo $row['due_amt'];?></b></td>
                <td>
                    <?php if(in_array("prinv",$permission))  {?>
                    <a href="delivery_note.php?reference=<?php echo "INV00".$row['order_id'];?>&ref_type=1&id=<?php echo $row['order_id'];?>" ><span ><i class="fas fa-shipping-fast"></i></span></a>
                    <?php } if(in_array("prinv",$permission))  {?>
				<a href="print_invoice.php?pdf=1&id=<?php echo $row['order_id'];?>" target="_blank"><span ><i class="fas fa-print text-dark"></i></span></a>
				<?php } if(in_array("upinv",$permission))  {?>
                <a href="update_invoice.php?invno=<?php  echo $row['inv_reference'] ;?>&id=<?php echo $row['order_id'];?>"><span ><i class="fas fa-edit"></i></span></a>
                <?php } if(in_array("delinv",$permission))  {?>
                <a href="index.php?delete=1&id=<?php echo $row['order_id'];?>" id="<?php echo $row['order_id'];?>" class="delete " onclick="return confirm('Are you sure you want to remove this? هل أنت متأكد أنك تريد إزالة هذا')"><span ><i class="fas fa-trash text-danger"></i></span></a>
                <?php } ?>
                </td>
              </tr>
            <?php
          }
       
        ?>
      </table>