

<?php


include('header.php');
include('functions.php');

$user_permission = array(); 

$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
for($i =0; $i <= count($explode_comma_separated); $i++)
{
@array_push($user_permission,$explode_comma_separated[$i]);
}

if ((in_array('3', $user_permission))) {

    ?>

<h1>Invoice List</h1>
<hr>

<div class="row">

	<div class="col-xs-12">

		<div id="response" class="alert alert-success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="message"></div>
		</div>
	
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Payment Section</h4>
			</div>
			<div class="panel-body form-group form-group-sm">



   

				</form>
		</div>

				<?php
				$invoice_explode = $_GET['invoice_explode'];
				$explode_invoice = explode("^",$invoice_explode);
				
				 $company_name  = $explode_invoice[0];
				 $Company  = $explode_invoice[0];;
				 $From = $explode_invoice[1];
				 $To = $explode_invoice[2];
				 $Status = $explode_invoice[3];

				
 
 $From_style = $From;
 $To_style =  $To; 



				 if( ($Status == 'open' || $Status == 'paid' ) && $Company != 'All' )
				 {
				 
				 
				 
				 
				 
										 $General_Total=0;
										   
										   $company_name =  $company_name ;
										   $data_table = 'data-table';
					 
				   
						 // the query
						$query = "SELECT  *  FROM invoices i  
							JOIN customers c  ON c.invoice = i.invoice
					
					   WHERE  ( i.invoice = c.invoice and i.invoice_type = 'invoice' )  
						   and   (c.company_name = '$Company') 
						   and    ( i.invoice_date between '$From' and '$To')
						   and (i.status = '$Status')
					   
				 
						   ORDER BY i.invoice DESC ";
						   
						 
				   
				   
					 // mysqli select query
					 $results = $mysqli->query($query);
					 // mysqli select query
					 if($results) {
						   print '
						   <h4><b>  <span style="color:orange;"> '.$From_style.'  -  '.$To_style.' </span> -  </b> <b style="color:red; font-size:25px;width:32px;padding: 5px;border: 2px solid gray;margin: 0;"> '.$Company.' </b>  </h4>
						   <table class="table table-striped table-hover table-bordered" id="'.$data_table.'" cellspacing="0"  class="display" cellspacing="0" width="100%"><thead>
						   <tr>
						   
										   <th>Invoice</th>
										   <th>Patient</th>
										   <th>Issue Date</th>
										   <th>Company Name</th>
										   <th>Type</th>
										   <th>Status</th>
										   <th>Total Sum</th>
				 
										 
										   
									   
						   
										 </tr></thead><tbody>';
										 $invoice_array = array();$array_invoice ='';
										 
										 $concatenated_array = $company_name."^".$From."^".$To."^".$Status;

								   while($row = $results->fetch_assoc()) {
									@array_push($invoice_array,$row["invoice"]);
									 $Total_sum = 0;
									 $inv = $row["invoice"];
									 $check_quantity = "select *,(qty * price) as p  from invoice_items where invoice = '$inv'  ";
									 $quantity_price = $mysqli->query( $check_quantity);
									 while($mow = $quantity_price->fetch_assoc()) {
									   $Total_sum += $mow['p'];
									 }
									 
								   $search = '/';
								   $replace = '_';
								   $subject = $row["invoice"];
						   
								   $invoice_number = str_replace($search, $replace, $subject);
						   
								   $date=date_create($row["invoice_date"]);
								   $date_invoice  = date_format($date,"d-m-Y");
						   
								   $date=date_create($row["invoice_date"]);
								   $date_due  = date_format($date,"d-m-Y");
						   
						   
									   print '
										   <tr>
											   <td>'.$row["invoice"].'</td>
											   <td>'.$row["name"].'</td>
											   <td>'.$date_invoice .'</td>
											   <td>'.$row["company_name"].'</td>
											   <td>'.$row["invoice_type"].'</td>
											';
						   
										   if($row['status'] == "open"){
											   print '<td><span class="label label-primary">'.$row['status'].'</span></td>';
										   } elseif ($row['status'] == "paid"){
											   print '<td><span class="label label-success">'.$row['status'].'</span></td>';
										   }
				 
										   print '<td><b>'.number_format($Total_sum)."&nbsp;".'</b></td>';
										
										   $user_permission = array(); 
										   $explode_comma_separated = explode(",", $_SESSION['User_Permission']);
										   
										   for($i =0; $i <= count($explode_comma_separated); $i++)
										   {
										   @array_push($user_permission,$explode_comma_separated[$i]);
										   }
						   
									   
									   
						   
								   
										   $General_Total += $Total_sum;
										   $array_invoice .= "^".$row["invoice"]; 
								   }
								   
								   print '</tr>
								   
								   
								   
								   
								   <tr>
          
								   <th >Total Sum </th>
								   <th></th>
								   <th></th>
								   <th></th>
								   <th></th>
								   <th></th>
								   <th> '.number_format($General_Total)."&nbsp;".CURRENCY.' ';
								  
								  if($General_Total >0 && $Status == 'open'){ 
									 print '
								  
									 <div class="input-group col-xs-4 float-right"> 
								 
									 <a href="proceed_payments.php?invoices='.$array_invoice.'" class="btn btn-success btn-sm">
									 <span class="glyphicon glyphicon-edit" aria-hidden="true">Confirm Payments</span></a>
				 
									</div> <br><br>';}
									
								   
								 print ' </th> </tr>  </tbody></table>
								 
								 <a href="print_payment.php?invoices='.$Company."^".$From."^".$To."^".$Status.'" type="button" class="btn btn-primary btn-md">
									 <span class="glyphicon glyphicon-print   " aria-hidden="true">Print</span></a>
								 
								 
								 ';
						   
							   } else {
						   
								   echo "<p>There are no invoices to display.</p>";
								   
						   
							   }
				   
				   
				   
						
				 
				 
				 // Frees the memory associated with a result
				 @$results->free();
				 
				 // close connection 
				 @$mysqli->close();
				 
				 }
				
				
				?>
			</div>
		</div>
	</div>
<div>

<div id="delete_invoice" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Invoice</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this invoice?</p>
      </div>
      <div class="modal-footer">

        <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>

		
		<button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<?php
    include('footer.php');
}
else
{

  echo "
  <script>
      setTimeout(function() {
          window.location = 'authentication_error_page.php';
      }, 1);
  </script>
";

}
?>