<?php

include('header.php');

?>

<h1>Add Patient</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="create_customer">
	<input type="hidden" name="action" value="create_customer">
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
				
				<input type="text" class="form-control margin-bottom copy-input required" name="customer_name"   id="customer_name" placeholder="Enter Patients Full Name" tabindex="1">
							</div>
							<label> Age </label>
							<div class="form-group">
								<!-- <input type="hidden" min="0" class="form-control margin-bottom copy-input required" name="Age" id="Age" placeholder="Age" tabindex="3">	 -->
		<select class="form-control required" name="customer_age" id="customer_age" placeholder="customer_age" required="">
                <option value="">-- Select Age--</option>
                <?php
                    
					
                    
                    for($i=0 ; $i<=100 ; $i++)
                    {
                       echo "<option value=".$i."> $i </option>";

                    }
                ?>
            </select>

							
							</div>
							<label> Town </label>
							<div class="form-group">
<input list="town" class="form-control margin-bottom required"  name="customer_town" id="customer_town" placeholder="Enter Title">

<datalist id="town">
	<?php
	 $sqldepartment= "SELECT * FROM Town ";
	 $results = $mysqli->query($sqldepartment);
while($town=$results->fetch_assoc())
                    {
                      
                        echo "<option value='$town[town_name]' selected> $town[town_name] </option>";
                        
                       

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
                            <option  selected value="">-- Sex --</option>
				            <option   value="Male">Male</option>
				            <option   value="Female">Female</option>
                            </select>
                            </div>
       <!-- <div class="input-group float-right margin-bottom" style='display:none'>
		<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
		<input type="hidden" class="form-control copy-input required" name="customer_email" id="customer_email" placeholder="Email" aria-describedby="sizing-addon1" tabindex="2">
		</div> -->


		<label> Assign Physican  </label>
		<div class="form-group">
		<select class="form-control required" name="customer_assigned_dr" id="customer_assigned_dr" placeholder="Assigned Dr...." required="">
                <option value="" selected>-- Assign Physican --</option>
                <?php
                    $sqldepartment= "SELECT * FROM doctor ";
					$results = $mysqli->query($sqldepartment);
                    
                    while($rsdepartment=$results->fetch_assoc())
                    {
                       
                       
						
			echo "<option value='$rsdepartment[doctorid]' >$rsdepartment[doctorname]</option>";
                        
                     

                    }
                ?>
            </select>
        </div>

		<label> Date of Registration </label>
							<div class="form-group">
								<?php $dt = new DateTime(); 
						  ;
						  ?>
						    	<input value="<?php echo $dt->format('d-m-Y') ; ?>" readonly type="text" class="form-control margin-bottom copy-input required" name="customer_date_of_reg" id="customer_date_of_reg" placeholder="<?php echo $dt->format('d-m-y') ; ?>" tabindex="4">
						    </div>

						    <!-- <div class="form-group" hidden>
						    	<input type="hidden" class="form-control margin-bottom copy-input" name="customer_address_2" id="customer_address_2" placeholder="Address 2" tabindex="4">
						    </div>

						    <div class="form-group" hidden>
						    	<input type="hidden" class="form-control margin-bottom copy-input required" name="customer_county" id="customer_county" placeholder="Country" tabindex="6">
						    </div> -->

						    <!-- <div class="form-group no-margin-bottom" hidden>
						    	<input type="hidden" class="form-control required" name="customer_phone" id="invoice_phone" placeholder="Phone Number" tabindex="8">
							</div> -->
						</div>
					</div>
				</div>
			</div>
		</div>
		</div>


	<div class="row">
		<div class="col-xs-12 margin-top btn-group">
			<input type="submit" id="action_create_customer" class="btn btn-success float-right" value="Add Patient" data-loading-text="Creating...">
		</div>
	</div>
</form>

<?php
	include('footer.php');
?>