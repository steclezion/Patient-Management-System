<?php


include_once('includes/config.php');

/* include autoloader */
require_once 'dompdf/autoload.inc.php';



//Include mpdf library file
require_once __DIR__ . '/vendor/autoload.php';

$mpdf = new \Mpdf\Mpdf();

use Mpdf\HTMLParserMode;
use Mpdf\Mpdf as PDFF;
use Mpdf\MpdfException;


/* reference the Dompdf namespace */
use Dompdf\Dompdf;


/* instantiate and use the dompdf class */
$dompdf = new Dompdf();

// show PHP errors
ini_set('display_errors', 1);

// output any connection error
if ($mysqli->connect_error) {
    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

$action = isset($_POST['action']) ? $_POST['action'] : "";



if ($action == 'email_invoice'){

	$fileId = $_POST['id'];
	$emailId = $_POST['email'];
	$invoice_type = $_POST['invoice_type'];
	$custom_email = $_POST['custom_email'];

	require_once('class.phpmailer.php');

	$mail = new PHPMailer(); // defaults to using php "mail()"

	$mail->AddReplyTo(EMAIL_FROM, EMAIL_NAME);
	$mail->SetFrom(EMAIL_FROM, EMAIL_NAME);
	$mail->AddAddress($emailId, "");

	$mail->Subject = EMAIL_SUBJECT;
	//$mail->AltBody = EMAIL_BODY; // optional, comment out and test
	if (empty($custom_email)){
		if($invoice_type == 'invoice'){
			$mail->MsgHTML(EMAIL_BODY_INVOICE);
		} else if($invoice_type == 'quote'){
			$mail->MsgHTML(EMAIL_BODY_QUOTE);
		} else if($invoice_type == 'receipt'){
			$mail->MsgHTML(EMAIL_BODY_RECEIPT);
		}
	} else {
		$mail->MsgHTML($custom_email);
	}

	$mail->AddAttachment("./invoices/".$fileId.".pdf"); // attachment

	if(!$mail->Send()) {
		 //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mail->ErrorInfo.'</pre>'
	    ));
	} else {
	   echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Invoice has been successfully send to the customer'
		));
	}

}
// download invoice csv sheet
if ($action == 'download_csv'){

	header("Content-type: text/csv"); 

	// output any connection error
	if ($mysqli->connect_error) {
		die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
	}
 
    $file_name = 'invoice-export-'.date('d-m-Y').'.csv';   // file name
    $file_path = 'downloads/'.$file_name; // file path

	$file = fopen($file_path, "w"); // open a file in write mode
    chmod($file_path, 0777);    // set the file permission

    $query_table_columns_data = "SELECT * 
									FROM invoices i
									JOIN customers c
									ON c.invoice = i.invoice
									WHERE i.invoice = c.invoice
									ORDER BY i.invoice";

    if ($result_column_data = mysqli_query($mysqli, $query_table_columns_data)) {

    	// fetch table fields data
        while ($column_data = $result_column_data->fetch_row()) {

            $table_column_data = array();
            foreach($column_data as $data) {
                $table_column_data[] = $data;
            }

            // Format array as CSV and write to file pointer
            fputcsv($file, $table_column_data, ",", '"');
        }

	}

    //if saving success
    if ($result_column_data = mysqli_query($mysqli, $query_table_columns_data)) {
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'CSV has been generated and is available in the /downloads folder for future reference, you can download by <a href="downloads/'.$file_name.'">clicking here</a>.'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

 
    // close file pointer
    fclose($file);

    $mysqli->close();

}


// Create customer
if ($action == 'create_company'){

	// Basic Physicians Information
	$company_name = $_POST['company_name']; // customer name
	$company_number_employee = $_POST['company_number_employee']; // doctor address 1
	$company_location = $_POST['company_location']; // doctor doctor_phone
	$company_email = $_POST['company_email']; // doctor_town
	$company_post_office = $_POST['company_post_office']; // doctor_postcode
	$company_tele  = $_POST['company_tele']; // customer town
	$company_department = $_POST['company_department']; // doctor_address_2
	$contract_type = $_POST['contract_type']; // country
	
	$date = date('Y-m-d H:i:s');

	$query = "INSERT INTO companies
	(
    type_contract,
	name,
	type,
	num_of_vistors,
    location,
	telephone_number,
	post_office,
	email,
	department,
	Timestamp
     )

	VALUES (
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?
			
				);
			";

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param(
		'ssssssssss',
		$contract_type ,
		$company_name,
		$contract_type,
		$company_number_employee,
		$company_location,
		$company_tele,
		$company_post_office,
		$company_email,
		$company_department,
		$date 

	);

	if($stmt->execute()){
		//if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message' => 'Company has been added successfully!'
		));
	} else {
		// if unable to create invoice
		echo json_encode(array(
			'status' => 'Error',
			'message' => 'There has been an error, please try again.',
			// debug
			'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
		));
	}

	//close database connection
	$mysqli->close();
}



































// Create customer
if ($action == 'create_doctor'){

	
	// Basic Physicians Information
	$doctor_name = $_POST['doctor_name']; // customer name
	$doctor_address_1 = $_POST['doctor_address_1']; // doctor address 1
	$doctor_phone = $_POST['doctor_phone']; // doctor doctor_phone
	$doctor_town = $_POST['doctor_town']; // doctor_town
	$doctor_postcode = $_POST['doctor_postcode']; // doctor_postcode
	$doctor_email = $_POST['doctor_email']; // customer town
	$doctor_address_2 = $_POST['doctor_address_2']; // doctor_address_2
	$doctor_country = $_POST['doctor_country']; // country
	
	//Education Background
	@$doctor_title = $_POST['doctor_title']; // doctor_title (Education Background)
	$doctor_department = $_POST['doctor_department']; // customer address (Education Background)
	$doctor_consultancy_charge = $_POST['doctor_consultancy_charge']; // customer address (Education Background)
	$doctor_status = $_POST['doctor_status']; // customer postcode (Education Background)
	$doctor_education = $_POST['doctor_education']; // doctor education (Education Background)


	$deletestatus = 0;


	$query = "INSERT INTO doctor
	(
	doctorname,
	mobileno,
	departmentid,
	status,
	education,
	consultancy_charge,
	delete_status,
	email,
	address_one,
	address_two,
	town,
	country_id,
	postcode,
	title
	)
	VALUES (
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?,
					?
				);
			";

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param(
		'siissibsssssss',
		$doctor_name,
		$doctor_phone,
		$doctor_department,
		$doctor_status,
		$doctor_education,
		$doctor_consultancy_charge,
		$deletestatus,
		$doctor_email,
		$doctor_address_1,
		$doctor_address_2,
		$doctor_town,
		$doctor_country,
		$doctor_postcode,
		$doctor_title
	);

	if($stmt->execute()){
		//if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message' => 'Physician has been added successfully!'
		));
	} else {
		// if unable to create invoice
		echo json_encode(array(
			'status' => 'Error',
			'message' => 'There has been an error, please try again.',
			// debug
			'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
		));
	}

	//close database connection
	$mysqli->close();
}







// Create customer
if ($action == 'create_customer'){

	// invoice customer information
	// billing
	$customer_name = $_POST['customer_name']; // customer name
	$customer_age = $_POST['customer_age']; // customer age
	$customer_sex = $_POST['customer_sex']; // customer Sex
	$customer_town = $_POST['customer_town']; // customer Town
	$customer_assinged_dr = $_POST['customer_assigned_dr']; // customer Assigned Dr
	$customer_date_of_reg = $_POST['customer_date_of_reg']; // customer Date of regisration
	$customer_company_name = $_POST['customer_company_name']; // customer_company_name
	

	$query = "INSERT INTO store_customers (
         name, town, age,sex,assigned_dr,date_of_reg,company_name			
				)
				 VALUES (
					
					?,
					?,
					?,
					?,
					?,
					?,
					?
					
				);
			";

	/* Prepare statement */


	$stmt = $mysqli->prepare($query);

	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param(
		'sssssss',
		$customer_name,$customer_town,$customer_age,$customer_sex,$customer_assinged_dr,$customer_date_of_reg,$customer_company_name
		);

	if($stmt->execute()){
		//if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message' => 'Patient has been created successfully!'
		));
	} else {
		// if unable to create invoice
		echo json_encode(array(
			'status' => 'Error',
			'message' => 'There has been an error, please try again.'
			// debug
			//'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
		));
	}

	//close database connection
	$mysqli->close();
}



//create_renal_test


if($action == 'print_html')
{


	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);


	$To_be_rendered     =      $_POST['To_be_rendered'];
    $invoice_id         =      $_POST['invoice_id'];
	$receipt_number     =      $_POST['receipt_number'];
	$company_name       =      $_POST['company_name'];





	 $Today = date('y/m/d'); 
	 $new = date('Y', strtotime($Today));
     $currentDate = date('d/m/Y'); 
	
	 $invoice_date = $currentDate; // invoice date
	$inv_date =  explode('/',$invoice_date);
	$inv_date = $inv_date[2]."-".$inv_date[1]."-".$inv_date[0];
    
	$date=date_create($inv_date);
	$currentDate = date_format($date,"Y-m-d");



	      session_start();
	     $_SESSION['login_username'];
	     $id = $_SESSION['login_user_id'];
	
		//$_SESSION['login_user_id'];
		$query = "SELECT * FROM `users` WHERE id  = $id ";
		$result_query = $mysqli->query($query);
		$result_name = $result_query->fetch_assoc();
		$name =  $result_name['name'] ;
	
		$user_name = $_SESSION['login_username'];; 


		

		
	
		$date = new DateTime(); // For today/now, don't pass an arg.
		$date= $date->format("d-m-Y") ;





   if( $result_query == true ){
	$search = '/';
	$replace = '_';
	$subject = $invoice_id;

	$invoice_number = str_replace($search, $replace, $subject);


	 $file_name = 'Printed/'.$invoice_number."_".time().".pdf";

	 $stylesheet =" <style>
	 .invoice-box {
		 max-width: 800px;
		 margin: auto;
		 padding: 30px;
		 border: 1px solid #eee;
		 box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
		 font-size: 16px;
		 line-height: 24px;
		 font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
		 color: #555;
	 }

	 .invoice-box table {
		 width: 100%;
		 line-height: inherit;
		 text-align: left;
	 }

	 .invoice-box table td {
		 padding: 5px;
		 vertical-align: top;
	 }

	 .invoice-box table tr td:nth-child(2) {
		 text-align: right;
	 }

	 .invoice-box table tr.top table td {
		 padding-bottom: 20px;
	 }

	 .invoice-box table tr.top table td.title {
		 font-size: 45px;
		 line-height: 45px;
		 color: #333;
	 }

	 .invoice-box table tr.information table td {
		 padding-bottom: 40px;
	 }

	 .invoice-box table tr.heading td {
		 background: #eee;
		 border-bottom: 1px solid #ddd;
		 font-weight: bold;
	 }

	 .invoice-box table tr.details td {
		 padding-bottom: 20px;
	 }

	 .invoice-box table tr.item td {
		 border-bottom: 1px solid #eee;
	 }

	 .invoice-box table tr.item.last td {
		 border-bottom: none;
	 }

	 .invoice-box table tr.total td:nth-child(2) {
		 border-top: 2px solid #eee;
		 font-weight: bold;
	 }

	 @media only screen and (max-width: 600px) {
		 .invoice-box table tr.top table td {
			 width: 100%;
			 display: block;
			 text-align: center;
		 }

		 .invoice-box table tr.information table td {
			 width: 100%;
			 display: block;
			 text-align: center;
		 }
	 }

	 /** RTL **/
	 .invoice-box.rtl {
		 direction: rtl;
		 font-family: Tahoma, 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
	 }

	 .invoice-box.rtl table {
		 text-align: right;
	 }

	 .invoice-box.rtl table tr td:nth-child(2) {
		 text-align: left;
	 }
 </style>";




	$header = [
		'Content-Type' => 'application/pdf',
		'Content-Disposition' => 'inline: filename="' . $file_name . '"'];
		$mpdf= new PDFF([
			'mode' => "utf-8",
			'format' => COMPANY_SIZE_PAPER,
			'margin_header' => "5",
			'margin_top' => "50",
			'margin_bottom' => "15",
			'margin_footer' => "2",
		]);

		$mpdf->SetHTMLHeader(COMPANY_Header);
		$mpdf->SetHTMLFooter(COMPANY_Footer);
		//$stylesheet = file_get_contents('stylesheet.css');

        $mpdf->WriteHTML($stylesheet,1);
       $mpdf->WriteHTML($To_be_rendered ,2);


        $mpdf->showWatermarkText = true;
		$mpdf->SetWatermarkText('Mekane Hiwot Clinic');
		$mpdf->watermarkTextAlpha = 0.1;


		// $mpdf->SetDisplayMode('fullpage');
		// $mpdf->list_indent_first_level = 0; 


		$file = $mpdf->Output($file_name, 'F');

		$company_name = trim($company_name);

	 $insert_query = "INSERT INTO generate_invoice_print ( `invoice_number`,`company_name`,`html_data`, `file_generated_name`, `Date`, `Who`) 
		                 VALUES ('$receipt_number','$company_name','--','$file_name','$currentDate','$user_name')";

	     $result_query = $mysqli->query($insert_query);

         $table = "";

 
						 // the query
						 $query = "SELECT  *  FROM  generate_invoice_print WHERE `company_name`  = '$company_name'  ORDER BY invoice_number  ASC  ";
                        // mysqli select query
				        $results = $mysqli->query($query);  // mysqli select query
				        if($results) {

	                while($row = $results->fetch_assoc()) {
							
					
						
						
						$table .=  '<tr> <td>'.$row["invoice_number"].'</td>';
						$table .= '<td>'.$row["Date"].'</td>';
			$table .= '<td><a target="_blank" style="display: block;" id="print_generated_file" href="'.$row["file_generated_name"].'" type="button" class="btn btn-primary btn-md float-right"><i class="fas fa-print"></i></a>
									</td></tr>';
						
	                     }

						}
								
								
		//if saving success
	echo json_encode(array(
		'status' => 'Success',
		'Message' => 1,
		'Download' => $file_name, 
		'mode' => 'Saved',
		'print_status' => 'printed',
		'print_table' => $table, 
		'message'=> 'Print Invoice  has been saved successfully.'
	));




} else {
	//if unable to create new record
	echo json_encode(array(
		'status' => 'Error',
		//'message'=> 'There has been an error, please try again.'
		'Message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$result_query.'</pre>'
	));
}
//close database connection
$mysqli->close();



}




























if($action == 'create_renal_test')
{

	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	$uric_acid  =     $_POST['uric_acid'];
	$creatinine =     $_POST['creatinine'];
	$urea       =       $_POST['urea'];

	$invoice = $_POST['invoice_di'];
	

	$renal_referred_by =  $_POST['renal_referred_by'];
	$renal_patient_sample_type = $_POST['renal_patient_sample_type'];
	$renal_patient_test_date = $_POST['renal_patient_test_date'];
	$renal_patient_gender = $_POST['renal_patient_gender'];
	$renal_patient_name = $_POST['renal_patient_name'];
	$renal_patient_age = $_POST['renal_patient_age'];

	$query = "select * from labaratory_test where invoice = '$invoice' ";
	$result = $mysqli->query($query);



   if($result->num_rows == 1)
   {
      //update 
	  $update_query = "update  labaratory_test set   `uric_acid` = '$uric_acid',  `creatinine` =  '$creatinine' , `urea` =  '$urea' where invoice = '$invoice' ";
	  $result_query = $mysqli->query($update_query);
      $Renal = "updated";


   }
   else if($result->num_rows == 0)
   {

	$insert_query = "INSERT INTO labaratory_test ( `invoice`, `uric_acid`,`creatinine`,`urea`)VALUES ('$invoice','$uric_acid','$creatinine','$urea')";
	$result_query = $mysqli->query($insert_query);
	$Renal = "saved";


	
	}

	      session_start();
	     $_SESSION['login_username'];
	     $id = $_SESSION['login_user_id'];
	
		//$_SESSION['login_user_id'];
		$query = "SELECT * FROM `users` WHERE id  = $id ";
		$result_query = $mysqli->query($query);
		$result_name = $result_query->fetch_assoc();
		$name =  $result_name['name'] ;
	
		
	
		$date = new DateTime(); // For today/now, don't pass an arg.
		$date= $date->format("d-m-Y") ;


$html = " 

<!DOCTYPE html>


<html>
<head>

     <meta charset='utf-8'>
     <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  
  <!-- Font Awesome -->
  <link rel='stylesheet' href='css/font-awesome.min.css'>
  <link rel='stylesheet' href='css/ionicons-2.0.1/css'>
  <!-- Ionicons -->
  <link rel='stylesheet' href='css/ionicons.min.css'>
  <link rel='stylesheet' href='css/ionicons.css'>
  <!-- Theme style -->
  <link rel='stylesheet' href='css/AdminLTE.css'>
 
  <link rel='stylesheet' href='css/skin-green.css'>

  
  <!-- Select2 -->
<script src='js/select2.full.min.js'></script>
	
	<!-- AdminLTE App -->
	<script src='js/app.min.js'></script>

	<!-- CSS -->
	<link rel='stylesheet' href='css/bootstrap.min.css'>
	<link rel='stylesheet' href='css/bootstrap.datetimepicker.css'>
	<link rel='stylesheet' href='css/jquery.dataTables.css'>
	<link rel='stylesheet' href='css/dataTables.bootstrap.css'>
	<link rel='stylesheet' href='css/styles.css'>

    <!-- Select2 -->
  
  <link rel='stylesheet' href='css/select2.min.css'>
  <link rel='stylesheet' href='css/select2-bootstrap4.min.css'>


  




</head>



<body class='hold-transition skin-green sidebar-mini'>
<h4 style='text-align:right'>  $date   </h4>
<h5 style='text-align:right'>  Ref: Lab-Test/$invoice   </h5>
<h3 style='text-align:center'>  RENAL FUNCTION TEST  <h3>

<div class='panel-body form-group form-group-sm'>
<table class='table table-striped table-hover table-bordered' id='data-table' cellspacing='0' style='border-collapse: collapse; border: 1px solid black;width: 100%;'>
  <thead style='height: 50px;'>
	<tr>
	  <th>Name </th>
	  <th> Age </th>
	  <th> Gender </th>
	  <th>Test</th>
	  <th>Sample</th>
	  <th>Referred</th>
	</tr>
  </thead>  
  <br><br>
  <tbody>
  <tr class='table-primary' style='background-color:lightgrey'>
  <td><span     id='renal_patient_name'> $renal_patient_name  </span> </td>
  <td><span     id='renal_patient_age'> $renal_patient_age </span></td>
  <td><span     id='renal_patient_gender'> $renal_patient_gender</span></td>
  <td><span     id='renal_patient_test_date'> $renal_patient_test_date </span></td>
  <td><span     id='renal_patient_sample_type'> SERUM </span></td>
  <td><span     id='renal_referred_by'> $renal_referred_by</span></td>
</tr>      
  
  </tbody>
</table>
</div>


<br><br>
<div style='border: 1px solid black;outline-color: red;'>
<table class='table table-striped table-hover table-bordered' id='data-table' cellspacing='0' 
 style='border-collapse: collapse; border: 1px solid black;width: 100%; padding: 15px;text-align: left;overflow-x:auto;'>
	
	<tr  style='height: 50px;'>
	<th style='border: 1px solid black;text-align:center;'>Test</th>
	<th style='border: 1px solid black;text-align:center;'>Results</th>
	<th style='border: 1px solid black;text-align:center;'>Reference Interval</th>
	<th style='border: 1px solid black;text-align:center;'>Unit</th>
  </tr>

<tbody >


<tbody>
<tr>    
  <td style='border: 1px solid black;text-align:center;' >Uric Acid</td>
  <td style='border: 1px solid black;text-align:center;' > <b> $uric_acid </b>  </td>
  <td style='border: 1px solid black;text-align:center;' >6-8</td>
  <td style='border: 1px solid black;text-align:center;' >g/dll</td>

</tr>      
<tr >
  <td style='border: 1px solid black;text-align:center;' >Creatinine</td>
  <td style='border: 1px solid black;text-align:center;' > <b> $creatinine </b> </td>
  <td style='border: 1px solid black;text-align:center;' >3.4 - 5.5</td>
  <td style='border: 1px solid black;text-align:center;' >g/dll</td>
</tr>
<tr >

<td style='border: 1px solid black;text-align:center;' >Urea </td>
<td style='border: 1px solid black;text-align:center;' > <b> $urea </b> </td>
  <td style='border: 1px solid black;text-align:center;' >0 - 41</td>
  <td style='border: 1px solid black;text-align:center;' >U/L</td>
</tr>


  


</tbody>
</table>
</div>

<br><br>
<div class='panel-body form-group form-group-sm'>
<table class='table table-striped table-hover table-bordered'>
 


  <tbody>
	<tr class='table-primary' style='background-color:lightgrey'>
	  <td><span >  Prepared By  <b> <u> $name </u></b> </span> </td>
     </tr>      
	<tr class='table-primary'>

	<td><span >  Signature   <b> <u>_____________________ </u></b> </span> </td>
  </tr>
  
  </tbody>
</table>
</div>



</body>
</html>";






   if( $result_query == true ){
	$search = '/';
	$replace = '_';
	$subject = $invoice;

	$invoice_number = str_replace($search, $replace, $subject);


	 $file_name = 'Renal/'.$invoice_number."_".time().".pdf";

	$header = [
		'Content-Type' => 'application/pdf',
		'Content-Disposition' => 'inline: filename="' . $file_name . '"'];
		$mpdf= new PDFF([
			'mode' => "utf-8",
			'format' => COMPANY_SIZE_PAPER,
			'margin_header' => "5",
			'margin_top' => "50",
			'margin_bottom' => "15",
			'margin_footer' => "2",
		]);

		$mpdf->SetHTMLHeader(COMPANY_Header);
		$mpdf->SetHTMLFooter(COMPANY_Footer);


		$mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);

		$mpdf->showWatermarkText = true;
		$mpdf->SetWatermarkText('Mekane Hiwot Clinic ');
		 $mpdf->watermarkTextAlpha = 0.1;
		// $mpdf->SetDisplayMode('fullpage');
		// $mpdf->list_indent_first_level = 0; 


		$file = $mpdf->Output($file_name, 'F');



		$update_query = "update  labaratory_test set   `renal_generated_file` = '$file_name', `renal_status`= '1' where invoice = '$invoice' ";
		$result_query = $mysqli->query($update_query);
		

			//if saving success
	echo json_encode(array(
		'status' => 'Success',
		'Download' => $file_name, 
		'mode' => $Renal,
		'renal_status' => 1,
		'message'=> 'Renal Test has been '.$Renal.' successfully.'
	));




} else {
	//if unable to create new record
	echo json_encode(array(
		'status' => 'Error',
		//'message'=> 'There has been an error, please try again.'
		'message' => '5There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$result_query.'</pre>'
	));
}
//close database connection
$mysqli->close();






}





//create_liver_test

if($action == 'create_liver_test')
{

	


	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	$total_protien  = $_POST['total_protien'];
	$alb    = $_POST['alb'];
	$ast    = $_POST['ast'];
	$ggt    = $_POST['ggt'];
	$tbil   = $_POST['tbil'];
	$dbil   = $_POST['dbil'];
	$alp    = $_POST['alp'];




	$liver_referred_by =  $_POST['liver_referred_by'];
	$liver_patient_sample_type = $_POST['liver_patient_sample_type'];
	$liver_patient_test_date = $_POST['liver_patient_test_date'];
	$liver_patient_gender = $_POST['liver_patient_gender'];
	$liver_patient_name = $_POST['liver_patient_name'];
	$liver_patient_age = $_POST['liver_patient_age'];



 	 $invoice = $_POST['invoice_di'];
	 $to_be_printed = $_POST['to_be_printed'];



	$query = "select * from labaratory_test where invoice = '$invoice' ";
	$result = $mysqli->query($query);


   if($result->num_rows == 1)
   {
      //update 
	  $update_query = "update  labaratory_test set  

	   `total_protien` = '$total_protien',  `alb` =  '$alb ' , `ast` =  '$ast', `ggt` =  '$ggt' ,  `tbil` =  '$tbil' ,  `dbil` =  '$dbil', `alp` =  '$alp'   
	  
	   where invoice = '$invoice' ";
	  $result_query = $mysqli->query($update_query);
      $Liver = "updated";


   }
   else if($result->num_rows == 0)
   {

	 $insert_query = "INSERT INTO labaratory_test ( `invoice`, `total_protien`,`alb`,`ast`,`ggt`,`tbil`,`dbil`,`alp`)
	 VALUES ('$invoice','$total_protien','$alb','$ast','$ggt','$tbil','$dbil','$alp')";
	$result_query = $mysqli->query($insert_query);
	$Liver = "saved";
	


   }

session_start();
$_SESSION['login_username'];
$id = $_SESSION['login_user_id'];

	//$_SESSION['login_user_id'];
    $query = "SELECT * FROM `users` WHERE id  = $id ";
    $result_query = $mysqli->query($query);
	$result_name = $result_query->fetch_assoc();
	$name =  $result_name['name'] ;

	

	$date = new DateTime(); // For today/now, don't pass an arg.
	$date= $date->format("d-m-Y") ;
	
	 

$html = " 

<!DOCTYPE html>


<html>
<head>

     <meta charset='utf-8'>
     <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  
  <!-- Font Awesome -->
  <link rel='stylesheet' href='css/font-awesome.min.css'>
  <link rel='stylesheet' href='css/ionicons-2.0.1/css'>
  <!-- Ionicons -->
  <link rel='stylesheet' href='css/ionicons.min.css'>
  <link rel='stylesheet' href='css/ionicons.css'>
  <!-- Theme style -->
  <link rel='stylesheet' href='css/AdminLTE.css'>
 
  <link rel='stylesheet' href='css/skin-green.css'>

  
  <!-- Select2 -->
<script src='js/select2.full.min.js'></script>
	
	<!-- AdminLTE App -->
	<script src='js/app.min.js'></script>

	<!-- CSS -->
	<link rel='stylesheet' href='css/bootstrap.min.css'>
	<link rel='stylesheet' href='css/bootstrap.datetimepicker.css'>
	<link rel='stylesheet' href='css/jquery.dataTables.css'>
	<link rel='stylesheet' href='css/dataTables.bootstrap.css'>
	<link rel='stylesheet' href='css/styles.css'>

    <!-- Select2 -->
  
  <link rel='stylesheet' href='css/select2.min.css'>
  <link rel='stylesheet' href='css/select2-bootstrap4.min.css'>


  




</head>



<body class='hold-transition skin-green sidebar-mini'>
<h4 style='text-align:right'>  $date   </h4>
<h5 style='text-align:right'>  Ref: Lab-Test/$invoice   </h5>

<h3 style='text-align:center'>  LIVER  TEST  <h3>

<div class='panel-body form-group form-group-sm'>
<table class='table table-striped table-hover table-bordered' id='data-table' cellspacing='0' style='border-collapse: collapse; border: 1px solid black;width: 100%;'>
  <thead style='height: 50px;'>
	<tr>
	  <th>Name </th>
	  <th> Age </th>
	  <th> Gender </th>
	  <th>Test</th>
	  <th>Sample</th>
	  <th>Referred</th>
	</tr>
  </thead>  
  <br><br>
  <tbody>
  <tr class='table-primary' style='background-color:lightgrey'>
  <td><span     id='liver_patient_name'> $liver_patient_name  </span> </td>
  <td><span     id='liver_patient_age'> $liver_patient_age </span></td>
  <td><span     id='liver_patient_gender'> $liver_patient_gender</span></td>
  <td><span     id='liver_patient_test_date'> $liver_patient_test_date </span></td>
  <td><span     id='liver_patient_sample_type'> SERUM </span></td>
  <td><span     id='liver_referred_by'> $liver_referred_by</span></td>
</tr>      
  
  </tbody>
</table>
</div>


<br><br>
<div style='border: 1px solid black;outline-color: red;'>
<table class='table table-striped table-hover table-bordered' id='data-table' cellspacing='0' 
 style='border-collapse: collapse; border: 1px solid black;width: 100%; padding: 15px;text-align: left;overflow-x:auto;'>
	
	<tr  style='height: 50px;'>
	<th style='border: 1px solid black;text-align:center;'>Test</th>
	<th style='border: 1px solid black;text-align:center;'>Results</th>
	<th style='border: 1px solid black;text-align:center;'>Reference Interval</th>
	<th style='border: 1px solid black;text-align:center;'>Unit</th>
  </tr>

<tbody >


<tbody>
<tr>    
  <td style='border: 1px solid black;text-align:center;' >Total Protien</td>
  <td style='border: 1px solid black;text-align:center;' > <b> $total_protien </b>  </td>
  <td style='border: 1px solid black;text-align:center;' >6-8</td>
  <td style='border: 1px solid black;text-align:center;' >g/dll</td>

</tr>      
<tr >
  <td style='border: 1px solid black;text-align:center;' >ALB</td>
  <td style='border: 1px solid black;text-align:center;' > <b> $alb </b> </td>
  <td style='border: 1px solid black;text-align:center;' >3.4 - 5.5</td>
  <td style='border: 1px solid black;text-align:center;' >g/dll</td>
</tr>
<tr >

<td style='border: 1px solid black;text-align:center;' >AST </td>
<td style='border: 1px solid black;text-align:center;' > <b> $ast </b> </td>
  <td style='border: 1px solid black;text-align:center;' >0 - 41</td>
  <td style='border: 1px solid black;text-align:center;' >U/L</td>
</tr>
<tr >
  <td style='border: 1px solid black;text-align:center;' >GGT </td>
  <td style='border: 1px solid black;text-align:center;' > <b>  $ggt </b>  </td>
  <td style='border: 1px solid black;text-align:center;' >1 - 49 </td>
  <td style='border: 1px solid black;text-align:center;' >U/L</td>
</tr>



<tr >
  <td style='border: 1px solid black;text-align:center;' >TBIL </td>
  <td style='border: 1px solid black;text-align:center;' > <b> $tbil </b></td>
  <td style='border: 1px solid black;text-align:center;' >0-1</td>
  <td style='border: 1px solid black;text-align:center;' >MG/dl</td>
</tr>

<tr >
  <td style='border: 1px solid black;text-align:center;'> DBIL </td>
  <td style='border: 1px solid black;text-align:center;'> <b>  $dbil </b>  </td>
  <td style='border: 1px solid black;text-align:center;'> 0 - 0.3 </td>
  <td style='border: 1px solid black;text-align:center;'> MG/dl</td>
</tr>

<tr >
  <td style='border: 1px solid black;text-align:center;'> ALP </td>
  <td style='border: 1px solid black;text-align:center;'> <b> $alp </b>  </td>
  <td style='border: 1px solid black;text-align:center;'> 42 - 406</td>
  <td style='border: 1px solid black;text-align:center;'> u/l</td>
</tr>

  


</tbody>
</table>
</div>

<br><br>
<div class='panel-body form-group form-group-sm'>
<table class='table table-striped table-hover table-bordered'>
 


  <tbody>
	<tr class='table-primary' style='background-color:lightgrey'>
	  <td><span >  Prepared By  <b> <u> $name </u></b> </span> </td>
     </tr>      
	<tr class='table-primary'>

	<td><span >  Signature   <b> <u>_____________________ </u></b> </span> </td>
  </tr>
  
  </tbody>
</table>
</div>



</body>
</html>";






   if( $result_query == true ){
	$search = '/';
	$replace = '_';
	$subject = $invoice;

	$invoice_number = str_replace($search, $replace, $subject);


	 $file_name = 'Liver/'.$invoice_number."_".time().".pdf";

	$header = [
		'Content-Type' => 'application/pdf',
		'Content-Disposition' => 'inline: filename="' . $file_name . '"'];
		$mpdf= new PDFF([
			'mode' => "utf-8",
			'format' => COMPANY_SIZE_PAPER,
			'margin_header' => "5",
			'margin_top' => "50",
			'margin_bottom' => "15",
			'margin_footer' => "2",
		]);

		$mpdf->SetHTMLHeader(COMPANY_Header);
		$mpdf->SetHTMLFooter(COMPANY_Footer);


		$mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);

		$mpdf->showWatermarkText = true;
		$mpdf->SetWatermarkText('Mekane Hiwot Clinic ');
		 $mpdf->watermarkTextAlpha = 0.1;
		// $mpdf->SetDisplayMode('fullpage');
		// $mpdf->list_indent_first_level = 0; 


		$file = $mpdf->Output($file_name, 'F');



		$update_query = "update  labaratory_test set   `liver_generated_file` = '$file_name', `liver_status`= '1' where invoice = '$invoice' ";
		$result_query = $mysqli->query($update_query);
		

			//if saving success
	echo json_encode(array(
		'status' => 'Success',
		'Download' => $file_name, 
		'mode' => $Liver,
		'liver_status' => 1,
		'message'=> 'Liver Test has been '.$Liver.' successfully.'
	));




} else {
	//if unable to create new record
	echo json_encode(array(
		'status' => 'Error',
		//'message'=> 'There has been an error, please try again.'
		'message' => '5There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$result_query.'</pre>'
	));
}
//close database connection
$mysqli->close();




}

//create_lipid_test

if($action == 'create_lipid_test')
{
    // Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	$tchol  = $_POST['tchol'];
	$TG     = $_POST['TG'];
	$HDLC   = $_POST['HDLC'];
	$LDLC   = $_POST['LDLC'];
 	$invoice = $_POST['invoice_di'];
	$to_be_printed = $_POST['to_be_printed'];
	$lipid_referred_by =  $_POST['lipid_referred_by'];
	$lipid_patient_sample_type = $_POST['lipid_patient_sample_type'];
	$lipid_patient_test_date = $_POST['lipid_patient_test_date'];
	$lipid_patient_gender = $_POST['lipid_patient_gender'];
	$lipid_patient_name = $_POST['lipid_patient_name'];
	$lipid_patient_age = $_POST['lipid_patient_age'];


	$query = "select * from labaratory_test where invoice = '$invoice' ";
	$result = $mysqli->query($query);


   if($result->num_rows == 1)
   {
      //update 
	  $update_query = "update  labaratory_test set   `tchol` = '$tchol',  `tg`   =  '$TG' , `hdlc` =  '$HDLC', `ldlc` =  '$LDLC'
	  where invoice = '$invoice' ";
	  $result_query = $mysqli->query($update_query);
      $Lipid = "updated";


   }
   else if($result->num_rows == 0)
   {

	$insert_query = "INSERT INTO labaratory_test ( `invoice`, `tchol`,`tg`,`hdlc`,`ldlc`) VALUES ('$invoice','$tchol','$TG','$HDLC','$LDLC')";
	$result_query = $mysqli->query($insert_query);
	$Lipid = "saved";
	


   }

session_start();
$_SESSION['login_username'];


$id = $_SESSION['login_user_id'];

	//$_SESSION['login_user_id'];
    $query = "SELECT * FROM `users` WHERE id  = $id ";
    $result_query = $mysqli->query($query);
	$result_name = $result_query->fetch_assoc();
	$name =  $result_name['name'] ;

	

	$date = new DateTime(); // For today/now, don't pass an arg.
	
 $date= $date->format("d-m-Y") ;
	
	 

$html = " 

<!DOCTYPE html>


<html>
<head>

     <meta charset='utf-8'>
     <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  
  <!-- Font Awesome -->
  <link rel='stylesheet' href='css/font-awesome.min.css'>
  <link rel='stylesheet' href='css/ionicons-2.0.1/css'>
  <!-- Ionicons -->
  <link rel='stylesheet' href='css/ionicons.min.css'>
  <link rel='stylesheet' href='css/ionicons.css'>
  <!-- Theme style -->
  <link rel='stylesheet' href='css/AdminLTE.css'>
 
  <link rel='stylesheet' href='css/skin-green.css'>

  
  <!-- Select2 -->
<script src='js/select2.full.min.js'></script>
	
	<!-- AdminLTE App -->
	<script src='js/app.min.js'></script>

	<!-- CSS -->
	<link rel='stylesheet' href='css/bootstrap.min.css'>
	<link rel='stylesheet' href='css/bootstrap.datetimepicker.css'>
	<link rel='stylesheet' href='css/jquery.dataTables.css'>
	<link rel='stylesheet' href='css/dataTables.bootstrap.css'>
	<link rel='stylesheet' href='css/styles.css'>

    <!-- Select2 -->
  
  <link rel='stylesheet' href='css/select2.min.css'>
  <link rel='stylesheet' href='css/select2-bootstrap4.min.css'>


  




</head>



<body class='hold-transition skin-green sidebar-mini'>
<h4 style='text-align:right'>  $date   </h4>
<h5 style='text-align:right'>  Ref: Lab-Test/$invoice   </h5>
<h3 style='text-align:center'>  LIPID PROFILE TEST  <h3>

<div class='panel-body form-group form-group-sm'>
<table class='table table-striped table-hover table-bordered' id='data-table' cellspacing='0' style='border-collapse: collapse; border: 1px solid black;width: 100%;'>
  <thead style='height: 50px;'>
	<tr>
	  <th>Name </th>
	  <th> Age </th>
	  <th> Gender </th>
	  <th>Test</th>
	  <th>Sample</th>
	  <th>Referred</th>
	</tr>
  </thead>  
  <br><br>
  <tbody>
	<tr class='table-primary' style='background-color:lightgrey'>
	  <td><span     id='lipid_patient_name'> $lipid_patient_name  </span> </td>
	  <td><span  id='lipid_patient_age'> $lipid_patient_age </span></td>
	  <td><span id='lipid_patient_gender'> $lipid_patient_gender</span></td>
	  <td><span id='lipid_patient_test_date'> $lipid_patient_test_date </span></td>
	  <td><span id='lipid_patient_sample_type'> SERUM </span></td>
	  <td><span id='lipid_referred_by'> $lipid_referred_by</span></td>
	</tr>      
  
  </tbody>
</table>
</div>


<br><br>
<div style='border: 1px solid black;outline-color: red;'>
<table class='table table-striped table-hover table-bordered' id='data-table' cellspacing='0' 
 style='border-collapse: collapse; border: 1px solid black;width: 100%; padding: 15px;text-align: left;overflow-x:auto;'>
	
	<tr  style='height: 50px;'>
	<th style='border: 1px solid black;text-align:center;'>Test</th>
	<th style='border: 1px solid black;text-align:center;'>Results</th>
	<th style='border: 1px solid black;text-align:center;'>Reference Interval</th>
	<th style='border: 1px solid black;text-align:center;'>Unit</th>
  </tr>

<tbody >
<tr  style='height: 50px;'>
	<td style='border: 1px solid black;text-align:center;'>TCHOL</td>
	<td style='border: 1px solid black;text-align:center;'> $tchol   </td>
	<td style='border: 1px solid black;text-align:center;'>130 - 250</td>
	<td style='border: 1px solid black;text-align:center;'>mg/dl</td>
  </tr>      
  <tr  style='height: 50px;'>
	<td style='border: 1px solid black;text-align:center;'>TG</td>
	<td style='border: 1px solid black;text-align:center;'> $TG </td>
	<td style='border: 1px solid black;text-align:center;'>60 - 170 </td>
	<td style='border: 1px solid black;text-align:center;'>mg/dl</td>
  </tr>
  <tr  style='height: 50px;'>
	<td style='border: 1px solid black;text-align:center;'>HDLC</td>
	<td style='border: 1px solid black;text-align:center;'>  $HDLC </td>
	<td style='border: 1px solid black;text-align:center;'>35 - 80 </td>
	<td style='border: 1px solid black;text-align:center;'>mg/dl</td>
  </tr>

  
  <tr >
	<td style='border: 1px solid black;text-align:center;' >LDLC </td>
	<td style='border: 1px solid black;text-align:center;'> $LDLC </td>
	<td style='border: 1px solid black;text-align:center;'> 0 - 130 </td>
	<td style='border: 1px solid black;text-align:center;' >mg/dl</td>
  </tr>

  


</tbody>
</table>
</div>

<br><br>
<div class='panel-body form-group form-group-sm'>
<table class='table table-striped table-hover table-bordered'>
 


  <tbody>
	<tr class='table-primary' style='background-color:lightgrey'>
	  <td><span >  Prepared By  <b> <u> $name </u></b> </span> </td>
     </tr>      
	<tr class='table-primary'>

	<td><span >  Signature   <b> <u>_____________________ </u></b> </span> </td>
  </tr>
  
  </tbody>
</table>
</div>



</body>
</html>";






   if( $result_query == true ){
	$search = '/';
	$replace = '_';
	$subject = $invoice;

	$invoice_number = str_replace($search, $replace, $subject);


	$file_name = 'Lipid/'.$invoice_number."_".time().".pdf";

	$header = [
		'Content-Type' => 'application/pdf',
		'Content-Disposition' => 'inline: filename="' . $file_name . '"'];
		$mpdf= new PDFF([
			'mode' => "utf-8",
			'format' => COMPANY_SIZE_PAPER,
			'margin_header' => "5",
			'margin_top' => "50",
			'margin_bottom' => "15",
			'margin_footer' => "2",
		]);

		$mpdf->SetHTMLHeader(COMPANY_Header);
		$mpdf->SetHTMLFooter(COMPANY_Footer);


		$mpdf->WriteHTML($html, HTMLParserMode::HTML_BODY);

		$mpdf->showWatermarkText = true;
		$mpdf->SetWatermarkText('Mekane Hiwot Clinic ');
		 $mpdf->watermarkTextAlpha = 0.1;
		// $mpdf->SetDisplayMode('fullpage');
		// $mpdf->list_indent_first_level = 0; 


		$file = $mpdf->Output($file_name, 'F');



		$update_query = "update  labaratory_test set   `lipid_generated_file_path` = '$file_name', `lipid_status`= '1' where invoice = '$invoice' ";
		$result_query = $mysqli->query($update_query);
		

			//if saving success
	echo json_encode(array(
		'status' => 'Success',
		'Download' => $file_name, 
		'mode' => $Lipid,
		'lipid_status' => 1,
		'message'=> 'Lipid Test has been '.$Lipid.' successfully.'
	));




} else {
	//if unable to create new record
	echo json_encode(array(
		'status' => 'Error',
		//'message'=> 'There has been an error, please try again.'
		'message' => '5There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$result_query.'</pre>'
	));
}
//close database connection
$mysqli->close();

}



//Submit_To_DR

if($action == 'Submit_To_DR'){

	@$invoice = $_POST['invoice'];
	
	@$sender_id = $_POST['sender_id'];

	$query = "select * from labaratory_test where invoice = '$invoice'";
	$result = $mysqli->query($query);
	$rows = $result->fetch_assoc();

	$update_query = "update  labaratory_test set   `notify_to_dr` = '1'  where invoice = '$invoice' ";
	$result_query = $mysqli->query($update_query);



	$update_query = "update  task_tracker set   `Lab_status` = '1'  where cashier_task_invoice_id  = '$invoice' ";
	$result_query = $mysqli->query($update_query);


		//Sent Notification TO LabTechnician 
		$subject = 'Lab Request submission to Dr';
		$message = 'A patient with invoice Id '.$invoice.' his/her lab test has been completed.';
	
	
	
	
		$query = "INSERT INTO notification(`subject`,`message`,`status`,`user_id`,`timestamp` )
									 VALUES    ('$subject', '$message',0,$sender_id ,NOW() )";
	
	        $results = $mysqli->query($query);




	$row_hematology = $rows['hematology_status'];
	$row_liver = $rows['liver_status'];
	$row_renal = $rows['renal_status'];
	$row_lipid = $rows['lipid_status'];



echo json_encode(array(
		'status' => 'success',
		'liver'  => $row_liver,
		'renal' => $row_renal,
		'lipd' => $row_lipid,
		'message' => 'Test has been completed successfully.',
	
	));




}

//submit_hematology
 
if ($action == 'submit_hematology')
{

$invoice  = $_POST['invoice_di_hematology']; 
$Hgh =  $_POST['hgh'];
$bf_malaria = $_POST['bf_malaria'];
$twbc = $_POST['TWBC'];
$diff_count = $_POST['diff'];
$vdrl = $_POST['vdrl'];
$widal  = $_POST['widal'];
$others_hematology = $_POST['others_hematology'];
$color_urine = $_POST['urine_color'];
$reaction_urine = $_POST['reaction_color'];
$albumin = $_POST['urine_Albumin'];
$sugar = $_POST['urine_sugar'];
$acetone = $_POST['urine_acetone'];
$bile_pigment = $_POST['urine_bile_pigment'];
$pus_cell_microsopy = $_POST['pus_cell_microsocopy'];

$RBC =  $_POST['RBC'];


$crystall =  $_POST['Crystal'];
$EPC =  $_POST['EPC'];
$Ova =  $_POST['ova'];
$other_microscopy =  $_POST['others'];
$RBS  =  $_POST['RBS'];
$ERS =  $_POST['ERS'];
$Morphology =  $_POST['Morphology'];
$HCG  =  $_POST['HCG'];
$H_Pylori =  $_POST['H_pylori'];
$Brucella_test =  $_POST['Brucella_Test'];
$Hgb  =  $_POST['HGB'];
$color =  $_POST['color'];
$consist =  $_POST['Consist'];
$reaction =  $_POST['Reaction'];
$mucus =  $_POST['Mucus'];
$blood =  $_POST['Blood'];
$worms =  $_POST['Worms'];
$Pus_Cells_direct_microscopy =  $_POST['Pus_Cells_direct_microscopy'];

$RBCS=  $_POST['RBCS'];
$o_p=  $_POST['o_p'];

$H_Pylori_Ag_ = $_POST['H_Pylori_Ag_'];

//New Once
$HBV = $_POST['HBV'];
$HIV = $_POST['HIV'];
$HCV = $_POST['HCV'];
$FBS = $_POST['FBS'];





$hematology_status=1;

$invoice = $_POST['invoice_di_hematology'];

$h_patient_name = $_POST['h_patient_name'];
$h_patient_age = $_POST['h_patient_age'];
$h_patient_gender = $_POST['h_patient_gender'];
$h_patient_test_date = $_POST['h_ptest_date'];
$h_patient_prefred_by = $_POST['h_ptest_prefred_by'];




 $query = "select * from labaratory_test where invoice = '$invoice' ";
$result = $mysqli->query($query);

 $result->num_rows; 

if($result->num_rows == 1)
{
  //update 
  //$update_query = "update  labaratory_test set   `tchol` = '$tchol',  `tg`   =  '$TG' , `hdlc` =  '$HDLC', `ldlc` =  '$LDLC' where invoice = '$invoice' ";
  $update_query = "update  labaratory_test set  `HIV` = '$HIV', `HBV` = '$HBV', `HCV` = '$HCV', `FBS` = '$FBS',  `Hgh` = '$Hgh', `bf_malaria` =  '$bf_malaria', `twbc`  = '$twbc', `diff_count` = '$diff_count', `vdrl` = '$vdrl', `widal` = '$widal' , `others_hematology`  =  '$others_hematology', `color_urine`  =  '$color_urine',`reaction_urine` =  '$reaction_urine',`albumin` =  '$albumin',`sugar`  = '$sugar',`acetone` =  '$acetone',`bile_pigment`  =  '$bile_pigment' ,`pus_cell_microsopy`  =  '$pus_cell_microsopy',`RBC`  =  '$RBC',`crystall`  =  '$crystall' , `EPC` = '$EPC' , `Ova`= '$Ova', `other_microscopy` = '$other_microscopy', `RBS`=  '$RBC', `ERS` = '$ERS', `Morphology` = '$Morphology', `HCG` = '$HCG',`H_Pylori` = '$H_Pylori',`Brucella_test`  = '$Brucella_test',`Hgb`  = '$Hgb',`color` = '$color', `consist` = '$consist', `reaction`  = '$reaction',`mucus`  = '$mucus',`blood` = '$blood', `worms` = '$worms', `pus_cells_direct_microscopy` = '$Pus_Cells_direct_microscopy', `RBCS`= '$RBCS', `O_P` = '$o_p' ,`hematology_status` =  $hematology_status  where invoice = '$invoice'";
 $result_query = $mysqli->query($update_query);
  $hematology = "updated";


}
else if($result->num_rows == 0)
{
//$insert_query = "INSERT INTO labaratory_test ( `invoice`, `tchol`,`tg`,`hdlc`,`ldlc`) VALUES ('$invoice','$tchol','$TG','$HDLC','$LDLC')";
$insert_query= "INSERT INTO `invoicemgsys`.`labaratory_test`(`invoice`,`HIV`,`HBV`,`HCV`,`FBS`,`Hgh`,`bf_malaria`,`twbc`,`diff_count`,`vdrl`,`widal`,`others_hematology`,`color_urine`,`reaction_urine`,`albumin`,`sugar`,`acetone`,`bile_pigment`,`pus_cell_microsopy`,`RBC`,`crystall`,`EPC`,`Ova`,`other_microscopy`,`RBS`,`ERS`,`Morphology`,`HCG`,`H_Pylori`,`Brucella_test`,`Hgb`,`color`,`consist`,`reaction`,`mucus`,`blood`,`worms`,`pus_cells_direct_microscopy`,`RBCS`,`O_P`,`hematology_status`)VALUES('$invoice','$HIV','$HBV','$HCV','$FBS','$Hgh','$bf_malaria','$twbc','$diff_count','$vdrl','$widal','$others_hematology','$color_urine','$reaction_urine', '$albumin', '$sugar', '$acetone', '$bile_pigment', '$pus_cell_microsopy','$RBC','$crystall','$EPC','$Ova','$other_microscopy','$RBC','$ERS','$Morphology','$HCG','$H_Pylori','$Brucella_test','$Hgb','$color','$consist','$reaction','$mucus','$blood','$worms','$Pus_Cells_direct_microscopy','$RBCS','$o_p',$hematology_status)";

$result_query = $mysqli->query($insert_query);
$hematology = "saved";
}





session_start();
$_SESSION['login_username'];


$id = $_SESSION['login_user_id'];

	//$_SESSION['login_user_id'];
    $query = "SELECT * FROM `users` WHERE id  = $id ";
    $result_query = $mysqli->query($query);
	$result_name = $result_query->fetch_assoc();
	$name =  $result_name['name'] ;

	

	$date = new DateTime(); // For today/now, don't pass an arg.
	
 $date= $date->format("d-m-Y") ;
	
	 

$html = " 

<!DOCTYPE html>


<html>
<head>

     <meta charset='utf-8'>
     <meta http-equiv='X-UA-Compatible' content='IE=edge'>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
  
  <!-- Font Awesome -->
  <link rel='stylesheet' href='css/font-awesome.min.css'>
  <link rel='stylesheet' href='css/ionicons-2.0.1/css'>
  <!-- Ionicons -->
  <link rel='stylesheet' href='css/ionicons.min.css'>
  <link rel='stylesheet' href='css/ionicons.css'>
  <!-- Theme style -->
  <link rel='stylesheet' href='css/AdminLTE.css'>
 
  <link rel='stylesheet' href='css/skin-green.css'>

  
  <!-- Select2 -->
<script src='js/select2.full.min.js'></script>
	
	<!-- AdminLTE App -->
	<script src='js/app.min.js'></script>

	<!-- CSS -->
	<link rel='stylesheet' href='css/bootstrap.min.css'>
	<link rel='stylesheet' href='css/bootstrap.datetimepicker.css'>
	<link rel='stylesheet' href='css/jquery.dataTables.css'>
	<link rel='stylesheet' href='css/dataTables.bootstrap.css'>
	<link rel='stylesheet' href='css/styles.css'>

    <!-- Select2 -->
  
  <link rel='stylesheet' href='css/select2.min.css'>
  <link rel='stylesheet' href='css/select2-bootstrap4.min.css'>


  




</head>



<body class='hold-transition skin-green sidebar-mini'>
<h4 style='text-align:right'>  $date   </h4>
<h5 style='text-align:right'>  Ref: Lab-Test/$invoice   </h5>


<div class='panel-body form-group form-group-sm'>
<table class='table table-striped table-hover table-bordered' id='data-table' cellspacing='0' style='border-collapse: collapse; border: 1px solid black;width: 100%;'>
  <thead style='height: 50px;'>
	<tr>
	  <th>Name </th>
	  <th> Age </th>
	  <th> Gender </th>
	  <th>Test</th>
	  <th>Sample</th>
	  <th>Referred</th>
	</tr>
  </thead>  
  <br><br>
  <tbody>
	<tr class='table-primary' style='background-color:lightgrey'>
	<td><span id='hematology_patient_name'> $h_patient_name  </span> </td>
	<td><span id='hematology_patient_age'> $h_patient_age </span></td>
	<td><span id='hematology_patient_gender'> $h_patient_gender</span></td>
	<td><span id='hematology_patient_test_date'> $h_patient_test_date </span></td>
	<td><span id='hematology_patient_sample_type'> SERUM </span></td>
	<td><span id='hematology_referred_by'> $h_patient_prefred_by</span></td>
	</tr>      
  
  </tbody>
</table>
</div>


<br><br>

<div class='row'>
<div class='col-md-6'>
<h3 style='text-align:center'> <b> LABORATORY TESTS   </b> </h3>
<form  id='commentForm' method='POST' action='submit_hematology'  onSubmit='return validate();' enctype='multipart/form-data'  >
<input type='hidden' name='action' value='submit_hematology'>
<input class='form-check-input' type='hidden'  id='invoice_di_hematology'  value =''  name='invoice_di_hematology'> 
<input type='hidden' value='' name='h_patient_name' id='h_patient_name' /> 
<input type='hidden' value='' name='h_patient_age' id='h_patient_age' /> 
<input type='hidden' value='' name='h_patient_gender' id='h_patient_gender' /> 
<input type='hidden' value='' name='h_ptest_date' id='h_ptest_date' /> 
<input type='hidden' value='' name='h_ptest_prefred_by' id='h_ptest_prefred_by' /> 

<body>
<div style='border: 1px solid black;outline-color: red;'>
<table class='table table-striped table-hover table-bordered' id='data-table' cellspacing='0' 
 style='border-collapse: collapse; border: 1px solid black;width: 100%; padding: 15px;text-align: left;overflow-x:auto;'>
	
	<tr  style='height: 50px;'>
	<th style='border: 1px solid black;text-align:center;'></th>
	<th style='border: 1px solid black;text-align:center;'></th>
	
  </tr>

<tbody >
<tr  style='height: 50px;'>
	<td style='border: 1px solid black;text-align:left;'>
	<h3> <b> HEMATOLOGY  </b> </h3>
	Hgb :  <b> $Hgh </b> <br>
	BF. For Malaria : <b>  $bf_malaria </b> <br>
	TWBC :  <b>  $twbc </b>  <br>
	Diff. Count : <b>  $diff_count </b>   <br>
	V.D.R.L : <b>  $vdrl </b>   <br>
	WIDAL Test : <b>  $widal </b>  <br>
	Others : <b>  $others_hematology </b>   <br>
	
	</td>
	<td col-span = '2' style='border: 1px solid black;text-align:left;'>   

RBS : <b> $RBS </b> <br>
FBS : <b> $FBS </b> <br>

ERS :  <b>  $ERS </b>   <br>
Morphology : <b>  $Morphology </b>  <br>
HCG : <b>  $HCG  </b>  <br>
H. Pylori : <b>  $H_Pylori </b>  <br>
Brucella Test : <b>  $Brucella_test </b>  <br>
Hgb. A1C : <b>  $Hgb </b>  <br>

HIV : <b>  $HIV </b>  <br>
HBV : <b>  $HBV </b>  <br>
HCV : <b>  $HCV </b>  <br>
	
	
	</td>
	
  </tr>      
  <tr  style='height: 50px;'>
	<td style='border: 1px solid black;text-align:left;'>
<h3> <b> URINE ANALYSIS </b> </h3>
Colour : <b>  $color_urine </b> <br>
Reaction : <b>  $reaction_urine </b> <br>
Albumin : <b>  $albumin </b> <br>
Sugar : <b>  $sugar </b> <br>
Acetone : <b>  $acetone </b> <br>
Bile Pigment : <b>  $bile_pigment </b> <br>

	</td>
	<td style='border: 1px solid black;text-align:left;'> 
	
	<h3> <b> STOOL ANALYSIS </b></h3> 
	Colour  :  <b>  $color </b> <br>
	Consist :  <b> $consist </b> <br>
	Reaction : <b>  $reaction </b> <br>
	Mucus :    <b>  $mucus </b> <br>
	Blood :    <b>  $blood </b> <br>
	Worms :    <b>  $worms </b> <br>
	
	</td>

  </tr>


  <tr  style='height: 50px;'>
  <td style='border: 1px solid black;text-align:left;'>
<h3> <b>  MICROSCOPY  </b> </h3>
Pus Cell : <b>  $pus_cell_microsopy </b> <br>
RBC :      <b>  $RBC </b> <br>

Crystal :  <b> $crystall </b> <br>
Epc :      <b>  $EPC </b>  <br>  
Ova :	   <b>   $Ova  </b><br>
Others :   <b>   $other_microscopy </b> <br>

  </td>
  <td style='border: 1px solid black;text-align:left;'>  
  <h3> <b> DIRECT MICROSCOPY </b> </h3>
  Pus Cells : <b>  $Pus_Cells_direct_microscopy </b> <br>
  R.B. Cs :   <b>  $RBCS </b> <br>
  O/P :       <b>  $o_p </b>  <br>
  H.Pylori(Ag) :  <b>  $H_Pylori_Ag_ </b>  <br>
  </td>

</tr>


  


</tbody>
</table>
</div>

<br><br>
<div class='panel-body form-group form-group-sm'>
<table class='table table-striped table-hover table-bordered'>
 


  <tbody>
	<tr class='table-primary' style='background-color:lightgrey'>
	  <td><span >  Prepared By  <b> <u> $name </u></b> </span> </td>
     </tr>      
	<tr class='table-primary'>

	<td><span >  Signature   <b> <u>_____________________ </u></b> </span> </td>
  </tr>
  
  </tbody>
</table>
</div>

</body>
</html>";







   if( $result_query == true ){
	$search = '/';
	$replace = '_';
	$subject = $invoice;

	$invoice_number = str_replace($search, $replace, $subject);


	$file_name = 'Hematology/'.$invoice_number."_".time().".pdf";

	$header = [
		'Content-Type' => 'application/pdf',
		'Content-Disposition' => 'inline: filename="' . $file_name . '"'];
		$mpdf= new PDFF([
			'mode' => "utf-8",
			'format' => COMPANY_SIZE_PAPER,
			'margin_header' => "5",
			'margin_top' => "50",
			'margin_bottom' => "15",
			'margin_footer' => "2",
		]);

		$mpdf->SetHTMLHeader(COMPANY_Header);
		$mpdf->SetHTMLFooter(COMPANY_Footer);

		$body1 = htmlspecialchars_decode($html);
		$mpdf->WriteHTML($body1, HTMLParserMode::HTML_BODY);

		$mpdf->showWatermarkText = true;
		$mpdf->SetWatermarkText('Mekane Hiwot Clinic ');
		 $mpdf->watermarkTextAlpha = 0.1;
		// $mpdf->SetDisplayMode('fullpage');
		// $mpdf->list_indent_first_level = 0; 


		$file = $mpdf->Output($file_name, 'F');

		



		$update_query = "update  labaratory_test set   `hematology_generated_file_path` = '$file_name', `hematology_status`= '1' where invoice = '$invoice' ";
		$result_query = $mysqli->query($update_query);
		

			//if saving success
	echo json_encode(array(
		'status' => 'Success',
		'Download' => $file_name, 
		'mode' => $hematology,
		'hema_live_status' => 1,
		'message'=> 'Hematology Test has been '.$hematology.' successfully.'
	));




} else {
	//if unable to create new record
	echo json_encode(array(
		'status' => 'Error',
		//'message'=> 'There has been an error, please try again.'
		'message' => '5There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$result_query.'</pre>'
	));
}
//close database connection
$mysqli->close();








}












// Dr calculating how many requests has sent for a particular Task or invoice 


if ($action == 'table_request_form_lab'){

    $invoice_id = $_POST['invoice_id'];
	@$cashier_invoice_created  = $_POST['cashier_invocie_created'];
	$i = 1;
	$return_data ='';
	$Labratory_Test = '';

     $get_list_task_tracker  = "SELECT * , labaratory_test.invoice  as li  FROM invoices i  JOIN task_tracker  t  ON i.invoice = t.task_tracker_related_id 
	
	LEFT JOIN labaratory_test ON labaratory_test.invoice  = i.invoice  WHERE t.task_tracker_related_id = '$invoice_id' ORDER BY t.Timestamp ";

   // mysqli select query
    $results = $mysqli->query($get_list_task_tracker);

	while ($row = $results->fetch_assoc())

	  {
		$l_status='';
		$assigned_lab_technicians = $row['assigned_lab_technicians'];
        $assigned_cashier = $row['assigned_cashier'];
		$Sender_id   = $row['Sender_id'];

	    $lab_name = "SELECT * from users  where id  = $assigned_lab_technicians ";	 $results_lab = $mysqli->query($lab_name); $results_lab_name = $results_lab->fetch_assoc();
		$cashier_name = "SELECT * from users  where id  = $assigned_cashier";	 $results_cashier = $mysqli->query($cashier_name);$results_cashier_name = $results_cashier->fetch_assoc();
	   $dr_name = "SELECT * from users  where id  = $Sender_id   ";	 $results_dr = $mysqli->query($dr_name); $results_dr_name = $results_dr->fetch_assoc();
	

  $lab_test = "SELECT * from labaratory_test  where id  = $Sender_id   ";	 $results_dr = $mysqli->query($dr_name); $results_dr_name = $results_dr->fetch_assoc();
  $cashier_status =  $row['cashier_task_invoice_status'];


	if($cashier_status  ==0 ) { $ca_status = '<span class="label label-warning"> requested </span> '; } else {   $ca_status = '<span class="label label-success">Done </span>  &nbsp;&nbsp;  <a href="'.$row['cashier_invoice_download_link'].'" class="btn btn-danger  btn-xs "> <span class="glyphicon glyphicon-download" aria-hidden="true"></span></a>';   }


         $invoice_created =  $row['cashier_task_invoice_id'];

	     $lab_test_result = "SELECT * from labaratory_test  where invoice  = '$invoice_created'   ";
		 $results_lab = $mysqli->query($lab_test_result); 
		 $results_labs_name = $results_lab->fetch_assoc();



         $lab_status =  $results_labs_name['notify_to_dr'];
	
	

	if($lab_status  == 0 ) { $l_status = '<span class="label label-warning"> requested "'. $invoice_created.'" </span> '; } else 
	
	{         
		
		
if(isset( $results_labs_name['hematology_generated_file_path'])){
        $l_status .= '<span class="label label-primary"> Hematology  &nbsp;&nbsp; &nbsp;&nbsp;</span><a target="_blank"  href="'. $results_labs_name['hematology_generated_file_path'].'" class="btn btn-success  btn-xs "> <span class="glyphicon glyphicon-download" aria-hidden="true"></span></a><br>';
}
if(isset($results_labs_name['lipid_generated_file_path'])){
		$l_status .= '<span class="label label-primary"> Lipid  &nbsp;&nbsp;  &nbsp;&nbsp;</span> <a target="_blank" href="'.$results_labs_name['lipid_generated_file_path'].'" class="btn btn-success  btn-xs "> <span class="glyphicon glyphicon-download" aria-hidden="true"></span></a><br>';
}
if(isset($results_labs_name['renal_generated_file'] )){	
		
		$l_status .= '<span class="label label-primary"> Renal &nbsp;&nbsp;  &nbsp;&nbsp;</span><a target="_blank" href="'.$results_labs_name['renal_generated_file'].'" class="btn btn-success  btn-xs "> <span class="glyphicon glyphicon-download" aria-hidden="true"></span></a><br>';
}
if(isset($results_labs_name['liver_generated_file'])){	
		
		$l_status .= '<span class="label label-primary"> Liver  &nbsp;&nbsp;  &nbsp;&nbsp;</span><a target="_blank"  href="'.$results_labs_name['liver_generated_file'].'" class="btn btn-success  btn-xs "> <span class="glyphicon glyphicon-download" aria-hidden="true"></span></a><br>';
}




	 }
	
   $Get_main_task = explode(',',$row['main_task']);
   if($Get_main_task[0] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= '<b> GENERAL TEST- </b>[<i style="color:orange">'.$row['Test_Type'].'&nbsp;</i> ]<br>';}
   if($Get_main_task[1] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= '<b> LIPID-&nbsp;</b>';}
   if($Get_main_task[2] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= '<b> LIVER- &nbsp;</b>';}
   if($Get_main_task[3] ==0 ) { $Labratory_Test .= '';} else { $Labratory_Test .= '<b> RENAL- &nbsp;</b>';}

   $lab_invoice_id =  $row['li'];

   //check Status 





		$return_data .= "<tr><td>" . $i++ . "</td>";
		$return_data .= "<td id='seqence_number'>" .$row['task_tracker_related_id']. "</td>";
		$return_data .= "<td>" . $row['task_tracker_description']. "</td>";
        $return_data .= "<td>" . $results_dr_name['name']. "</td>";		
		$return_data .= "<td>" . $results_lab_name ['name']. "</td>";
		$return_data .= "<td>" . $results_cashier_name['name']. "</td>";
		$return_data .= "<td>" . $Labratory_Test . "</td>";
		$return_data .= "<td>" . $ca_status. "</td>";
		$return_data .= "<td>" . $l_status. "</td>";


		$return_data .= "<td>" . $row['Timestamp']. "</td>";
		$Labratory_Test = '';

	  }



	
	echo json_encode(array(
		'status' => 'Error',
		'data_returned' => $return_data ,
		'message' => 'There has been an error, please try again.',
		// debug
		//'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	));





}



// Create customer
if ($action == 'send_request_to_lab'){

	$hematology = $_POST['hematology']; // hematology
	$lipid = $_POST['lipid']; // lipid'
	$liver = $_POST['liver']; // liver
	$renal = $_POST['renal']; // renal
	$test = $_POST['test']; //Test

	$search = ',';
	$replace = '<BR>';
	$subject = $test;

	$test = str_replace($search, $replace, $subject);


	$labaratorist_name = $_POST['labaratorist_name']; //labaratorist_name
	$user_type_chasier = $_POST['user_type_chasier']; //user_type_chasier

	$invoice_id = $_POST['invoice_id']; // invoice_id

    $dr_requested_test = $hematology.",".$lipid.",".$liver.",".$renal;


	$get_labaratorist_name = "SELECT * from users where id =$labaratorist_name ";
    // mysqli select query
    $results = $mysqli->query($get_labaratorist_name );
	$row = $results->fetch_assoc();
	$user_name_lab = $row['name'];


	$user_type_chash  = "SELECT * from users where id =  '$user_type_chasier'";
    // mysqli select query
    $results = $mysqli->query($user_type_chash );
	$row = $results->fetch_assoc();
	$user_name_chasier = $row['name'];





	$query = "UPDATE invoices SET
				dr_requested_test = ?,
				assigned_lab_technicians = ?,
				assigned_cashier =?
				WHERE invoice = ?
			";

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param(
		'ssss',
		$dr_requested_test,
		$labaratorist_name,
		$user_type_chasier,
		$invoice_id
	);
    



	session_start();
	$current_login_user = $_SESSION['login_user_id'] ;



	//Insert to Task Tracker 
    $task_tracker_name = 'Lab Request';
	$task_tracker_related_id = $invoice_id;
	$task_tracker_description = 'Dr sending inquiries to Labaratory----'.$user_name_lab;
	$task_tracker_description .= 'Dr sending inquiries to Cashier----'.$user_name_chasier;
	

	$Active_entites_for_invoice = $user_type_chasier.",".$labaratorist_name;



$query = "INSERT INTO task_tracker(Test_Type,task_tracker_name,task_tracker_related_id,task_tracker_description,main_task,Sender_id,Receiver_id,timestamp )

VALUES ('$test','$task_tracker_name', '$task_tracker_related_id','$task_tracker_description','$dr_requested_test','$current_login_user','$Active_entites_for_invoice',NOW())";

$results = $mysqli->query($query);



	//Sent Notification TO LabTechnician 
    $subject = 'Lab Request';
	$message = 'A patient with invoice Id '.$invoice_id.' wanted to take a Lab Test';

$labaratorist_id = $labaratorist_name;
$cashier_id = $user_type_chasier; 


	$query = "INSERT INTO notification(`subject`,`message`,`status`,`user_id`,`timestamp` )
	                             VALUES    ('$subject', '$message',0,$labaratorist_id,NOW() )";

            $results = $mysqli->query($query);


    $query = "INSERT INTO notification(`subject`,`message`,`status`,`user_id`,`timestamp` )
                                 VALUES    ('$subject', '$message',0,$cashier_id,NOW() )";

            $results = $mysqli->query($query);





	//execute the query
	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'You have sent an Inqury to Lab technician Mr./Ms.  <b style="color:orange">'.$user_name_lab.'</b> <br> Success: You have sent an Inqury to Cashier Mr./Ms. <b style="color:orange"> '.$user_name_chasier."</b>"
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}
            //close database connection
	         $mysqli->close();
	
	
}



///create_invoice_from_invoice


  if($action == 'create_invoice_from_invoice')
  {

// invoice customer information
	// billing
	$tranaction_id =  addslashes($_POST['transaction_id']);
	$customer_name = addslashes($_POST['customer_name']); // customer name
	$customer_email =addslashes( $_POST['customer_town']); // customer email
	$customer_address_1 = addslashes($_POST['customer_age']); // customer age
	$customer_address_2 = addslashes($_POST['customer_sex']); // customer address
	$customer_town = addslashes($_POST['customer_town']); // customer town
	$customer_county = '';//addslashes($_POST['customer_town']); // customer county
	$customer_postcode = addslashes($_POST['customer_date_of_reg']); // customer postcode

	$customer_company_name =  addslashes($_POST['customer_company_name']); // Company_name

	$customer_phone = '';// addslashes($_POST['customer_age']); // customer phone number
	
	//shipping  //Changed to Dr/ Physician Information doctor_name doctor_email doctor_title

	$customer_name_ship = addslashes($_POST['doctor_name']); // physician_full_name (shipping)
	$customer_address_1_ship = addslashes($_POST['doctor_email']); // customer address (shipping)
	$customer_address_2_ship = addslashes($_POST['doctor_title']); // customer address (shipping)
	$customer_town_ship = '';//addslashes($_POST['doctor_title']); // customer town (shipping)
	$customer_county_ship = '';//addslashes($_POST['doctor_title']); // customer county (shipping)
	$customer_postcode_ship = '';//addslashes($_POST['doctor_title']); // customer postcode (shipping)

	// invoice details
	$invoice_number = addslashes($_POST['invoice_id']); // invoice number
	$custom_email = addslashes($_POST['custom_email']); // invoice custom email body

	//Date Invoice 
	$invoice_date = ($_POST['invoice_date']); // invoice date
	$inv_date =  explode('/',$invoice_date);
	$inv_date = $inv_date[2]."-".$inv_date[1]."-".$inv_date[0];
    
	$date=date_create($inv_date);
	$invoice_date = date_format($date,"Y-m-d");




	$custom_email = addslashes($_POST['custom_email']); // custom invoice email

	//Date Invoice_due
	$invoice_due_date = ($_POST['invoice_due_date']); // invoice due date
	$inv_date =  explode('/',$invoice_due_date);
	$inv_date = $inv_date[2]."-".$inv_date[1]."-".$inv_date[0];
    $date=date_create($inv_date);
	$invoice_due_date= date_format($date,"Y-m-d");

	$invoice_subtotal = addslashes($_POST['invoice_subtotal']); // invoice sub-total
	$invoice_shipping = addslashes($_POST['servicecharge']); // invoice shipping amount
	$invoice_discount = addslashes($_POST['invoice_discount']); // invoice discount
	//$invoice_vat = $_POST['invoice_vat']; // invoice vat
	$invoice_total = addslashes($_POST['invoice_total']); // invoice total
	$invoice_notes = addslashes($_POST['invoice_notes']); // Invoice notes
	$invoice_type = addslashes($_POST['invoice_type']); // Invoice type
	$invoice_status = addslashes($_POST['invoice_status']); // Invoice status

	session_start();
	$_SESSION['login_username'];
	$id = $_SESSION['login_user_id'];

	// insert invoice into database
	 $query = "INSERT INTO invoices (
					invoice,
					custom_email,
					invoice_date, 
					invoice_due_date, 
					subtotal, 
					shipping, 
					discount, 
					vat, 
					total,
					notes,
					invoice_type,
					invoice_registration,
					invoice_intially_created_by,
					status
				) VALUES (
				  	'".$invoice_number."',
				  	'".$custom_email."',
				  	'".$invoice_date."',
				  	'".$invoice_due_date."',
				  	'".$invoice_subtotal."',
				  	'".$invoice_shipping."',
				  	'".$invoice_discount."',
				  	'0',
				  	'".$invoice_total."',
				  	'".$invoice_notes."',
				  	'".$invoice_type."',
					'new',
					'".$id."',
				  	'".$invoice_status."'
			    );
			";

			
	// insert customer details into database
	$query .= "INSERT INTO customers (
					invoice,
					name,
					email,
					address_1,
					address_2,
					town,
					county,
					postcode,
					phone,
					name_ship,
					address_1_ship,
					address_2_ship,
					town_ship,
					county_ship,
					postcode_ship,
					company_name
				) VALUES (
					'".$invoice_number."',
					'".$customer_name."',
					'".$customer_email."',
					'".$customer_address_1."',
					'".$customer_address_2."',
					'".$customer_town."',
					'".$customer_county."',
					'".$customer_postcode."',
					'".$customer_phone."',
					'".$customer_name_ship."',
					'".$customer_address_1_ship."',
					'".$customer_address_2_ship."',
					'".$customer_town_ship."',
					'".$customer_county_ship."',
					'".$customer_postcode_ship."',
					'".$customer_company_name."'
				);
			";


	// invoice product items
	foreach($_POST['invoice_product'] as $key => $value) {
	    //$item_product = addslashes($value);
		

		$item_product= str_replace("'", '', $value);

	    // $item_description = $_POST['invoice_product_desc'][$key];
	    $item_qty = addslashes($_POST['invoice_product_qty'][$key]);
	    $item_price = addslashes($_POST['invoice_product_price'][$key]);
	    $item_discount = addslashes($_POST['invoice_product_discount'][$key]);
	    $item_subtotal = addslashes($_POST['invoice_product_sub'][$key]);

	    // insert invoice items into database
		$query .= "INSERT INTO invoice_items (
				invoice,
				product,
				qty,
				price,
				discount,
				subtotal
			) VALUES (
				'".$invoice_number."',
				'".$item_product."',
				'".$item_qty."',
				'".$item_price."',
				'".$item_discount."',
				'".$item_subtotal."'
			);
		";

	}

	header('Content-Type: application/json');

	// execute the query
	if($mysqli -> multi_query($query)){
		//if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message' => 'Invoice has been created successfully!',
			'invoice_type' => $invoice_type
		));

		//Set default date timezone
		date_default_timezone_set(TIMEZONE);
		//Include Invoicr class
		include('invoice.php');
		//Create a new instance
		$invoice = new invoicr("A4",CURRENCY,"en");
		//Set number formatting
		$invoice->setNumberFormat('.',',');
		//Set your logo
		$invoice->setLogo(COMPANY_LOGO,COMPANY_LOGO_WIDTH,COMPANY_LOGO_HEIGHT);
		//Set theme color
		$invoice->setColor(INVOICE_THEME);
		//Set type
		$invoice->setType($invoice_type);
		//Set reference
		$invoice->setReference($invoice_number);
		//Set date
		$invoice->setDate($invoice_date);
		//Set due date
		$invoice->setDue($invoice_due_date);
		//Set from
		
		@$invoice->setFrom(array(COMPANY_NAME,COMPANY_ADDRESS_1,COMPANY_ADDRESS_2,COMPANY_COUNTY,COMPANY_POSTCODE,COMPANY_NAME_,COMPANY_NUMBER,COMPANY_NUMBER2));
		
		
		//Set to
		@$invoice->setTo(array($customer_name,$customer_address_1,$customer_address_2,$customer_town,$customer_county,$customer_postcode,$customer_company_name,"Phone: ".$customer_phone));
		
		
		
		//Ship to
		@$invoice->shipTo(array($customer_name_ship,$customer_address_1_ship,$customer_address_2_ship,$customer_town_ship,$customer_county_ship,$customer_postcode_ship,''));
		//Add items
		// invoice product items
		foreach($_POST['invoice_product'] as $key => $value) {

		    $item_product =($value);


		    // $item_description = $_POST['invoice_product_desc'][$key];
		    $item_qty = $_POST['invoice_product_qty'][$key];
		    $item_price = $_POST['invoice_product_price'][$key];
		    $item_discount = $_POST['invoice_product_discount'][$key];
		    $item_subtotal = $_POST['invoice_product_sub'][$key];

		   	if(ENABLE_VAT == false) {
		   		$item_vat = (VAT_RATE / 100) * $item_subtotal;
		   	}

		    $invoice->addItem($item_product,'',$item_qty,$item_vat,$item_price,$item_discount,$item_subtotal);
		}
		//Add totals
		$invoice->addTotal("Total",$invoice_subtotal);
		if(!empty($invoice_discount)) {
			$invoice->addTotal("Discount",$invoice_discount);
		}
		if(!empty($invoice_shipping)) {
			$invoice->addTotal("Service charge",$invoice_shipping);
		}
		if(ENABLE_VAT == true) {
			$invoice->addTotal("TAX/VAT ".VAT_RATE."%",$invoice_vat);
		}
		$invoice->addTotal("Total Due",$invoice_total,true);


		//Add Badge
		$invoice->addBadge($invoice_status);
        $invoice->SetTextColor(204,0,0);

		// Customer notes:
		if(!empty($invoice_notes)) {
			$invoice->addTitle("Customer Notes");
			$invoice->addParagraph($invoice_notes);
		}
		//Add Title
		$invoice->addTitle("Payment information");
		//Add Paragraph
		$invoice->addParagraph(PAYMENT_DETAILS);
		//Set footer note
		$invoice->setFooternote(FOOTER_NOTE);
		//Render the PDF
         
		$search = '/';
		$replace = '_';
		$subject = $invoice_number;

		$invoice_number = str_replace($search, $replace, $subject);

		$invoice->render('invoices/'.$invoice_number.'.pdf','F');

		$link ='invoices/'.$invoice_number.'.pdf';

		$subject = trim($subject);

		  // Connect to the database
		  $mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);
		  $query_update = "UPDATE task_tracker SET  `cashier_task_invoice_status` = 1 , `cashier_task_invoice_id` = '$subject',  `status`= 'Payment Finishied', `cashier_invoice_download_link` = '$link'  WHERE `id` = '$tranaction_id' ";
   
		  $results = $mysqli->query($query_update);


	} else {
		// if unable to create invoice
		echo json_encode(array(
			'status' => 'Error',
			//'message' => 'There has been an error, please try again.'
			// debug
			//'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
		));
	}

	//close database connection
	$mysqli->close();

}



// Adding new product
if($action == 'delete_invoice') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$id = $_POST["delete"];

	// the query
	$query = "DELETE FROM invoices WHERE invoice = '".$id."';";
	$query .= "DELETE FROM customers WHERE invoice = '".$id."';";
	$query .= "DELETE FROM invoice_items WHERE invoice = '".$id."';";

	@unlink('invoices/'.$id.'.pdf');

	if($mysqli -> multi_query($query)) {
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Invoice has been deleted successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	// close connection 
	$mysqli->close();

}

// Adding new product
if($action == 'update_customer') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$getID = $_POST['id']; // id

	// invoice customer information
	// billing
	$customer_name = $_POST['customer_name']; // customer name
	$customer_age = $_POST['customer_age']; // customer age
	$customer_sex = $_POST['customer_sex']; // customer Sex
	$customer_town = $_POST['customer_town']; // customer Town
	$customer_assinged_dr = $_POST['customer_assigned_dr']; // customer Assigned Dr
	$customer_date_of_reg = $_POST['customer_date_of_reg']; // customer Date of regisration
	$customer_company_name = $_POST['customer_company_name']; // customer_company_name


	// the query
	$query = "UPDATE store_customers SET
				name = ?,
				town = ?,
				age = ?,
                sex = ?,
                assigned_dr = ?,
				date_of_reg=?,
				company_name=?
				
                WHERE id = ?

			";

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param(
		'ssssssss',
		$customer_name,$customer_town,$customer_age,$customer_sex,$customer_assinged_dr,$customer_date_of_reg,	$customer_company_name,$getID);

	//execute the query
	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Patients has been updated successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	//close database connection
	$mysqli->close();
	
}

// Update product
if($action == 'update_product') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// invoice product information
	$getID = $_POST['id']; // id
	$product_name = $_POST['product_name']; // product name
	$product_desc = $_POST['product_desc']; // product desc
	$product_price = $_POST['product_price']; // product price

	// the query
	$query = "UPDATE products SET
				product_name = ?,
				product_desc = ?,
				product_price = ?
			 WHERE product_id = ?
			";

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param(
		'ssss',
		$product_name,$product_desc,$product_price,$getID
	);

	//execute the query
	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Product has been updated successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	//close database connection
	$mysqli->close();


  }





// Create invoice
if ($action == 'create_invoice'){

	// invoice customer information
	// billing
	$customer_name = addslashes($_POST['customer_name']); // customer name
	$customer_email =addslashes( $_POST['customer_town']); // customer email
	$customer_address_1 = addslashes($_POST['customer_age']); // customer age
	$customer_address_2 = addslashes($_POST['customer_sex']); // customer address
	$customer_town = addslashes($_POST['customer_town']); // customer town
	$customer_county = '';//addslashes($_POST['customer_town']); // customer county
	$customer_postcode = addslashes($_POST['customer_date_of_reg']); // customer postcode

	$customer_company_name =  addslashes($_POST['customer_company_name']); // Company_name

	$customer_phone = '';// addslashes($_POST['customer_age']); // customer phone number
	
	//shipping  //Changed to Dr/ Physician Information doctor_name doctor_email doctor_title

	$customer_name_ship = addslashes($_POST['doctor_name']); // physician_full_name (shipping)
	$customer_address_1_ship = addslashes($_POST['doctor_email']); // customer address (shipping)
	$customer_address_2_ship = addslashes($_POST['doctor_title']); // customer address (shipping)
	$customer_town_ship = '';//addslashes($_POST['doctor_title']); // customer town (shipping)
	$customer_county_ship = '';//addslashes($_POST['doctor_title']); // customer county (shipping)
	$customer_postcode_ship = '';//addslashes($_POST['doctor_title']); // customer postcode (shipping)

	// invoice details
	$invoice_number = addslashes($_POST['invoice_id']); // invoice number
	$custom_email = addslashes($_POST['custom_email']); // invoice custom email body

	//Date Invoice 
	$invoice_date = ($_POST['invoice_date']); // invoice date
	$inv_date =  explode('/',$invoice_date);
	$inv_date = $inv_date[2]."-".$inv_date[1]."-".$inv_date[0];
    
	$date=date_create($inv_date);
	$invoice_date = date_format($date,"Y-m-d");




	$custom_email = addslashes($_POST['custom_email']); // custom invoice email

	//Date Invoice_due
	$invoice_due_date = ($_POST['invoice_due_date']); // invoice due date
	$inv_date =  explode('/',$invoice_due_date);
	$inv_date = $inv_date[2]."-".$inv_date[1]."-".$inv_date[0];
    $date=date_create($inv_date);
	$invoice_due_date= date_format($date,"Y-m-d");

	$invoice_subtotal = addslashes($_POST['invoice_subtotal']); // invoice sub-total
	$invoice_shipping = addslashes($_POST['servicecharge']); // invoice shipping amount
	$invoice_discount = addslashes($_POST['invoice_discount']); // invoice discount
	//$invoice_vat = $_POST['invoice_vat']; // invoice vat
	$invoice_total = addslashes($_POST['invoice_total']); // invoice total
	$invoice_notes = addslashes($_POST['invoice_notes']); // Invoice notes
	$invoice_type = addslashes($_POST['invoice_type']); // Invoice type
	$invoice_status = addslashes($_POST['invoice_status']); // Invoice status

	session_start();
	$_SESSION['login_username'];
	$id = $_SESSION['login_user_id'];

	// insert invoice into database
	 $query = "INSERT INTO invoices (
					invoice,
					custom_email,
					invoice_date, 
					invoice_due_date, 
					subtotal, 
					shipping, 
					discount, 
					vat, 
					total,
					notes,
					invoice_type,
					invoice_registration,
					invoice_intially_created_by,
					status
				) VALUES (
				  	'".$invoice_number."',
				  	'".$custom_email."',
				  	'".$invoice_date."',
				  	'".$invoice_due_date."',
				  	'".$invoice_subtotal."',
				  	'".$invoice_shipping."',
				  	'".$invoice_discount."',
				  	'0',
				  	'".$invoice_total."',
				  	'".$invoice_notes."',
				  	'".$invoice_type."',
					'new',
					'".$id."',
				  	'".$invoice_status."'
			    );
			";

			
	// insert customer details into database
	$query .= "INSERT INTO customers (
					invoice,
					name,
					email,
					address_1,
					address_2,
					town,
					county,
					postcode,
					phone,
					name_ship,
					address_1_ship,
					address_2_ship,
					town_ship,
					county_ship,
					postcode_ship,
					company_name
				) VALUES (
					'".$invoice_number."',
					'".$customer_name."',
					'".$customer_email."',
					'".$customer_address_1."',
					'".$customer_address_2."',
					'".$customer_town."',
					'".$customer_county."',
					'".$customer_postcode."',
					'".$customer_phone."',
					'".$customer_name_ship."',
					'".$customer_address_1_ship."',
					'".$customer_address_2_ship."',
					'".$customer_town_ship."',
					'".$customer_county_ship."',
					'".$customer_postcode_ship."',
					'".$customer_company_name."'
				);
			";


	// invoice product items
	foreach($_POST['invoice_product'] as $key => $value) {
	    //$item_product = addslashes($value);
		

		$item_product= str_replace("'", '', $value);

	    // $item_description = $_POST['invoice_product_desc'][$key];
	    $item_qty = addslashes($_POST['invoice_product_qty'][$key]);
	    $item_price = addslashes($_POST['invoice_product_price'][$key]);
	    $item_discount = addslashes($_POST['invoice_product_discount'][$key]);
	    $item_subtotal = addslashes($_POST['invoice_product_sub'][$key]);

	    // insert invoice items into database
		$query .= "INSERT INTO invoice_items (
				invoice,
				product,
				qty,
				price,
				discount,
				subtotal
			) VALUES (
				'".$invoice_number."',
				'".$item_product."',
				'".$item_qty."',
				'".$item_price."',
				'".$item_discount."',
				'".$item_subtotal."'
			);
		";

	}

	header('Content-Type: application/json');

	// execute the query
	if($mysqli -> multi_query($query)){
		//if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message' => 'Invoice has been created successfully!',
			'invoice_type' => $invoice_type
		));

		//Set default date timezone
		date_default_timezone_set(TIMEZONE);
		//Include Invoicr class
		include('invoice.php');
		//Create a new instance
		$invoice = new invoicr("A4",CURRENCY,"en");
		//Set number formatting
		$invoice->setNumberFormat('.',',');
		//Set your logo
		$invoice->setLogo(COMPANY_LOGO,COMPANY_LOGO_WIDTH,COMPANY_LOGO_HEIGHT);
		//Set theme color
		$invoice->setColor(INVOICE_THEME);
		//Set type
		$invoice->setType($invoice_type);
		//Set reference
		$invoice->setReference($invoice_number);
		//Set date
		$invoice->setDate($invoice_date);
		//Set due date
		$invoice->setDue($invoice_due_date);
		//Set from
		
		@$invoice->setFrom(array(COMPANY_NAME,COMPANY_ADDRESS_1,COMPANY_ADDRESS_2,COMPANY_COUNTY,COMPANY_POSTCODE,COMPANY_NAME_,COMPANY_NUMBER,COMPANY_NUMBER2));
		
		
		//Set to
		@$invoice->setTo(array($customer_name,$customer_address_1,$customer_address_2,$customer_town,$customer_county,$customer_postcode,$customer_company_name,"Phone: ".$customer_phone));
		
		
		
		//Ship to
		@$invoice->shipTo(array($customer_name_ship,$customer_address_1_ship,$customer_address_2_ship,$customer_town_ship,$customer_county_ship,$customer_postcode_ship,''));
		//Add items
		// invoice product items
		foreach($_POST['invoice_product'] as $key => $value) {

		    $item_product =($value);


		    // $item_description = $_POST['invoice_product_desc'][$key];
		    $item_qty = $_POST['invoice_product_qty'][$key];
		    $item_price = $_POST['invoice_product_price'][$key];
		    $item_discount = $_POST['invoice_product_discount'][$key];
		    $item_subtotal = $_POST['invoice_product_sub'][$key];

		   	if(ENABLE_VAT == false) {
		   		$item_vat = (VAT_RATE / 100) * $item_subtotal;
		   	}

		    $invoice->addItem($item_product,'',$item_qty,$item_vat,$item_price,$item_discount,$item_subtotal);
		}
		//Add totals
		$invoice->addTotal("Total",$invoice_subtotal);
		if(!empty($invoice_discount)) {
			$invoice->addTotal("Discount",$invoice_discount);
		}
		if(!empty($invoice_shipping)) {
			$invoice->addTotal("Service charge",$invoice_shipping);
		}
		if(ENABLE_VAT == true) {
			$invoice->addTotal("TAX/VAT ".VAT_RATE."%",$invoice_vat);
		}
		$invoice->addTotal("Total Due",$invoice_total,true);


		//Add Badge
		$invoice->addBadge($invoice_status);
        $invoice->SetTextColor(204,0,0);

		// Customer notes:
		if(!empty($invoice_notes)) {
			$invoice->addTitle("Customer Notes");
			$invoice->addParagraph($invoice_notes);
		}
		//Add Title
		$invoice->addTitle("Payment information");
		//Add Paragraph
		$invoice->addParagraph(PAYMENT_DETAILS);
		//Set footer note
		$invoice->setFooternote(FOOTER_NOTE);
		//Render the PDF
         
		$search = '/';
		$replace = '_';
		$subject = $invoice_number;

		$invoice_number = str_replace($search, $replace, $subject);

		$invoice->render('invoices/'.$invoice_number.'.pdf','F');
	} else {
		// if unable to create invoice
		echo json_encode(array(
			'status' => 'Error',
			//'message' => 'There has been an error, please try again.'
			// debug
			//'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
		));
	}

	//close database connection
	$mysqli->close();

}



// Adding new product
if($action == 'delete_invoice') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$id = $_POST["delete"];

	// the query
	$query = "DELETE FROM invoices WHERE invoice = '".$id."';";
	$query .= "DELETE FROM customers WHERE invoice = '".$id."';";
	$query .= "DELETE FROM invoice_items WHERE invoice = '".$id."';";

	@unlink('invoices/'.$id.'.pdf');

	if($mysqli -> multi_query($query)) {
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Invoice has been deleted successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	// close connection 
	$mysqli->close();

}

// Adding new product
if($action == 'update_customer') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$getID = $_POST['id']; // id

	// invoice customer information
	// billing
	$customer_name = $_POST['customer_name']; // customer name
	$customer_age = $_POST['customer_age']; // customer age
	$customer_sex = $_POST['customer_sex']; // customer Sex
	$customer_town = $_POST['customer_town']; // customer Town
	$customer_assinged_dr = $_POST['customer_assigned_dr']; // customer Assigned Dr
	$customer_date_of_reg = $_POST['customer_date_of_reg']; // customer Date of regisration
	$customer_company_name = $_POST['customer_company_name']; // customer_company_name


	// the query
	$query = "UPDATE store_customers SET
				name = ?,
				town = ?,
				age = ?,
                sex = ?,
                assigned_dr = ?,
				date_of_reg=?,
				company_name=?
				
                WHERE id = ?

			";

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param(
		'ssssssss',
		$customer_name,$customer_town,$customer_age,$customer_sex,$customer_assinged_dr,$customer_date_of_reg,	$customer_company_name,$getID);

	//execute the query
	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Patients has been updated successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	//close database connection
	$mysqli->close();
	
}

// Update product
if($action == 'update_product') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// invoice product information
	$getID = $_POST['id']; // id
	$product_name = $_POST['product_name']; // product name
	$product_desc = $_POST['product_desc']; // product desc
	$product_price = $_POST['product_price']; // product price

	// the query
	$query = "UPDATE products SET
				product_name = ?,
				product_desc = ?,
				product_price = ?
			 WHERE product_id = ?
			";

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param(
		'ssss',
		$product_name,$product_desc,$product_price,$getID
	);

	//execute the query
	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Product has been updated successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	//close database connection
	$mysqli->close();
	
}


// Adding new product
if($action == 'update_invoice') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$id = $_POST["update_id"];

	// // the query
	// $query = "DELETE FROM invoices WHERE invoice = ".$id.";";
	// //$query .= "DELETE FROM customers WHERE invoice = ".$id.";";
	// $query .= "DELETE FROM invoice_items WHERE invoice = ".$id.";";

	// unlink('invoices/'.$id.'.pdf');

	// invoice customer information

	$query = ""; 


	// billing
	$customer_name = $_POST['customer_name']; // customer name
	$customer_email = $_POST['customer_email']; // customer email
	$customer_address_1 = $_POST['customer_address_1']; // customer address
	$customer_address_2 = $_POST['customer_address_2']; // customer address
	$customer_town = $_POST['customer_town']; // customer town
	$customer_county = $_POST['customer_county']; // customer county
	$customer_postcode = $_POST['customer_postcode']; // customer postcode
	$customer_phone = $_POST['customer_phone']; // customer phone number
	
	//shipping
	$customer_name_ship = $_POST['customer_name_ship']; // customer name (shipping)
	$customer_address_1_ship = $_POST['customer_address_1_ship']; // customer address (shipping)
	$customer_address_2_ship = $_POST['customer_address_2_ship']; // customer address (shipping)
	$customer_town_ship = $_POST['customer_town_ship']; // customer town (shipping)
	$customer_county_ship = $_POST['customer_county_ship']; // customer county (shipping)
	$customer_postcode_ship = $_POST['customer_postcode_ship']; // customer postcode (shipping)

	// invoice details
	$invoice_number = $_POST['invoice_id']; // invoice number
	$custom_email = $_POST['custom_email']; // invoice custom email body
	$invoice_date = $_POST['invoice_date']; // invoice date
	$invoice_due_date = $_POST['invoice_due_date']; // invoice due date
	$invoice_subtotal = $_POST['invoice_subtotal']; // invoice sub-total
	$invoice_shipping = $_POST['invoice_shipping']; // invoice shipping amount
	$invoice_discount = $_POST['invoice_discount']; // invoice discount
	$invoice_vat = $_POST['invoice_vat']; // invoice vat
	$invoice_total = $_POST['invoice_total']; // invoice total
	$invoice_notes = $_POST['invoice_notes']; // Invoice notes
	$invoice_type = $_POST['invoice_type']; // Invoice type
	$invoice_status = $_POST['invoice_status']; // Invoice status

	//var_dump($invoice_status); 

	// insert invoice into database
	$query .= "INSERT INTO invoices (
					invoice, 
					invoice_date, 
					invoice_due_date, 
					subtotal, 
					shipping, 
					discount, 
					vat, 
					total,
					notes,
					invoice_type,
					status
				) VALUES (
				  	'".$invoice_number."',
				  	'".$invoice_date."',
				  	'".$invoice_due_date."',
				  	'".$invoice_subtotal."',
				  	'".$invoice_shipping."',
				  	'".$invoice_discount."',
				  	'".$invoice_vat."',
				  	'".$invoice_total."',
				  	'".$invoice_notes."',
				  	'".$invoice_type."',
				  	'".$invoice_status."'
			    );
			";
	// insert customer details into database
	$query .= "INSERT INTO customers (
					invoice,
					custom_email,
					name,
					email,
					address_1,
					address_2,
					town,
					county,
					postcode,
					phone,
					name_ship,
					address_1_ship,
					address_2_ship,
					town_ship,
					county_ship,
					postcode_ship
				) VALUES (
					'".$invoice_number."',
					'".$custom_email."',
					'".$customer_name."',
					'".$customer_email."',
					'".$customer_address_1."',
					'".$customer_address_2."',
					'".$customer_town."',
					'".$customer_county."',
					'".$customer_postcode."',
					'".$customer_phone."',
					'".$customer_name_ship."',
					'".$customer_address_1_ship."',
					'".$customer_address_2_ship."',
					'".$customer_town_ship."',
					'".$customer_county_ship."',
					'".$customer_postcode_ship."'
				);
			";


			// echo $query; 

	// invoice product items
	foreach($_POST['invoice_product'] as $key => $value) {
	    $item_product = $value;
	    // $item_description = $_POST['invoice_product_desc'][$key];
	    $item_qty = $_POST['invoice_product_qty'][$key];
	    $item_price = $_POST['invoice_product_price'][$key];
	    $item_discount = $_POST['invoice_product_discount'][$key];
	    $item_subtotal = $_POST['invoice_product_sub'][$key];

	    // insert invoice items into database
		$query .= "INSERT INTO invoice_items (
				invoice,
				product,
				qty,
				price,
				discount,
				subtotal
			) VALUES (
				'".$invoice_number."',
				'".$item_product."',
				'".$item_qty."',
				'".$item_price."',
				'".$item_discount."',
				'".$item_subtotal."'
			);
		";

	}

	header('Content-Type: application/json');

	if($mysqli -> multi_query($query)) {
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Product has been updated successfully!'
		));

		//Set default date timezone
		date_default_timezone_set(TIMEZONE);
		//Include Invoicr class
		include('invoice.php');
		//Create a new instance
		$invoice = new invoicr("A4",CURRENCY,"en");
		//Set number formatting
		$invoice->setNumberFormat('.',',');
		//Set your logo
		$invoice->setLogo(COMPANY_LOGO,COMPANY_LOGO_WIDTH,COMPANY_LOGO_HEIGHT);
		//Set theme color
		$invoice->setColor(INVOICE_THEME);
		//Set type
		$invoice->setType("Invoice");
		//Set reference
		$invoice->setReference($invoice_number);
		//Set date
		$invoice->setDate($invoice_date);
		//Set due date
		$invoice->setDue($invoice_due_date);
		//Set from
		$invoice->setFrom(array(COMPANY_NAME,COMPANY_ADDRESS_1,COMPANY_ADDRESS_2,COMPANY_COUNTY,COMPANY_POSTCODE,COMPANY_NUMBER,COMPANY_NUMBER2));
		//Set to
		$invoice->setTo(array($customer_name,$customer_address_1,$customer_address_2,$customer_town,$customer_county,$customer_postcode,"Age: ".$customer_phone));
		//Ship to
		$invoice->shipTo(array($customer_name_ship,$customer_address_1_ship,$customer_address_2_ship,$customer_town_ship,$customer_county_ship,$customer_postcode_ship,''));
		//Add items
		// invoice product items
		foreach($_POST['invoice_product'] as $key => $value) {
		  // $item_product = addslashes($value);

		   $item_product= str_replace("'", '', $value);
		  
		    // $item_description = $_POST['invoice_product_desc'][$key];
		    $item_qty = $_POST['invoice_product_qty'][$key];
		    $item_price = $_POST['invoice_product_price'][$key];
		    $item_discount = $_POST['invoice_product_discount'][$key];
		    $item_subtotal = $_POST['invoice_product_sub'][$key];

		   	if(ENABLE_VAT == true) {
		   		$item_vat = (VAT_RATE / 100) * $item_subtotal;
		   	}

		    $invoice->addItem($item_product,'',$item_qty,$item_vat,$item_price,$item_discount,$item_subtotal);
		}
		//Add totals
		$invoice->addTotal("Total",$invoice_subtotal);
		if(!empty($invoice_discount)) {
			$invoice->addTotal("Discount",$invoice_discount);
		}
		if(!empty($invoice_shipping)) {
			$invoice->addTotal("Delivery",$invoice_shipping);
		}
		if(ENABLE_VAT == true) {
			$invoice->addTotal("TAX/VAT ".VAT_RATE."%",$invoice_vat);
		}
		$invoice->addTotal("Total Due",$invoice_total,true);
		//Add Badge
		$invoice->addBadge($invoice_status);
		// Customer notes:
		if(!empty($invoice_notes)) {
			$invoice->addTitle("Customer Notes");
			$invoice->addParagraph($invoice_notes);
		}
		//Add Title
		$invoice->addTitle("Payment information");
		//Add Paragraph
		$invoice->addParagraph(PAYMENT_DETAILS);
		//Set footer note
		$invoice->setFooternote(FOOTER_NOTE);

		//Render the PDF
		$invoice->render('invoices/'.$invoice_number.'.pdf','F');

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	// close connection 
	$mysqli->close();

}

// Adding new product
if($action == 'delete_product') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$id = $_POST["delete"];

	// the query
	$query = "DELETE FROM products WHERE product_id = ?";

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param('s',$id);

	//execute the query
	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Product has been deleted successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	// close connection 
	$mysqli->close();

}

// Login to system
if($action == 'login') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	session_start();
   extract($_POST);

    $username = mysqli_real_escape_string($mysqli,$_POST['username']);
    $pass_encrypt = md5(mysqli_real_escape_string($mysqli,$_POST['password']));

	//$_SESSION['login_user_id'];
    $query = "SELECT * FROM `users` WHERE username='$username' AND `password` = '$pass_encrypt'";

    $results = mysqli_query($mysqli,$query) or die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
    $count = mysqli_num_rows($results);

    if($count==1) {
		$row = $results->fetch_assoc();

		$_SESSION['login_username'] =   $row['username'];
		$_SESSION['login_user_id'] =    $row['id'];
		$_SESSION['User_Permission'] =  $row['user_permission'];
		$_SESSION['user_type'] =  $row['user_type'];

		$query = "update  `users`  set  check_activity=1  WHERE id =  '".$row['id']."'             ";
        $results = mysqli_query($mysqli,$query) or die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);



		// processing remember me option and setting cookie with long expiry date
		if (isset($_POST['remember'])) {	
			@session_set_cookie_params('604800'); //one week (value in seconds)
			session_regenerate_id(true);
		}  
		
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Login was a success! Transfering you to the system now, hold tight!'
		));
    }
	
	else {
    	echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'Login incorrect, does not exist or simply a problem! Try again!'
	    ));
    }
}

// Adding new product
if($action == 'add_product') {

	$product_name = $_POST['product_name'];
	$product_desc = $_POST['product_desc'];
	$product_price = $_POST['product_price'];

	//our insert query query
	$query  = "INSERT INTO products
				(
					product_name,
					product_desc,
					product_price
				)
				VALUES (
					?, 
                	?,
                	?
                );
              ";

    header('Content-Type: application/json');

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param('sss',$product_name,$product_desc,$product_price);

	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Product has been added successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	//close database connection
	$mysqli->close();
}

// Adding new user
if($action == 'add_user') {

	$user_name = $_POST['name'];
	$user_username = $_POST['username'];
	$user_email = $_POST['email'];
	$user_phone = $_POST['phone'];
	$user_password = $_POST['password'];
	$user_type = $_POST['user_type'];


	$dashboard   = $_POST['dashboard']; //1

	@$create_invoice  = trim($_POST['create_invoice']);//2  
	@$download_csv  =   trim($_POST['download_csv']);//3
	@$manage_invoice =  trim($_POST['manage_invoice']);//4

	@$Add_Procedure =    trim($_POST['Add_Procedure']);//5
	@$manage_procedure = trim($_POST['manage_procedure']);//6
	@$edit_procedure =   trim($_POST['edit_procedure']);//7

	@$Add_patient =    trim($_POST['Add_patient']);//8
	@$manage_patient = trim($_POST['manage_patient']);//9
	@$Edit_patient  =  trim($_POST['edit_patient']);//10

	@$Add_doctor  =   trim($_POST['Add_doctor']);//11
	@$manage_doctor = trim($_POST['manage_doctor']);//12
	@$Edit_doctor =   trim($_POST['edit_doctor']);//13

	@$Add_users = trim($_POST['Add_users']);//14
	@$manage_users = trim($_POST['manage_users']);//15
	@$edit_users = trim($_POST['edit_users']);//16

	@$delete_invoice = trim($_POST['delete_invoice']);//17
	@$delete_procedure = trim($_POST['delete_procedure']);//18
	@$delete_patient = trim($_POST['delete_patient']);//19
	@$delete_doctor = trim($_POST['delete_doctor']);//20
	@$delete_users = trim($_POST['delete_users']);//21



	@$Users_Permission= $dashboard.",".$create_invoice.",".$manage_invoice.",".$download_csv.",".$Add_Procedure.",".$manage_procedure.",".$edit_procedure.",".$Add_patient.",".$manage_patient.",".$Edit_patient.",".$Add_doctor.",".$manage_doctor.",".$Edit_doctor.",".$Add_users.",".$manage_users.",".$edit_users.",".$delete_invoice.",".$delete_procedure.",".$delete_patient.",".$delete_doctor.",".$delete_users;

	//our insert query query
	$query  = "INSERT INTO users
				(
					name,
					username,
					email,
					phone,
					password,
					user_permission,
					user_type
				)
				VALUES (
					?,
					?, 
                	?,
                	?,
                	?,
					?,
					?
                );
              ";

    header('Content-Type: application/json');

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	$user_password = md5($user_password);
	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param('sssssss',$user_name,$user_username,$user_email,$user_phone,$user_password,$Users_Permission,$user_type );

	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'User has been added successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	//close database connection
	$mysqli->close();
}

// Update product
if($action == 'update_user') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// user information
	$getID = $_POST['id']; // id


	$name = $_POST['name']; // name
	$username = $_POST['username']; // username
	$email = $_POST['email']; // email
	$phone = $_POST['phone']; // phone
	$password = $_POST['password']; // password
	$user_type = $_POST['user_type']; // password

	@$dashboard   = $_POST['dashboard']; //1

	@$create_invoice  = trim($_POST['create_invoice']);//2  
	@$download_csv  =   trim($_POST['download_csv']);//3
	@$manage_invoice =  trim($_POST['manage_invoice']);//4

	@$Add_Procedure =    trim($_POST['Add_Procedure']);//5
	@$manage_procedure = trim($_POST['manage_procedure']);//6
	@$edit_procedure =   trim($_POST['edit_procedure']);//7

	@$Add_patient =    trim($_POST['Add_patient']);//8
	@$manage_patient = trim($_POST['manage_patient']);//9
	@$Edit_patient  =  trim($_POST['edit_patient']);//10

	@$Add_doctor  =   trim($_POST['Add_doctor']);//11
	@$manage_doctor = trim($_POST['manage_doctor']);//12
	@$Edit_doctor =   trim($_POST['edit_doctor']);//13

	@$Add_users = trim($_POST['Add_users']);//14
	@$manage_users = trim($_POST['manage_users']);//15
	@$edit_users = trim($_POST['edit_users']);//16

	@$delete_invoice = trim($_POST['delete_invoice']);//17
	@$delete_procedure = trim($_POST['delete_procedure']);//18
	@$delete_patient = trim($_POST['delete_patient']);//19
	@$delete_doctor = trim($_POST['delete_doctor']);//20
	@$delete_users = trim($_POST['delete_users']);//21



@$Users_Permission= $dashboard.",".$create_invoice.",".$manage_invoice.",".$download_csv.",".$Add_Procedure.",".$manage_procedure.",".$edit_procedure.",".$Add_patient.",".$manage_patient.",".$Edit_patient.",".$Add_doctor.",".$manage_doctor.",".$Edit_doctor.",".$Add_users.",".$manage_users.",".$edit_users.",".$delete_invoice.",".$delete_procedure.",".$delete_patient.",".$delete_doctor.",".$delete_users;


	if($password == ''){
		// the query
		$query = "UPDATE users SET
					name = ?,
					username = ?,
					email = ?,
					phone = ?,
					user_permission = ?,
					user_type = ?
				 WHERE id = ?
				";
	} else {
		// the query
		$query = "UPDATE users SET
					name = ?,
					username = ?,
					email = ?,
					phone = ?,
					password =?,
					user_permission = ?,
					user_type = ?

				 WHERE id = ?
				";
	}

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);

	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	if($password == ''){
		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
     	$stmt->bind_param(
			'sssssss',
			$name,$username,$email,$phone,$Users_Permission,$user_type,$getID
		);

	} else {
		$password = md5($password);
		/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
		$stmt->bind_param(
			'ssssssss',
			$name,$username,$email,$phone,$password,$Users_Permission,$user_type,$getID
		);

	}


	//execute the query
	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'User has been updated successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	//close database connection
	$mysqli->close();
	
}

// Delete User
if($action == 'delete_user') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$id = $_POST["delete"];

	// the query
	$query = "DELETE FROM users WHERE id = ?";

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param('s',$id);

	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'User has been deleted successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	// close connection 
	$mysqli->close();

}



// Delete Company
if($action == 'delete_company') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$id = $_POST["delete"];

	// the query
	$query = "DELETE FROM companies WHERE id = ?";

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param('s',$id);

	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Company has been deleted successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	// close connection 
	$mysqli->close();

}


























// Delete User
if($action == 'delete_customer') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$id = $_POST["delete"];

	// the query
	$query = "DELETE FROM store_customers WHERE id = ?";

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param('s',$id);

	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Patient has been deleted successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	// close connection 
	$mysqli->close();

}




// Delete Doctor
if($action == 'delete_doctor') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$id = $_POST["delete"];

	// the query
	$query = "DELETE FROM doctor WHERE doctorid = ?";

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param('s',$id);

	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Physician has been deleted successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	// close connection 
	$mysqli->close();

}

//Update Company
if($action == 'update_company') {
// output any connection error
if ($mysqli->connect_error) {
	die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
}

// invoice product information
$getID = $_POST['id']; // id

// Basic Company Information

	$company_name = $_POST['company_name']; // customer name
	$company_number_employee = $_POST['company_number_employee']; // doctor address 1
	$company_location = $_POST['company_location']; // doctor doctor_phone
	$company_email = $_POST['company_email']; // doctor_town
	$company_post_office = $_POST['company_post_office']; // doctor_postcode
	$company_tele  = $_POST['company_tele']; // customer town
	$company_department = $_POST['company_department']; // doctor_address_2
	$contract_type = $_POST['contract_type']; // country

$getID = $_POST['id']; // Company ID


//The Query
 $query = "UPDATE companies SET

type_contract  = ?,
name  =  ?,
num_of_vistors = ?,
department = ?,
location = ?,
telephone_number = ?,
post_office = ?,
email = ?
				 
		 WHERE   id = ?
		";

/* Prepare statement */
$stmt = $mysqli->prepare($query);
if($stmt === false) {
  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
}

/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
$stmt->bind_param(
	'sssssssss',
	$contract_type, 
	$company_name,
	$company_number_employee,
	$company_department,
	$company_location,
	$company_tele,
	$company_post_office,
	$company_email,
	$getID
);

//execute the query
if($stmt->execute()){
	//if saving success
	echo json_encode(array(
		'status' => 'Success',
		'message'=> 'Company Detatils has been updated successfully!'
	));

} else {
	//if unable to create new record
	echo json_encode(array(
		'status' => 'Error',
		//'message'=> 'There has been an error, please try again.'
		'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	));
}

//close database connection
$mysqli->close();




}


//Update Doctor 
if($action == 'update_doctor') {

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// invoice product information
	$getID = $_POST['id']; // id

	// Basic Physicians Information
	$doctor_name = $_POST['doctor_name']; // customer name
	$doctor_address_1 = $_POST['doctor_address_1']; // doctor address 1
	$doctor_phone = $_POST['doctor_phone']; // doctor doctor_phone
	$doctor_town = $_POST['doctor_town']; // doctor_town
	$doctor_postcode = $_POST['doctor_postcode']; // doctor_postcode
	$doctor_email = $_POST['doctor_email']; // customer town
	$doctor_address_2 = $_POST['doctor_address_2']; // doctor_address_2
	$doctor_country = $_POST['doctor_country']; // doctor country
	
	//Education Background
	$doctor_title = $_POST['doctor_title']; // doctor_title (Education Background)
	$doctor_department = $_POST['doctor_department']; // doctor Department (Education Background)
	$doctor_consultancy_charge = $_POST['doctor_consultancy_charge']; // customer address (Education Background)
	$doctor_status = $_POST['doctor_status']; // customer postcode (Education Background)
	$doctor_education = $_POST['doctor_education']; // doctor education (Education Background)

	$getID = $_POST['id']; // Doctor ID


	//The Query
	 $query = "UPDATE doctor SET

       doctorname =  ?,
       mobileno = ?,
       departmentid = ?,
       status= ?,
       education = ?,
       consultancy_charge = ?,
       address_one = ?,
       email= ?,
       address_two =? ,
       town = ?,
       country_id = ?,
       postcode = ?,
       title = ?
					 
			 WHERE   doctorid = ?
			";

	/* Prepare statement */
	$stmt = $mysqli->prepare($query);
	if($stmt === false) {
	  trigger_error('Wrong SQL: ' . $query . ' Error: ' . $mysqli->error, E_USER_ERROR);
	}

	/* Bind parameters. TYpes: s = string, i = integer, d = double,  b = blob */
	$stmt->bind_param(
		'sssssssssssssi',
		$doctor_name,
		$doctor_phone,
		$doctor_department,
		$doctor_status,
		$doctor_education,
		$doctor_consultancy_charge,
		$doctor_address_1,
		$doctor_email,
		$doctor_address_2,
		$doctor_town,
		$doctor_country,
		$doctor_postcode,
		$doctor_title,
		$getID
	);

	//execute the query
	if($stmt->execute()){
	    //if saving success
		echo json_encode(array(
			'status' => 'Success',
			'message'=> 'Physician has been updated successfully!'
		));

	} else {
	    //if unable to create new record
	    echo json_encode(array(
	    	'status' => 'Error',
	    	//'message'=> 'There has been an error, please try again.'
	    	'message' => 'There has been an error, please try again.<pre>'.$mysqli->error.'</pre><pre>'.$query.'</pre>'
	    ));
	}

	//close database connection
	$mysqli->close();
	
}

?>