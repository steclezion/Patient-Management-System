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


<script src="vendor/fastlaod/jquery/jquery-3.2.1.min.js"></script>

<link rel="stylesheet"  href="vendor/fastlaod/DataTables/jquery.datatables.min.css">	
<script src="vendor/fastlaod/DataTables/jquery.dataTables.min.js" type="text/javascript"></script> 

<link href="style.css" rel="stylesheet" type="text/css" />

<script>
        $(document).ready(function ()
        {
            $('#tbl-contact thead th').each(function () {
                var title = $(this).text();
                $(this).html(title+' <input type="text" class="col-search-input" placeholder="Search ' + title + '" />');
            });
            
            var table = $('#employee').DataTable({
                	"scrollX": true,
            		"pagingType": "numbers",
                "processing": true,
                "serverSide": true,
                "ajax": "vendor/server.php",
                order: [[2, 'asc']],
                columnDefs: [{
                    targets: "_all",
                    orderable: false
                 }]
            });

            table.columns().every(function () {
                var table = this;
                $('input', this.header()).on('keyup change', function () {
                    if (table.search() !== this.value) {
                    	   table.search(this.value).draw();
                    }
                });
            });
        });

    </script>

<h1>Receipts List</h1>
<hr>

<div class="row">

	<div class="col-xs-12">

		<div id="response" class="alert alert-success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="message"></div>
		</div>
	
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Manage Receipts</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
     
				<?php   getBalances(); ?>
        <?php  //getInvoicesPharmacy_from_DR(); ?>
        <?php //getReceipts(); ?>
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