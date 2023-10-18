<?php

include('header.php');

$user_permission = array(); 

$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
for($i =0; $i <= count($explode_comma_separated); $i++)
{
@array_push($user_permission,$explode_comma_separated[$i]);
}

if ((in_array('14', $user_permission))) {

    ?>
<h1>Add User</h1>
<hr>

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

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>
						
<div class="row">
	<div class="col-xs-12">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>User Information</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
				<form method="post" id="add_user">
					<input type="hidden" name="action" value="add_user">

					<div class="row">
						<div class="col-xs-4">
							<input type="text" class="form-control margin-bottom required" name="name" placeholder="Name">
						</div>
						<div class="col-xs-4">
							<input type="text" class="form-control margin-bottom required" name="username" placeholder="Enter username">
						</div>
						<div class="col-xs-4">
							<input type="text" class="form-control margin-bottom required" name="email" placeholder="Enter user's email address">
						</div>
					</div>

					<div class="row">
						<div class="col-xs-4">
							<input type="text" class="form-control" name="phone" placeholder="Enter user's phone number">
						</div>
						<div class="col-xs-4">
							<input type="password" class="form-control required" name="password" id="password" placeholder="Enter user's password">
						</div>

						<div class="col-xs-4">
					    <select name="user_type" id="user_type" class="form-control">
						<option value="Clerk" selected>Clerk</option>
						<option value="Cashier">Cashier</option>
						<option value="Nurse">Nurse</option>
						<option value="HeadNuse">Head Nurse</option>
						<option value="Labaratory">Laboratory Technician</option>
						<option value="Doctor">Doctor</option>
						<option value="Admin">Administrator</option>
					
					    </select>
				</div>


					</div>
            <!-- First set Row --> 
			<div class="container" id ="ex2">
  <h2>Users Roles</h2>
  <span class="well well-sm" > Can Access </span>
  &nbsp;
  <div class="checkbox">

  <ul class="list-group" id ="ex1">
      <label><input type="checkbox"  class="form-group required" name="dashboard" value="1" id="dashboard"> Dashboard  </label>
  </ul>

    </div>

	&nbsp;

	<div class="checkbox" >
  <ul class="list-group" id ="ex1">
      <label><input type="checkbox" name="create_invoice" value="2" id="create_invoice">    Create Invoice      </label>
	  <label><input type="checkbox" name="manage_invoice" value="3" id="manage_invoice">    Manage Invoice      </label>&nbsp;
	  <label><input type="checkbox" name="download_csv" value="4" id="download_csv">      Download Invoices   </label>&nbsp;
	  <label><input type="checkbox" name="delete_invoice" value="17" id="delete_invoice" >   Delete Invoices   </label>&nbsp;
</ul>
    </div>


	&nbsp;

	<div class="checkbox" >
	<ul class="list-group" id ="ex1">
	 <label><input type="checkbox" name="Add_Procedure" value="5"  id="Add_Procedure"> Add Procedures </label>&nbsp;
	 <label><input type="checkbox" name="manage_procedure" value="6"  id="manage_procedure"> Manage Procedure</label>&nbsp;
	 <label><input type="checkbox" name="edit_procedure" value="7"  id="edit_procedure"> Edit Procedure</label>&nbsp;
	 <label><input type="checkbox" name="delete_procedure" value="18" id="delete_procedure" >   Delete Procedure   </label>&nbsp;

    </ul>
    </div>

&nbsp;
	<div class="checkbox" >
	<ul class="list-group" id ="ex1">
	 <label><input type="checkbox" name="Add_patient" value="8" id="Add_patient" > Add Patient</label>&nbsp;
	  <label><input type="checkbox" name="manage_patient" value="9" id="manage_patient" > Manage Patient</label>&nbsp;
	  <label><input type="checkbox" name="edit_patient" value="10" id="edit_patient" > Edit Patient</label>&nbsp;
	  <label><input type="checkbox" name="delete_patient" value="19"  id="delete_patient" > Delete Patient</label>&nbsp;
   </ul>
    </div>

&nbsp; 
	<div class="checkbox" >
	<ul class="list-group" id ="ex1" >
	 <label><input type="checkbox" name="Add_doctor" value="11" id="Add_doctor" > Add Doctor</label> &nbsp;
	  <label><input type="checkbox" name="manage_doctor" value="12"  id="manage_doctor" > Manage Doctor</label>&nbsp;
	  <label><input type="checkbox" name="edit_doctor" value="13"  id="edit_doctor" > Edit Doctor</label>&nbsp;
	  <label><input type="checkbox" name="delete_doctor" value="20"  id="delete_doctor" > Delete Doctor</label>&nbsp;
    </ul>
    </div>
&nbsp; 


  <div class="checkbox" >

  <ul class="list-group" id ="ex1">
	 <label><input type="checkbox" name="Add_users" value="14" id="Add_users"> Add Users</label> &nbsp;
	  <label><input type="checkbox" name="manage_users" id="manage_users"  value="15"> Manage Users</label>&nbsp;
	  <label><input type="checkbox" name="edit_users" id="edit_users"  value="16"> Edit Users</label>&nbsp;
	  <label><input type="checkbox" name="delete_users" id="delete_users" value="21"> Delete Users</label>&nbsp;
  </ul>

  </div>


  <span class="well well-sm" > <button class="btn btn-primary btn-xs" id="select_permission_all"> Select All </button>  </span>

<span class="well well-sm" > <button class="btn btn-primary btn-xs" id="unselect_permission_all"> Unselect All </button>  </span>



</div>


<div class="row">
						<div class="col-xs-12 margin-top btn-group">
							<input type="submit" id="action_add_user" class="btn btn-success float-right" value="Add user" data-loading-text="Adding...">
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