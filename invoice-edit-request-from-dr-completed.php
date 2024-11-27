
<?php

include('header.php');
include('functions.php');

$user_permission = array(); 
$Labratory_Test = '';
$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
for($i =0; $i <= count($explode_comma_separated); $i++)
{
@array_push($user_permission,$explode_comma_separated[$i]);
}

if ((in_array('5', $user_permission))) {


    $get_referenced_id = explode('*',$_GET['customer_id']);

	$Get_customers_id = $get_referenced_id[0];

	 $Get_transaction_id = $get_referenced_id[1];

	 $Get_invoice_id = $get_referenced_id[2];

	 $Medicine_name  = $get_referenced_id[3];


	$query = "SELECT * FROM customers where id = '$Get_customers_id'  ";
    // mysqli select query
	$results = $mysqli->query($query);
	$Get_Customer_record = $results->fetch_assoc();

	$getID = $Get_invoice_id;

	$query_task_tracker = "SELECT *,m.medicine_name as medname, c.name as cname , t.id as tid, t.status as tstatus,  t.task_tracker_related_id as tidn , t.quantity as tquantity , t.task_tracker_description as tdesc , t.Timestamp as tt , u.name as uname
	  FROM  task_tracker_pharmacy t 
			 JOIN customers c ON c.invoice = t.task_tracker_related_id
			 join invoices i on i.invoice = t.task_tracker_related_id
            Join medicine m ON m.medicine_id = t.medicine_id
			JOIN users  u ON u.id  = t.Sender_id 
			WHERE t.task_tracker_related_id  = '$Get_invoice_id'  ";


    // mysqli select query
	$results_task = $mysqli->query($query_task_tracker);

	$results_tasks = $mysqli->query($query_task_tracker);

	$Get_tasks = $results_task->fetch_assoc();
	@$invoice_type= $Get_tasks['invoice_type'];
	@$invoice_status = $Get_tasks['status'];
	



$invoice_id = $Get_invoice_id;
    
$get_balance = "SELECT *,  b.invoice_type as binv_type , count(b.invoice_id) as counted_b , i.invoice as invoice_right, b.Timestamp as btimestamp
from invoices i
 Join balance_invoices b
ON b.invoice_id = i.invoice
WHERE (b.old_invoice_id = '$Get_invoice_id' and b.invoice_type='Laboratory')
Group by b.invoice_id
ORDER BY i.invoice DESC";
$results = $mysqli->query($get_balance);
$row_fetch = $results->fetch_assoc()


    ?>

		<h1>Edit Invoice (<?php echo "<b title='orginated ID' style='color:red'>".$getID."</b>/<b style='color:green' title='generated id' >".$row_fetch['invoice']."</b>" ?>)</h1>
		<hr>

		<div id="response" class="alert alert-success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="message"></div>
		</div>

		<form method="post" id="update_invoice">
			<input type="hidden" name="action" value="update_invoice_laboratory">
			<input type="hidden" name="update_id_invoice_pharmacy" value="<?php echo $getID; ?>">
			
	   <input type="hidden" name="transaction_id"  id="transaction_id" value="<?php echo  $Get_transaction_id ;?>">
		<input type="hidden" name="get_invoice_id"  id="get_invoice_id" value="<?php echo  $getID ;?>">

			<div class="row">
				 <div class="col-xs-12">
					 <textarea hidden name="custom_email" id="custom_email" class="custom_email_textarea" placeholder="Enter a custom email message here if you wish to override the default invoice type email message."><?php echo $custom_email; ?></textarea> 
					 <textarea hidden class-"form-control" name="invoice_notes" placeholder="Please enter any order notes here."><?php echo $invoice_notes; ?></textarea>

					</div>
			</div>

			<div class="row">
				<div class="col-xs-5">
					<h1>
						<img src="<?php echo COMPANY_LOGO ?>" class="img-responsive">
					</h1>
				</div>
				<div class="col-xs-7 text-right">
					<div class="row">
						<div class="col-xs-6">
							<h1>Receipt</h1>
						</div>
						<!-- <div class="col-xs-3">
							<select name="invoice_type" id="invoice_type" class="form-control">
								<option value="invoice" <?php if($invoice_type === 'invoice'){?>selected<?php } ?>>Invoice</option>
								<option value="quote" <?php if($invoice_type === 'quote'){?>selected<?php } ?>>Quote</option>
								<option value="receipt" <?php if($invoice_type === 'receipt'){?>selected<?php } ?>>Receipt</option>
							</select>
						</div>
						<div class="col-xs-3">
							<select name="invoice_status" id="invoice_status" class="form-control">
								<option value="open" <?php if($invoice_status === 'open'){?>selected<?php } ?>>Open</option>
								<option value="paid" <?php if($invoice_status === 'paid'){?>selected<?php } ?>>Paid</option>
							</select>
						</div> -->
					</div>
					<div class="col-xs-4 no-padding-right">
				<div class="form-group">
					<?PHP $dt = new DateTime(); 
						  $dt->format('d-m-y') ;
							   ?>
					<div class="input-group date" id="invoice_date">
						<label class="input-group-addon"> Invoice Date </label>
						<input width="100" value="<?php echo $dt->format('d-m-Y');  ?>" readonly type="text"
							class="form-control required" name="invoice_date"
							placeholder="<?php echo $dt->format('Y-m-d');  ?>"
							data-date-format="<?php echo DATE_FORMAT ?>" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>

			<div class="col-xs-4">
				<div class="form-group">
					<div class="input-group date" id="invoice_due_date">
						<label class="input-group-addon"> Due Date </label>
						<input width="50"  value="<?php echo $dt->format('d-m-Y');  ?>" readonly type="text"
							class="form-control required" name="invoice_due_date"
							placeholder="<?php //echo $dt->format('Y-m-d');  ?>"
							data-date-format="<?php echo DATE_FORMAT ?>" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>

						<div class="input-group col-xs-4 float-right">
				<span class="input-group-addon">#
					<?php echo INVOICE_PREFIX ?>
				</span>
				<input type="text" name="invoice_id" id="invoice_id" class="form-control required"
					placeholder="Invoice Number" readonly aria-describedby="sizing-addon1" value="<?php getInvoiceId(); ?>">
			</div>

				</div>
			</div>
			<div class="row">
		<div class="col-xs-4">

		</div>
		<div class="col-xs-8 text-right">
			<div class="row">
				<div class="col-xs-6">
					<h2 class="">Select Type:</h2>
				</div>
				<div class="col-xs-3">
					<select name="invoice_type" id="invoice_type" class="form-control">
						<option value="invoice" >Invoice</option>
						<option value="quote">Quote</option>
						<option value="receipt" selected >Receipt</option>
					</select>
				</div>
				<div class="col-xs-3">
					<select name="invoice_status" id="invoice_status" class="form-control">
						<option value="open">Open</option>
						<option value="paid" selected>Paid</option>
					</select>
				</div>
			</div>
			<div class="col-xs-4 no-padding-right">
				<div class="form-group">
					<?PHP $dt = new DateTime(); 
						  $dt->format('d-m-y') ;
							   ?>
					<div class="input-group date" id="invoice_date">
						<label class="input-group-addon"> Invoice Date </label>
						<input width="100" value="<?php echo $dt->format('d-m-Y');  ?>" readonly type="text"
							class="form-control required" name="invoice_date"
							placeholder="<?php echo $dt->format('Y-m-d');  ?>"
							data-date-format="<?php echo DATE_FORMAT ?>" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="col-xs-4">
				<div class="form-group">
					<div class="input-group date" id="invoice_due_date">
						<label class="input-group-addon"> Due Date </label>
						<input width="50"  value="<?php echo $dt->format('d-m-Y');  ?>" readonly type="text"
							class="form-control required" name="invoice_due_date"
							placeholder="<?php //echo $dt->format('Y-m-d');  ?>"
							data-date-format="<?php echo DATE_FORMAT ?>" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="input-group col-xs-4 float-right">
				<span class="input-group-addon">#
					<?php echo INVOICE_PREFIX ?>
				</span>
				<input type="text" name="invoice_id" id="invoice_id" class="form-control required"
					placeholder="Invoice Number" readonly aria-describedby="sizing-addon1" value="<?php getInvoiceId(); ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="float-left">Patient Information</h4>
					<a href="#" hidden class="float-right select-customer"><b>OR</b> Select Existing Patient</a>
					<div class="clear"></div>
				</div>
				
				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required"
									value ="<?php echo $Get_Customer_record['name'];?>"   name="customer_name" id="customer_name" readonly placeholder="Full Name"
									tabindex="1">
							</div>
							<div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required"
									name="customer_town" 	value ="<?php echo $Get_Customer_record['town'];?>"   id="customer_town" readonly placeholder="Town" tabindex="3">
							</div>
							<div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required"
									name="customer_age" 	value ="<?php echo $Get_Customer_record['address_1'];?>"  id="customer_age" readonly placeholder="Age" tabindex="5">
							</div>

							
							<div class="form-group">

								<input type="text" readonly class="form-control margin-bottom copy-input required"
									name="customer_date_of_reg" id="customer_date_of_reg"
									placeholder="Date of Registration"  value ="<?php echo $Get_Customer_record['postcode'];?>"  aria-describedby="sizing-addon1" tabindex="2">
							</div>
							<div class="form-group">
								<input type="text" class="form-control copy-input required" name="customer_company_name"
									id="customer_company_name" placeholder="Company Name" value ="<?php echo $Get_Customer_record['company_name'];?>" readonly tabindex="7">
							</div>

							<div class="form-group no-margin-bottom">
								<input type="text" class="form-control copy-input required" name="customer_sex"
									id="customer_sex" placeholder="Gender"  value ="<?php echo $Get_Customer_record['address_2'];?>" readonly tabindex="7">
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-6 text-right">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Prescribing Physicians's Information</h4>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<input readonly type="text" class="form-control margin-bottom required"
									name="doctor_name" value ="<?php echo $Get_Customer_record['name_ship'];?>" id="doctor_name" placeholder="Physician Name" tabindex="9">
							</div>
							<div class="form-group">
								<input readonly type="email" class="form-control margin-bottom" name="doctor_email"
									id="doctor_email" value ="<?php echo $Get_Customer_record['address_1_ship'];?>" placeholder="Email" tabindex="11">
							</div>
							<div class="form-group no-margin-bottom">
								<input readonly type="text" class="form-control required" name="doctor_title"
									id="doctor_title"  value ="<?php echo $Get_Customer_record['address_2_ship'];?>" placeholder="Title" tabindex="13">
							</div>

							

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
			<!-- / end client details section -->

			<div class="well well-lg">	
	
 
 <!-- <table class="table table-striped table-hover table-bordered" id="med_table" cellspacing="0"><thead><tr>
 <th>Ser.No</th>
<th>Medicine Name</th>
<th>Quanity</th>
<th>Result</th>
<th>Description</th>
</tr></thead><tbody> -->

<?php 
$i=1;
$sum=0;
$query_task_tracker = "SELECT *,m.medicine_name as medname, c.name as cname , t.id as tid, t.status as tstatus,  t.task_tracker_related_id as tidn , t.quantity as tquantity , t.task_tracker_description as tdesc , t.Timestamp as tt , u.name as uname
	  FROM  task_tracker_pharmacy t 
			 JOIN customers c ON c.invoice = t.task_tracker_related_id
            Join medicine m ON m.medicine_id = t.medicine_id
			JOIN users  u ON u.id  = t.Sender_id 
			WHERE t.task_tracker_related_id  = '$Get_invoice_id'  ";



	$results_tasks = $mysqli->query($query_task_tracker);

// while($med = $results_tasks->fetch_assoc()) {
// 	$sum+=$med["tquantity"] * $med["rate"]; 
// 	print '
// 	<tr class="success">
// 	 <td>'.$i.'</td>
//    <td>'.$med["medname"].'</td>
//     <td>'.$med["tquantity"].'</td>
//     <td>'.$med["tquantity"].'*'.$med["rate"].'='.number_format($med["tquantity"] * $med["rate"],2).'</td>
  
//    <td>'.$med["tdesc"].'</td>
//    </tr>';
// $i++;
// }
// print '<tr class="info">    <td colspan="1"> </td> <td > </td> <td > </td>   <td >'.number_format($sum,2).'</td>   <td > </td>            <tr>';
?>
</tbody>
</table>



			
			<table class="table table-bordered" id="invoice_table">
				<thead>
					<tr>
						<th width="500">
							<h4><a href="#" readonly style="display:none"class="btn btn-success btn-xs add-row"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a> Item</h4>
						</th>
						<th>
							<h4>Qty</h4>
						</th>
						<th>
							<h4>Price</h4>
						</th>
						<th width="300">
							<h4>Discount</h4>
						</th>
						<th>
							<h4>Sub Total</h4>
						</th>
					</tr>
				</thead>
				<tbody>
					<?php 
					 $invoice_generated= $row_fetch['invoice'];

						// Connect to the database
						$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

						// output any connection error
						if ($mysqli->connect_error) {
							die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
						}

						// the query
						$query2 = "SELECT * FROM invoice_items WHERE invoice = '" . $mysqli->real_escape_string(trim($invoice_generated)) . "'";

						$result2 = mysqli_query($mysqli, $query2);

						//var_dump($result2);

						// mysqli select query
						if($result2) {
							while ($rows = mysqli_fetch_assoc($result2)) {

								//var_dump($rows);

							    $item_product = $rows['product'];
							    $item_qty = $rows['qty'];
							    $item_price = $rows['price'];
							    $item_discount = $rows['discount'];
							    $item_subtotal = $rows['subtotal'];
					?>
					<tr>
						<td>
							<div class="form-group form-group-sm  no-margin-bottom">
								<!-- <a href="#" class="btn btn-danger btn-xs delete-row"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a> -->
								<input type="text" readonly class="form-control form-group-sm item-input invoice_product" name="invoice_product[]" placeholder="Enter item title and / or description" value="<?php echo $item_product; ?>">
								<!-- <p class="item-select">or <a href="#">Select Procedure</a></p> -->
							</div>
						</td>
						<td class="text-right">
							<div class="form-group form-group-sm no-margin-bottom">
								<input type="text" readonly class="form-control invoice_product_qty calculate" name="invoice_product_qty[]" value="<?php echo $item_qty; ?>">
							</div>
						</td>
						<td class="text-right">
							<div class="input-group input-group-sm  no-margin-bottom">
								<span class="input-group-addon"><?php echo CURRENCY ?> &nbsp;</span>
								<input type="text" readonly class="form-control calculate invoice_product_price required" name="invoice_product_price[]" aria-describedby="sizing-addon1" placeholder="0.00" value="<?php echo $item_price; ?>">
							</div>
						</td>
						<td class="text-right">
							<div class="form-group form-group-sm  no-margin-bottom">
								<input type="text" readonly class="form-control calculate" name="invoice_product_discount[]" placeholder="Enter % or value (ex: 10% or 10.50)" value="<?php echo $item_discount; ?>">
							</div>
						</td>
						<td class="text-right">
							<div class="input-group input-group-sm">
								<span class="input-group-addon"><?php echo CURRENCY ?> &nbsp;</span>
								<input type="text"  class="form-control calculate-sub" name="invoice_product_sub[]" id="invoice_product_sub" aria-describedby="sizing-addon1" value="<?php echo $item_subtotal; ?>" readonly>
							</div>
						</td>
					</tr>
					<?php } } ?>
				</tbody>
			</table>
			<div id="invoice_totals" class="padding-right row text-right">
				<div class="col-xs-6">
					<div class="input-group form-group-sm textarea no-margin-bottom">
					<table class="table table-striped table-hover table-bordered" id="med_table" cellspacing="0"><thead><tr>
					<th>Count</th>
                    <th>Total</th>
                    <th>Paid</th>
                    <th>Balance</th>
                    <th>Invoice File</th>
					<th>Invoice ID</th>
                    <th>Action</th>
</tr></thead><tbody>

<?php 
$invoice_id = $Get_invoice_id;
    
$get_balance = "SELECT *,  b.invoice_type as binv_type , count(b.invoice_id) as counted_b , i.invoice as invoice_right, b.Timestamp as btimestamp
from invoices i
 Join balance_invoices b
ON b.invoice_id = i.invoice 
WHERE (b.old_invoice_id = '$Get_invoice_id' and b.invoice_type='Laboratory')
Group by b.invoice_id
ORDER BY i.invoice ASC ";

// mysqli select query
$results = $mysqli->query($get_balance);
$i=0;
$return_data='';


while ($row = $results->fetch_assoc()) {
	$i++;
if($i==1) {$sts='First Time Payment';}
if($i==2) {$sts='Second Time Payment';}
if($i==3) {$sts='Third Time Payment';}
if($i==4) {$sts='Fourth Time Payment';}
if($i==5) {$sts='Fifth Time Payment';}
if($i==6) {$sts='Sixth Time Payment';}
if($i==7) {$sts='Seventh Time Payment';}
if($i==8) {$sts='Eigteeth Time Payment';}
if($i==9) {$sts='Nineeth Time Payment';}
if($i==10) {$sts='Tenth Time Payment';}
if($i==11) {$sts='Eleventh Time Payment';}
if($i==12) {$sts='Twelveth Time Payment';}
if($i==13) {$sts='Thirteenth Time Payment';}
if($i==14) {$sts='Fourteenth Time Payment';}
if($i==15) {$sts='Fifteenth Time Payment';}


$search = '/';
$replace = '_';
$subject = $row["invoice_right"];

$invoice_number = str_replace($search, $replace, $subject); 

$link =  '<a href="invoices/'.$invoice_number.'.pdf" class="btn btn-success btn-xs" target="_blank">
<span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';

print	"<tr><td><b style='color:blue'>" . $sts. "</b></td>
	 <td>" .number_format($row['total'],2). "</td>
	 <td>" .number_format($row['patient_paid'],2). "</td>
	 <td>" .number_format($row['remained_balance'],2). "</td>
     <td>" .$link. "</td>
	   <td>" .$row['invoice']. "</td>
	 <td>" .$row['btimestamp']. "</td>";


	 
	
}


 $get_balance_ = "SELECT *,  b.invoice_type as binv_type , count(b.invoice_id) as counted_b , 
 i.invoice as invoice_right, b.Timestamp as btimestamp
from invoices i
 Join balance_invoices b
ON b.invoice_id = i.invoice
WHERE ( b.old_invoice_id = '$Get_invoice_id' and b.invoice_type='Laboratory')
Group by b.invoice_id
ORDER BY b.id DESC limit 1 ";

$results_ = $mysqli->query($get_balance_);
$row_= $results_->fetch_assoc();

$ppaying = filter_var($row_['remained_balance'], FILTER_SANITIZE_NUMBER_INT);







// the query
$query = "SELECT p.*, i.*, c.*
			FROM invoice_items p 
			JOIN invoices i ON i.invoice = p.invoice
			JOIN customers c ON c.invoice = i.invoice
			WHERE p.invoice = '" . $mysqli->real_escape_string($invoice_generated) . "'";

$result = mysqli_query($mysqli, $query);

// mysqli select query
if($result) {
	while ($row = mysqli_fetch_assoc($result)) {

		// invoice details
		$invoice_number = $row['invoice']; // invoice number
		$custom_email = $row['custom_email']; // invoice custom email body
		$invoice_date = $row['invoice_date']; // invoice date
		$invoice_due_date = $row['invoice_due_date']; // invoice due date
		$invoice_subtotal = $row['subtotal']; // invoice sub-total
		$invoice_shipping = $row['shipping']; // invoice shipping amount
		$invoice_discount = $row['discount']; // invoice discount
		$invoice_vat = $row['vat']; // invoice vat
		$invoice_total = $row['total']; // invoice total
		$invoice_notes = $row['notes']; // Invoice notes
		$invoice_type = $row['invoice_type']; // Invoice type
		$invoice_status = $row['status']; // Invoice status
	}
}

?>
</tbody>
</table>					</div>
				</div>
				<div class="col-xs-6 no-padding-right">
					<div class="row">
						<div class="col-xs-3 col-xs-offset-6">
							<strong>Sub Total:</strong>
						</div>
						<div class="col-xs-3">
							<?php echo CURRENCY ?> &nbsp;<span class="invoice-sub-total"> <?php echo $invoice_subtotal; ?></span>
							<input type="hidden" name="invoice_subtotal" id="invoice_subtotal" value="<?php echo $invoice_subtotal; ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-3 col-xs-offset-6">
							<strong>Discount:</strong>
						</div>
						<div class="col-xs-3">
							<?php echo CURRENCY ?> &nbsp;<span class="invoice-discount"> <?php echo $invoice_discount; ?></span>
							<input type="hidden" name="invoice_discount" id="invoice_discount" value="<?php echo $invoice_discount; ?>">
						</div>
					</div>
					<div class="row">
				<div class="col-xs-4 col-xs-offset-5">
					<strong class="shipping">Service Charge:</strong>
				</div>
				<div class="col-xs-3">
					<div class="input-group input-group-sm">
						<span class="input-group-addon">
							<?php echo CURRENCY ?> &nbsp;
						</span>
						<input type="text" readonly class="form-control calculate servicecharge" name="servicecharge" aria-describedby="sizing-addon1" placeholder="0.00" value="0.00">
					</div>
				</div>
			</div>
					<?php if (ENABLE_VAT == true) { ?>
					<div class="row">
						<div class="col-xs-3 col-xs-offset-6">
							<strong>TAX/VAT:</strong>
						</div>
						<div class="col-xs-3">
							<?php echo CURRENCY ?> &nbsp;<span class="invoice-vat" data-enable-vat="<?php echo ENABLE_VAT ?>" data-vat-rate="<?php echo VAT_RATE ?>" data-vat-method="<?php echo VAT_INCLUDED ?>"><?php echo $invoice_vat; ?></span>
							<input type="hidden" name="invoice_vat" id="invoice_vat" value="<?php echo $invoice_vat; ?>">
						</div>
					</div>
					<?php } ?>
					<div class="row">
						<div class="col-xs-3 col-xs-offset-6">
							<strong>Total:</strong>
						</div>
						<div class="col-xs-3">
						<!-- <span id="fill_patient" class="btn btn-primary btn-xs add-to-patient-section"><span class="glyphicon glyphicon-star" aria-hidden="true"></span></span>      -->
            <?php echo CURRENCY ?> &nbsp;<span class="invoice-total"> <?php echo $invoice_total; ?></span>
			<input type="hidden" name="invoice_total" id="invoice_total" value="<?php echo $invoice_total; ?>">
						</div>
					</div>

					
<br>
			<div class="row">
				<div class="col-xs-4 col-xs-offset-5">
					<strong class="shipping">Patient Paying Cash<?php echo $ppaying; ?>:</strong>
				</div>
				<div class="col-xs-3">
					<div class="input-group input-group-sm">
						<span class="input-group-addon">
							<?php echo CURRENCY ?> &nbsp;
						</span>
						<input type="number" class="form-control calculate invoice-patient-paying" name="invoice_patient_paying"  aria-describedby="sizing-addon1" placeholder="0.00" width="60%"
						  value="<?php echo $ppaying; ?>" id="invoice_patient_paying_edit" Placeholder="<?php echo $ppaying; ?>">
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-xs-4 col-xs-offset-5">
					<strong>Balance:</strong>
				</div>
				<div class="col-xs-3">
	<?php echo CURRENCY ?> &nbsp;&nbsp;&nbsp;<span id="invoice_balance" class="invoice-balance">0.00</span>
	<input type="hidden" name="limited_price" value="<?php echo   $ppaying;?>"  id="invoice_bala" >
	<input type="hidden" name="unchanged" value="<?php echo   $ppaying;?>"  id="unchanged" >
	<input type="hidden" name="remained_final_balance" id="remained_final_balance" value=""  id="unchanged" >
				</div>
			</div>
            </div>

			</div>
			<div class="row">
				<!-- <div class="col-xs-12 margin-top btn-group">
					<input type="submit" id="action_edit_invoice_Laboratory" class="btn btn-success float-right" value="Create Invoice Balance" data-loading-text="Updating...">
				</div> -->
			</div>
		</form>








		
		<div id="insert" class="modal fade">
		  <div class="modal-dialog">
		    <div class="modal-content">
		      <div class="modal-header">
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
		        <h4 class="modal-title">Select an item</h4>
		      </div>
		      <div class="modal-body">
				<?php popProductsList(); ?>
		      </div>
		      <div class="modal-footer">
		        <button type="button" data-dismiss="modal" class="btn btn-primary" id="selected">Add</button>
				<button type="button" data-dismiss="modal" class="btn">Cancel</button>
		      </div>
		    </div><!-- /.modal-content -->
		  </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->

<?php
}
	include('footer.php');
?>