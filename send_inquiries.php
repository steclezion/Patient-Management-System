<?php


include('header.php');
include('functions.php');

$user_permission = array(); 

$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
for($i =0; $i <= count($explode_comma_separated); $i++)
{
@array_push($user_permission,$explode_comma_separated[$i]);
}

if ((in_array('3', $user_permission))) {

    ?>

<h1>Today's Patient List 
  <?php  $Today = date('y/m/d'); $new = date('Y', strtotime($Today));
  echo "<span style='color:orange;font-type:Monotype Corsiva;'>". $currentDate = date('d-m-Y')."</span>"; 
  
  ?></h1>
<hr>

<div class="row">

	<div class="col-xs-12">

		<div id="response" class="alert alert-success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="message"></div>
		</div>
	
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Send Inquiries</h4>

        
    <a href="send_inquiries.php#" class="btn btn-primary active">New Patient</a>
    <a href="pending_inquiries.php#" class="btn btn-warning">Pending Patient</a>
    <a href="posted-list.php" class="btn btn-primary">Posted List</a>


			</div>
			<div class="panel-body form-group form-group-sm">
				<?php  getInvoice_Today(); ?>
			</div>
		</div>
	</div>
<div>

<div id="delete_invoice" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Invoice</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this invoice?</p>
      </div>
      <div class="modal-footer">

        <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>

		
		<button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->





<div id="lab_inquiries" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title alert-success alert-dismissable">Issues Inquiries to Labaratory <span id='invoice_id' > </span>  </h4>
      </div>
      <div class="modal-body">
      <div class="panel panel-default" id="hematology_test"  hidden> </div>
      <div class="form-check"> <input class="form-check-input" type="checkbox" value="Hematology" id="hematology"> <label class="form-check-label" for="flexCheckDefault">
       &nbsp;General Tests </label>
      
      
       <h5 class="panel-title float-right" style="display:none" id="list_hema"  >
          <a  data-toggle="collapse" href="#collapse1" id="colp" ><i style="color:blue" class="glyphicon glyphicon-plus-sign"  id="collapse_one"> </i></a>
        </h5>
      
        <div id="collapse1" class="panel-collapse collapse">
      
<table class='table table-condensed' id='data-table'>
	
	<tr >
	<th style='border: 1px solid black;text-align:center;'></th>
  </tr>

<tbody >
<tr   >
	<td style='border: 1px solid black;text-align:left;' >
	<h3> <b> HEMATOLOGY </b> </h3>
  <div class="form-check">
  <input class="form-check-input" type="checkbox" value="Hgb_test" id="Hgb_test" />
  <label class="form-check-label" for="flexCheckDefault">Hgb</label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="BF_Test" id="BF_Test" />
  <label class="form-check-label" for="flexCheckDefault">	BF. For Malaria;( P.F)+  </label>
</div>


<div class="form-check">
  <input class="form-check-input" type="checkbox" value="TWBC_test" id="TWBC_test" />
  <label class="form-check-label" for="flexCheckDefault">TWBC</label>
</div>




<div class="form-check">
  <input class="form-check-input" type="checkbox" value="Diff_Count_test" id="Diff_Count_test" />
  <label class="form-check-label" for="flexCheckDefault">	Diff. Count</label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="VDRL_test" id="VDRL_test" />
  <label class="form-check-label" for="flexCheckDefault">V.D.R.L</label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="WIDAL_Test" id="WIDAL_Test" />
  <label class="form-check-label" for="flexCheckDefault">WIDAL Test</label>
</div>

<div class="form-check">
<label class="form-check-label" for="flexCheckDefault">Others</label>
  <input class="form-check-input" type="input" value="" id="others_test" />
 
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="RBS_test" id="RBS_test" />
  <label class="form-check-label" for="flexCheckDefault">RBS</label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="ERs_test" id="ERs_test" />
  <label class="form-check-label" for="flexCheckDefault">ERs</label>
</div>




<div class="form-check">
  <input class="form-check-input" type="checkbox" value="Morphology_test" id="Morphology_test" />
  <label class="form-check-label" for="flexCheckDefault">Morphology</label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="HCG_test" id="HCG_test" />
  <label class="form-check-label" for="flexCheckDefault">HCG </label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="H_Pylori_test" id="H_Pylori_test" />
  <label class="form-check-label" for="flexCheckDefault">H. Pylori</label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="Brucella_test" id="Brucella_test" />
  <label class="form-check-label" for="flexCheckDefault">Brucella Test </label>
</div>

<div class="form-check">
  <input class="form-check-input" type="checkbox" value="Hgb_A1C" id="Hgb_A1C" />
  <label class="form-check-label" for="flexCheckDefault">  Hgb. A1C </label>
</div>

 </td>


	
  </tr>      
  <tr >
  <tr >
	<td style='border: 1px solid black;text-align:left;'>
<h5> <b> <input class="form-check-input" type="checkbox" value="urine_analysis" id="urine_analysis" /> URINE ANALYSIS </b> </h3>
</td>
</tr>
<tr  >
	<td style='border: 1px solid black;text-align:left;'> 
	<h5> <b> <input class="form-check-input" type="checkbox" value="stool_analysis" id="stool_analysis" /> STOOL ANALYSIS </b></h3> 
  </td>
  </tr>

  <tr  >
	<td style='border: 1px solid black;text-align:left;'> 
	<h5> <b> <input class="form-check-input" type="checkbox" value="screening_for_hiv" id="screening_for_hiv" /> SCREENING FOR HIV </b></h3> 
  </td>
  </tr>


  <tr>
	<td style='border: 1px solid black;text-align:left;'> 
	<h5> <b> <input class="form-check-input" type="checkbox" value="HBV" id="HBV" /> HBV </b></h3> 
  </td>
  </tr>

  <tr>
	<td style='border: 1px solid black;text-align:left;'> 
	<h5> <b> <input class="form-check-input" type="checkbox" value="HCV" id="HCV" /> HCV </b></h3> 
  </td>
  </tr>







</tbody>
</table>


</div>


      </div>

      <div class="form-check"><input class="form-check-input" width="30%" height="30%" type="checkbox" value="Lipid" id="lipid" ><label class="form-check-label" for="flexCheckDefault">
      &nbsp; Lipid Test</label> </div>

    <div class="form-check"><input class="form-check-input" type="checkbox" value="Liver" id="liver" ><label class="form-check-label" for="flexCheckDefault">
    &nbsp; Liver Test </label> </div>

    <div class="form-check"><input class="form-check-input" type="checkbox" value="Renal" id="renal" ><label class="form-check-label" for="flexCheckDefault">
    &nbsp; Renal Test </label> </div>

   <br> 

   <div class="row">
		<div class="col-xs-4">
      <label> online Cashier </label>
			<select name="user_type_chasier" id="user_type_chasier" class="form-control">
      <option value="0" > </option>

		<?php 	

    $query = "SELECT * from users where check_activity = 1 and user_type = 'Cashier'   ";
    // mysqli select query
	  $results = $mysqli->query($query);
    while($row = $results->fetch_assoc()) {

     echo '<option value='.$row["id"].' > '.$row["name"].' </option>' ;


    }
    ?>
		</select>
		</div>

        <div class="col-xs-4">
      <label>  online Labaratorist</label>
     
			<select name="user_type" id="user_type" class="form-control">
      <option value="0" > </option>
		<?php 	
    $query = "SELECT * from users where check_activity = 1 and user_type = 'Labaratory'   ";
    // mysqli select query
	  $results = $mysqli->query($query);
    while($row = $results->fetch_assoc()) {

     echo '<option value='.$row["id"].' > '.$row["name"].' </option>' ;


    }
    ?>
						
					    </select>
				</div>

        </div>
      </div>
      <div class="modal-footer">

        <button type="button" data-dismiss="modal" class="btn btn-success" id="submit_dr_requeste_to_test">Submit</button>

		
		<button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


















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