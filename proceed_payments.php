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
				<h4>Payment Confirmation</h4>
			</div>
			<div class="panel-body form-group form-group-sm">



   

				</form>
		</div>

				<?php
				$invoices = $_GET['invoices'];
				$explode_invoices = explode("^",$invoices);
				$invoice_array = array();
				$array_invoice='';
				for( $i=0 ; $i < count($explode_invoices); $i++)
				{
					//@array_push($invoice_array,$explode_invoices[$i]);
					$array_invoice .=  "'".$explode_invoices[$i]."',";
				}

			  $final_invoice = "(".$array_invoice .")"; 
			  $final_invoice = str_replace(",)", ")", $final_invoice);


			  $final_invoice ;

			  $query = " update invoices set status = 'paid' where invoice in $final_invoice ";
			   // mysqli select query
	          $results = $mysqli->query($query);	

			  if($results == 1)
			  {

				echo '<div class="container">
			
				<div class="panel-group">
				  <div class="panel panel-success">
					<div class="panel-heading">Confirmation Section </div>
					<div class="panel-body">Payment Completed Successfully</div>
				  </div>
				  
				  <a href="invoice-list.php" type="button" class="btn btn-success">Back</a>
				  ';
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