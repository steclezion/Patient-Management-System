<?php


include_once("includes/config.php");


//get getReceipts


// get invoice list
function getReceipts() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
		die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
    $query = "SELECT  *  
		FROM invoices i
		JOIN customers c
		ON c.invoice = i.invoice
		WHERE i.invoice = c.invoice and  i.invoice_type = 'receipt' 

		ORDER BY i.invoice DESC ";

	// mysqli select query
	$results = $mysqli->query($query);



	// mysqli select query
	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table" cellspacing="0"><thead><tr>

				<th>Invoice</th>
				<th>Patient</th>
				<th>Issue Date</th>
				<th>Due Date</th>
				<th>Type</th>
				<th>Status</th>
				<th>Actions</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

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
				    <td>'.$date_due .'</td>
				    <td>'.$row["invoice_type"].'</td>
				';

				if($row['status'] == "open"){
					print '<td><span class="label label-primary">'.$row['status'].'</span></td>';
				} elseif ($row['status'] == "paid"){
					print '<td><span class="label label-success">'.$row['status'].'</span></td>';
				}
				$user_permission = array(); 
				$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
				
				for($i =0; $i <= count($explode_comma_separated); $i++)
				{
				@array_push($user_permission,$explode_comma_separated[$i]);
				}

			print
			
			'<td>
					
			        <a style="display:none" href="invoice-edit.php?id='.$row["invoice"].'" class="btn btn-primary btn-xs" style="display:none">
					<span hidden class="glyphicon glyphicon-edit" style="display:none" aria-hidden="true"></span></a>

					<a style="display:none" href="#" hidden data-invoice-id="'.$row['invoice'].'" data-email="'.$row['email'].'" data-invoice-type="'.$row['invoice_type'].'" data-custom-email="'.$row['custom_email'].'" class="btn btn-success btn-xs email-invoice">
					<span  style="display:none" class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a> 
			';
			
			if ((in_array('4', $user_permission))) {
				
				print '<a href="invoices/'.$invoice_number.'.pdf" class="btn btn-info btn-xs" target="_blank">
					<span class="glyphicon glyphicon-upload" aria-hidden="true"></span></a>';
					
}
if ((in_array('17', $user_permission))) {
    print '&nbsp; <a data-invoice-id="'.$row['invoice'].'" class="btn btn-danger btn-xs delete-invoice">
				    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
}
			'</td>
			    </tr>
			';

		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no invoices to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();

}





// get invoice list
function getInvoices() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
		die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
    $query = "SELECT  *  
		FROM invoices i
		JOIN customers c
		ON c.invoice = i.invoice
		WHERE i.invoice = c.invoice and i.invoice_type = 'invoice'
		ORDER BY i.invoice DESC ";

	// mysqli select query
	$results = $mysqli->query($query);



	// mysqli select query
	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table" cellspacing="0"  class="display" cellspacing="0" width="100%"><thead><tr>

				<th>Invoice</th>
				<th>Patient</th>
				<th>Issue Date</th>
				<th>Due Date</th>
				<th>Type</th>
				<th>Status</th>
				<th>Company Name</th>

				<th>Actions</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

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
				    <td>'.$date_due .'</td>
				    <td>'.$row["invoice_type"].'</td>
					
				';

				if($row['status'] == "open"){
					print '<td><span class="label label-primary">'.$row['status'].'</span></td>';
				} elseif ($row['status'] == "paid"){
					print '<td><span class="label label-success">'.$row['status'].'</span></td>';
				}
				print '<td>'.$row["company_name"].'</td>';
				$user_permission = array(); 
				$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
				
				for($i =0; $i <= count($explode_comma_separated); $i++)
				{
				@array_push($user_permission,$explode_comma_separated[$i]);
				}

			print
			
			'<td>
		        	<a href="invoice-edit.php?id='.$row["invoice"].'" class="btn btn-primary btn-xs">
					<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
					
			        <a style="display:none" href="invoice-edit.php?id='.$row["invoice"].'" class="btn btn-primary btn-xs" style="display:none">
					<span hidden class="glyphicon glyphicon-edit" style="display:none" aria-hidden="true"></span></a>

					<a style="display:none" href="#" hidden data-invoice-id="'.$row['invoice'].'" data-email="'.$row['email'].'" data-invoice-type="'.$row['invoice_type'].'" data-custom-email="'.$row['custom_email'].'" class="btn btn-success btn-xs email-invoice">
					<span  style="display:none" class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a> 
			';
			
			if ((in_array('4', $user_permission))) {
				
				print '<a href="invoices/'.$invoice_number.'.pdf" class="btn btn-info btn-xs" target="_blank">
					<span class="glyphicon glyphicon-upload" aria-hidden="true"></span></a>';
					
}
if ((in_array('17', $user_permission))) {
    print '&nbsp; <a data-invoice-id="'.$row['invoice'].'" class="btn btn-danger btn-xs delete-invoice">
				    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
}
			'</td>
			    </tr>
			';

		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no invoices to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();

}



//getInvoices_from_DR_for_Lab

function getInvoices_from_DR_for_Lab()
{

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
		die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
	}


	$Today = date('y/m/d');
	$new = date('Y', strtotime($Today));
    $currentDate = date('Y-d-m');
	$Labratory_Test  = '';

	// the query
	$query  = "	SELECT *,  invoices.invoice as inv, task_tracker.Timestamp as tam,    customers.id as cid, customers.name as cname,  task_tracker.id as transaction_id  FROM 
    invoices JOIN task_tracker 
	ON  invoices.invoice = task_tracker.task_tracker_related_id 
	JOIN customers 
	ON customers.invoice  = task_tracker.task_tracker_related_id 
	LEFT JOIN labaratory_test
	ON labaratory_test.invoice  = task_tracker.cashier_task_invoice_id 
    ORDER BY task_tracker.Timestamp ASC";





	// mysqli select query
	$results = $mysqli->query($query);

	// mysqli select query
	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table" cellspacing="0"><thead><tr>

		        <th width="10%">Transaction ID</th>		
		        <th>Invoice</th>
				<th>Patient</th>
				<th>Sender </th>
				<th>Task Name</th>
				<th>Requested Tests</th>
				<th>Requested Date</th>
				<th>Status</th>
            	<th>Actions</th>
                </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		$search = '/';
		$replace = '_';
		$subject = $row["inv"];

		$Sender_id   = $row['Sender_id'];


		$dr_name = "SELECT * from users  where id  = $Sender_id   ";	 $results_dr = $mysqli->query($dr_name); $results_dr_name = $results_dr->fetch_assoc();


		@$Get_main_task = explode(',',$row['main_task']);
	
		if($Get_main_task[0] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= '<b> GENERAL TEST- </b>[<i style="color:orange">'.$row['Test_Type'].'&nbsp;</i> ]<br>';}
		if(@$Get_main_task[1] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= '<b> LIPID-&nbsp;</b>';}
		if(@$Get_main_task[2] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= '<b> LIVER- &nbsp;</b>';}
		if(@$Get_main_task[3] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= '<b> RENAL- &nbsp;</b>';}


		$invoice_number = str_replace($search, $replace, $subject);

			print '
				<tr>
				    <td>'.$row["transaction_id"].'</td>
					<td>'.$row["inv"].'</td>
					<td>'.$row["cname"].'</td>
				    <td>'.$results_dr_name ['name'].'</td>
				    <td>'.$row["task_tracker_name"].'</td>
					<td>'.$Labratory_Test.'</td>
			
					<td><span class="label label-primary">'.$row["tam"].'</span></td>';
					;
					if($row['status'] == "requested"){
						print '<td><span class="label label-primary">'.$row['status'].'</span></td>';
					} elseif ($row['status'] == "Payment Finishied"){
						print '<td><span class="label label-success">'.$row['status'].'</span></td>';
					}

				

				$user_permission = array(); 
				$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
				
				for($i =0; $i <= count($explode_comma_separated); $i++)
				{
				@array_push($user_permission,$explode_comma_separated[$i]);
				}

	
		 if( $_SESSION['user_type'] == 'Labaratory' || $_SESSION['user_type'] == 'Admin' ) {
            //  print '<td> 
			//  &nbsp; <a data-invoice-id="'.$row['invoice'].'" class="btn btn-warning  btn-xs ">
			// 	    <span class="glyphicon glyphicon-edit" aria-hidden="true"> Process Payment</span></a></td>';


			if($row['status'] == "requested")
			{
	print '<td>
	
	
	<span class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-check" aria-hidden="true"> Waiting </span>

	&nbsp;</td>'; 
			}
			else if($row['status'] == "Payment Finishied" &&   $row['notify_to_dr'] == 0 )
			{

				$Today = date('y/m/d');
	$new = date('Y', strtotime($Today));
    $currentDate = date('Y-d-m');

	@$Get_main_task = explode(',',$row['main_task']);
	
	
		if(@$Get_main_task[1] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= ' LIPID&nbsp';}
		if(@$Get_main_task[2] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= 'LIVER- &nbsp';}
		if(@$Get_main_task[3] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= ' RENAL- &nbsp';}



				print '<td>
	
			<a data-invoice-id="'.$row['transaction_id'].'"  
			data-invoice-di="'.$row['cashier_task_invoice_id'].'" 
			data-hematology="'.$Get_main_task[0].'" 
			data-lipid="'.$Get_main_task[1].'" 
			data-liver="'.$Get_main_task[2].'" 
			data-renal="'.$Get_main_task[3].'" 

			data-pname="'.$row['name'].'" 
			data-page="'.$row['address_1'].'" 
			data-gender="'.$row['address_2'].'" 
			data-ptest_date="'.$currentDate.'" 
			data-prefred_by="'.'Dr '.$row['name_ship'].'"
			
			
			data-hematology_status="'.$row['hematology_status'].'" 
			data-liver_status="'.$row['liver_status'].'" 
			data-renal_status="'.$row['renal_status'].'" 
			data-lipid_status="'.$row['lipid_status'].'" 

			
			data-lipid_generated_file_path="'.$row['lipid_generated_file_path'].'" 
			data-tchol="'.$row['tchol'].'" 
			data-tg = "'.$row['tg'].'" 
			data-hdlc="'.$row['hdlc'].'" 
			data-ldlc="'.$row['ldlc'].'" 


			data-total_protien ="'.$row['total_protien'].'" 
			data-alb= "'.$row['alb'].'" 
			data-ggt="'.$row['ggt'].'" 
			data-ast="'.$row['ast'].'" 
			data-tbil="'.$row['tbil'].'" 
			data-dbil="'.$row['dbil'].'" 
			data-alp="'.$row['alp'].'" 
			data-liver_generated_file="'.$row['liver_generated_file'].'" 


			data-uric_acid="'.$row['uric_acid'].'" 
			data-creatinine="'.$row['creatinine'].'" 
			data-urea="'.$row['urea'].'" 
			data-renal_generated_file="'.$row['renal_generated_file'].'" 


			data-hgh="'.$row['Hgh'].'" 
			data-bf_malaria="'.$row['bf_malaria'].'" 
			data-TWBC ="'.$row['twbc'].'" 
			data-diff="'.$row['diff_count'].'" 
			data-vdrl="'.$row['vdrl'].'" 
			data-widal="'.$row['widal'].'" 
			data-others_hematology="'.$row['others_hematology'].'" 
			data-reaction_color="'.$row['reaction_urine'].'" 
			data-urine_Albumin="'.$row['albumin'].'" 
			data-urine_sugar="'.$row['sugar'].'" 
			data-urine_acetone="'.$row['acetone'].'" 
			data-urine_bile_pigment="'.$row['bile_pigment'].'" 
			data-pus_Cell_microsocopy="'.$row['pus_cell_microsopy'].'"
			data-RBC ="'.$row['RBC'].'"  
			data-crystal ="'.$row['crystall'].'" 
			data-EPC="'.$row['EPC'].'" 
			data-ova ="'.$row['Ova'].'" 
			data-others="'.$row['other_microscopy'].'" 
			data-RBS="'.$row['RBS'].'" 
			data-ERS="'.$row['ERS'].'" 
			data-Morphology="'.$row['Morphology'].'" 
			data-HCG ="'.$row['HCG'].'" 
			data-H_pylori="'.$row['H_Pylori'].'" 
			data-Brucella_Test="'.$row['Brucella_test'].'" 
			data-HGB="'.$row['Hgb'].'" 
			data-color_stool="'.$row['color'].'" 
			data-Consist ="'.$row['consist'].'" 
			data-reaction ="'.$row['reaction'].'" 
			data-Reaction="'.$row['renal_generated_file'].'" 
			data-mucus="'.$row['mucus'].'" 
			data-Blood= "'.$row['blood'].'" 
            data-worms="'.$row['worms'].'" 
            data-Pus_Cells_direct_microscopy ="'.$row['pus_cells_direct_microscopy'].'" 
			data-RBCS ="'.$row['RBCS'].'" 
			data-o_p="'.$row['O_P'].'" 
           data-general_test="'.$row['Test_Type'].'"  

		   data-HIV="'.$row['HIV'].'"  
		   data-HBV="'.$row['HBV'].'"  
		   data-HCV="'.$row['HCV'].'"  
		   data-FBS="'.$row['FBS'].'"  

			data-hematology_generated_file_path="'.$row['hematology_generated_file_path'].'" 
			data-Sender_id = "'.$row['Sender_id'].'" 
            class="btn btn-warning btn-xs lab_request_from_dr">
			
			<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>Proceed Test</a>';
            '</td>';

				
			}


			else if($row['status'] == "Payment Finishied" &&   $row['notify_to_dr'] == 1 )
			{

				$Today = date('y/m/d');
	$new = date('Y', strtotime($Today));
    $currentDate = date('Y-d-m');

				print '<td>
	
			<a data-invoice-id="'.$row['transaction_id'].'"  
			data-invoice-di="'.$row['cashier_task_invoice_id'].'" 
			data-hematology="'.$Get_main_task[0].'" 
			data-lipid="'.$Get_main_task[1].'" 
			data-liver="'.$Get_main_task[2].'" 
			data-renal="'.$Get_main_task[3].'" 

			data-pname="'.$row['name'].'" 
			data-page="'.$row['address_1'].'" 
			data-gender="'.$row['address_2'].'" 
			data-ptest_date="'.$currentDate.'" 
			data-prefred_by="'.'Dr '.$row['name_ship'].'"
			
			
			data-hematology_status="'.$row['hematology_status'].'" 
			data-liver_status="'.$row['liver_status'].'" 
			data-renal_status="'.$row['renal_status'].'" 
			data-lipid_status="'.$row['lipid_status'].'" 

			
			data-lipid_generated_file_path="'.$row['lipid_generated_file_path'].'" 
			data-tchol="'.$row['tchol'].'" 
			data-tg = "'.$row['tg'].'" 
			data-hdlc="'.$row['hdlc'].'" 
			data-ldlc="'.$row['ldlc'].'" 


			data-total_protien ="'.$row['total_protien'].'" 
			data-alb= "'.$row['alb'].'" 
			data-ggt="'.$row['ggt'].'" 
			data-ast="'.$row['ast'].'" 
			data-tbil="'.$row['tbil'].'" 
			data-dbil="'.$row['dbil'].'" 
			data-alp="'.$row['alp'].'" 
			data-liver_generated_file="'.$row['liver_generated_file'].'" 


			data-uric_acid="'.$row['uric_acid'].'" 
			data-creatinine="'.$row['creatinine'].'" 
			data-urea="'.$row['urea'].'" 
			data-renal_generated_file="'.$row['renal_generated_file'].'" 


			data-hgh="'.$row['Hgh'].'" 
			data-bf_malaria="'.$row['bf_malaria'].'" 
			data-TWBC ="'.$row['twbc'].'" 
			data-diff="'.$row['diff_count'].'" 
			data-vdrl="'.$row['vdrl'].'" 
			data-widal="'.$row['widal'].'" 
			data-others_hematology="'.$row['others_hematology'].'" 
			data-reaction_color="'.$row['reaction_urine'].'" 
			data-urine_Albumin="'.$row['albumin'].'" 
			data-urine_sugar="'.$row['sugar'].'" 
			data-urine_acetone="'.$row['acetone'].'" 
			data-urine_bile_pigment="'.$row['bile_pigment'].'" 
			data-pus_Cell_microsocopy="'.$row['pus_cell_microsopy'].'"
			data-RBC ="'.$row['RBC'].'"  
			data-crystal ="'.$row['crystall'].'" 
			data-EPC="'.$row['EPC'].'" 
			data-ova ="'.$row['Ova'].'" 
			data-others="'.$row['other_microscopy'].'" 
			data-RBS="'.$row['RBS'].'" 
			data-ERS="'.$row['ERS'].'" 
			data-Morphology="'.$row['Morphology'].'" 
			data-HCG ="'.$row['HCG'].'" 
			data-H_pylori="'.$row['H_Pylori'].'" 
			data-Brucella_Test="'.$row['Brucella_test'].'" 
			data-HGB="'.$row['Hgb'].'" 
			data-color_stool="'.$row['color'].'" 
			data-reaction ="'.$row['reaction'].'" 
			data-Reaction="'.$row['renal_generated_file'].'" 
			data-mucus="'.$row['mucus'].'" 
			data-Blood= "'.$row['blood'].'" 
            data-worms="'.$row['worms'].'" 
            data-Pus_Cells_direct_microscopy ="'.$row['pus_cells_direct_microscopy'].'" 
			data-RBCS ="'.$row['RBCS'].'" 
			data-o_p="'.$row['O_P'].'" 

			data-hematology_generated_file_path="'.$row['hematology_generated_file_path'].'" 
            class="btn btn-success btn-xs lab_request_from_dr_done">
				<span class="glyphicon glyphicon-check" aria-hidden="true"></span>Done</a>';

				'</td>';

				
			}


}
        
			    '</tr>
			';
			$Labratory_Test ='';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no invoices to display.</p>";

	}

	// Frees the memory associated with a result
	@$results->free();

	// close connection 
	@$mysqli->close();


}




function getInvoice_pending()

{




// Connect to the database
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// output any connection error
if ($mysqli->connect_error) {
	die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
}


	 $Today = date('y/m/d'); 
	 $new = date('Y', strtotime($Today));

	 $date = new DateTime(); // For today/now, don't pass an arg.
	 $date->modify("-10 day");
	 
	  $prev_date= $date->format("Y-m-d") ;
	  $current_date =  $currentDate = date('Y-m-d');



// the query
//    $query = "SELECT  *  
// 	FROM invoices i
// 	JOIN customers c
// 	ON c.invoice = i.invoice
// 	WHERE i.invoice = c.invoice
// 	and 
// 	i.assigned_lab_technicians != 0
// 	ORDER BY i.invoice_date DESC limit 10 ";



$query = "SELECT  *  , i.status as invstat , t.status as tstatus
FROM invoices i
JOIN customers c
ON c.invoice = i.invoice left JOIN task_tracker t ON c.invoice  = t.task_tracker_related_id 

WHERE (i.invoice = c.invoice and  i.assigned_lab_technicians = 0

and 
i.invoice_registration = 'new'
)

ORDER BY i.invoice DESC ";











// mysqli select query
$results = $mysqli->query($query);

// mysqli select query
if($results) {

	print '<table class="table table-striped table-hover table-bordered" id="data-table" cellspacing="0"><thead><tr>

			<th>Invoice</th>
			<th>Patient</th>
			<th>Issue Date</th>
			<th>Type</th>
			<!--<th>cashier status</th> -->
			
			<th>Status</th>
			<th>Actions</th>

		  </tr></thead><tbody>';

	while($row = $results->fetch_assoc()) {


		if($row['tstatus'] == "requested" && $row['Lab_status'] == 0 ){
			$style = "style='background-color:'";
		
		} elseif ($row['tstatus'] == "Payment Finishied" && $row['Lab_status'] == 1 ){
			
			$style = "style='background-color: ";
		}

	 elseif ($row['tstatus'] == "Payment Finishied" && $row['Lab_status'] == 0 ){
			
		$style = "style='background-color: '";
	}


	$search = '/';
	$replace = '_';
	$subject = $row["invoice"];

	$invoice_number = str_replace($search, $replace, $subject);

		print '
			<tr '.@$style.'>
				<td>'.$row["invoice"].'</td>
				<td>'.$row["name"].'</td>
				<td>'.$row["invoice_date"].'</td>
				<td>'.$row["invoice_type"].'</td>
			 <!-- <td>'.$row["invoice_due_date"].'</td> -->
			   
			';

			if($row['invstat'] == "open"){
				print '<td><span class="label label-primary">'.$row['invstat'].'</span></td>';
			} elseif ($row['invstat'] == "paid"){
				print '<td><span class="label label-success">'.$row['invstat'].'</span></td>';
			}
			$user_permission = array(); 
			$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
			
			for($i =0; $i <= count($explode_comma_separated); $i++)
			{
			@array_push($user_permission,$explode_comma_separated[$i]);
			}

		print
		
		'<td>
				
				<a style="display:none" href="invoice-edit.php?id='.$row["invoice"].'" class="btn btn-primary btn-xs" style="display:none">
				<span hidden class="glyphicon glyphicon-edit" style="display:none" aria-hidden="true"></span></a>

				<a style="display:none" href="#" hidden data-invoice-id="'.$row['invoice'].'" data-email="'.$row['email'].'" data-invoice-type="'.$row['invoice_type'].'" data-custom-email="'.$row['custom_email'].'" class="btn btn-success btn-xs email-invoice">
				<span  style="display:none" class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a> 
		';
		
		if ((in_array('4', $user_permission))) {
			
			print '<a href="invoices/'.$invoice_number.'.pdf" class="btn btn-info btn-xs" target="_blank">
				<span class="glyphicon glyphicon-download-alt" aria-hidden="true">Receipts</span></a>';

				print '&nbsp; <a data-invoice-id="'.$row['invoice'].'" class="btn btn-success btn-xs lab_inquiries_posted_list">
				<span class="glyphicon glyphicon-upload" aria-hidden="true"></span>Lab Inquiry</a>';
				
}
// if ((in_array('17', $user_permission))) {
// print '&nbsp; <a data-invoice-id="'.$row['invoice'].'" class="btn btn-danger btn-xs delete-invoice">
// 				<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
// }
		'</td>
			</tr>
		';

	}

	print '</tr></tbody></table>';

} else {

	echo "<p>There are no invoices to display.</p>";

}

// Frees the memory associated with a result
@$results->free();

// close connection 
@$mysqli->close();













}














// getInvoices_from_DR

function  getInvoices_from_DR()
{

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
		die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
	}


	$Today = date('y/m/d');
	$new = date('Y', strtotime($Today));
    $currentDate = date('Y-d-m');
	$Labratory_Test  = '';

	// the query
	$query  = "	SELECT *,  task_tracker.Timestamp as tam,    customers.id as cid, customers.name as cname,  task_tracker.id as transaction_id  FROM 
    invoices JOIN task_tracker 
	ON  invoices.invoice = task_tracker.task_tracker_related_id 
	JOIN customers 
	ON customers.invoice  = task_tracker.task_tracker_related_id 
    ORDER BY task_tracker.Timestamp ASC";





	// mysqli select query
	$results = $mysqli->query($query);

	// mysqli select query
	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table" cellspacing="0"><thead><tr>

		        <th width="10%">Transaction ID</th>		
		        <th>Invoice</th>
				<th>Patient</th>
				<th>Sender </th>
				<th>Task Name</th>
				<th>Requested Tests</th>
				<th>Requested Date</th>
				<th>Status</th>
				
				<th>Actions</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		$search = '/';
		$replace = '_';
		$subject = $row["invoice"];
        $Sender_id   = $row['Sender_id'];


		$dr_name = "SELECT * from users  where id  = $Sender_id   ";	 $results_dr = $mysqli->query($dr_name); $results_dr_name = $results_dr->fetch_assoc();


		@$Get_main_task = explode(',',$row['main_task']);
	
		if($Get_main_task[0] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= '<b> GENERAL TEST- </b>[<i style="color:orange">'.$row['Test_Type'].'&nbsp;</i> ]<br>';}
		if(@$Get_main_task[1] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= '<b> LIPID-&nbsp;</b>';}
		if(@$Get_main_task[2] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= '<b> LIVER- &nbsp;</b>';}
		if(@$Get_main_task[3] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= '<b> RENAL- &nbsp;</b>';}


		$invoice_number = str_replace($search, $replace, $subject);

			print '
				<tr>
				    <td>'.$row["transaction_id"].'</td>
					<td>'.$row["invoice"].'</td>
					<td>'.$row["cname"].'</td>
				    <td>'.$results_dr_name ['name'].'</td>
				    <td>'.$row["task_tracker_name"].'</td>
					<td>'.$Labratory_Test.'</td>
			
					<td><span class="label label-primary">'.$row["tam"].'</span></td>';
					;
					if($row['status'] == "requested"){
						print '<td><span class="label label-primary">'.$row['status'].'</span></td>';
					} elseif ($row['status'] == "Payment Finishied"){
						print '<td><span class="label label-success">'.$row['status'].'</span></td>';
					}

				

				$user_permission = array(); 
				$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
				
				for($i =0; $i <= count($explode_comma_separated); $i++)
				{
				@array_push($user_permission,$explode_comma_separated[$i]);
				}

	
if ((in_array('17', $user_permission))) {
            //  print '<td> 
			//  &nbsp; <a data-invoice-id="'.$row['invoice'].'" class="btn btn-warning  btn-xs ">
			// 	    <span class="glyphicon glyphicon-edit" aria-hidden="true"> Process Payment</span></a></td>';


			if($row['status'] == "requested")
			{
	print '<td>
	
	<a type="hidden" href="invoice-create_from_request.php?customer_id='.$row["cid"].'*'.$row["transaction_id"].'*'.$row["invoice"].'" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true">Process Payment</span></a>
	
	
	&nbsp;</td>'; 
			}
			else if($row['status'] == "Payment Finishied")
			{
				print '<td>
	
			<span class="btn btn-success btn-xs"><span class="glyphicon glyphicon-check" aria-hidden="true"> Done </span>
				
				
				&nbsp;</td>';

				
			}
}
        
			    '</tr>
			';
			$Labratory_Test ='';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no invoices to display.</p>";

	}

	// Frees the memory associated with a result
	@$results->free();

	// close connection 
	@$mysqli->close();



}


// get invoice list
function getInvoice_Today() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
		die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
	}


	$Today = date('y/m/d');
	$new = date('Y', strtotime($Today));
     $currentDate = date('Y-m-d');

	// the query
       $query = "SELECT  *  , i.status as invstat
		FROM invoices i
		JOIN customers c
		ON c.invoice = i.invoice

		left JOIN task_tracker t
	ON c.invoice  = t.task_tracker_related_id 

		WHERE i.invoice = c.invoice
		and 
		(i.invoice_date = '$currentDate'
        and 
		i.assigned_lab_technicians = 0
		and 
		i.invoice_registration = 'new'
		
		
		)

		ORDER BY i.invoice DESC ";

	// mysqli select query
	$results = $mysqli->query($query);

	// mysqli select query
	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table" cellspacing="0"><thead><tr>

				<th>Invoice</th>
				<th>Patient</th>
				<th>Issue Date</th>
				<th>Due Date</th>
				<th>Type</th>
				<th>Status</th>
				<th>Actions</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		$search = '/';
		$replace = '_';
		$subject = $row["invoice"];

		$invoice_number = str_replace($search, $replace, $subject);

			print '
				<tr>
					<td>'.$row["invoice"].'</td>
					<td>'.$row["name"].'</td>
				    <td>'.$row["invoice_date"].'</td>
				    <td>'.$row["invoice_due_date"].'</td>
				    <td>'.$row["invoice_type"].'</td>
				';

				if($row['invstat'] == "open"){
					print '<td><span class="label label-primary">'.$row['invstat'].'</span></td>';
				} elseif ($row['invstat'] == "paid"){
					print '<td><span class="label label-success">'.$row['invstat'].'</span></td>';
				}
				$user_permission = array(); 
				$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
				
				for($i =0; $i <= count($explode_comma_separated); $i++)
				{
				@array_push($user_permission,$explode_comma_separated[$i]);
				}

			print
			
			'<td>
					
			        <a style="display:none" href="invoice-edit.php?id='.$row["invoice"].'" class="btn btn-primary btn-xs" style="display:none">
					<span hidden class="glyphicon glyphicon-edit" style="display:none" aria-hidden="true"></span></a>

					<a style="display:none" href="#" hidden data-invoice-id="'.$row['invoice'].'" data-email="'.$row['email'].'" data-invoice-type="'.$row['invoice_type'].'" data-custom-email="'.$row['custom_email'].'" class="btn btn-success btn-xs email-invoice">
					<span  style="display:none" class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a> 
			';
			
			if ((in_array('4', $user_permission))) {
				
				print '<a href="invoices/'.$invoice_number.'.pdf" class="btn btn-info btn-xs" target="_blank">
					<span class="glyphicon glyphicon-download-alt" aria-hidden="true">Receipts</span></a>';

					print '&nbsp;<a data-invoice-id="'.$row['invoice'].'" class="btn btn-success btn-xs lab_inquiries">
				    <span class="glyphicon glyphicon-upload" aria-hidden="true"></span>Lab Inquiry</a>';
					
}
// if ((in_array('17', $user_permission))) {
//     print '&nbsp; <a data-invoice-id="'.$row['invoice'].'" class="btn btn-danger btn-xs delete-invoice">
// 				    <span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
// }
			'</td>
			    </tr>
			';

		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no invoices to display.</p>";

	}

	// Frees the memory associated with a result
	//@$results->free();

	// close connection 
	@$mysqli->close();

}




// get invoice list
function getInvoice_of_ten_days() {

		

// Connect to the database
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// output any connection error
if ($mysqli->connect_error) {
	die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
}


	 $Today = date('y/m/d'); 
	 $new = date('Y', strtotime($Today));

	 $date = new DateTime(); // For today/now, don't pass an arg.
	 $date->modify("-10 day");
	 
	  $prev_date= $date->format("Y-m-d") ;
	  $current_date =  $currentDate = date('Y-m-d');



// the query
//    $query = "SELECT  *  
// 	FROM invoices i
// 	JOIN customers c
// 	ON c.invoice = i.invoice
// 	WHERE i.invoice = c.invoice
// 	and 
// 	i.assigned_lab_technicians != 0
// 	ORDER BY i.invoice_date DESC limit 10 ";



$query = "SELECT  *  , i.status as invstat , t.status as tstatus FROM invoices i JOIN customers c ON c.invoice = i.invoice left JOIN task_tracker t ON c.invoice  = t.task_tracker_related_id 
 WHERE (  i.assigned_lab_technicians <> 0   and  i.invoice_registration = 'new' ) ORDER BY i.invoice DESC ";

// mysqli select query
$results = $mysqli->query($query);

// mysqli select query
if($results) {

	print '<table class="table table-striped table-hover table-bordered" id="data-table" cellspacing="0"><thead><tr>

			<th>Invoice</th>
			<th>Patient</th>
			<th>Issue Date</th>
			<th>Type</th>
			<!--<th>cashier status</th> -->
			
			<th>Status</th>
			<th>Actions</th>

		  </tr></thead><tbody>';

	while($row = $results->fetch_assoc()) {

		$real_invoice = $row['cashier_task_invoice_id'];
		$query = "SELECT  *  FROM labaratory_test  where `invoice` = '$real_invoice'  ";


        //  // mysqli select query
         $result = $mysqli->query($query);
		$labaratory_test = $result->fetch_assoc();




		if($row['tstatus'] == "requested" && $row['Lab_status'] == 0 ){
			$style = "style='background-color:'";
		
		} elseif ($row['tstatus'] == "Payment Finishied" && $row['Lab_status'] == 1 ){
			
			$style = "style='background-color: ";
		}

	 elseif ($row['tstatus'] == "Payment Finishied" && $row['Lab_status'] == 0 ){
			
		$style = "style='background-color: '";
	}


	$search = '/';
	$replace = '_';
	$subject = $row["invoice"];

	$invoice_number = str_replace($search, $replace, $subject);

		print '
			<tr '.@$style.'>
				<td>'.$row["invoice"].'</td>
				<td>'.$row["name"].'</td>
				<td>'.$row["invoice_date"].'</td>
				<td>'.$row["invoice_type"].'</td>
			 <!-- <td>'.$row["invoice_due_date"].'</td> -->
			   
			';

			if($row['invstat'] == "open"){
				print '<td><span class="label label-primary">'.$row['invstat'].'</span></td>';
			} elseif ($row['invstat'] == "paid"){
				print '<td><span class="label label-success">'.$row['invstat'].'</span></td>';
			}
			$user_permission = array(); 
			$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
			
			for($i =0; $i <= count($explode_comma_separated); $i++)
			{
			@array_push($user_permission,$explode_comma_separated[$i]);
			}

		print
		
		'<td>
				
				<a style="display:none" href="invoice-edit.php?id='.$row["invoice"].'" class="btn btn-primary btn-xs" style="display:none">
				<span hidden class="glyphicon glyphicon-edit" style="display:none" aria-hidden="true"></span></a>

				<a style="display:none" href="#" hidden data-invoice-id="'.$row['invoice'].'" data-email="'.$row['email'].'" data-invoice-type="'.$row['invoice_type'].'" data-custom-email="'.$row['custom_email'].'" class="btn btn-success btn-xs email-invoice">
				<span  style="display:none" class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a> 
		';
		
		if ((in_array('4', $user_permission))) {
			


			print '<a href="invoices/'.$invoice_number.'.pdf" class="btn btn-info btn-xs" target="_blank">
				<span class="glyphicon glyphicon-download-alt" aria-hidden="true">Receipts</span></a>';


				print '&nbsp; <a
				 data-invoice-id="'.$row['invoice'].'"
				 data-invoice-id_lab="'.$real_invoice.'"
				class="btn btn-success btn-xs lab_inquiries_posted_list">
				<span class="glyphicon glyphicon-upload" 
				aria-hidden="true">
				</span>Lab Inquiry</a>';
				
				
}
// if ((in_array('17', $user_permission))) {
// print '&nbsp; <a data-invoice-id="'.$row['invoice'].'" class="btn btn-danger btn-xs delete-invoice">
// 				<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
// }
		'</td>
			</tr>
		';

	}

	print '</tr></tbody></table>';

} else {

	echo "<p>There are no invoices to display.</p>";

}

// Frees the memory associated with a result
@$results->free();

// close connection 
@$mysqli->close();
}









// Initial invoice number
function getInvoiceId() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$query = "SELECT invoice FROM invoices ORDER BY invoice DESC LIMIT 1";

	if ($result = $mysqli->query($query)) {

		$row_cnt = $result->num_rows;

	    $row = mysqli_fetch_assoc($result);

	    //var_dump($row);
		$Today = date('y:m:d');
		$new = date(' Y', strtotime($Today));
	    if($row_cnt == 0){
			// echo INVOICE_INITIAL_VALUE;
		
           echo  "INV/".trim($new),"/0001";
		} else {
            $Get_the_number = explode('/',$row['invoice']);
			$count_squence = $Get_the_number[2] + 1;

		   $zero_filled_counter = sprintf('%04d',$count_squence);
			
			echo "INV/".trim($new),"/".$zero_filled_counter;

		}

	    // Frees the memory associated with a result
		$result->free();

		// close connection 
		$mysqli->close();
	}
	
}

// populate product dropdown for invoice creation
function popProductsList() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT * FROM products ORDER BY product_id ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {
		echo '<select style="display:block;width:570px;"  id="products_insert" class="form-control item-select  select2bs4 required">';
		print '<option selected value="3000"> Consultation </option>';

		while($row = $results->fetch_assoc()) {

		    print '<option   value="'.$row['product_price'].'">'.$row["product_name"].'</option>';
		}
		echo '</select>';

	} else {

		echo "<p>There are no products, please add a product.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();

}

// populate product dropdown for invoice creation
function popCustomersList() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT * , s.town as patient_town FROM store_customers s join doctor d on d.doctorid = s.assigned_dr
	
	ORDER BY s.id ASC   ";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>

				<th>Full Name</th>
				<th>Town</th>
				<th>Age</th>
				<th>Sex</th>
				<th>Date of Reg.</th>
				<th>Action</th>

			  </tr></thead><tbody>';

			 

		while($row = $results->fetch_assoc()) {
			$date=date_create($row['date_of_reg']);
			$date= date_format($date,"d/m/Y");
		    print '
			    <tr>
					<td>'.$row["name"].'</td>
				    <td>'.$row["patient_town"].'</td>
				    <td>'.$row["age"].'</td>
					<td>'.$row["sex"].'</td>
					<td>'.$row["date_of_reg"].'</td>
				    <td><a href="#" class="btn btn-primary btn-xs customer-select" 
					data-customer-name="'.$row['name'].'"
					data-customer-town="'.$row['patient_town'].'"
					data-customer-age="'.$row['age'].'" 
					data-customer-sex="'.$row['sex'].'" 
					data-customer-date_of_reg="'.$date.'" 
					data-customer-company_name="'.$row["company_name"].'" 
					
					data-doctor-name="'.$row['doctorname'].'"
					data-doctor-title="'.$row['title'].'" 
					data-doctor-email="'.$row['email'].'"  >
					             Select
					</a></td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no customers to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();

}



// get products list
function getProcedure() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT * FROM procedure ORDER BY procedure_name ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>

				<th>Procedure</th>
				<th>Description</th>
				<th>Price</th>
				<th>Action</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		    print '
			    <tr>
					<td>'.$row["procedure_name"].'</td>
				    <td>'.$row["procedure_desc"].'</td>
				    <td>$'.$row["procedure_price"].'</td>
				    <td><a href="product-edit.php?id='.$row["procedure_id"].'" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <a data-product-id="'.$row['product_id'].'" class="btn btn-danger btn-xs delete-product"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are No Procecudre To Display.</p>";

	}

	// Frees the memory associated with a result
	@$results->free();

	// close connection 
	$mysqli->close();
}




// get products list
function getProducts() 
{

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT * FROM products ORDER BY product_name ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	$user_permission = array(); 

	$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
	for($i =0; $i <= count($explode_comma_separated); $i++)
	{
	@array_push($user_permission,$explode_comma_separated[$i]);
	}


	if($results) {
		$i=1;
		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
		<th>Procedure</th>
				<th>Procedure</th>
				<th>Description</th>
				<th>Price</th>
				<th>Action</th>
                 </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		    print '
			    <tr>
				<td>'.$i++.'</td>
					<td>'.$row["product_name"].'</td>
				    <td>'.$row["product_desc"].'</td>
				    <td>'.$row["product_price"]." ".CURRENCY.'</td>
				    <td>';

					if ((in_array('7', $user_permission))) {
					print '<a href="procedure-edit.php?id='.$row["product_id"].'" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>&nbsp;'; 
					}
					if ((in_array('18', $user_permission))) {
    print '<a data-product-id="'.$row['product_id'].'" class="btn btn-danger btn-xs delete-product"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
}

			    '
				</td> </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no products to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();



}

// get user list
function getUsers() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT * FROM users ORDER BY username ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>

				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Phone</th>
				<th>User Type</th>
				<th>Action</th>

			  </tr></thead><tbody>';
			  $user_permission = array(); 
			  $explode_comma_separated = explode(",", $_SESSION['User_Permission']);
			  
			  for($i =0; $i <= count($explode_comma_separated); $i++)
			  {
			  @array_push($user_permission,$explode_comma_separated[$i]);
			  }


		while($row = $results->fetch_assoc()) {

		    print '
			    <tr>
			    	<td>'.$row['name'].'</td>
					<td>'.$row["username"].'</td>
				    <td>'.$row["email"].'</td>
				    <td>'.$row["phone"].'</td>
					<td>'.$row["user_type"].'</td>
				    <td>';

					if ((in_array('16', $user_permission))) {
					print '<a href="user-edit.php?id='.$row["id"].'" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span>&nbsp;';
					                                       }

					if ((in_array('21', $user_permission))) {
					print '</a> <a data-user-id="'.$row['id'].'" class="btn btn-danger btn-xs delete-user"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
					                                        }
					'</td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no users to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();
}

// get user list
function getCustomers() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT *, s.town as patient_town FROM store_customers s
	JOIN doctor c ON c.doctorid = s.assigned_dr
	
    
	ORDER BY s.id ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {
		$i=1;
		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
		<th>ID</th>
				<th>Name</th>
				<th>Town</th>
				<th>Age</th>
				<th>Gender</th>
				<th ">Assigned Dr</th>
				<th>Date Of Registration</th>
				<th>Company Name</th>
				<th>Action</th>

			  </tr></thead><tbody>';

			  $user_permission = array(); 
			  $explode_comma_separated = explode(",", $_SESSION['User_Permission']);
			  
			  for($i =0; $i <= count($explode_comma_separated); $i++)
			  {
			  @array_push($user_permission,$explode_comma_separated[$i]);
			  }

		while($row = $results->fetch_assoc()) {
               
		    print '
			    <tr>
				    <td>'.$i++.'</td>
					<td>'.$row["name"].'</td>
				    <td>'.$row["patient_town"].'</td>
				    <td>'.$row["age"].'</td>
					<td>'.$row["sex"].'</td>
					<td style="color:green">'.$row["doctorname"].'</td>
					<td>'.date("d-m-Y",strtotime($row["date_of_reg"])).'</td>
					<td>'.$row["company_name"].'</td>
				    <td>';

						if ((in_array('10', $user_permission))) {
					print '<a href="patient-edit.php?id='.$row["id"].'" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>&nbsp;';
						}

						if ((in_array('19', $user_permission))) {
				 print ' <a data-customer-id="'.$row['id'].'" class="btn btn-danger btn-xs delete-customer"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a>';
						}

				  ' </td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no customers to display.</p>";

	}

	// Frees the memory associated with a result
	@$results->free();

	// close connection 
	$mysqli->close();
}


// get getcompany 

function getcompany() 
{


// Connect to the database
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// output any connection error
if ($mysqli->connect_error) {
	die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

// the query
$query = "SELECT * FROM companies order by id ASC ";

// mysqli select query
 $results = $mysqli->query($query);

if($results)  {  $n=1;

	print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
			 <th width="10%">ID</th>
			<th width="10%">Name</th>
			<th width="10%">Email</th>
			<th width="10%"> Contract Type  </th>
			<th width="10%"> Number of Visitors  </th>
			<th width="10%"> Location  </th>
			<th width="10%"> Tele </th>
			<th width="10%"> Post Office </th>
			<th width="10%"> Department </th>
			<th width="10%"> Action </th>
			
			</tr></thead><tbody>';
			$user_permission = array(); 
			$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
			
			for($i =0; $i <= count($explode_comma_separated); $i++)
			{
			@array_push($user_permission,$explode_comma_separated[$i]);
			}

	while($row = $results->fetch_assoc()) {

		print '
			<tr>
			<td width="10%" >'.$n++.'</td>
				<td width="10%" >'.$row["name"].'</td>
				<td width="10%">'.$row["email"].'</td>
				<td width="10%">'.$row["type_contract"].'</td>
				<td width="10%">'.$row["num_of_vistors"].'</td>
				<td width="10%">'.$row["location"].'</td>
				<td width="10%">'.$row["telephone_number"].'</td>
				<td width="10%">'.$row["post_office"].'</td>
				<td width="10%">'.$row["department"].'</td>
				
			
				
				<td>';
				
				if ((in_array('13', $user_permission))) {
		   print'<a href="company-edit.php?id='.$row["id"].'" class="btn btn-primary btn-xs"> <span class="glyphicon glyphicon-edit" aria-hidden="true"> </span></a> &nbsp;';
				}
				
	if ((in_array('20', $user_permission))) 
	            {
	print '<a data-company-id="'.$row['id'].'"  class="btn btn-danger btn-xs delete-company"> <span class="glyphicon glyphicon-trash" aria-hidden="true"> </span></a>';
				}
				'</td>
			</tr>
		';
	}

	print '</tr></tbody></table>';

} else {

	echo "<p>There are no companies  to display.</p>";

}

// Frees the memory associated with a result
$results->free();

// close connection 
$mysqli->close();


}



// get doctors list
function getDoctors() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT * FROM doctor d JOIN countries c ON c.id = d.country_id JOIN department de ON de.departmentid = d.departmentid
              ORDER BY d.doctorid ASC ";

	// mysqli select query
 	$results = $mysqli->query($query);

	if($results)  {  $i=1;

		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
		         <th>ID</th>
		        <th>Name</th>
				<th>Email</th>
				<th width="10%"> Department  Name    </th>
				<th width="10%">  Consu. Charge  </th>
				<!-- <th>Address-1</th>
				<th width="10%">Address-2</th>-->
				<th width="10%" >Phone</th>
				<th>Town</th>
				<!-- <th>Country Name</th> -- >
			<!--  <th width="10px" >Title</th>  -->
				<th width="10px" >Status</th>
				<th width="10px">Action</th>
				
                </tr></thead><tbody>';
				$user_permission = array(); 
				$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
				
				for($i =0; $i <= count($explode_comma_separated); $i++)
				{
				@array_push($user_permission,$explode_comma_separated[$i]);
				}

		while($row = $results->fetch_assoc()) {

		    print '
			    <tr>
				<td width="10%" >'.$i++.'</td>
					<td width="10%" >'.$row["doctorname"].'</td>
				    <td width="10%">'.$row["email"].'</td>
					<td width="10%">'.$row["departmentname"].'</td>
					<td width="10%">'.$row["consultancy_charge"].'</td>
					<!-- <td width="10%">'.$row["address_one"].'</td>
					<td width="10%">'.$row["address_two"].'</td> -->
					<td width="10%">'.$row["mobileno"].'</td>
					<td width="10%">'.$row["town"].'</td>
				
					<td width="10%">'.$row["status"].'</td>
				    
				    <td>';
					
					if ((in_array('13', $user_permission))) {
               print'<a href="doctor-edit.php?id='.$row["doctorid"].'" class="btn btn-primary btn-xs"> <span class="glyphicon glyphicon-edit" aria-hidden="true"> </span></a> &nbsp;';
					}
					
					if ((in_array('20', $user_permission))) {
		print '<a data-doctor-id="'.$row['doctorid'].'"  class="btn btn-danger btn-xs delete-doctor"> <span class="glyphicon glyphicon-trash" aria-hidden="true"> </span></a>';
					}
					' </td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no doctors to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();
}
?>

