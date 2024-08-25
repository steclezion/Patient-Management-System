<?php

include('header.php');

$user_permission = array(); 
$explode_comma_separated = explode(",", $_SESSION['User_Permission']);

for($i =0; $i <= count($explode_comma_separated); $i++)
{
@array_push($user_permission,$explode_comma_separated[$i]);
}

if ((in_array('8', $user_permission))) {

?>

<script>


function filechangevalidation_pic(val,file_id,response_id)
{
if ($('input:submit').attr('disabled',false)){
	$('input:submit').attr('disabled',true);
    }
    
var ext = $('#'+file_id).val().split('.').pop().toLowerCase();
if ($.inArray(ext, ['jpeg','jpg','JPG','gif','ico','png','psd']) == -1){
	$('#error1').slideDown("slow");
    $('#error2').slideUp("slow");
    $('#error3').slideUp("slow");
    $('#'+response_id).hide('10');
	a=0;
	}else{
        $('#'+response_id).show('10');
    //var picsize = ($('#'+file_id).files[0].size);
    var picsize = ($('#'+file_id).get(0).files[0].size);
    console.log(picsize);
    var mb = picsize/1000000;

	if (picsize > 10000000){
    $('#error2').slideDown("slow");
    $('#'+response_id).hide('10');
    $('#error3').slideDown("slow");
    $('#file_size').html(Math.round(mb));


	a=0;
	}else{
	a=1;
    $('#error2').slideUp("slow");
    $('#'+response_id).show('10');
    $('#error3').slideUp("slow");
	}
	$('#error1').slideUp("slow");
	if (a==1){
        $('input:submit').attr('disabled',false);
        $('#'+response_id).show('10');
		}
}
}


</script>

<h1>Add Medicine</h1>
<hr>

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form  method="POST"  id="MedicineForm" name="MedicineForm" action="response.php" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="action" value="add_medicine">
	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Medicine Information</h4>
					<div class="clear"></div>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="col-xs-6">
              <label class="control-label">Medicine Image:</label><div class="col-sm-6">
                          <img title="profile picture" width="50" height="50" id="preview-image" src="{{ $users->avatar_path }} " alt="preview image" style="max-height: 250px;">
                         </div>
							<div class="form-group">
							<div id="kv-avatar-errors-1" class="center-block" style="display:none;"></div> 
		<input type="file" onchange="filechangevalidation_pic(this.value,'MedicineImage','action_create_medicin')"  class="form-control margin-bottom copy-input required"  id="MedicineImage" name="MedicineImage"  >
							


							<p id="error1" style="display:none; color:#FF0000;">
Invalid File Format! File format  Must Be pdf.
</p>
<p id="error2" style="display:none; color:#FF0000;">
Maximum File Size Limit is 10MB.
</p>

<p id="error3" style="display:none; color:#FF0000;">
Current selected file size is <span id="file_size"></span>MB
</p>
<p>
					
						</div>

						<label> Medicine Name  </label>
						<div class="form-group">
	                        <input type="text" class="form-control required" name="medicine_name" id="medicine_name" placeholder="Enter Name of the Medicine...." required="">
                            
                        </div>
       <!-- <div class="input-group float-right margin-bottom" style='display:none'>
		<span class="input-group-addon"><i class="fa fa-envelope"></i></span>
		<input type="hidden" class="form-control copy-input required" name="customer_email" id="customer_email" placeholder="Email" aria-describedby="sizing-addon1" tabindex="2">
		</div> -->


	
							<label> MRP(Maximum Retail Price) </label>
							<div class="form-group">
<input type="text" class="form-control margin-bottom required"  name="MaximumRetailPrice" id="Maximum Retail Price" placeholder="Enter MRP">
</div>

<label> Expiry Date </label>
<div class="form-group">
<input type="date"  class="form-control margin-bottom copy-input required" name="expdate"   id="expdate" placeholder=" " tabindex="1">
</div>

<label> Category </label>
<div class="form-group">
<select class="form-control required" name="Category" id="Category" placeholder="Category" required="">

<option value="" selected> </option>
                <?php
                    $sqldcategory = "SELECT * FROM categories  order by categories_id  ";
					$results = $mysqli->query($sqldcategory);
                    
                    while($sqlrow =$results->fetch_assoc())
                    {
                       
                       
						
			echo "<option value='$sqlrow[categories_id]' >$sqlrow[categories_name]</option>";
                        
                     

                    }
                ?>
            </select>
				</div>
                        </div>

						<div class="col-xs-6" >
			
						<label> Quantity  </label>
							<div class="form-group">
		<input type="text" class="form-control required" name="medicine_quantity" id="medicine_quantity" placeholder="Quantity" required="">
        </div>
		
		<label> Rate   </label>
		<div class="form-group">
		<div class="input-group">
		<span class="input-group-addon"><?php echo CURRENCY ?></span>
		<input class="form-control required" placeholder="0.00" aria-describedby="sizing-addon1"  name="medicine_rate" id="medicine_rate" placeholder="Rate" required="">
		</div>
	

	
	</div>

		<label> Batch No  </label>
		<div class="form-group">
		<input  type="text" class="form-control margin-bottom copy-input required" name="medicine_batch_no" id="medicine_batch_no" placeholder="Batch No" tabindex="4">
		</div>

		<label> Manufacturer Name  </label>
		<div class="form-group">
		<select class="form-control required" name="manufacturer_name" id="manufacturer_name" placeholder="Manufacture Name" required="">
				<option value="" selected> </option>
                <?php
                    $sql= "SELECT * FROM brands ";
					$results = $mysqli->query($sql);
                    
                    while($rsdepartment=$results->fetch_assoc())
                    {
                       
                       
						
			echo "<option value='$rsdepartment[brand_id]' >$rsdepartment[brand_name]</option>";
                        
                     

                    }
                ?>
            </select>
				</div>

		<label> Status  </label>
		<div class="form-group">
					    <select name="medicine_status" id="medicine_status" class="form-control required ">
						<option value="1" selected>Active</option>
						<option value="0">Inactive</option>
                       </select>
				</div>

          </div>
					</div>
				</div>
			</div>
		</div>
		</div>


	<div class="row">
		<div class="col-xs-12 margin-top btn-group">
			<input type="submit" id="action_create_medicin" class="btn btn-success float-right" value="Add Medicine" data-loading-text="Creating...">
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