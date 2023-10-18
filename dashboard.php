<?php
/*******************************************************************************
*  Invoice Management System                                                *
*                                                                              *
* Version: 1.0	                                                               *
* Developer:  Abhishek Raj                                   				           *
*******************************************************************************/

include('header.php');
include('functions.php');
include_once("includes/config.php");

$user_permission = array(); 

$explode_comma_separated = explode(",", $_SESSION['User_Permission']);

$_SESSION['login_username'];
$id = $_SESSION['login_user_id'];


for($i =0; $i <= count($explode_comma_separated); $i++)
{
@array_push($user_permission,$explode_comma_separated[$i]);
}

if ((in_array('1', $user_permission))) {

    ?>


  <link href="css/ionicons.css" rel="stylesheet" type="text/css" />
  <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />

<section class="content">
  
      <?php 

      if($_SESSION['user_type']  == 'Admin') {include('dashboard_main.php'); }
 
      if($_SESSION['user_type']  == 'Cashier') {include('dashboard_Cahier.php'); }


      if($_SESSION['user_type']  == 'Labaratory') {include('dashboard_Labaratory.php'); }
      
      
      
      
      
      
      
      ?> 

    </section>
    <!-- /.content -->



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