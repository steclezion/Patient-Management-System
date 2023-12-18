<style>
table, td, th {
    border: 1px solid black;
}

table {
    border-collapse: collapse;
    width: 100%;
}

th {
    height: 50px;
}
</style>


<?php

//Include mpdf library file
require_once __DIR__ . '/vendor/autoload.php';

use NumberToWords\NumberToWords;
$numberToWords = new NumberToWords();
$numberTransformer = $numberToWords->getNumberTransformer('en');



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

<h1>Payment Confirmation</h1>
<hr>

<div class="row">

	<div class="col-xs-12">

		<div id="response" class="alert alert-success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="message"></div>
		</div>
	
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Print Confirmation</h4>
			</div>
			<div class="panel-body form-group form-group-sm">



   

				</form>
		</div>

				<?php
				$invoices = $_GET['invoices'];
				$explode_invoices = explode("^",$invoices);
				$invoice_array = array();
?>

           
<?php


$invoice_explode = $_GET['invoices'];
$explode_invoice = explode("^",$invoice_explode);

 $company_name  = $explode_invoice[0];
 $Company  = trim($explode_invoice[0]);
 $From = $explode_invoice[1];
 $To = $explode_invoice[2];
 $Status = $explode_invoice[3];
 $From_style = $From;
 $To_style =  $To; 


  $query_comp = "SELECT  *  FROM companies where  name = '$Company' ";
  // mysqli select query
$results_comp = $mysqli->query($query_comp);
$row_comp = $results_comp->fetch_assoc();



?>

<textarea id="summernote" name="template_for_notification" > 


<input type="hidden" name="invoice_id" id="invoice_id" class="form-control required"
					placeholder="Invoice Number" readonly aria-describedby="sizing-addon1" value="<?php getInvoiceId(); ?>">
          <h4>

	</head>

	<body>
  <div class='invoice-box'  id ="to_be_print" >

   <h2  style='position: absolute;left: 45%; ' > <b>  INVOICE  </b> </h2> <br><br><br><br>

			<table cellpadding="0" cellspacing="0">
				<tr class="top">
					<td colspan="2">
						<table>
							<tr>
								<td class="title">
              <?php print "  <h4><b>  <span style='color:orange;'> $From_style  -  $To_style  </span> -  </b> <b style='color:red; font-size:25px;width:32px;padding: 5px;margin: 0;'> $Company </b>  </h4>" ; ?>
								</td>

								<td>
                <div class='row invoice-info' >
<div class='col-lg-12'    >

<b> Company Name :</b> <span id="fullname_contact"> <?php echo $company_name ?>  </span> <br>
<b> Invoice number:</b> <span id="receipt_number"><?php trim(getInvoiceId_print()); ?></span> <br>
<b>Date of issuance:</b>  <span id="issuance_date"> <span id="current_date">  <?php  $Today = date('y/m/d'); $new = date('Y', strtotime($Today));
  echo "<span style='color:orange;font-type:Monotype Corsiva;'>". $currentDate = date('d-m-Y')."</span>"; ?>  </span> 
</div>
<!-- /.col -->
</div>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="information">
					<td colspan="2">
						<table>
							<tr>
								<td style="text-align:left">
									Location : <?php echo $row_comp['location']; ?> <br />
									Email: <?php echo $row_comp['email']; ?> <br />
									Tel: <?php $row_comp['telephone_number']; ?>
								</td>

              


								<td style="text-align:right">
									Receiver Name Mr. :   <br />
									Contract Type : <?php echo $row_comp['type_contract']; ?> <br >
									Juba, South Sudan
								</td>
							</tr>
						</table>


            <table>
							<tr  rowspan=2>
								<td>
									
<p> Dear ,<br><br>

This is just a friendly reminder that your account is past due. According to our records your balance of $ is currently . We have emailed a detailed copy of your account statements. In the event you have not received these messages and documents, we have provided a summary of your account below.
<br>
Invoice number:<br>
Invoice Date:<br>
Amount: Due Date:<br>
Days past due:<br>
<br>
We would much appreciate if you could let us know the status of this payment. Please contact us or send your payment of $ to the address below by April 16, 2022 if you have not already done so.
<br>
ATTN: Accounting Dept.
<br>
If there is some error or you are unable to pay at this time, please contact me at so we can correct any errors or arrange for another payment plan. Thank you for your prompt response to this request and for your continued business.
<br>
Sincerely, </p>
									john@example.com
								</td>
							</tr>
						</table>


					</td>





				</tr>

				<?php
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
					   
				 
						   ORDER BY i.invoice_date  ASC  ";
						   
						 
				   
				   
					 // mysqli select query
					 $results = $mysqli->query($query);
					 // mysqli select query
					 if($results) {
						   print '
						   <table class="table table-striped table-bordered table-hover table-condensed" id="examplee" cellspacing="0"  class="display" cellspacing="0" width="100%"><thead>
						
 
						   <tr>
						   
										   <th width="10px" >Invoice</th>
										   <th width="10px">Patient</th>
										   <th width="10px" >Issue Date</th>
										   <th width="10px" >Company Name</th>
										   <th width="10px" >Type</th>
										   <th width="10px" >Status</th>
										   <th width="30px" >Total Sum</th>
				               </tr></thead><tbody>';?>
<?php
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
								   <th> ';
								  
								  if($General_Total >0 && $Status == 'open')
								  {

									
							
									 print $General_Total."  SSP";
									
								
								}
									
							   } 
							   
							   else {
						   
								   echo "<p>There are no invoices to display.</p>";
								   
						   
                 }
				   
				   
				   
						
                
				 
				 
				 // Frees the memory associated with a result
				 @$results->free();
				 
				 // close connection 
				 @$mysqli->close();
				 
				 
				
				
				?>
				</table>

        <p class="a"> <b> Amount in words: <?php print $numberTransformer->toWords($General_Total ); ?>  SSP ONLY   </b> </p>
<br/><br/>

  <p id="nmfa_info">
  Issued by: Ermias Ghebreluul
  <br>
  Head of Finance Division
  <br>
  Mekane Hiwot Clinic
  <br>
  Juba, South Sudan
  <br> 
  Cc: Department of Administration , General Director 
  </p>
  <br><br><br>
  </div>    
 <!-- <button id="addRow" class="btn btn-success btn-sm"><i class="fas fa-plus"> </i></button> -->


			</table>
		</div>
</textarea>
  
        <div class='row'>
        <div class='col-12' table-responsive  >

<button type="button" class="btn btn-primary float-md-left" 
id="invoice_save"> <i class="fas fa-save"></i> Save  </button>


<a target="_blank" style="display:none" id="print_invoice"  href="" type="button" class="btn btn-primary btn-md float-right" > <i class="glyphicon glyphicon-download"></i> Download </a>




<a href="{{ url()->previous() }}" type="button" class="btn btn-info float-md-right"  
id="acknowledgment_letter"> <i class="fas fa-arrow-circle-left"></i> Back </a>
          

<br>  <br>  <br>


        </div>
        </div>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->



       

		</div>
        </div>
        </div>
		</div>
        </div>
        </div>




			</div>
		</div>
	</div>
<div>






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


<script>
  $(function () {
    // Summernote
     $('#summernote').summernote();
    // $('#summernotee').summernote();
    // $('#summernote_Remark_section_four').summernote();

    // CodeMirror
    CodeMirror.fromTextArea(document.getElementById("codeMirrorDemo"), {
      mode: "htmlmixed",
      theme: "monokai"
    });
  });


  $('#invoice_save').click(function () {
        //alert("hellow Eyoba");
  if (confirm("Are you sure you want to print this letter of Invoice." + "Changes will not be reverted.") == true)
   {
  
   var To_be_rendered = document.getElementById('to_be_print').innerHTML ; 
   var invoice_id = document.getElementById('invoice_id').value; 
   var action = 'print_html';

   alert(To_be_rendered );

  
  
  document.getElementById('invoice_save').disabled = true;



     $.ajax({  

  url: 'response.php',
  type:'POST',
  data: {
  
  action : action,
  To_be_rendered:To_be_rendered,
  invoice_id:invoice_id,

},
processData: true,
success: (data) => {
if(data.Message==true)  
{


  $('#print_invoice').attr("href", data.Download);
var Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 6000
                  }); 
                  
                  document.getElementById('invoice_save').disabled = false;

 toastr.success("Financial notification saved successfully")
 var id = setInterval(finance_not, 2000);
              function finance_not() {
              window.location = "/generating_financial_notifications";
              clearInterval(id);
        }

} 
else
{
    
this.reset();
 var Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 6000
    }); 


$('#UploadData').html('Save changes');
document.getElementById('UploadData').disabled = false;
var contact_person  = document.getElementById('contact_person_name').innerHTML;
$('#app_name').val(contact_person.toUpperCase().trim());
toastr.error('Allowed Files Type is only .PDF (PDF Document)')

           }
},

error: function(data){
console.log(data);
}

});

}

  else { return false;}


});
  
</script>


<style>
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
		</style>


<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css"> 
  <!-- DataTables -->
  <!-- <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css"> -->
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css" >
  <!-- CodeMirror -->
  <!-- <link rel="stylesheet" href="plugins/codemirror/codemirror.css">
  <link rel="stylesheet" href="plugins/codemirror/theme/monokai.css"> -->
  <!-- SimpleMDE -->
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="dist/css/adminlte.min.css"> -->
 
<!--   
plugins -->
<!-- <script rel="javascript" src="app/lib/ajax/jquery/1.9.1/jquery.js" ></script>
<script src="plugins/jquery/jquery.min.js"></script> -->
  <!-- SweetAlert2 -->
  <!-- <link rel="stylesheet" href=plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css>
  <link rel="stylesheet" href="app/lib/twitter-bootstrap/4.1.3/css/bootstrap.min.css" > -->
<link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">

<!--<link rel="stylesheet" href="3.3.6/bootstrap.min.css" >-->
<link rel="stylesheet" href="app/lib/1.10.16/css/jquery.dataTables.min.css" >
<link rel="stylesheet" href="app/lib/1.10.19/css/dataTables.bootstrap4.min.css" >
    <!-- Select2 -->
<link rel="stylesheet" href="plugins/select2/css/select2.min.css" >
<link rel="stylesheet" href="plugins/select2/css/select2.min.css" >
<link rel="stylesheet" href="plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css" >



<script rel="javascript" src="plugins/toastr/toastr.min.js" ></script>
<script rel="javascript" src="plugins/sweetalert2/sweetalert2.min.js" ></script>
<!-- Select2 -->
<script rel="stylesheet" src="plugins/select2/js/select2.full.min.js" ></script>
<script src="dist/js/demo.js" ></script>


<!-- Font Awesome -->
<link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <!-- <link rel="stylesheet" href="dist/css/adminlte.min.css"> -->
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <link rel="stylesheet" href="plugins/toastr/toastr.min.css">
  <link rel="stylesheet" href="plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
  <link rel="stylesheet" href="plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">

  <style>
p.a {
  text-transform: uppercase;
}

p.b {
  text-transform: lowercase;
}

p.c {
  text-transform: capitalize;
}
</style>



<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  // $.widget.bridge('uibutton', $.ui.button);
  // fadeTo(speed in ms, opacity)
  $("#alert-messages").fadeTo(15000, 1000).slideUp(500, function(){
      $("#alert-messages").slideUp(500);
  });
</script>

<!-- Summernote -->
<script src="plugins/summernote/summernote-bs4.min.js"></script>