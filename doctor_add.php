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

<h1>Add Physician</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="create_doctor">
	<input type="hidden" name="action" value="create_doctor">
	<div class="row">
		<div class="col-xs-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Physician Information</h4>
					<div class="clear"></div>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="col-xs-6">
							<div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required" name="doctor_name" id="doctor_name" placeholder="Enter FullName" tabindex="1">
							</div>
							<div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required" name="doctor_address_1" id="doctor_address_1" placeholder="Address 1" tabindex="3">	
							</div>
							<div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required" name="doctor_town" id="doctor_town" placeholder="Town/City" tabindex="5">		
							</div>
							<div class="form-group no-margin-bottom">
								<input type="text" value="0000" class="form-control copy-input required" name="doctor_postcode" id="doctor_postcode" placeholder="Postcode" tabindex="7">					
							</div>
						</div>
						<div class="col-xs-6">
							<div class="input-group float-right margin-bottom">
								<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
								<input type="email" class="form-control copy-input required" name="doctor_email" id="doctor_email" placeholder="Email" aria-describedby="sizing-addon1" tabindex="2">
							</div>
						    <div class="form-group">
						    	<input type="text" class="form-control margin-bottom copy-input" name="doctor_address_2" id="doctor_address_2" placeholder="Address 2" tabindex="4">
						    </div>
							<div class="form-group no-margin-bottom">
						
						
				<select class="form-control required" name="doctor_country" id="doctor_country" placeholder="Enter Country...." required="">
                <option  selected value="">-- Select Country --</option>
                <?php
                    $countries  = "SELECT * FROM countries ";
					$results = $mysqli->query($countries);
                    
                    while($rscountries=$results->fetch_assoc())
                    {
                     
                        echo "<option value='$rscountries[id]'> $rscountries[country_name]</option>";
                        
                       

                    }
                ?>
            </select>
            <span class="messages"></span>							</div>
<br>
						    <div class="form-group no-margin-bottom">
						    	<input type="text" class="form-control required" name="doctor_phone" id="invoice_phone" placeholder="Phone Number" tabindex="8">
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

<input list="physician" class="form-control margin-bottom required"  name="doctor_title" id="doctor_title" placeholder="Enter Title">

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
                       if($rsdepartment['departmentid'] == $rsedit['departmentid'])
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
							<!-- <div class="form-group">
						    	<input type="password" class="form-control margin-bottom required" name="doctor_password" id="doctor_password" placeholder="Password" tabindex="10">
							</div>
							<div class="form-group">
								<input type="password" class="form-control margin-bottom required" name="doctor_confrim_password" id="doctor_confirm_password" placeholder="Confirm Password" tabindex="12">							
						    </div> -->

							<div class="form-group">
								<input type="text" class="form-control margin-bottom required" name="doctor_education" id="doctor_education" placeholder="Education" tabindex="11">	
							</div>
							<div class="form-group no-margin-bottom">
								<input type="text" class="form-control required" name="doctor_consultancy_charge" id="doctor_consultancy_charge" placeholder="Consutacy Charge" tabindex="13">
							</div>
				<br>
						    <div class="form-group no-margin-bottom">
							<select name="doctor_status" id="doctor_status" class="form-control" required="">
                <option value="">-- Select Activity -- </option>
                <option value="Active" <?php if(isset($_GET['editid']))
        { if($rsedit['status'] == 'Active') { echo 'selected'; } } ?>>Active</option>
                <option value="Inactive" <?php if(isset($_GET['editid']))
        { if($rsedit['status'] == 'Inactive') { echo 'selected'; } } ?>>Inactive</option>
            </select>
            <span class="messages"></span>							</div>


			
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 margin-top btn-group">
			<input type="submit" id="action_create_doctor" class="btn btn-success float-right" value="Add Physician" data-loading-text="Creating...">
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