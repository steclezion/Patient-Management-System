<?php
	//check login
	include("session.php");
?>


<!DOCTYPE html>


<html>
<head>

     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>Patient Management System</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  
  <!-- Font Awesome -->
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link rel="stylesheet" href="css/ionicons-2.0.1/css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="css/ionicons.min.css">
  <link rel="stylesheet" href="css/ionicons.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="css/AdminLTE.css">
 
  <link rel="stylesheet" href="css/skin-green.css">
  
  	<!-- JS -->
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/moment.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/jquery.dataTables.js"></script>
	<script src="js/dataTables.bootstrap.js"></script>
	<script src="js/bootstrap.datetime.js"></script>
	<script src="js/bootstrap.password.js"></script>
	<script src="js/scripts.js"></script>
  
  <!-- Select2 -->
<script src="js/select2.full.min.js"></script>
	
	<!-- AdminLTE App -->
	<script src="js/app.min.js"></script>

	<!-- CSS -->
	<link rel="stylesheet" href="css/bootstrap.min.css">
	<link rel="stylesheet" href="css/bootstrap.datetimepicker.css">
	<link rel="stylesheet" href="css/jquery.dataTables.css">
	<link rel="stylesheet" href="css/dataTables.bootstrap.css">
	<link rel="stylesheet" href="css/styles.css">

    <!-- Select2 -->
  
  <link rel="stylesheet" href="css/select2.min.css">
  <link rel="stylesheet" href="css/select2-bootstrap4.min.css">

    <!-- Toaster  --> 

    <!-- <script src="Toaster/2.1.1_jquery.min.js"></script> -->
  <!-- <script src="Toaster/3.2.0_css_bootstrap.min.css"></script>
  <script src="Toaster/3.2.0_css_bootstrap-theme.min.css"></script>
  <script src="Toaster/3.2.0_js_bootstrap.min.js"></script> -->
  <script src="Toaster/jquery.toaster.js"></script>

  <script>
$(document).ready(function(){
// updating the view with notifications using ajax
function load_unseen_notification(view = '')
{
 $.ajax({
  url:"fetch.php",
  method:"POST",
  data:{view:view},
  dataType:"json",
  success:function(data)
  {
   $('.notifyme').html(data.notification);
   if(data.unseen_notification > 0)
   {
    $('.count').html(data.unseen_notification);
   }
  }
 });
}
load_unseen_notification();
// submit form and get new records
$('#comment_form').on('submit', function(event){
 event.preventDefault();
 if($('#subject').val() != '' && $('#comment').val() != '')
 {
  var form_data = $(this).serialize();
  $.ajax({
   url:"insert.php",
   method:"POST",
   data:form_data,
   success:function(data)
   {
    $('#comment_form')[0].reset();
    load_unseen_notification();
   }
  });
 }
 else
 {
  alert("Both Fields are Required");
 }
});
// load new notifications
$(document).on('click', '.notifications-menu', function(){
 $('.count').html('');
 load_unseen_notification('yes');
});
setInterval(function(){
 load_unseen_notification();;
}, 5000);
});
</script>

</head>



<body class="hold-transition skin-green sidebar-mini">
<div class="wrapper">

  <!-- Main Header -->
  <header class="main-header">

     <!--Logo -->
    <a href="" class="logo">
       <!--mini logo for sidebar mini 50x50 pixels -->
      <span class="logo-mini"><b>IN</b>MS</span>
       <!--logo for regular state and mobile devices -->
      <span style="text-decoration:none;" class="logo-lg"><b>Patient Management </b> System</span>
    </a>

    <!-- Header Navbar -->
    <nav class="navbar navbar-static-top" role="navigation">
      <!-- Sidebar toggle button-->
      <a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">
        <span class="sr-only">Toggle navigation</span>
      </a>
      <!-- Navbar Right Menu -->
  


           <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
         
        <li class="dropdown user user-header">
        <a href="#" class="dropdown-toggle notifications-menu" data-toggle="dropdown">
	      <span class="label label-pill label-danger count" style="border-radius:10px;"></span>
	      <span class="glyphicon glyphicon-bell" style="font-size:18px;"></span></a>
      <ul class="dropdown-menu notifyme"></ul>
     </li>

          <!-- User Account Menu -->
          <li class="dropdown user user-menu">
            <!-- Menu Toggle Button -->
            <a href="#" class="dropdown-toggle logout" data-toggle="dropdown">
              <!-- The user image in the navbar-->
              <img src="default-user.png" class="user-image" alt="User Image">
              <!-- hidden-xs hides the username on small devices so only the image appears. -->
              <span class="hidden-xs"><?php echo $_SESSION['login_username'];?></span>
            </a>
            <ul class="dropdown-menu">
             <!-- Drop down list-->
              <li><a href="logout.php" class="btn btn-default btn-flat">Log out</a></li>
            </ul>
          </li>
        </ul>
      </div>

    </nav>
  </header>
  
  
  <!-- Left side column. contains the logo and sidebar -->
  <aside class="main-sidebar">

    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">


      <!-- Sidebar Menu -->
      <ul class="sidebar-menu">
        <li class="header">MENU</li>
        <!-- Menu 0.1 -->
        <li class="treeview">
        <?php 
        
        $user_permission = array(); 
        $explode_comma_separated = explode(",", $_SESSION['User_Permission']);
       for($i =0; $i <= count($explode_comma_separated); $i++)
       {
       @array_push($user_permission,$explode_comma_separated[$i]);
       }

            if (in_array('1', $user_permission)) {?>
          <a href="dashboard.php"><i class="fa fa-tachometer"></i> <span>Dashboard</span>
          <?php } ?>

         </a>
          
            
        </li>
        <!-- Menu 1 -->
         <li class="treeview">
        <?php  if (in_array('2', $user_permission)) {?>
          <a href="#"><i class="fa fa-file-text"></i> <span>Invoices</span>
        <?php } ?>

            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php  if (in_array('2', $user_permission)) {?>
            <li><a href="invoice-create.php"><i class="fa fa-plus"></i>Create Invoice</a></li>
          <?php } ?>
          <?php  if (in_array('3', $user_permission)) {?> 
            <li><a href="invoice-list.php"><i class="fa fa-money"></i>Manage Invoices</a></li>
            <?php } ?>

            <?php  if (in_array('3', $user_permission)) {?> 
            <li><a href="receipts-list-today.php"><i class="fa fa-cab"></i>Today's Receipts</a></li>
            <?php } ?>

            <?php  if (in_array('3', $user_permission)) {?> 
            <li><a href="receipts-list.php"><i class="fa fa-cab"></i>Manage Receipts</a></li>
            <?php } ?>

            <?php  if (in_array('3', $user_permission)) {?> 
            <li><a href="request_from_dr.php"><i class="fa fa-cog"></i>Request From Dr</a></li>
            <?php } ?>


            <?php  if (in_array('4', $user_permission)) {?>
            <li><a href="#" class="download-csv"><i class="fa fa-download"></i>Download CSV</a></li>
            <?php } ?>
          </ul>
        </li>



        <?php  if (in_array('11', $user_permission)) {?>

        <li class="treeview">
       
         <a href="#"><i class="fa fa-file-text"></i> <span>Physician</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>

          <ul class="treeview-menu">
           <li><a href="send_inquiries.php"><i class="fa fa-plus"></i>Send Inquiries</a></li>
            <li><a href="posted-list.php"><i class="fa fa-cog"></i>Posted List</a></li>
           </ul>

        </li>
<?php  }  ?> 

<?php  if( $_SESSION['user_type'] == 'Labaratory' || $_SESSION['user_type'] == 'Admin' ) {?>
        <li class="treeview">
         <a href="#"><i class="fa fa-file-text"></i> <span>Labaratory</span>
        <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">


          <?php  if( $_SESSION['user_type'] == 'Labaratory' || $_SESSION['user_type'] == 'Admin' ) {?>
            <li><a href="request_from_dr_for_labt_today.php"><i class="fa fa-cog"></i>Today's Request From Dr</a></li>
            <?php } ?>


            
          <?php  if( $_SESSION['user_type'] == 'Labaratory' || $_SESSION['user_type'] == 'Admin' ) {?>
            <li><a href="request_from_dr_for_lab.php"><i class="fa fa-cog"></i>Request From Dr</a></li>
            <?php } ?>


           


            <!-- <li><a href="posted-list.php"><i class="fa fa-cog"></i>Completed List</a></li> -->
           </ul>
        </li>
        <?php } ?>


        <!-- Menu 2 -->
         <li class="treeview">
         <?php  if (in_array('5', $user_permission)) {?>
          <a href="#"><i class="fa fa-archive"></i><span> Procedures </span>
          <?php }?> 
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php  if (in_array('5', $user_permission)) {?>
            <li><a href="procedure-add.php"><i class="fa fa-plus"></i>Add Procedures</a></li>
            <?php } ?>
            <?php  if (in_array('6', $user_permission)) {?>
            <li><a href="procedure-list.php"><i class="fa fa-cog"></i>Manage Procedures</a></li>
            <?php } ?>
          </ul>
        </li>
        <!-- Menu 3 -->
        <li class="treeview">

        <?php  if (in_array('8', $user_permission)) {?>
          <a href="#"><i class="fa fa-users"></i><span>Patients</span>
        <?php } ?>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php  if (in_array('8', $user_permission)) {?>
            <li><a href="patient-add.php"><i class="fa fa-user-plus"></i>Add Patient</a></li>
            <?php } ?>
            <?php  if (in_array('9', $user_permission)) {?>
            <li><a href="patient-list.php"><i class="fa fa-cog"></i>Manage Patient</a></li>
            <?php } ?>
          </ul>
        </li>

        <li class="treeview">
        <?php  if (in_array('11', $user_permission)) {?>
          <a href="#"><i class="fa fa-users"></i><span>Doctor/Physician</span>
          <?php } ?>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php  if (in_array('11', $user_permission)) {?>
            <li><a href="doctor_add.php"><i class="fa fa-user-plus"></i>Add Doctor</a></li>
            <?php } ?>
            <?php  if (in_array('12', $user_permission)) {?>
            <li><a href="doctor_list.php"><i class="fa fa-cog"></i>Manage Doctor</a></li>
            <?php } ?>
          </ul>
        </li>


        <li class="treeview">
        <?php  if (in_array('11', $user_permission)) {?>
          <a href="#"><i class="fa fa-users"></i><span>Company Infos</span>
          <?php } ?>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">
          <?php  if (in_array('11', $user_permission)) {?>
            <li><a href="company_add.php"><i class="fa fa-user-plus"></i>Add Company</a></li>
            <?php } ?>
            <?php  if (in_array('12', $user_permission)) {?>
            <li><a href="company_list.php"><i class="fa fa-cog"></i>Manage Company</a></li>
            <?php } ?>
          </ul>
        </li>



        
        <!-- Menu 4 -->
        <li class="treeview">
        <?php  if (in_array('14', $user_permission)) {?>
          <a href="#"><i class="fa fa-cog"></i><span>System Settings</span>
          <?php } ?>
            <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
          </a>
          <ul class="treeview-menu">

           <?php  if (in_array('14', $user_permission)) {?>
            <li><a href="user-add.php"><i class="fa fa-plus"></i>Add User</a></li>
            <?php } ?>

            <?php  if (in_array('15', $user_permission)) {?>
            <li><a href="user-list.php"><i class="fa fa-cog"></i>Manage Users</a></li>
            <?php } ?>

            

          </ul>
        </li>
        
      </ul>
      <!-- /.sidebar-menu -->
    </section>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
   

    <!-- Main content -->
    <section class="content">

      <!-- Your Page Content Here -->
