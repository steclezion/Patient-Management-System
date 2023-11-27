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

<h1>Credit Invoice List</h1>
<hr>

<div class="row">

	<div class="col-xs-12">

		<div id="response" class="alert alert-success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="message"></div>
		</div>
	
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Manage Invoices</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
      <div class="col-xs-8 text-right">
	
<form  id="invoice_with_report" method="POST" action="invoice_with_selection.php" name="post_submission"  onSubmit="return validate();" enctype="multipart/form-data"  >

			<div class="col-xs-4 no-padding-right">
				<div class="form-group">
					<?PHP $dt = new DateTime(); 
						  $dt->format('d-m-y') ;
							   ?>
					<div class="input-group date" id="invoice_date">
						<label class="input-group-addon"> <b>  From  </b>  </label>
						<input width="100"  required   type="text" class="form-control required" name="invoice_date_from" placeholder="<?php echo $dt->format('Y-m-d');  ?>"   data-date-format="<?php echo DATE_FORMAT ?>" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="col-xs-4">
				<div class="form-group">
					<div class="input-group date" id="invoice_due_date">
						<label class="input-group-addon"> <b>  To  </b>  </label>
						<input width="50"    required  type="text" class="form-control required" name="invoice_date_to" placeholder="<?php echo $dt->format('Y-m-d');  ?>"  value="<?php echo $dt->format('Y-m-d');  ?>"  data-date-format="<?php echo DATE_FORMAT ?>" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="input-group col-xs-4 float-right">
      <label class="input-group-addon"> <b> Status </b> </label>
		 <select name="invoice_status" id="invoice_statuss" class="form-control"  required  aria-describedby="sizing-addon1" >
     <option  value="All">All</option>
						<option value="open" selected >Open</option>
						<option value="paid" >Paid</option>
</select>


</div>
</div>

<div class="input-group col-xs-4 float-center">
      <label class="input-group-addon"> <b>Company </b>  </label>
		  <select class="form-control required"  required   name="customer_company_name" id="customer_company_name" placeholder="customer_company_name" required="">
      <option value="All" selected>All</option>
      <?php $sqldepartment= "SELECT * FROM companies ";  $results = $mysqli->query($sqldepartment);
                    while($rsdepartment=$results->fetch_assoc())
                    {
     echo "<option value='$rsdepartment[name]' >$rsdepartment[name]</option>";
                    }
                ?>
            </select>

            
        </div>
        <br>
		<div class="input-group col-xs-4 float-right">
        <button type="submit"  name="submit" class="btn btn-primary">Generate Invoices</button>
				</div>
			</div>
    


   

				</form>
		</div>

				<?php getInvoices(); ?>
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