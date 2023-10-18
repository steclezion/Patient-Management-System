<?php


include('header.php');
include('functions.php');

$user_permission = array(); 

$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
for($i =0; $i <= count($explode_comma_separated); $i++)
{
@array_push($user_permission,$explode_comma_separated[$i]);
}

  if( $_SESSION['user_type'] == 'Labaratory' || $_SESSION['user_type'] == 'Admin' ) {

    ?>

<h1>Request From a Doctor</h1>
<hr>

<div class="row">

	<div class="col-xs-12">

		<div id="response" class="alert alert-success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="message"></div>
		</div>
	
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Test Requests</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
				<?php getInvoices_from_DR_for_Lab(); ?>
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


   <input type="hidden" name="data-hematology_status" id="data-hematology_status" />
   <input type="hidden" name="data-liver_status" id="data-liver_status" />
   <input type="hidden" name="data-renal_status" id="data-renal_status" />
   <input type="hidden" name="data-lipid_status" id="data-lipid_status" />
   <input type="hidden" name="data-sender_id" id="data-sender_id" />



<div id="lab_request_from_dr" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title alert-warning alert-dismissable">Lab Procedures <span id='invoice_id' > </span>  </h4>
        
 <b>  Request From Dr  : <span id="General_test">  </span>   </b>
      </div>
      <div class="modal-body">
        
    <div> 
    <!-- <img src="images/Picture3.png" class="img-rounded" alt="Cinque Terre" width="850" height="130">  -->

    <table class="table table-responsive">
    <thead>
      <tr>
        <th>Patient Name </th>
        <th> Age </th>
        <th> Gender </th>
        <th>Test Date(Y/D/M)</th>
        <th>Sample Type</th>
        <th>Referred By</th>
      </tr>
    </thead>  
    <tbody>
      <tr class="table-primary" style="background-color:lightgrey">
        <td><span id="patient_name"> </span> </td>
        <td><span id="patient_age"> </span></td>
        <td><span id="patient_gender"> </span></td>
        <td><span id="patient_test_date"> </span></td>
        <td><span id="patient_sample_type"> SERUM </span></td>
        <td><span id="referred_by"> </span></td>
      </tr>      
    
    </tbody>
  </table>
     

  <div id="hematology_display" hidden > <input class="form-check-input" type="checkbox" value="Hematology" id="hematology"> <label class="form-check-label" for="flexCheckDefault">&nbsp;General Test </label> </div>
<div id="lipid_display" hidden ><input class="form-check-input" width="30%" height="30%" type="checkbox" value="Lipid" id="lipid" ><label class="form-check-label" for="flexCheckDefault"> 
      &nbsp; Lipid Test</label> </div>

      <div id="liver_display" hidden > <input class="form-check-input" type="checkbox" value="Liver" id="liver" ><label class="form-check-label" for="flexCheckDefault"> 
    &nbsp; Liver Test </label> </div>

<div id="renal_display" hidden > <input class="form-check-input" type="checkbox" value="Renal" id="renal" ><label class="form-check-label" for="flexCheckDefault"> 
&nbsp; Renal Test </label> </div>
<br> 

   
    <div class="panel panel-default" id="hematology_test"  hidden>
      <div class="panel-heading" >
        <h4 class="panel-title" >
          <a data-toggle="collapse"   href="#collapse1">General Tests  </a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse">
      <div class="panel-body"   >

      <div style="overflow-x:auto;">
<div class="container">          
  <img src="images/Picture3.png" class="img-rounded" alt="Cinque Terre" width="850" height="130"> 
  <table class="table table-responsive">
    <thead>
      <tr>
    

        <th width ="10%">Patient Name </th>
        <th width ="10%"> Age </th>
        <th width ="10%"> Gender </th>
        <th width ="10%">Test Date(Y/D/M)</th>
        <th width ="10%">Sample Type</th>
        <th width="10px">Referred By</th>
      </tr>
    </thead>  
    <tbody>
      <tr class="table-primary" style="background-color:lightgrey">
     <td>   <span id="hema_patient_name">          </span> </td>
        <td><span  id="hema_patient_age">          </span></td>
        <td><span id="hema_patient_gender">        </span></td>
        <td><span id="hema_patient_test_date">     </span></td>
        <td><span id="hema_patient_sample_type"> SERUM </span></td>
        <td><span id="hema_referred_by"> </span></td>
      </tr>      
    
    </tbody>
  </table>



</div>

      <div class="row">
<div class="col-md-6">
<h3> <b> HEMATOLOGY   </b> </h3>




<form  id="commentForm" method="POST" action="submit_hematology"  onSubmit="return validate();" enctype="multipart/form-data"  >
<input type="hidden" name="action" value="submit_hematology">


<input class="form-check-input" type="hidden"  id="invoice_di_hematology"  value =""  name="invoice_di_hematology"> 

<input type="hidden" value="" name="h_patient_name" id="h_patient_name" /> 
<input type="hidden" value="" name="h_patient_age" id="h_patient_age" /> 
<input type="hidden" value="" name="h_patient_gender" id="h_patient_gender" /> 
<input type="hidden" value="" name="h_ptest_date" id="h_ptest_date" /> 
<input type="hidden" value="" name="h_ptest_prefred_by" id="h_ptest_prefred_by" /> 


<div id="class_1" style='border: 2px dotted black;outline-color: red;'>
<div class="form-group">

<label>Hgb </label>
<input class="form-control requiredd" type="text" id="hgh" name="hgh"    > 
</div>                               
<div class="form-group">
<label>BF. For Malaria </label>
<!-- <select id="bf_malaria" class="form-control requiredd" name="bf_malaria">
<option value="" selected></option>
          <option value="+1">+<sup> 1</sup></option>
          <option value="+2">+<sup> 2</sup></option>
          <option value="+3">+<sup> 3</sup></option>
          <option value="Vivax"> Vivax</option>
          <option value="Falcipurum">Falcipurum</option>
              </select>    -->

<input list="malaria" class="form-control margin-bottom required"  name="bf_malaria" id="bf_malaria" placeholder="BF Malaria">
          <datalist id="malaria">
          <option value='' selected>  </option>
          <option value="+1">+<sup> 1</sup></option>
          <option value="+2">+<sup> 2</sup></option>
          <option value="+3">+<sup> 3</sup></option>
          <option value="Vivax"> Vivax</option>
          <option value="(P.f)+1">(P.f)+1</option>
          <option value="(P.f)+2">(P.f)+2</option>
          <option value="(P.f)+3">(P.f)+3</option>
</datalist>
</div>                     
<div class="form-group">
<label>TWBC</label>
<input class="form-control requiredd" type="text" id="TWBC" name="TWBC" >
  
</div>
<div class="form-group">
<label>Diff. Count </label>
 <input autocomplete="off" class="form-control requiredd"   type="text" name="diff"   id="diff"/>
</div> 

<div class="form-group">
<label>V.D.R.L </label>
<!-- <input class="form-control requiredd" type="text" id="vdrl" name="vdrl" > -->

<!-- <select class="form-control requiredd"  id="vdrl" name="vdrl">
<option value="" selected></option>
          <option value="+1">+<sup> 1</sup></option>
          <option value="+2">+<sup> 2</sup</option>
          <option value="+3">+<sup> 3</sup</option>
  </select> -->

  <input list="vdrl_" class="form-control margin-bottom required"  name="vdrl" id="vdrl" placeholder="vdrl">
          <datalist id="vdrl_">
          <option value='' selected>  </option>
          <option value="+1">+<sup> 1</sup></option>
          <option value="+2">+<sup> 2</sup></option>
          <option value="+3">+<sup> 3</sup></option>
       
</datalist>

</div>

<div class="form-group">
<label>WIDAL Test ……O;1;20  H;1;40  </label>
<input class="form-control requiredd" type="text" id="widal" name="widal" >
</div>



<div class="form-group">
<label>Others</label>
<textarea autocomplete="off" class="form-control requiredd"    id="others_hematology" type="text" name="others_hematology" >

  </textarea>
</div> 
</div>
<br>
<div id="class_2" style='border: 2px dotted black;outline-color: red;'>
<h3> <b> URINE ANALYSIS   </b> </h3>
<div class="form-group">
<label>Colour </label>
<!-- <select id="urine_color" class="form-control requiredd" name="urine_color">
<option value="" selected></option>
<option value="Yellow">Yellow</option>
<option value="Cloudy">Cloudy</sup</option>
<option value="Clear">Clear</option>
              </select>   -->


<input list="color_urine" class="form-control margin-bottom required"  name="urine_color" id="urine_color" placeholder="urine color">
<datalist id="color_urine">
<option value="" selected></option>
<option value="Yellow">Yellow</option>
<option value="Cloudy">Cloudy</sup</option>
<option value="Clear">Clear</option>
       
</datalist>


             </div> 

<div class="form-group">
<label>Reaction </label>
<!-- <input class=" form-control requiredd"  name="reaction_color"  id="reaction_color" type="text"  /> -->

<input list="urine_reaction_" class="form-control margin-bottom required" name="reaction_color"  id="reaction_color"    placeholder="Reaction Color">
   <datalist id="urine_reaction_">
   <option value="" selected></option>
   <option value="Acidic">Acidic</option>
   <option value="Alkalyne">Alkalyne</option>
     </datalist>


  </div>  

  <div class="form-group">
<label>Albumin</label>
<!-- <select id="urine_Albumin" class="form-control requiredd" name="urine_Albumin">
<option value="" selected></option>
          <option value="+1">+<sup> 1</sup></option>
          <option value="+2">+<sup> 2</sup</option>
          <option value="+3">+<sup> 3</sup</option>
          <option value="Null">+<sup> Null</sup</option>
</select>    -->

<input list="urine_Albumin_" class="form-control margin-bottom required"  name="urine_Albumin" id="urine_Albumin" placeholder="urine color">
<datalist id="urine_Albumin_">
          <option value="" selected></option>
          <option value="+1">+<sup> 1</sup></option>
          <option value="+2">+<sup> 2</sup</option>
          <option value="+3">+<sup> 3</sup</option>
          <option value="Null"><sup> Null</sup</option>
          </datalist>
</div> 

<div class="form-group">
<label>Sugar</label>
<!-- <select id="urine_sugar" class="form-control requiredd" name="urine_sugar">
          <option value="" selected></option>
          <option value="+1">+<sup> 1</sup></option>
          <option value="+2">+<sup> 2</sup</option>
          <option value="+3">+<sup> 3</sup</option>
          </select>    -->

          <input list="urine_sugar_" class="form-control margin-bottom required"  name="urine_sugar"  id="urine_sugar"  placeholder="Urine Sugar">
          <datalist id="urine_sugar_">
          <option value="" selected></option>
          <option value="+1">+<sup>1</sup></option>
          <option value="+2">+<sup>2</sup</option>
          <option value="+3">+<sup>3</sup</option>
          <option value="Null"><sup>Null</sup</option>
          </datalist>

</div>  
<div class="form-group">
<label>Acetone </label>
          <!-- <select id="urine_acetone" class="form-control requiredd" name="urine_acetone">
          <option value="" selected></option>
          <option value="+1">+<sup> 1</sup></option>
          <option value="+2">+<sup> 2</sup</option>
          <option value="+3">+<sup> 3</sup</option>
          </select>  -->

   <input list="urine_acetone_" class="form-control margin-bottom required"  id="urine_acetone"  name="urine_acetone"  placeholder="Urine Acetone">
   <datalist id="urine_acetone_">
   <option value="" selected></option>
   <option value="+1">+<sup>1</sup></option>
   <option value="+2">+<sup>2</sup</option>
   <option value="+3">+<sup>3</sup</option>
   <option value="Null"><sup>Null</sup</option>
   </datalist>


</div> 
<div class="form-group">
<label>Bile Pigment  </label>
<!-- <select id="urine_bile_pigment" class="form-control requiredd" name="urine_bile_pigment">
<option value="" selected></option>
<option value="+1">+<sup> 1</sup></option>
<option value="+2">+<sup> 2</sup</option>
<option value="+3">+<sup> 3</sup</option>
</select>     -->





<input list="urine_bilepigment_" class="form-control margin-bottom required" id="urine_bile_pigment"  name="urine_bile_pigment"  placeholder="urine bile pigment">
   <datalist id="urine_bilepigment_">
   <option value="" selected></option>
   <option value="+1">+<sup>1</sup></option>
   <option value="+2">+<sup>2</sup</option>
   <option value="+3">+<sup>3</sup</option>
   <option value="Null"><sup>Null</sup</option>
   </datalist>



          </div> 
</div>
<br>
<div id="class_3" style='border: 2px dotted black;outline-color: red;'>
<h3> <b> MICROSCOPY </b> </h3>
<div class="form-group">
<label>Pus Cell </label>
<input type="text" class="form-control requiredd" id="pus_Cell_microsocopy" name="pus_cell_microsocopy" >
</div>  
<div class="form-group">
<!-- <label>RBC</label>
<select id="RBC" class="form-control requiredd" name="RBC">
<option value="" selected></option>
          <option value="A">A</option>
          <option value="B">B</option>
          <option value="C">C</option>
              </select> -->
<label>RBC</label>
<input type="text" class="form-control requiredd" id="RBC" name="RBC" Placeholder="RBC Description" >

          </div> 

<div class="form-group">
<label>Crystal  </label>
<input class=" form-control requiredd" autocomplete="off" name="Crystal"  id="crystal" type="text"  />
</div> 


<div class="form-group">
<label>EPC </label>
<input class="form-control requiredd" autocomplete="off" name="EPC"  id="EPC" type="text"  />
</div> 

<div class="form-group">
<label>Ova </label>
<input class=" form-control requiredd" autocomplete="off"  name="ova"  id="ova" type="text"  />
 </div> 


<div class="form-group">
<label>Others  </label>
<textarea class=" form-control requiredd" autocomplete="off" name="others"  id="others" type="text"  >
  </textarea>   
</div> 

</div>
</div>
<h3> <b> TEST </b> </h3>

<div class="col-md-6">
<div id="class_4" style='border: 2px dotted black;outline-color: red;'>
 <div class="form-group">
  <label class="control-label" for="inputError">RBS</label>
  <input type="text" class="form-control requiredd" id="RBS" name="RBS" />
    </div>

    <div class="form-group">
  <label class="control-label" for="inputError">FBS</label>
  <input type="text" class="form-control requiredd" id="FBS" name="FBS" />
    </div>

    <div class="form-group">
  <label class="control-label" for="inputError">ERS</label>
  <input type="text" class="form-control requiredd" id="ERS" name="ERS"  />
    </div>

    <div class="form-group">
  <label class="control-label" for="inputError">Morphology </label>
  <input type="text" class="form-control requiredd" id="Morphology" name="Morphology"  name="Morphology" />
    </div>

    <div class="form-group">
  <label class="control-label" for="inputError">HCG </label>

  <!-- <select id="HCG" class="form-control requiredd" name="HCG">
  <option value="" selected></option>
          <option value="Positive">Positive</option>
          <option value="Negative">Negative</option>
          </select> -->

          <input list="HCG" class="form-control margin-bottom required" id="HCG"  name="HCG"  placeholder="HCG">
   <datalist id="HCG">
   <option value="" selected></option>
   <option value="Positive">+<sup>Positive</sup></option>
   <option value="Negative">+<sup>Negative</sup></option>
   <option value="Null"><sup>Null</sup</option>
   </datalist>


    </div>

    <div class="form-group">
  <label class="control-label" for="inputError">H. Pylori </label>

          <!-- <select id="H_pylori" class="form-control requiredd" name="H_pylori">
          <option value="" selected></option>
          <option value="Positive">Positive</option>
          <option value="Negative">Negative</option>
          </select> -->


          <input list="H_p"  id="H_pylori" class="form-control requiredd" name="H_pylori" placeholder="H Pylori">
   <datalist id="H_P">
   <option value="" selected></option>
   <option value="Positive">+<sup>Positive</sup></option>
   <option value="Negative">+<sup>Negative</sup></option>
   <option value="Null"><sup>Null</sup</option>
   </datalist>

    </div>

  <div class="form-group">
  <label class="control-label" for="inputError">Brucella Test  </label>
  <input type="text" class="form-control requiredd" id="Brucella_Test" name="Brucella_Test" >
  </div>


  <div class="form-group">
  <label class="control-label" for="inputError">Hgb. A1C </label>
  <input id="HGB" type="text" class="form-control requiredd" name="HGB">
   
  </div>
</div>
  <br>

  <div id="class_5" style='border: 2px dotted black;outline-color: red;'>
 <h3> <b> STOOL ANALYSIS  </b> </h3>
                                   
  <div class=" form-group input-group input-group-md">
  <span class="input-group-addon">Colour</span>
  <input id="color_stool" type="text"  name="color"  class="form-control requiredd"   />
  </div>

<div class="form-group input-group input-group-md">
  <span class="input-group-addon">Consist </span>

 <input type="text" name="Consist" id="Consist" class="form-control requiredd" />

</div>   


<div class="form-group input-group input-group-md">
  <span class="input-group-addon">Reaction</span>
 <input type="text" name="Reaction" id="Reaction" class="form-control requiredd" />
</div>   



<div class="form-group input-group input-group-md">
  <span class="input-group-addon">Mucus</span>
 <input type="text" name="Mucus" id="Mucus" class="form-control requiredd" />
</div> 

<div class="form-group input-group input-group-md">
  <span class="input-group-addon">Blood </span>
 <input type="text" name="Blood" id="Blood" class="form-control requiredd" />
</div> 

<div class="form-group input-group input-group-md">
  <span class="input-group-addon">Worms </span>
 <input type="text" name="Worms" id="Worms" class="form-control requiredd" />
</div> 
</div>
<br>

<div id="class_5" style='border: 2px dotted black;outline-color: red;'>
 <h3> <b> Screening For HIV  </b> </h3>
                                   
  <div class=" form-group input-group input-group-md">
  <span class="input-group-addon">HIV</span>
  <input id="HIV" type="text"  name="HIV"  class="form-control requiredd"   />
  </div> 
 
</div>
<br>
<div id="class_5" style='border: 2px dotted black;outline-color: red;'>
 <h3> <b> HBV </b> </h3>
                                   
  <div class=" form-group input-group input-group-md">
  <span class="input-group-addon">HBV</span>
  <input id="HBV" type="text"  name="HBV"  class="form-control requiredd"   />
  </div> 
 
</div>
<br>

<div id="class_5" style='border: 2px dotted black;outline-color: red;'>
 <h3> <b> HCV </b> </h3>
                                   
  <div class=" form-group input-group input-group-md">
  <span class="input-group-addon">HCV</span>
  <input id="HCV" type="text"  name="HCV"  class="form-control requiredd"   />
  </div> 
 
</div>
<br>

<div id="class_6" style='border: 2px dotted black;outline-color: red;'>
<h3><b> DIRECT MICROSCOPY </b>  </h3>
   <div class="form-group">
    <label>Pus Cells</label>
   <input class="form-control requiredd" type="text" id="Pus_Cells_direct_microscopy" name="Pus_Cells_direct_microscopy">
</div>

   <div class="form-group">
    <label>R.B. Cs</label>
    <input class="form-control requiredd" type="text" id="RBCS" name="RBCS" >
</div>
   <div class="form-group">
    <label>O/P </label>
   <input class="form-control requiredd" type="text" id="o_p" name="o_p">
</div>



<div class="form-group">
    <label>H.Pylori(Ag) </label>
   <input class="form-control requiredd" type="text" id="H.Pylori(Ag)" name="H_Pylori_Ag_">
</div>


</div>
</form>

<div class="modal-footer">
<a target="_blank" style="display:none" id="print_hematology"  href="" type="button" class="btn btn-primary btn-md float-right" > <i class="glyphicon glyphicon-download"></i> Download </a>

<button type="button"  class="btn btn-success float-left" id="submit_lab_requeste_to_test_hematology"><span class="glyphicon glyphicon-list-alt"> </span>Save</button>


<br><br>

<div id="response_hematology" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>


  </div>



</div>
       
  
</div>  </div>  </div>
</div></div>



<div class="panel panel-default" id="lipid_test"  hidden>
      <div class="panel-heading" >
        <h4 class="panel-title" >
          <a data-toggle="collapse"   href="#collapse2">Lipid Tests</a>
        </h4>
      </div>
      <div id="collapse2" class="panel-collapse collapse">
      <div class="panel-body">

      <div style="overflow-x:auto;">
  <h2 style="text-align:center"><b> LIPID PROFILE TEST</b></h2>

  <form method="post" method="POST" id="create_lipid_test"  action="create_lipid_test"  onSubmit="return validate();" enctype="multipart/form-data"> 
  

  <input type="hidden" name="action" value="create_lipid_test">

  <input type="hidden" name="invoice_di" id="invoice_di" value="">
  <div id="this_to_be_print">
  <div class="container">          
  <img src="images/Picture3.png" class="img-rounded img-responsive" alt="Cinque Terre" width="850" height="130"> 


  <table class="table table-responsive">
    <thead>
      <tr>
        <th width ="10%">Patient Name </th>
        <th> Age </th>
        <th width ="10%"> Gender </th>
        <th width ="10%">Test Date(Y/D/M)</th>
        <th width ="10%">Sample Type</th>
        <th>Referred By</th>
      </tr>
    </thead>  
    <tbody> 
      <tr class="table-primary" style="background-color:lightgrey">
        <td><span id="lipid_patient_name"> </span> </td>
        <td><span  id="lipid_patient_age"> </span></td>
        <td><span id="lipid_patient_gender"> </span></td>
        <td><span id="lipid_patient_test_date"> </span></td>
        <td><span id="lipid_patient_sample_type"> SERUM </span></td>
        <td><span id="lipid_referred_by"> </span></td>
      </tr>      
    
    </tbody>
  </table>
</div>
  <table class="table table-responsive">
      <thead>
      <tr>
      <th>Test</th>
      <th>Results</th>
      <th>Reference Interval</th>
      <th>Unit</th>
    </tr>
  </thead>
  <tbody>
    <tr>
      <td>TCHOL</td>
      <td>  <span id="tcholl"> <input id="tchol" size="10" type="number" min="0" placeholder="put a number"  name="tchol"  class="form-control required"  />  </span>   </td>
      <td>130 - 250</td>
      <td>mg/dl</td>
    </tr>      
    <tr >
      <td>TG</td>
      <td> <span id="TGG"> <input id="TG" size="10"  type="text" min="0"  placeholder="put a number"  name="TG"  class="form-control required"   /></td>
      <td>60 - 170 </td>
      <td>mg/dl</td>
    </tr>
    <tr >
      <td>HDLC</td>
      <td> <span id="HDLCC"> <input id="HDLC" type="number" min="0" size="10" name="HDLC"  placeholder="put a number"  class="form-control required  required   required"   /></td>
      <td>35 - 80 </td>
      <td>mg/dl</td>
    </tr>

    
    <tr >
      <td>LDLC </td>
      <td> <span id="LDLCC">  <input id="LDLC" size="10" min="0"  type="number"  name="LDLC"  placeholder="put a number"  class="form-control required  required  xs required "   /></td>
      <td> 0 - 130 </td>
      <td>mg/dl</td>
    </tr>

    

  
  </tbody>
</table>
</div> 
<!-- <button type="button"  style="display:none" class="btn btn-success submit_lab_requeste_to_test_lipid_update"  id="submit_lab_requeste_to_test_lipid_updated"> <span class="glyphicon-fa-save"> </span>Update</button> -->
<!-- <button   type="button"  style="display:none" id="print" class="btn btn-primary btn-md float-right"><span class="glyphicon glyphicon-print" aria-hidden="true"></span>Print </button> -->

<a target="_blank" style="display:none" id="print_lipid"  href="" type="button" class="btn btn-primary btn-md float-right" > <i class="glyphicon glyphicon-download"></i> Download </a>


<button type="button"  class="btn btn-success submit_lab_requeste_to_test_lipid_save" id="submit_lab_requeste_to_test_lipid"><span class="glyphicon-fa-save"> </span>Save </button>
<br><br><br>

<div id="response_lipid" class="alert alert-success" style="display:none;">
<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>
</form>

</div></div>
	  
	  </div>
	  
	  </div>





    <div class="panel panel-default" id="liver_test"  hidden>
      <div class="panel-heading" >
        <h4 class="panel-title" >
          <a data-toggle="collapse"   href="#collapse3">Liver Tests</a>
          
        </h4>
      </div>
      <div id="collapse3" class="panel-collapse collapse">
     <div class="panel-body"   >

     <form method="post" id="create_liver_test"> <input type="hidden" name="action" value="create_liver_test">
     <input type="hidden" name="action" value="create_liver_test">

  <input type="hidden" name="invoice_di_liver" id="invoice_di_liver" value="">

     <div style="overflow-x:auto;">
     <div class="container">          
     <img src="images/Picture3.png" class="img-rounded" alt="Cinque Terre" width="850" height="130"> 

  <table class="table table-responsive">
    <thead>
      <tr>
      <th width ="10%">Patient Name </th>
        <th width ="10%"> Age </th>
        <th width ="10%"> Gender </th>
        <th width ="10%">Test Date(Y/D/M)</th>
        <th width ="10%">Sample Type</th>
        <th  width="10px">Referred By</th>
      </tr>
    </thead>  
    <tbody>
      <tr class="table-primary" style="background-color:lightgrey">
     <td><span     id="liver_patient_name"> </span> </td>
        <td><span  id="liver_patient_age"> </span></td>
        <td><span id="liver_patient_gender"> </span></td>
        <td><span id="liver_patient_test_date"> </span></td>
        <td><span id="liver_patient_sample_type"> SERUM </span></td>
        <td><span id="liver_referred_by"> </span></td>
      </tr>      
    
    </tbody>
  </table>
</div>


<h3 style="text-align:center">  <b> LIVER FUNCTION TEST  </b> </h3>
<table class="table table-responsive"  id='this_to_be_print_liver'>
  <thead>
    <tr>
       <th>Test</th>
      <th>Results</th>
      <th>Reference</th>
      <th>Unit</th>
    </tr>
  </thead>
  <tbody>
    <tr>    
      <td>Total Protien</td>
      <td>  <input id="total_protien" type="text" placeholder="put a number"  name="uric_acidr"  class="form-control required" /></td>
      <td>6-8</td>
      <td>g/dll</td>
  
    </tr>      
    <tr >
      <td>ALB</td>
      <td><input id="alb" type="text" placeholder="put a number"  name="alb"  class="form-control required"   /></td>
      <td>3.4 - 5.5</td>
      <td>g/dll</td>
    </tr>
    <tr >

  <td>AST </td>
  <td><input id="ast" type="text"  name="ast"  placeholder="put a number"  class="form-control required"   /></td>
      <td>0 - 41</td>
      <td>U/L</td>
    </tr>
    <tr >
      <td>GGT </td>
      <td><input id="ggt" type="text"  name="ggt"  placeholder="put a number"  class="form-control required"   /></td>
      <td>1 - 49 </td>
      <td>U/L</td>
    </tr>

   

    <tr >
      <td>TBIL </td>
      <td> <input id="tbil" type="text"  name="tbil"  placeholder="put a number"  class="form-control required"   /></td>
      <td>0-1</td>
      <td>MG/dl</td>
    </tr>
   
    <tr >
      <td>DBIL </td>
      <td>  <input id="dbil" type="text"  name="dbil"  placeholder="put a number"  class="form-control required"   /></td>
      <td>0 - 0.3 </td>
      <td>MG/dl</td>
    </tr>

    <tr >
      <td>ALP </td>
      <td>  <input id="alp" type="text"  name="alp"  placeholder="put a number"  class="form-control required"   /></td>
      <td>42 - 406</td>
      <td>u/l</td>
    </tr>

  
  </tbody>
</table>
<a target="_blank" style="display:none" id="print_liver"  href="" type="button" class="btn btn-primary btn-md float-right" > <i class="glyphicon glyphicon-download"></i> Download </a>

<button type="button" data-dismiss="modal" class="btn btn-success" id="submit_lab_requeste_to_test_liver"><span class="glyphicon-fa-save"> </span>Save</button>

<br><br> 

<div id="response_liver" class="alert alert-success" style="display:none;">
<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>
</form>
</div>
</div>
	  
</div>
</div>
	  
	  




    <div class="panel panel-default" id="renal_test"  hidden >
      <div class="panel-heading" >
        <h4 class="panel-title" >
          <a data-toggle="collapse"   href="#collapse4">Renal Tests</a>
        </h4>
      </div>
      <div id="collapse4" class="panel-collapse collapse">
      <div class="panel-body"   >


      <div style="overflow-x:auto;">
      <h3 style="text-align:center">  <b> RENAL FUNCTION TEST  </b> </h3>

     <form method="post" id="create_renal_test"> <input type="hidden" name="action" value="create_renal_test">
     <input type="hidden" name="action" value="create_renal_test">

  <input type="hidden" name="invoice_di_renal" id="invoice_di_renal" value="">


      <div class="container">          
  <img src="images/Picture3.png" class="img-rounded" alt="Cinque Terre" width="850" height="130"> 
  <table class="table table-responsive">
    <thead>
      <tr>
    

        <th width ="10%">Patient Name </th>
        <th width ="10%"> Age </th>
        <th width ="10%"> Gender </th>
        <th width ="10%">Test Date(Y/D/M)</th>
        <th width ="10%">Sample Type</th>
        <th  width="10px">Referred By</th>
      </tr>
    </thead>  
    <tbody>
      <tr class="table-primary" style="background-color:lightgrey">
     <td>   <span id="renal_patient_name"> </span> </td>
        <td><span  id="renal_patient_age"> </span></td>
        <td><span id="renal_patient_gender"> </span></td>
        <td><span id="renal_patient_test_date"> </span></td>
        <td><span id="renal_patient_sample_type"> SERUM </span></td>
        <td><span id="renal_referred_by"> </span></td>
      </tr>      
    
    </tbody>
  </table>
</div>



  <table class="table table-responsive">
    <thead>
      <tr>
        <th>Description</th>
        <th>Results</th>
        <th>Reference</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>URIC ACID	</td>
        <td>  <input id="uric_acid" type="text" placeholder="put a number"  name="uric_acidr"  class="form-control required"   /></td>
        <td>4-7.2</td>
      </tr>      
      <tr >
        <td>CREATININE</td>
        <td>  <input id="creatinine" type="text" placeholder="put a number"  name="creatinine"  class="form-control required"   /></td>
        <td>0.6-1.1</td>
      </tr>
      <tr >
        <td>UREA </td>
        <td>  <input id="urea" type="text"  name="urea"  placeholder="put a number"  class="form-control required"   /></td>
        <td>10-40</td>
      </tr>
    
    </tbody>
  </table>
  <a target="_blank" style="display:none" id="print_renal"  href="" type="button" class="btn btn-primary btn-md float-right" > <i class="glyphicon glyphicon-download"></i> Download </a>


  <button type="button" data-dismiss="modal" class="btn btn-success" id="submit_lab_requeste_to_test_renal"><span class="glyphicon-fa-save"> </span>Save</button>
  <br><br>

  <div id="response_renal" class="alert alert-success" style="display:none;">
<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>
</form>
</div>
	  </div>
	  </div>
	  
	  </div>




                              





      </div>
      <div class="modal-footer">

     

      <button type="button"  class="btn btn-success" id="submit_lab_requeste_to_dr"><span class="glyphicon-fa-save"> </span>Submit To DR</button>

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