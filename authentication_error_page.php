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

?>
  <link href="css/ionicons.css" rel="stylesheet" type="text/css" />
  <link href="css/ionicons.min.css" rel="stylesheet" type="text/css" />
  <style>
.right {
  border: 5px solid;
  position: relative
  top: 80%;
  transform : translate(0, 50%);
  padding : 10px;
  margin : 50px;
  color: red;
    
}
</style>

<section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
 
   
<p class="right"> Dear  <?php echo $_SESSION['login_username']  ;?> You have no Permission to access this page. Your Credential is blocked!! </p>
   
      </div>
      <!-- /.row -->


  
      
     

    </section>
    <!-- /.content -->



<?php
	include('footer.php');
?>