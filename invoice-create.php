<?php

include('header.php');
include('functions.php');

?>

<h2>Create New <span class="invoice_type">Invoice</span> </h2>
<!-- <hr> -->

<div id="response" class="alert alert-success" style="display:none;">
	<a href="#" class="close" data-dismiss="alert">&times;</a>
	<div class="message"></div>
</div>

<form method="post" id="create_invoice">
	<input type="hidden" name="action" value="create_invoice">

	<div class="row">
		<div class="col-xs-4">

		</div>
		<div class="col-xs-8 text-right">
			<div class="row">
				<div class="col-xs-6">
					<h2 class="">Select Type:</h2>
				</div>
				<div class="col-xs-3">
					<select name="invoice_type" id="invoice_type" class="form-control">
						<option value="invoice" selected>Invoice</option>
						<option value="quote">Quote</option>
						<option value="receipt">Receipt</option>
					</select>
				</div>
				<div class="col-xs-3">
					<select name="invoice_status" id="invoice_status" class="form-control">
						<option value="open">Open</option>
						<option value="paid" selected>Paid</option>
					</select>
				</div>
			</div>
			<div class="col-xs-4 no-padding-right">
				<div class="form-group">
					<?PHP $dt = new DateTime(); 
						  $dt->format('d-m-y') ;
							   ?>
					<div class="input-group date" id="invoice_date">
						<label class="input-group-addon"> Invoice Date </label>
						<input width="100" value="<?php echo $dt->format('d-m-Y');  ?>" readonly type="text"
							class="form-control required" name="invoice_date"
							placeholder="<?php //echo $dt->format('Y-m-d');  ?>"
							data-date-format="<?php echo DATE_FORMAT ?>" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="col-xs-4">
				<div class="form-group">
					<div class="input-group date" id="invoice_due_date">
						<label class="input-group-addon"> Due Date </label>
						<input width="50"  value="<?php echo $dt->format('d-m-Y');  ?>" readonly type="text"
							class="form-control required" name="invoice_due_date"
							placeholder="<?php //echo $dt->format('Y-m-d');  ?>"
							data-date-format="<?php echo DATE_FORMAT ?>" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="input-group col-xs-4 float-right">
				<span class="input-group-addon">#
					<?php echo INVOICE_PREFIX ?>
				</span>
				<input type="text" name="invoice_id" id="invoice_id" class="form-control required"
					placeholder="Invoice Number" readonly aria-describedby="sizing-addon1" value="<?php getInvoiceId(); ?>">
			</div>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-6">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4 class="float-left">Patient Information</h4>
					<a href="#" class="float-right select-customer"><b>OR</b> Select Existing Patient</a>
					<div class="clear"></div>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required"
									name="customer_name" id="customer_name" readonly placeholder="Full Name"
									tabindex="1">
							</div>
							<div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required"
									name="customer_town" id="customer_town" readonly placeholder="Town" tabindex="3">
							</div>
							<div class="form-group">
								<input type="text" class="form-control margin-bottom copy-input required"
									name="customer_age" id="customer_age" readonly placeholder="Age" tabindex="5">
							</div>

							
							<div class="form-group">

								<input type="text" readonly class="form-control margin-bottom copy-input required"
									name="customer_date_of_reg" id="customer_date_of_reg"
									placeholder="Date of Registration" aria-describedby="sizing-addon1" tabindex="2">
							</div>

							<div class="form-group no-margin-bottom">
								<input type="text" class="form-control copy-input required" name="customer_sex"
									id="customer_sex" placeholder="Gender" readonly tabindex="7">
							</div>

						</div>

					</div>
				</div>
			</div>
		</div>
		<div class="col-xs-6 text-right">
			<div class="panel panel-default">
				<div class="panel-heading">
					<h4>Prescribing Physicians's Information</h4>
				</div>
				<div class="panel-body form-group form-group-sm">
					<div class="row">
						<div class="col-xs-12">
							<div class="form-group">
								<input readonly type="text" class="form-control margin-bottom required"
									name="doctor_name" id="doctor_name" placeholder="Physician Name" tabindex="9">
							</div>
							<div class="form-group">
								<input readonly type="email" class="form-control margin-bottom" name="doctor_email"
									id="doctor_email" placeholder="Email" tabindex="11">
							</div>
							<div class="form-group no-margin-bottom">
								<input readonly type="text" class="form-control required" name="doctor_title"
									id="doctor_title" placeholder="Title" tabindex="13">
							</div>

							

						</div>

					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- / end client details section -->
	<table class="table table-bordered table-hover table-striped" id="invoice_table">
		<thead>
			<tr>
				<th width="500">
					<h4><a href="#" class="btn btn-success btn-xs add-row"><span class="glyphicon glyphicon-plus"
								aria-hidden="true"></span></a> Product</h4>
				</th>
				<th>
					<h4>Qty</h4>
				</th>
				<th width="200">
					<h4>Price</h4>
				</th>
				<th width="30">
					<h4><span title="Enter % OR value (ex: 10% or 10.50)"> Discount <span></h4>
				</th>
				<th>
					<h4>Sub Total</h4>
				</th>
			</tr>
		</thead>
		<tbody>
			<tr  id="calculate">
				<td>
					<div class="form-group form-group-sm  no-margin-bottom">
						<a href="#" class="btn btn-danger btn-xs delete-row"><span class="glyphicon glyphicon-remove"
								aria-hidden="true"></span></a>
						<input type="text" class="form-control form-group-sm item-input invoice_product"
							name="invoice_product[]" placeholder="Enter Name of Procedure" readonly>
						<p  id="select-item" style="display:block" class="item-select">or <a href="#">Select Procedure</a></p>
					</div>
				</td>
				<td class="text-right">
					<div class="form-group form-group-sm no-margin-bottom">
						<input type="number" class="form-control invoice_product_qty calculate"
							name="invoice_product_qty[]" value="1"/>
					</div>
				</td>
				<td class="text-right">
					<div class="input-group input-group-md no-margin-bottom">
						<span class="input-group-addon">
							<?php echo CURRENCY ?> &nbsp;
						</span>
						<input readonly type="number" class="form-control calculate invoice_product_price required"
							name="invoice_product_price[]" aria-describedby="sizing-addon1" placeholder="0.00"/>
					</div>
				</td>
				<td class="text-right">
					<div  class="form-group form-group-sm  no-margin-bottom" title="Enter % OR value (ex: 10% or 10.50)">
						<input value="0" <?php echo DISCOUNT;?> type="text" title="Enter % OR value (ex: 10% or 10.50)" class="form-control calculate invoice_product_discount" 
							name="invoice_product_discount[]" placeholder="Enter % OR value (ex: 10% or 10.50)"/>
					</div>
				</td>
				<td class="text-right">
					<div class="input-group input-group-md">
						<span class="input-group-addon">
							<?php echo CURRENCY ?> &nbsp;
						</span>
						<input type="text" class="form-control calculate-sub calculate invoice_product_sub" name="invoice_product_sub[]"
							 value="0.00" aria-describedby="sizing-addon1" disabled>
					</div>
				</td>
			</tr>


		</tbody>
	</table>
	<div id="invoice_totals" class="padding-right row text-right">
		<div class="col-xs-6">
			<div class="input-group form-group-sm textarea no-margin-bottom">
				<textarea class="form-control" name="invoice_notes" placeholder="Additional Notes..."></textarea>
			</div>


		</div>


		<div class="col-xs-6 no-padding-right">
			<div class="row">
				<div class="col-xs-4 col-xs-offset-5">
					<strong>Sub Total:</strong>
				</div>
				<div class="col-xs-3">
					<?php echo CURRENCY ?> &nbsp;<span class="invoice-sub-total">0.00</span>
					<input type="hidden" name="invoice_subtotal" id="invoice_subtotal">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4 col-xs-offset-5">
					<strong>Discount:</strong>
				</div>
				<div class="col-xs-3">
					<?php echo CURRENCY ?> &nbsp;<span class="invoice-discount">0.00</span>
					<input type="hidden" name="invoice_discount" id="invoice_discount">
				</div>
			</div>
			<div class="row">
				<div class="col-xs-4 col-xs-offset-5">
					<strong class="shipping">Service Charge:</strong>
				</div>
				<div class="col-xs-3">
					<div class="input-group input-group-sm">
						<span class="input-group-addon">
							<?php echo CURRENCY ?> &nbsp;
						</span>
						<input type="text" class="form-control calculate servicecharge" name="servicecharge"
							aria-describedby="sizing-addon1" placeholder="0.01" value="0.01">
					</div>
				</div>
			</div>
			<?php if (ENABLE_VAT == True) { ?>
			<div class="row">
				<div class="col-xs-4 col-xs-offset-5">
					<strong>TAX/VAT:</strong><br>Remove TAX/VAT <input type="checkbox" disabled class="remove_vat">
				</div>
				<div class="col-xs-3">
					<?php echo CURRENCY ?> &nbsp;<span class="invoice-vat" data-enable-vat="<?php echo ENABLE_VAT ?>"
						data-vat-rate="<?php echo VAT_RATE ?>" data-vat-method="<?php echo VAT_INCLUDED ?>">0.00</span>
					<input type="hidden" name="invoice_vat" id="invoice_vat">
				</div>
			</div>
			<?php } ?>
			<div class="row">
				<div class="col-xs-4 col-xs-offset-5">
					<strong>Total:</strong>
				</div>
				<div class="col-xs-3">
					<?php echo CURRENCY ?> &nbsp;<span class="invoice-total">0.00</span>
					<input type="hidden" name="invoice_total" id="invoice_total">
				</div>
			</div>
		</div>


		<div class="col-xs-6">
			<input type="email" name="custom_email" id="custom_email" class="custom_email_textarea"
				placeholder="Enter custom email if you wish to override the default invoice type email msg!"></input>
		</div>

		<div class="col-xs-6 margin-top btn-group">
			<input type="submit" id="action_create_invoice" class="btn btn-success float-right" value="Create Invoice"
				data-loading-text="Creating...">
		</div>


	</div>
	<div class="row">

	</div>
</form>

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

<div id="insert_customer" class="modal fade">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
						aria-hidden="true">&times;</span></button>
				<h4 class="modal-title">Select An Existing Patient</h4>
			</div>
			<div class="modal-body">
				<?php popCustomersList(); ?>
			</div>
			<div class="modal-footer">
				<button type="button" data-dismiss="modal" class="btn">Cancel</button>
			</div>
		</div><!-- /.modal-content -->
	</div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<?php
	include('footer.php');
?>