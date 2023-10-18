<?php


include('header.php');
include('functions.php');

$user_permission = array(); 

$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
for($i =0; $i <= count($explode_comma_separated); $i++)
{
@array_push($user_permission,$explode_comma_separated[$i]);
}

if ((in_array('15', $user_permission))) {

    

$getID = $_GET['id'];

// output any connection error
if ($mysqli->connect_error) {
	die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
}

// the query
$query = "SELECT * FROM users WHERE id = '" . $mysqli->real_escape_string($getID) . "'";

$result = mysqli_query($mysqli, $query);

// mysqli select query
if($result) {
	while ($row = mysqli_fetch_assoc($result)) {
		$name = $row['name']; // name
		$username = $row['username']; // username
		$email = $row['email']; // email address
		$phone = $row['phone']; // phone number
		$password = $row['password']; // password
		$user_permission= $row['user_permission']; // password
		$user_type= $row['user_type']; // password
	}
}
$array_numbers = [];
$explode_users_permission = explode(',',$user_permission);

foreach($explode_users_permission as $exp)
{ array_push($array_numbers, $exp);}



/* close connection */
$mysqli->close();

?>

<h1>Edit User</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>
				
<style>

#ex1 {
  width: 600px;
  margin-left: 2px;
  border: 2px solid lightgray;
  padding : 0.1%;
  text-align: justify;
  border-width: auto;

  text-align:left;
}

#ex2 {
  max-width: 800px;
  margin-left: 2px;
  border: 5px solid lightgray;
  padding : 2%;
}


</style>

<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Editing User (<?php echo $getID; ?>)</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
				<form method="post" id="update_user">
					<input type="hidden" name="action" value="update_user">
					<input type="hidden" name="id" value="<?php echo $getID; ?>">

					<div class="row">
						<div class="col-xs-4">
							<input type="text" class="form-control margin-bottom required" name="name" placeholder="Name" value="<?php echo $name; ?>">
						</div>
						<div class="col-xs-4">
							<input type="text" class="form-control margin-bottom required" name="username" placeholder="Enter username" value="<?php echo $username; ?>">
						</div>
						<div class="col-xs-4">
							<input type="text" class="form-control margin-bottom required" name="email" placeholder="Enter user's email address" value="<?php echo $email; ?>">
						</div>
					</div>
					<div class="row">
						<div class="col-xs-4">
							<input type="text" class="form-control" name="phone" placeholder="Enter user's phone number" value="<?php echo $phone; ?>">
						</div>
						<div class="col-xs-4">
							<input type="password" class="form-control required" name="password" id="password" placeholder="Enter user's new password, if left empty it won't change.">
						</div>

						<div class="col-xs-4">
					    <select name="user_type" id="user_type" class="form-control">
							
						<option <?php if($user_type=='Clerk'){ echo 'selected'; } ?>value="Clerk" selected>Clerk</option>
						<option <?php if($user_type=='Cashier'){ echo 'selected'; } ?> value="Cashier">Cashier</option>
						<option <?php if($user_type=='Nurse'){ echo 'selected'; } ?> value="Nurse">Nurse</option>
						<option <?php if($user_type=='HeadNurse'){ echo 'selected'; } ?> value="HeadNuse">Head Nurse</option>
						<option <?php if($user_type=='Labaratory'){ echo 'selected'; } ?> value="Labaratory">Laboratory Technician</option>
						<option <?php if($user_type=='Doctor'){ echo 'selected'; } ?> value="Doctor">Doctor</option>
						<option <?php if($user_type=='Admin'){ echo 'selected'; } ?> value="Admin">Administrator</option>
			
						
					    </select>
				</div>

					</div>


			 <!-- First set Row --> 
			 <div class="container" id ="ex2">
  <h2>Users Roles</h2>
  <span class="well well-sm" > Can Access </span>
  <div class="checkbox">

  	<ul class="list-group" id ="ex1">
	<?php    if(in_array('1',$array_numbers)) { @$checked_dash = 'checked'; } else { @$checked_dash='';} ?>
      <label><input id="dashboard" type="checkbox" <?php echo @$checked_dash; ?>  class="form-group required" name="dashboard" value="1"> Dashboard  </label>
  	</ul>
    </div>
&nbsp;

  <div class="checkbox">
  	<ul class="list-group" id ="ex1">
      <?php    if(in_array('2',$array_numbers)) { @$checked_created = 'checked'; } else { @$checked_created='';} ?>
      <label><input id="create_invoice" type="checkbox"  <?php echo @$checked_created; ?> name="create_invoice" value="2">   Create Invoice      </label>
	 
	  <?php    if(in_array('3',$array_numbers)) { @$checked_manage = 'checked'; } else { @$checked_manage='';} ?>
	  <label><input id="manage_invoice" type="checkbox" <?php echo @$checked_manage; ?> name="manage_invoice" value="3">     Manage Invoice      </label>&nbsp;

	  <?php    if(in_array('4',$array_numbers)) { @$checked_download = 'checked'; } else { @$checked_download='';} ?>
	  <label><input id="download_csv" type="checkbox" <?php echo @$checked_download; ?> name="download_csv" value="4">    Download Invoices   </label>&nbsp;

	  <?php    if(in_array('17',$array_numbers)) { @$checked_delete_inv = 'checked'; } else { @$checked_delete_inv='';} ?>
	  <label><input id="delete_invoice"  type="checkbox"  <?php echo @$checked_delete_inv; ?> name="delete_invoice" value="17">    Delete Invoices   </label>&nbsp;
	</ul>
    </div>
&nbsp;
	
	<div class="checkbox">
		<ul class="list-group" id ="ex1">

	<?php    if(in_array('5',$array_numbers)) { @$checked_add_pro = 'checked'; } else { @$checked_add_pro='';} ?>
	<label><input id="Add_Procedure" type="checkbox" <?php echo @$checked_add_pro; ?> name="Add_Procedure" value="5"> Add Procedures </label>&nbsp;
	
	<?php    if(in_array('6',$array_numbers)) { @$checked_manage_pro = 'checked'; } else { @$checked_manage_pro ='';} ?>
    <label><input id="manage_procedure" type="checkbox" <?php echo @$checked_manage_pro; ?>  name="manage_procedure" value="6"> Manage Procedure</label>&nbsp;
	
	<?php    if(in_array('7',$array_numbers)) { @$checked_edit_pro = 'checked'; } else { @$checked_edit_pro='';} ?>
    <label><input id="edit_procedure" type="checkbox" <?php echo @$checked_delete_inv; ?> name="edit_procedure" value="7"> Edit Procedure</label>&nbsp;
	
	<?php    if(in_array('18',$array_numbers)) { @$checked_delete_pro = 'checked'; } else { @$checked_delete_pro='';} ?>
    <label><input id="delete_procedure"  type="checkbox" <?php echo @$checked_delete_pro; ?>  name="delete_procedure" value="18">   Delete Procedure   </label>&nbsp;

    	</ul>
    </div>
&nbsp;
	

	
	
	
	
	
	
	

	<div class="checkbox">
		<ul class="list-group" id ="ex1">
	<?php    if(in_array('8',$array_numbers)) { @$checked_add_patient = 'checked'; } else { @$checked_add_patient='';} ?>
     <label><input id="Add_patient" type="checkbox" <?php echo @$checked_add_patient; ?>  name="Add_patient" value="8"> Add Patient</label>&nbsp;
	 <?php    if(in_array('9',$array_numbers)) { @$checked_manage_patient = 'checked'; } else { @$checked_manage_patient='';} ?>
     <label><input id="manage_patient" type="checkbox" <?php echo @$checked_manage_patient; ?> name="manage_patient" value="9"> Manage Patient</label>&nbsp;
	 <?php    if(in_array('10',$array_numbers)) { @$checked_edit_patient = 'checked'; } else { @$checked_edit_patient='';} ?>
     <label><input id="edit_patient" type="checkbox" <?php echo @$checked_edit_patient; ?> name="edit_patient" value="10"> Edit Patient</label>&nbsp;
	 <?php    if(in_array('19',$array_numbers)) { @$checked_delete_patient = 'checked'; } else { @$checked_delete_patient='';} ?>
     <label><input id="delete_patient"  type="checkbox" <?php echo @$checked_delete_patient; ?>  name="delete_patient" value="19"> Delete Patient</label>&nbsp;
   	</ul>
    </div>
&nbsp;
	<div class="checkbox">
		<ul class="list-group" id ="ex1">
	<?php    if(in_array('11',$array_numbers)) { @$checked_add_doctor = 'checked'; } else { @$checked_add_doctor='';} ?>
    <label><input 	id="Add_doctor" type="checkbox" <?php echo @$checked_add_doctor; ?>  name="Add_doctor" value="11"> Add Doctor</label> &nbsp;
	<?php    if(in_array('12',$array_numbers)) { @$checked_manage_doctor = 'checked'; } else { @$checked_manage_doctor='';} ?>
    <label><input 	id="manage_doctor" type="checkbox"  <?php echo @$checked_manage_doctor; ?> name="manage_doctor" value="12"> Manage Doctor</label>&nbsp;
	<?php    if(in_array('13',$array_numbers)) { @$checked_edit_doctor = 'checked'; } else { @$checked_edit_doctor='';} ?>
    <label><input id="edit_doctor" type="checkbox" <?php echo @$checked_edit_doctor; ?>  name="edit_doctor" value="13"> Edit Doctor</label>&nbsp;
	<?php    if(in_array('20',$array_numbers)) { @$checked_delete_doctor = 'checked'; } else { @$checked_delete_doctor='';} ?>
     <label><input id="delete_doctor" type="checkbox" <?php echo @$checked_delete_doctor; ?>  name="delete_doctor" value="20"> Delete Doctor</label>&nbsp;
    	</ul>
    </div>
&nbsp;

  <div class="checkbox">
  	<ul class="list-group" id ="ex1">
<?php    if(in_array('14',$array_numbers)) { @$checked_add_users = 'checked'; } else { @$checked_add_users ='';} ?>
<label><input id="Add_users" type="checkbox" <?php echo @$checked_add_users; ?> name="Add_users" value="14"> Add Users</label> &nbsp;
<?php    if(in_array('15',$array_numbers)) { @$checked_manae_users = 'checked'; } else { @$checked_manage_users ='';} ?>
<label><input id="manage_users" type="checkbox" <?php echo @$checked_manae_users; ?>  name="manage_users" value="15"> Manage Users</label>&nbsp;
<?php    if(in_array('16',$array_numbers)) { @$checked_edit_users = 'checked'; } else { @$checked_edit_users='';} ?>
<label><input id="edit_users" type="checkbox" <?php echo @$checked_edit_users; ?>  name="edit_users" value="16"> Edit Users</label>&nbsp;
<?php    if(in_array('21',$array_numbers)) { @$checked_delete_users = 'checked'; } else { @$checked_delete_users='';} ?>
<label><input id="delete_users" type="checkbox"  <?php echo @$checked_delete_users; ?> name="delete_users" value="21"> Delete Users</label>&nbsp;
	</ul>
    </div>
&nbsp;

	
	 
	
	

	
	<span class="well well-sm" > <button class="btn btn-primary btn-xs" id="select_permission_all"> Select All </button>  </span>

	<span class="well well-sm" > <button class="btn btn-primary btn-xs" id="unselect_permission_all"> Unselect All </button>  </span>
	


</div>

					<div class="row">
						<div class="col-xs-12 margin-top btn-group">
							<input type="submit" id="action_update_user" class="btn btn-success float-right" value="Edit user" data-loading-text="Editing...">
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