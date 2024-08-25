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
$query = "SELECT * FROM brands WHERE brand_id = '" . $mysqli->real_escape_string($getID) . "'";

$result = mysqli_query($mysqli, $query);

// mysqli select query
if($result) {
	while ($row = mysqli_fetch_assoc($result)) {
		$manufacturer_name = $row['brand_name']; // Manufacturer name
		$manufacturer_active = $row['brand_active']; // Manufacturer Activity

	}
}

/* close connection */
$mysqli->close();

?>

<h1>Edit Manufacturer</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>
						
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Editing Manufacture/ (<?php echo $getID; ?>)</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
				

					<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Manufacturer's Information</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
			<form method="post" id="update_manufacturerr" >
					<input type="hidden" name="action" value="update_manufac">
					<input type="hidden" name="id" value="<?php echo $getID; ?>">
					<div class="row">
					<div class="col-xs-4">
							<input type="text" class="form-control required" name="manufacture_name" placeholder="Enter Manufacture Name" value = "<?php echo $manufacturer_name ;?>">
						</div>
						<div class="col-xs-4">
					    <select name="manufacturer_status" id="manufacturer_status" class="form-control">
						<option <?php if($manufacturer_active=='1'){ echo 'selected'; } ?>value="1" selected>Active</option>
						<option <?php if($manufacturer_active=='0'){ echo 'selected'; } ?>value="0" selected>Inactive</option>
                       </select>
				</div>

					</div>

					<div class="row">
						<div class="col-xs-12 margin-top btn-group">
							<input type="submit" id="action_update_manufacturer" class="btn btn-success float-right" value="Update Manufacturer" data-loading-text="Updating...">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<div>


			</div>
		</div>
	</div>
</div>
</div>

<?php
	include('footer.php');
?>