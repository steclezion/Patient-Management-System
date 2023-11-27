<?php


include('header.php');
include('functions.php');

$getID = $_GET['id'];

// Connect to the database
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// output any connection error
if ($mysqli->connect_error) {
	die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
}

// the query
$query = "SELECT * FROM  companies  WHERE id  = '" .$mysqli->real_escape_string($getID). "'
  ORDER BY id ASC ";

//echo $query;

$result = mysqli_query($mysqli, $query);

// mysqli select query
if($result) {
	while ($row = mysqli_fetch_assoc($result)) {

		
		$type_contract =   $row['type_contract'];
		$name          =   $row['name'];
		$num_of_vistors =  $row['num_of_vistors'];
		$locations =       $row['location'];
		$tele =            $row['telephone_number'];
		$post_office = $row['post_office'];
		$email = $row['email'];
		$department = $row['department'];
	
	}
}

/* close connection */
//$mysqli->close();

?>


<h1>Edit Company</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="update_company">
	<input type="hidden" name="action" value="update_company">
	<input type="hidden" name="id" value="<?php echo $getID; ?>">
	<div class="row">
		<div class="col-xs-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Editing Company (<?php echo $getID; ?>)</h4>
					<div class="clear"></div>
				</div>

				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<input type="text" value="<?php echo $name; ?>" class="form-control margin-bottom copy-input required" name="company_name" id="company_name" placeholder="Enter Companies FullName" tabindex="1">
							</div>
							<div class="form-group">
								<input type="number" min="0" value="<?php echo $num_of_vistors; ?>" class="form-control margin-bottom copy-input required" name="company_number_employee" id="company_number_employee" placeholder="Number of Employee" tabindex="3">	
							</div>

							<!-- <div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required" name="company_location" id="company_location" placeholder="Location" tabindex="5">		
							</div> -->


<div class="form-group">
<input list="town" class="form-control margin-bottom required" value="<?php echo $locations; ?>"  name="company_location" id="company_location" placeholder="Location">
<datalist id="town">
<?php $sqldepartment= "SELECT * FROM Town "; $results = $mysqli->query($sqldepartment); while($town=$results->fetch_assoc()){ echo "<option value='$town[town_name]' selected> $town[town_name] </option>"; }?>
</datalist>
</div>

						</div>
						<div class="col-xs-6">
							<div class="input-group float-right margin-bottom">
								<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
								<input type="email" class="form-control copy-input required"  value="<?php echo $email; ?>" name="company_email" id="company_email" placeholder="Email" aria-describedby="sizing-addon1" tabindex="2">
							</div>

						

							<div class="form-group no-margin-bottom">
						    	<input type="text" class="form-control margin-bottom copy-input required" value="<?php echo $post_office; ?>" name="company_post_office" id="company_post_office" placeholder="Post Office">
						    </div>
				

							<div class="form-group no-margin-bottom">
								<input type="text" class="form-control copy-input required" value="<?php echo $tele; ?>" name="company_tele" id="company_tele" placeholder="Tele" tabindex="7">					
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




<input list="contract_typee" value="<?php echo $type_contract; ?>"  class="form-control margin-bottom required"  name="contract_type" id="contract_type" placeholder="Contract Type">

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
				<?php 
				
				if($department == 'NGO'){  $ngo = 'selected';  } 
				if($department == 'Hotel'){  $Hotel = 'selected';  }
				if($department == 'Small Business'){  $Small_Business = 'selected';  }
				if($department == 'Construction'){  $Construction = 'selected';  }
				
				
				
				?>


              <option  <?php echo @$ngo; ?> value='NGO'>NGO</option>";
			  <option <?php echo @$Hotel; ?> value='Hotel'>Hotel</option>";
			  <option <?php echo @$Small_Business; ?> value='Small Business'>Small Business</option>";
			  <option <?php echo @$Construction; ?> value='Construction'>Construction</option>";
			

           
            </select>




			
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 margin-top btn-group">
			<input type="submit" id="action_update_company" class="btn btn-success float-right" value="Update Company" data-loading-text="Updating...">
		</div>
	</div>
</form>



<?php
	include('footer.php');
?>