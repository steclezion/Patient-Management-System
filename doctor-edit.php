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
$query = "SELECT * FROM  doctor d 
  JOIN countries c ON c.id = d.country_id 
  JOIN department de ON de.departmentid = d.departmentid
  WHERE d.doctorid  = '" .$mysqli->real_escape_string($getID). "'
  ORDER BY d.doctorid ";

//echo $query;

$result = mysqli_query($mysqli, $query);

// mysqli select query
if($result) {
	while ($row = mysqli_fetch_assoc($result)) {

		$doctor_name = $row['doctorname']; // Doctor name
		$doctor_email = $row['email']; // Doctor email
		$doctor_address_1 = $row['address_one']; // Doctor address
		$doctor_address_2 = $row['address_two']; // Doctor address
		$doctor_town = $row['town']; // Doctor town
		$doctor_country = $row['country_id']; // Doctor county
		$doctor_postcode = $row['postcode']; // customer postcode
		$doctor_phone = $row['mobileno']; // customer phone number
		$doctor_departmentid =  $row['departmentid'];
		$doctor_status =  $row['status'];
		$doctor_education =  $row['education'];//$doctor_experience = $row['experience'];
		$doctor_consulatancy_charge = $row['consultancy_charge']; // Consultancy Charge
		$doctor_title = $row['title']; //Doctor Title
	}
}

/* close connection */
//$mysqli->close();

?>

<h1>Edit Physician</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="update_doctor">
	<input type="hidden" name="action" value="update_doctor">
	<input type="hidden" name="id" value="<?php echo $getID; ?>">
	<div class="row">
		<div class="col-xs-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Editing Physicians (<?php echo $getID; ?>)</h4>
					<div class="clear"></div>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required" name="doctor_name" id="doctor_name" placeholder="Enter name" tabindex="1" value="<?php echo $doctor_name;  ?>">
							</div>
							<div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required" name="doctor_address_1" id="doctor_address_1" placeholder="Address 1" tabindex="3" value="<?php echo  $doctor_address_1;  ?>">	
							</div>
							<div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required" name="doctor_town" id="doctor_town" placeholder="Town" tabindex="5" value="<?php echo $doctor_town; ?>">		
							</div>
							<div class="form-group no-margin-bottom">
								<input type="text" class="form-control copy-input required" name="doctor_postcode" id="doctor_postcode" placeholder="Postcode" tabindex="7" value="<?php echo $doctor_postcode;  ?>">					
							</div>
						</div>
						<div class="col-xs-6">
							<div class="input-group float-right margin-bottom">
								<span class="input-group-addon">@</span>
								<input type="email" class="form-control copy-input required" name="doctor_email" id="doctor_email" placeholder="E-mail address" aria-describedby="sizing-addon1" tabindex="2" value="<?php echo $doctor_email; ?>">
							</div>
						    <div class="form-group">
						    	<input type="text" class="form-control margin-bottom copy-input" name="doctor_address_2" id="doctor_address_2" placeholder="Address 2" tabindex="4" value="<?php echo $doctor_address_2; ?>">
						    </div>


							<div class="form-group no-margin-bottom">
						
						
				<select class="form-control required" name="doctor_country" id="doctor_country" placeholder="Enter lastname...." required="">
                <option  selected value="">-- Select Country --</option>
                <?php
                    $countries  = "SELECT * FROM countries ";
					$results = $mysqli->query($countries);
                    
while($rsdepartment=$results->fetch_assoc()) {
    if($rsdepartment['id'] == $doctor_country) {
        echo "<option value='$doctor_country' selected>$rsdepartment[country_name]</option>";
    } else {
        echo "<option value='$doctor_country' > $rsdepartment[country_name]   </option>";
    }
}
                ?>
            </select>
            <span class="messages"></span>							</div>

						  <br>
						    <div class="form-group no-margin-bottom">
						    	<input type="text" class="form-control required" name="doctor_phone" id="invoice_phone" placeholder="Phone number" tabindex="8" value="<?php echo $doctor_phone; ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		

		<div class="col-xs-6 text-right">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Educational Background</h4>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
			
<!-- <input type="text" class="form-control margin-bottom required" name="doctor_title" id="doctor_title" placeholder="Enter Title" tabindex="9"> -->

<input list="physician" class="form-control margin-bottom required"  name="doctor_title" id="doctor_title" placeholder=""  value="<?php echo $doctor_title; ?>">
 <datalist id="physician">
  <option value="Nurse">
  <option value="Dr.">
  <option value="FY1/FY2">
  <option value="ST3+">
  <option value="SAS">
</datalist>
				<select class="form-control" name="doctor_department" id="doctor_department" placeholder="Enter lastname...." required="">
                <option value="">-- Select Department --</option>
                <?php
                    $sqldepartment= "SELECT * FROM department WHERE status='Active'";
					$results = $mysqli->query($sqldepartment);
					
                    
                    while($rsdepartment=$results->fetch_assoc())
                    {
                       if($rsdepartment['departmentid'] == $doctor_departmentid )
                       {
                        echo "<option value='$rsdepartment[departmentid]' selected>$rsdepartment[departmentname]</option>";
                        }
                        else
                        {
                            echo "<option value='$rsdepartment[departmentid]'>$rsdepartment[departmentname]</option>";
                        }

                    }
                ?>
            </select>

							</div>
						
						</div>
						<div class="col-xs-6">
			

							<div class="form-group">
								<input type="text" class="form-control margin-bottom required" name="doctor_education" id="doctor_education" placeholder="Education" tabindex="11" value="<?php echo $doctor_education; ?> ">	
							</div>
							<div class="form-group no-margin-bottom">
								<input type="text" class="form-control required" name="doctor_consultancy_charge" id="doctor_consultancy_charge" placeholder="Consutacy Charge" tabindex="13" value="<?php echo $doctor_consulatancy_charge ; ?> ">
							</div>
				<br>
				<div class="form-group no-margin-bottom">

				<select name="doctor_status" id="doctor_status" class="form-control required" required="">
				<option value="">-- Select Activity -- </option>
                <option value="Active"    <?php  if($doctor_status == 'Active') { echo 'selected'; } ?>>Active</option>
                <option value="Inactive"  <?php    if($doctor_status == 'Inactive') { echo 'selected'; } ?>>Inactive</option>
                </select>


            <span class="messages"></span>  </div>
	
						</div>
					</div>
				</div>
			</div>
		</div>


	</div>
	<div class="row">
		<div class="col-xs-12 margin-top btn-group">
			<input type="submit" id="action_update_doctor" class="btn btn-success float-right" value="Update Physician" data-loading-text="Updating...">
		</div>
	</div>
</form>

<?php
	include('footer.php');
?>