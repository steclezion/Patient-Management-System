<?php


include('header.php');
include('functions.php');

$user_permission = array(); 
$explode_comma_separated = explode(",", $_SESSION['User_Permission']);
@$get_id = $_GET['id'];
$explode_id = explode('|',$get_id,2);
$Get_id_exploded = $explode_id[0];
@$Get_id_exploded_Message = $explode_id[1];

for($i =0; $i <= count($explode_comma_separated); $i++)
{
@array_push($user_permission,$explode_comma_separated[$i]);
}

if ((in_array('9', $user_permission))) {

?>

<script>
  function medicine_affect_changes(medicine_id, medicine_name, action)
{
	// alert(medicine_id);

var   reference_no   = document.getElementById('reference_no').value;
var   adju_type      = document.getElementById('adju_type').value;
var   quantity_hand  = document.getElementById('quantity_hand').value;
var   quantity_counted   = document.getElementById('quantity_counted').value;
var   reason_stock       = document.getElementById('reason_stock').value;

var action = 'stock';
$.ajax({

	url: 'response.php',
	type: 'POST',
	data: {
    action : action,
    medicine_id  : medicine_id,

	},
	dataType: 'json',
	success: function (data) {
		document.getElementById('quantity_hand').value = data.quantity;
    document.getElementById('reference_no').value = data.reference_number;
		// document.getElementById('quantity_hand').disabled = true;
    // document.getElementById('reference_no').disabled = true;
	},
	error: function (data) {
		document.getElementById('quantity_hand').value = data.quantity;
    document.getElementById('reference_no').value = data.reference_number;
		// document.getElementById('quantity_hand').disabled = true;
    // document.getElementById('reference_no').disabled = false;
	}

});


}
</script>

<h1>Medicine  Stock Adjustment</h1>

<hr>

<div class="row">
	
	<div class="col-xs-12">
  <div id="response" class="alert alert-success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<div  id="custom_message" class="message"></div>
		</div>
		<div class="panel panel-default">


			<div class="panel-heading">
				<h4> 
        <button   id="add_stock_adjust"  class="btn btn-primary float-center add_stock_adjust"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span> Adjust Stock </button>
  
      
      </h4>
			</div>
			<div class="panel-body form-group form-group-sm">
				<?php getStockAdjust(); ?>
			</div>
		</div>
	</div>


<div id="delete_stock" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Medicine</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this Adjusted Stock?</p>
      </div>
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
		<button type="button" data-dismiss="modal" class="btn">Cancel</button>
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->



<div id="add_stock_adjustment" class="modal fade">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Stock Adjustment </h4>
        &naturals;

        <div class="form-group">
					<?PHP $dt = new DateTime(); 
						 $dt->format('d-m-y') ;
							   ?>
					<div class="input-group date" id="invoice_date">
						<label class="input-group-addon"> Date </label>
	<input width="100" value="<?php echo $dt->format('d-m-Y');  ?>" readonly type="text"  class="form-control required" name="date_stock_added" id="date_stock_added"	placeholder="<?php echo $dt->format('Y-m-d');  ?>" data-date-format="<?php echo DATE_FORMAT ?>" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				
			</div>
      </div>


      <div class="modal-body">
      <div class="col-xs-12">
			<div class="panel panel-default">
	
				<div class="panel-body form-group form-group-sm">
					<div class="row">
          <form class="row" method="POST"  id="submitStockForm" action="response" method="POST" enctype="multipart/form-data">
          <input type="hidden" width="100" value="<?php echo $dt->format('d-m-Y');  ?>" readonly type="text"  class="form-control required" name="date_stock_added" id="date_stock_added"	placeholder="<?php echo $dt->format('Y-m-d');  ?>" data-date-format="<?php echo DATE_FORMAT ?>" />

						<div class="col-xs-6">
            <label> Medicine Name  </label>
            <input type="hidden" name="action" value="add_stock_adjustment">
            <input type="hidden" name="uname" value="<?php echo $_SESSION['login_user_id']; ?>">

						<div class="form-group">
            <select class="form-control required" name="medicine_name" onchange="medicine_affect_changes(this.value,'medicine_name','submit_changes')" id="medicine_name" placeholder="Medicine Name" required="">
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

            <label> Refrence No  </label>
						<div class="form-group">
		        <input type="text" readonly  class="form-control required" name="reference_no" id="reference_no" placeholder="Reference No" required="">
            </div>


							<label> Location </label>
							<div class="form-group">
              <input type="text" class="form-control margin-bottom required"  value="Mekane Hiwot" name="Location" id="Location"  placeholder="Mekane Hiwot">
              </div> 

             <label> Adjustment Type </label>
             <div class="form-group">
             <select class="form-control required" name="adju_type" id="adju_type" placeholder="adju_type" required="">
             <option value="Normal" selected> Normal</option>
             <option value="Abnormal" > Abnormal</option>
             </select>
             </div>
            

                  </div>

						<div class="col-xs-6" >
            <label> Quantity onHand </label>
<div class="form-group">
<input  type="text" readonly  class="form-control margin-bottom copy-input required" name="quantity_hand" id="quantity_hand" placeholder="Quantity OnHand" tabindex="4">
</div>
      

            <label> Quantity Counted </label>
<div class="form-group">
<input  type="text" class="form-control margin-bottom copy-input required" name="quantity_counted" id="quantity_counted" placeholder="Quantity Counted" tabindex="4">
</div>


		<label> Reason  </label>
		<div class="form-group">
    <textarea required  class="form-control" name="reason_stock" id="reason_stock" placeholder="Additional Notes..."></textarea>
  </div>

   </form>
          </div>
					</div>
				</div>
			</div>
		</div>
		</div>

 
      <div class="modal-footer">
        <button type="button"  class="btn btn-success" id="submit_changes_stock">Submit Changes</button>
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