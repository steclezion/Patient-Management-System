<?php

include('header.php');


$user_permission = array(); 
$explode_comma_separated = explode(",", $_SESSION['User_Permission']);

for($i =0; $i <= count($explode_comma_separated); $i++)
{
@array_push($user_permission,$explode_comma_separated[$i]);
}

if ((in_array('11', $user_permission))) {

?>

<h1>Add New Company </h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="create_company">
	<input type="hidden" name="action" value="create_company">
	<div class="row">
		<div class="col-xs-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4> Company  Information</h4>
					<div class="clear"></div>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required" name="company_name" id="company_name" placeholder="Enter Companies FullName" tabindex="1">
							</div>
							<div class="form-group">
								<input type="number" min="0" class="form-control margin-bottom copy-input required" name="company_number_employee" id="company_number_employee" placeholder="Number of Employee" tabindex="3">	
							</div>

							<!-- <div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required" name="company_location" id="company_location" placeholder="Location" tabindex="5">		
							</div> -->


<div class="form-group">
<input list="town" class="form-control margin-bottom required"  name="company_location" id="company_location" placeholder="Location">
<datalist id="town">
<?php $sqldepartment= "SELECT * FROM Town "; $results = $mysqli->query($sqldepartment); while($town=$results->fetch_assoc()){ echo "<option value='$town[town_name]' selected> $town[town_name] </option>"; }?>
</datalist>
</div>

						</div>
						<div class="col-xs-6">
							<div class="input-group float-right margin-bottom">
								<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
								<input type="email" class="form-control copy-input required" name="company_email" id="company_email" placeholder="Email" aria-describedby="sizing-addon1" tabindex="2">
							</div>

						

							<div class="form-group no-margin-bottom">
						    	<input type="text" class="form-control margin-bottom copy-input required" name="company_post_office" id="company_post_office" placeholder="Post Office">
						    </div>
				

							<div class="form-group no-margin-bottom">
								<input type="text" value="" class="form-control copy-input required" name="company_tele" id="company_tele" placeholder="Tele" tabindex="7">					
							</div>


						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-6 text-right">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Agreements </h4>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<!-- <input type="text" class="form-control margin-bottom required" name="doctor_title" id="doctor_title" placeholder="Enter Title" tabindex="9"> -->




<input list="contract_typee" class="form-control margin-bottom required"  name="contract_type" id="contract_type" placeholder="Contract Type">

<datalist id="contract_typee">
  <option value="fixed-price contracts">
  <option value="cost-plus contracts">
  <option value="time and materials contracts">
  <option value="Unit pricing contracts">
  <option value="Unilateral contracts">
  <option value="Bilateral contracts">
  <option value="Simple contracts">
  <option value="Implied contracts">
  <option value="Express contracts">
  <option value="Unconscionable contracts">


</datalist>
			
		
							</div>
						
						</div>
						<div class="col-xs-6">
						<select class="form-control" name="company_department" id="company_department" placeholder="Enter lastname...." required="">
                <option value="">-- Company Type --</option>
              <option value='NGO'>NGO</option>";
			  <option value='Hotel'>Hotel</option>";
			  <option value='Small Business'>Small Business</option>";
			  <option value='Construction'>Construction</option>";
			

           
            </select>




			
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 margin-top btn-group">
			<input type="submit" id="action_create_company" class="btn btn-success float-right" value="Add Company" data-loading-text="Creating...">
		</div>
	</div>
</form>

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