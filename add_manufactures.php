<?php
include('header.php');

$user_permission = array(); 
$explode_comma_separated = explode(",", $_SESSION['User_Permission']);

for($i =0; $i <= count($explode_comma_separated); $i++)
{
@array_push($user_permission,$explode_comma_separated[$i]);
}

if ((in_array('5', $user_permission))) {

?>

<h2>Add Manufacturer</h2>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>
						
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Manufacturer's Information</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
			<form method="post" id="add_manu" >					
				<input type="hidden" name="action" value="add_manufact">

					<div class="row">
					<div class="col-xs-4">
							<input type="text" class="form-control required" name="manufacture_name" placeholder="Enter Manufacture Name">
						</div>
						<div class="col-xs-4">
					    <select name="manufacturer_status" id="manufacturer_status" class="form-control">
						<option value="1" selected>Active</option>
						<option value="0">Inactive</option>
                       </select>
				</div>

					</div>
					<div class="row">
						<div class="col-xs-12 margin-top btn-group">
							<input type="submit" id="action_add_manu" class="btn btn-success float-right" value="Add Manufacturer" data-loading-text="Adding...">

                    	</div>
					</div>
				</form>
			</div>
		</div>
	</div>
<div>

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