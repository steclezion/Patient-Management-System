<?php


include('header.php');
include('functions.php');

$getID = $_GET['id'];

// Connect to the database
$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

// output any connection error
if ($mysqli->connect_error) {
	die('Error : (' . $mysqli->connect_errno . ') ' . $mysqli->connect_error);
}

// the query
$query = "SELECT * FROM store_customers WHERE id = '" . $mysqli->real_escape_string($getID) . "'";

$result = mysqli_query($mysqli, $query);

// mysqli select query
if ($result) {
	while ($row = mysqli_fetch_assoc($result)) {
        // invoice customer information
	   // billing
	$customer_name = $row['name']; // customer name
	$customer_age = $row['age']; // customer age
	$customer_sex = $row['sex']; // customer Sex
	$customer_town = $row['town']; // customer Town
	$customer_assinged_dr = $row['assigned_dr']; // customer Assigned Dr
	$customer_date_of_reg = $row['date_of_reg']; // customer Date of regisration
	$customer_company_name = $row['company_name']; // customer_company_name
	

	

		
	}
}

/* close connection */
//$mysqli->close();

?>

<h1>Edit Patient</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="update_customer">
	<input type="hidden" name="action" value="update_customer">
	<input type="hidden" name="id" value="<?php echo $getID; ?>">

	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Patient Information</h4>
					<div class="clear"></div>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="col-xs-6">
						<label> FullName  </label>
							<div class="form-group">
				
				<input value="<?php echo $customer_name; ?>"  type="text"  class="form-control margin-bottom copy-input required" name="customer_name"   id="customer_name" placeholder="Enter Patients Full Name" tabindex="1">
							</div>
							<label> Age </label>
		<div class="form-group">
		<!-- <input type="hidden" min="0" class="form-control margin-bottom copy-input required" name="Age" id="Age" placeholder="Age" tabindex="3">	 -->
		<select class="form-control required" name="customer_age" id="customer_age" placeholder="customer_age" required="">
                <option value="">-- Select Age--</option>
                <?php
                    
            for($i=0 ; $i<=100 ; $i++)
                    {
						if($i == $customer_age)
						{
							echo "<option selected  value=".$i."> $i </option>";
						}
                       
					   else 
					   {
						echo "<option value=".$i."> $i </option>";
					   }

                    }
                ?>
            </select>
           </div>
				
		   <label> Town </label>
		   <div class="form-group">
<input  value="<?php echo $customer_town; ?>"  list="town" class="form-control margin-bottom required"  name="customer_town" id="customer_town" placeholder="Enter Title">

<datalist id="town">
	<?php
	 $sqldepartment= "SELECT * FROM Town ";
	 $results = $mysqli->query($sqldepartment);
while($town=$results->fetch_assoc())
                    {
                      
                        echo "<option value='$town[town_name]' selected>";
                        
                       

                    }
                ?>
</datalist>
 </div>
				
							<!-- <div class="form-group no-margin-bottom" hidden>
								<input type="hidden" class="form-control copy-input required" name="customer_postcode" id="customer_postcode" placeholder="Sex" tabindex="7">					
							</div> -->
                        </div>

						<div class="col-xs-6" >
						<label> SEX </label>
						<div class="form-group">
	                        <select class="form-control required" name="customer_sex" id="sex" placeholder="Enter Customer Gender...." required="">
                            <option  hidden value="">-- Sex --</option>
                              <?php  if($customer_sex == 'Male') {?>
				            <option  selected value="Male">Male</option>
							<option  value="Female">Female</option>
							<?php } else { ?>
				            <option  selected value="Female">Female</option>
							<option   value="Male">Male</option>
                              <?php }?>
                            </select>
                            </div>
 

		<label> Assign Physican  </label>
		<div class="form-group">
		<select class="form-control required" name="customer_assigned_dr" id="customer_assigned_dr" placeholder="Assigned Dr...." required="">
                <option value="" selected>-- Assign Physican --</option>
                <?php
                    $sqldepartment= "SELECT * FROM doctor ";
					$results = $mysqli->query($sqldepartment);
                    
					
                    while($rsdepartment=$results->fetch_assoc())
                    {
                       
						if($rsdepartment['doctorid'] == $customer_assinged_dr)
						{
			 echo "<option  selected value='$rsdepartment[doctorid]' >$rsdepartment[doctorname]</option>";
						}
						else
						{
    echo "<option  value='$rsdepartment[doctorid]' >$rsdepartment[doctorname]</option>";
}
                     

                    }
                ?>
            </select>
        </div>

		<label> Date of Registration </label>
							<div class="form-group">
						    	<input data-date="" data-date-format="DD MMMM YYYY"  value="<?php echo date('d-m-Y',strtotime($customer_date_of_reg));  ?>" readonly type="text" class="form-control margin-bottom copy-input required" name="customer_date_of_reg" id="customer_date_of_reg" placeholder="Date of Registration" tabindex="4">
						    </div>


							<label> Select Company  </label>
		<div class="form-group">
		<select class="form-control required" name="customer_company_name" id="customer_company_name" placeholder="customer_company_name" required="">
				<option value="R-Patient" selected>Random Patient</option>
                <?php
                    $sqldepartment= "SELECT * FROM companies ";
					$results = $mysqli->query($sqldepartment);
                    
                    while($rsdepartment=$results->fetch_assoc())
                    {
                       
						if($rsdepartment['name'] == $customer_company_name)
						{
			 echo "<option  selected value='$rsdepartment[name]' >$rsdepartment[name]</option>";
						}
						else
						{
    echo "<option  value='$rsdepartment[name]' >$rsdepartment[name]</option>";
}
                     

                    }

                ?>
            </select>
        </div>

							
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>

	<div class="row">
		<div class="col-xs-12 margin-top btn-group">
			<input type="submit" id="action_update_customer" class="btn btn-success float-right" value="Update Patient" data-loading-text="Updating...">
		</div>
	</div>
</form>

<?php
include('footer.php');
?>