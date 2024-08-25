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

<h1>Medicine List</h1>
<hr>

<div class="row">
	
	<div class="col-xs-12">
<?php if($Get_id_exploded == 'success') {?>
		<div id="response" class="alert alert-success" style="display:block;">

			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="message"><?php echo $Get_id_exploded_Message;?></div>
		</div>
	<?php } elseif($Get_id_exploded == 'error') {?>
    <div id="response" class="alert alert-success" style="display:none;">

<a href="#" class="close" data-dismiss="alert">&times;</a>
<div class="message"><?php echo $Get_id_exploded_Message;?></div>
</div>
<?php } ?>
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Medicine List</h4>
			</div>
			<div class="panel-body form-group form-group-sm">
				<?php getMedicine(); ?>
			</div>
		</div>
	</div>
<div>

<div id="delete_medicine" class="modal fade">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">Delete Medicine</h4>
      </div>
      <div class="modal-body">
        <p>Are you sure you want to delete this Medicine?</p>
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