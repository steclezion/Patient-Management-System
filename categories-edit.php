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
$query = "SELECT * FROM categories WHERE categories_id = '" . $mysqli->real_escape_string($getID) . "'";

$result = mysqli_query($mysqli, $query);

// mysqli select query
if($result) {
	while ($row = mysqli_fetch_assoc($result)) {
		$categories_name = $row['categories_name']; // categories  name
		$categories_active = $row['categories_active']; // categories Activity
	}
}

/* close connection */
$mysqli->close();

?>

<h1>Edit Categories</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>
						
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Editing Categoreis / (<?php echo $getID; ?>)</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
				

					<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Categoreis Information</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
			<form method="post" id="update_Categories" >
					<input type="hidden" name="action" value="update_categories">
					<input type="hidden" name="id" value="<?php echo $getID; ?>">
					<div class="row">
					        <div class="col-xs-4">
							<input type="text" class="form-control required" name="categories_name" placeholder="Enter Categories Name" value = "<?php echo $categories_name ;?>">
						    </div>
						<div class="col-xs-4">
					    <select name="categories_status" id="categories_status" class="form-control">
						<option <?php if($categories_active=='1'){ echo 'selected'; } ?>value="1" selected>Available</option>
						<option <?php if($categories_active=='0'){ echo 'selected'; } ?>value="0" selected>Not Available</option>
                       </select>
				</div>

					</div>

					<div class="row">
						<div class="col-xs-12 margin-top btn-group">
							<input type="submit" id="action_update_Categories" class="btn btn-success float-right" value="Update Categories" data-loading-text="Updating...">
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