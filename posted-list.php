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

<h1>Posted Inquires
  <?php  $Today = date('y/m/d'); 
         $new = date('Y', strtotime($Today));

         $date = new DateTime(); // For today/now, don't pass an arg.
         $date->modify("-10 day");
       //  echo $date->format("Y-m-d H:i:s");
    

      //  echo "<span style='color:orange;font-type:Monotype Corsiva;'>".$date->format("Y-m-d") ." AND ". $currentDate = date('Y/m/d')."</span>"; 
  
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
				<h4>Inquiries sent within  182.625 Days </h4>
                        
    <a href="send_inquiries.php#" class="btn btn-primary">New Patient</a>
    <a href="pending_inquiries.php#" class="btn btn-warning">Pending Patient</a>
    <a href="posted-list.php" class="btn btn-success active">Posted List</a>
			</div>



			<div class="panel-body form-group form-group-sm">
      <?php getInvoice_of_ten_days(); ?>
			</div>
		</div>
	</div>
<div>

<div id="insert" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Select Procedure</h4>
			</div>
			<div class="modal-body">
				<?php popProductsList(); ?>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn btn-primary" id="selected">Add</button>
				<button type="button" data-dismiss="modal" class="btn">Cancel</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="prescribe-patient" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
     
        <div style="width: 400px;height: 120px;padding: 10px;border: 5px solid skyblue;margin: 0;">
        <h3 class="modal-title">Prescription Info    </h4> <span class=" float-lg-right"> Invoice Number  <i> <b id="invid"> </b> <br> </i>  Patient Name <i> <b id="pname"> </b> </i> </span>
       </div>

    


      </div>
      <div class="modal-body" id='modal'>

      <div id="responsee" class="alert alert-success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="messagee"></div>
		</div>

      <form method="post" id="create_inquiry_to_pharmacy">
      <input type="hidden" name="action" value="create_inquiry_to_pharmacy">
      <input type="hidden" name="invoice_id_" id="invoice_id_" value="">
      <input type="hidden" name="task_tracker_name" id="task_tracker_name" value="Dr inquiring to Pharmacy">
      <input type="hidden" name="uname" value="<?php echo $_SESSION['login_user_id']; ?>">

	<table class="table table-bordered table-hover table-striped" id="invoice_table">
		<thead>
			<tr>
				<th width="300">
					<h4><a href="#" class="btn btn-success btn-xs add-row"><span class="glyphicon glyphicon-plus"
								aria-hidden="true"></span></a> Choose Medicine</h4>
				</th>
				<th>
					<h4>Qty</h4>
				</th>
				
				
				<th width="500">


				  	<h4>Description  </h4>
            <span class="col-xl-6">1 Tablet on the morning    </span>
            <span class="col-xl-6"> 1 Tablet on the Afternoon  </span>
            <span class="col-xl-6"> 1 Tablet on the Evening   </span>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr  id="calculate">
				<td>
					<div class="form-group form-group-sm  no-margin-bottom">
						<!-- <a href="#" class="btn btn-danger btn-xs delete-row"><span class="glyphicon glyphicon-remove"
								aria-hidden="true"></span></a>
						<input type="text" class="form-control form-group-sm item-input invoice_product"
							name="invoice_product[]" placeholder="Enter Name of Procedure" readonly>
						<p  id="select-item" style="display:block" class="item-select">or <a href="#">Select Procedure</a></p>
				 -->

         <a href="#" class="btn btn-danger btn-xs delete-row"><span class="glyphicon glyphicon-remove"
         aria-hidden="true"></span></a>

            <select name="medicine_product[]" class="form-control form-group-sm item-input invoice_product required" name="medicine_name"  id="medicine_name" placeholder="Medicine Name" required="">
				<option value="" selected> </option>
                <?php
                    $sql= "SELECT * FROM medicine  ";
					$results = $mysqli->query($sql);
         while($rsdepartment=$results->fetch_assoc())
                    {
echo "<option value='$rsdepartment[medicine_id]' >$rsdepartment[medicine_name]</option>";
                    }
                ?>
            </select>   
        
          </div>
				</td>
				<td class="text-right">
					<div class="form-group form-group-sm no-margin-bottom">
						<input type="number" class="form-control invoice_product_qty calculate required"
							name="invoice_product_qty[]" value="1" min="0"/>
					</div>
				</td>
		

				<td class="text-right">
					<div class="input-group input-group-md">
						
						<input  type="text" class="form-control  invoice_product_sub required" style='width: 245%;'  id="Description_prescription"
						name="Description[]" width="540px" height="100px"
						 aria-describedby="sizing-addon1" >
   
           
           
					</div>
                  </form>
				</td>
			</tr>


		</tbody>

	</table>
      </div>
      <div class="text-center" style="overflow-x:auto;" id="add_new_prescription">

      <button type="button"  class="btn btn-primary float-lg-right" title="Submit the inquiry from Dr to Pharmacy" id="action_send_to_pharmacy"  >Add New Prescription</button>

      
      
    </div>


      <div class="modal-footer">
   

      <div style="overflow-x:auto;">
                <table class="table table-striped table-hover table-bordered" id="data-tableee" cellspacing="0">
                  <thead>
                  <tr>
                    <th style="width: 10px;">ID</th>
                    <!-- <th style="width: 10px;">Invoice ID</th>
                    <th style="width: 10px;">Patient Name</th> -->
                    <th style="width: 10px;">Medicine Name</th>
                    <th style="width: 10px;" >Quantity</th>
                    <th style="width: 10px;">Description</th>
                    <th style="width: 10px;" >Date Added</th>
                 
                    <th width="10%">Added By</th>
                    <th style="width: 10px;" >Status</th>
                    <th style="width: 10px;">Action</th>
                  
       
                
                  </tr>
                  </thead>
                  <tbody id="table_Dr_request_Phar">
                   </tbody>
                  <tfoot>
                
                  
                  </tfoot>
                </table>
        </div>

<?php //if  ?>
        <select name="pharmacy_section" class="form-control form-group-sm item-input invoice_product required" name="Pharmacy_Name"  id="online_pharmacy" placeholder="Medicine Name" required="">
				<option value="0" selected> Choose Online Pharmaciest </option>
                <?php
                    $sql= "SELECT * FROM users where (user_type='Pharmacy' and check_activity = 1 )  ";
					$results = $mysqli->query($sql);
         while($rsdepartment=$results->fetch_assoc())
                    {
echo "<option value='$rsdepartment[id]' >$rsdepartment[name]</option>";
                    }
                ?>
            </select>   

        <button type="button"  class="btn btn-success" title="Submit the inquiry from Dr to Pharmacy" id="Submit_to_pharmacy">Submit To Pharmacy</button>

		
		<button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div id="delete_trid" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Prescription</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this Prescription?</p>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
		<button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->




<div id="lab_inquiries_posted_list" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title alert-success alert-dismissable">Issue Inquiries to Labaratory <span id='invoice_id' > </span>  </h4>
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
  <label class="form-check-label" for="flexCheckDefault">Hgh</label>
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

<div  style="display:block" class="row">
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
      <label>  online Labaratorist   </label>
     
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
                        <br><br>

</div> </div>       


                <br>
                <div style="overflow-x:auto;">
                <table class="table table-striped table-hover table-bordered" id="data-tablee" cellspacing="0">
                  <thead>
                  <tr>
                    <th>ID</th>
                    <th>Invoice</th>
                    <th>Issued Dr</th>
                    <th>Dr Name</th>
                    <th>Cashier Name</th>
                    <th>Lab Name</th>
                    <th>Test Type</th>
                    <th>Cashier Status</th>
                    <th>Lab Report</th>
                    <th>Date</th>
       
                
                  </tr>
                  </thead>
                  <tbody id="table_Dr_request_lab">
                   </tbody>
                  <tfoot>
                
                  
                  </tfoot>
                </table>
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