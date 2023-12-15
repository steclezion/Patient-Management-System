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

<textarea id="summernote" name="template_for_notification" > 


<section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12" id="letter_acknowledgement">
            <!-- Main content -->
            <div class="invoice p-3 mb-3">
              <!-- title row -->
              <div class="row">
                <div class="col-12">
                  <h4>
         
              </h4>
                </div>
                <!-- /.col -->
              </div>
              <!-- info row -->

  <!-- Main content -->
  <div class='invoice'>
      <!-- title row -->
      <div class='row'>
        <div class='col-12'>
   
          <h4>
           
<?php


$invoice_explode = $_GET['invoices'];
$explode_invoice = explode("^",$invoice_explode);

 $company_name  = $explode_invoice[0];
 $Company  = $explode_invoice[0];;
 $From = $explode_invoice[1];
 $To = $explode_invoice[2];
 $Status = $explode_invoice[3];
 $From_style = $From;
 $To_style =  $To; 

?>
<input type="hidden" value="{{  $id }}" id="application_id" name="" />
<span hidden> <i class='fas fa-globe'>  </i>  </span>
<small class='float-right' style='position: absolute;left: 80%; '>Date: <span id="current_date">  <?php  $Today = date('y/m/d'); $new = date('Y', strtotime($Today));
  echo "<span style='color:orange;font-type:Monotype Corsiva;'>". $currentDate = date('d-m-Y')."</span>"; 
  
  ?></span></small>

<br> <h2  style='position: absolute;left: 28%; ' > INVOICE </h2> </h4>
</div>
</div>


<br><br> <br><br>    <br><br> <br><br>   <br><br> 

<div class='row invoice-info' style='position: absolute;left: 0%; top: 15%;'>
<div class='col-lg-12'    >
<!-- <b> Customer’s Name :</b> <span id="fullname_contact"> {{ $apps->cfname." ".$apps->cmname." ".$apps->clname }}  </span> <br> -->

<b> Company Name :</b> <span id="fullname_contact"> <?php echo $company_name ?>  </span> <br>
<b>Receipt number:</b> <span id="receipt_number">      </span> <br>
<b>Date of issuance:</b>  <span id="issuance_date"> <?php echo $company_name ?>  </span> <br>
</div>
<!-- /.col -->
</div>



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

 <div class='row' id="financial_notification">
        <div class='col-12'>
        <br/> 

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
						   <h4><b>  <span style="color:orange;"> '.$From_style.'  -  '.$To_style.' </span> -  </b> <b style="color:red; font-size:25px;width:32px;padding: 5px;border: 2px solid gray;margin: 0;"> '.$Company.' </b>  </h4>
						   <table class="table table-striped table-bordered table-hover table-condensed" id="examplee" cellspacing="0"  class="display" cellspacing="0" width="100%"><thead>
						
 
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
								   <th> ';
								  
								  if($General_Total >0 && $Status == 'open')
								  {

									
							
									 print $General_Total;
									
								
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
			</div>





























<p class="a"> <b> Amount in words: <?php print $numberTransformer->toWords($General_Total); ?>  SSP ONLY   </b> </p>
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
 </div>
          <!-- /.col -->
</div>
</div>

<br><br><br>

 
</p>        
</div>
</div>
    <!-- /.content -->
</div>




 </textarea>
 </div>
        </div>
        </div>
		
  
        <div class='row'>
        <div class='col-12' table-responsive  >

<button type="button" class="btn btn-primary float-md-left" 
id="financial_notification_save"> <i class="fas fa-save"></i> Save  </button>

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


  $('#financial_notification_save').click(function () {
        //alert("hellow Eyoba");
  if (confirm("Are you sure you want to save this letter of Invoice."+
             "Changes will not be reverted.") == true) {
  
   var To_be_rendered = document.getElementById('financial_notification').innerHTML ; 
   var nmfa_info = document.getElementById('nmfa_info').innerHTML; 
   var application_id = document.getElementById('application_id').value;
   var financial_notification_date_of_order = document.getElementById('financial_notification_date_of_order').innerHTML;
   var fullname_contact = document.getElementById('fullname_contact').innerHTML;
   var receipt_number = document.getElementById('receipt_number').innerHTML ;
   var current_date = document.getElementById('current_date').innerHTML ;
  
  
  document.getElementById('financial_notification_save').disabled = true;



     $.ajax({  

url: 'response.php',
type:'POST',
data: {
  To_be_rendered:To_be_rendered,
  nmfa_info:nmfa_info,
  application_id:application_id,
   financial_notification_date_of_order:financial_notification_date_of_order,
  fullname_contact:fullname_contact,
  receipt_number: receipt_number,
  current_date:current_date,
},
processData: true,
success: (data) => {
if(data.Message==true)  
{
//document.getElementById('table_upload_cv').innerHTML = data.Data_returned;


var Toast = Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 6000
                  }); 
                  
    

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