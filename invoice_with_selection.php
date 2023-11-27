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



if(isset($_POST['submit']))
 {
//Posted Attributes 
 $From = $_POST['invoice_date_from'];
 $To   = $_POST['invoice_date_to'];
 $Status = $_POST['invoice_status'];
 $Company = $_POST['customer_company_name'];

 
 
 $date=date_create_from_format("d/m/Y",$From);
 $From = date_format($date,"Y-m-d");
 $From_style = date_format($date,"d-m-Y"); 
 
 
 $date=date_create_from_format("d/m/Y",$To);
 $To = date_format($date,"Y-m-d");
 $To_style = date_format($date,"d-m-Y"); 



    ?>

<h1>Credit Invoice List</h1>
<hr>

<div class="row">

	<div class="col-xs-12">

		<div id="response" class="alert alert-success" style="display:none;">
			<a href="#" class="close" data-dismiss="alert">&times;</a>
			<div class="message"></div>
		</div>
	
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>Manage Invoices  From <?php echo $From_style;  ?>   To  <?php echo  $To_style;   ?></h4>
			</div>
			<div class="panel-body form-group form-group-sm">
      <div class="col-xs-8 text-right">
	
<form  id="invoice_with_report" method="POST"  action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>"  name="post_submission"  onSubmit="return validate();" enctype="multipart/form-data"  >

			<div class="col-xs-4 no-padding-right">
				<div class="form-group">
					<?PHP $dt = new DateTime(); 
						  $dt->format('d-m-y') ;
							   ?>
					<div class="input-group date" id="invoice_date">
						<label class="input-group-addon"> <b>  From  </b>  </label>
						<input width="100"  required  type="text" class="form-control required" name="invoice_date_from" placeholder="<?php echo $dt->format('Y-m-d');  ?>"  value="<?php echo $dt->format('Y-m-d');  ?>" data-date-format="<?php echo DATE_FORMAT ?>" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="col-xs-4">
				<div class="form-group">
					<div class="input-group date" id="invoice_due_date">
						<label class="input-group-addon"> <b>  To  </b>  </label>
						<input width="50"   required type="text" class="form-control required" name="invoice_date_to" placeholder="<?php echo $dt->format('Y-m-d');  ?>" value="<?php echo $dt->format('Y-m-d');  ?>" data-date-format="<?php echo DATE_FORMAT ?>" />
						<span class="input-group-addon">
							<span class="glyphicon glyphicon-calendar"></span>
						</span>
					</div>
				</div>
			</div>
			<div class="input-group col-xs-4 float-right">
      <label class="input-group-addon"> <b> Status </b> </label>
		 <select name="invoice_status" id="invoice_statuss" class="form-control"  required  aria-describedby="sizing-addon1" >
     <option value="All" selected >All</option>
						<option value="open" selected >Open</option>
						<option value="paid">Paid</option>
</select>


</div>
</div>

<div class="input-group col-xs-4 float-center">
      <label class="input-group-addon"> <b>Company </b>  </label>
		  <select class="form-control required" required name="customer_company_name" id="customer_company_name" placeholder="customer_company_name" required="">
      <option value="All" selected>All</option>
      <?php $sqldepartment= "SELECT * FROM companies ";  $results = $mysqli->query($sqldepartment);
                    while($rsdepartment=$results->fetch_assoc())
                    {
     echo "<option value='$rsdepartment[name]' >$rsdepartment[name]</option>";
                    }
                ?>
            </select>

            
        </div>
        <br>
		<div class="input-group col-xs-4 float-right">
        <button type="submit" name="submit"   class="btn btn-primary">Generate Invoices</button>
				</div>
			</div>
    


   

				</form>
		</div>

				<?php 
                

    // Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
		die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
	}

if($Status == 'All' && $Company == 'All')
{
$a=1;

$sqldepartment= "SELECT * FROM companies ";  $res  = $mysqli->query($sqldepartment);

                    while($rsdepartment=$res->fetch_assoc())
                    {
                        
                        $company_name = $rsdepartment['name'];
                        $data_table = 'data-table'.$a;
  

    	// the query
     $query = "SELECT  *  FROM invoices i  
         JOIN customers c  ON c.invoice = i.invoice
 
		WHERE  ( i.invoice = c.invoice and i.invoice_type = 'invoice' )  
        and   (c.company_name = '$company_name') 
        and    ( i.invoice_date between '$From' and '$To')
        ORDER BY i.invoice DESC ";

        $check_quantity = "select * from invoice_items";


	// mysqli select query
	$results = $mysqli->query($query);
  // mysqli select query
	if($results) {
        print '
        <h4><b>  <span style="color:orange;"> '.$From_style.'  -  '.$To_style.' </span> -  </b> <b style="color:red; font-size:25px;width:32px;padding: 5px;border: 2px solid gray;margin: 0;"> '.$company_name.' </b>  </h4>
        <table class="table table-striped table-hover table-bordered" id="'.$data_table.'" cellspacing="0"  class="display" cellspacing="0" width="100%"><thead><tr>
        
                        <th>Invoice</th>
                        <th>Patient</th>
                        <th>Issue Date</th>
                        <th>Due Date</th>
                        <th>Type</th>
                        <th>Status</th>
                        <th>Company Name</th>
                        
                    
        
                      </tr></thead><tbody>';
        
                while($row = $results->fetch_assoc()) {
        
                $search = '/';
                $replace = '_';
                $subject = $row["invoice"];
        
                $invoice_number = str_replace($search, $replace, $subject);
        
                $date=date_create($row["invoice_date"]);
                $date_invoice  = date_format($date,"d-m-Y");
        
                $date=date_create($row["invoice_date"]);
                $date_due  = date_format($date,"d-m-Y");
        
        
                    print '
                        <tr>
                            <td>'.$row["invoice"].'</td>
                            <td>'.$row["name"].'</td>
                            <td>'.$date_invoice .'</td>
                            <td>'.$date_due .'</td>
                            <td>'.$row["invoice_type"].'</td>
                            
                        ';
        
                        if($row['status'] == "open"){
                            print '<td><span class="label label-primary">'.$row['status'].'</span></td>';
                        } elseif ($row['status'] == "paid"){
                            print '<td><span class="label label-success">'.$row['status'].'</span></td>';
                        }
                        print '<td>'.$row["company_name"].'</td>';
                        $user_permission = array(); 
                        $explode_comma_separated = explode(",", $_SESSION['User_Permission']);
                        
                        for($i =0; $i <= count($explode_comma_separated); $i++)
                        {
                        @array_push($user_permission,$explode_comma_separated[$i]);
                        }
        
                    
                    
        
                
        
                }
     
                print '</tr></tbody></table><br><br>';
        
            } else {
        
                echo "<p>There are no invoices to display.</p>";
        
            }



            $a++;

                    }
 




        



}

if( ($Status == 'open' || $Status == 'paid' ) && $Company == 'All' )
{

  $a=1;

  $sqldepartment= "SELECT * FROM companies ";  $res  = $mysqli->query($sqldepartment);
  
                      while($rsdepartment=$res->fetch_assoc())
                      {
                        $General_Total=0;
                          
                          $company_name = $rsdepartment['name'];
                          $data_table = 'data-table'.$a;
    
  
        // the query
       $query = "SELECT  *  FROM invoices i  
           JOIN customers c  ON c.invoice = i.invoice
   
      WHERE  ( i.invoice = c.invoice and i.invoice_type = 'invoice' )  
          and   (c.company_name = '$company_name') 
          and    ( i.invoice_date between '$From' and '$To')
          and (i.status = '$Status')
          ORDER BY i.invoice DESC ";
          
        
          
  
    // mysqli select query
    $results = $mysqli->query($query);
    // mysqli select query
    if($results) {
          print '
          <h4><b>  <span style="color:orange;"> '.$From_style.'  -  '.$To_style.' </span> -  </b> <b style="color:red; font-size:25px;width:32px;padding: 5px;border: 2px solid gray;margin: 0;"> '.$company_name.' </b>  </h4>
          <table class="table table-striped table-hover table-bordered" id="'.$data_table.'" cellspacing="0"  class="display" cellspacing="0" width="100%"><thead>
          <tr>
          
                          <th>Invoice</th>
                          <th>Patient</th>
                          <th>Issue Date</th>
                          <th>Company Name</th>
                          <th>Type</th>
                          <th>Status</th>
                          <th>Total Sum</th>

                        
                          
                      
          
                        </tr></thead><tbody>';
                  $invoice_array = array();
                  $concatenated_array = $company_name."^".$From."^".$To."^".$Status;
                  while($row = $results->fetch_assoc()) {
                    $Total_sum = 0;
                    $inv = $row["invoice"];

                    $check_quantity = "select *,(qty * price) as p  from invoice_items where invoice = '$inv'  ";
                    $quantity_price = $mysqli->query( $check_quantity);

                    while($mow = $quantity_price->fetch_assoc()) {
                      $Total_sum += $mow['p'];
                    }
                    
                  $search = '/';
                  $replace = '_';
                  $subject = $row["invoice"];
          
                  $invoice_number = str_replace($search, $replace, $subject);
          
                  $date=date_create($row["invoice_date"]);
                  $date_invoice  = date_format($date,"d-m-Y");
          
                  $date=date_create($row["invoice_date"]);
                  $date_due  = date_format($date,"d-m-Y");
          
          
                      print '
                          <tr>
                              <td>'.$row["invoice"].'</td>
                              <td>'.$row["name"].'</td>
                              <td>'.$date_invoice .'</td>
                              <td>'.$row["company_name"].'</td>
                              <td>'.$row["invoice_type"].'</td>
                           ';
          
                          if($row['status'] == "open"){
                              print '<td><span class="label label-primary">'.$row['status'].'</span></td>';
                          } elseif ($row['status'] == "paid"){
                              print '<td><span class="label label-success">'.$row['status'].'</span></td>';
                          }

                          print '<td><b>'.number_format($Total_sum)."&nbsp;".'</b></td>';
                       
                          $user_permission = array(); 
                          $explode_comma_separated = explode(",", $_SESSION['User_Permission']);
                          
                          for($i =0; $i <= count($explode_comma_separated); $i++)
                          {
                          @array_push($user_permission,$explode_comma_separated[$i]);
                          }
          
                      
                      
          
                      
                          $General_Total += $Total_sum;
                  }
                  
                  print '</tr>
                  
                  
                  
                  
                  
                  <tr>
          
                  <th >Total Sum </th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th> '.number_format($General_Total)."&nbsp;".CURRENCY.' ';
                 
                 if($General_Total >0 && $Status == 'open'){ 
                    print '
                 
                    <div class="input-group col-xs-4 float-right"> 
                
                    <a href="invoice-proceed_payments.php?invoice_explode='.$concatenated_array.'" class="btn btn-primary btn-sm">
					<span class="glyphicon glyphicon-edit" aria-hidden="true">Proceed Payments</span></a>

                   </div> <br><br>';}
                   
                  
                print ' </th> </tr>  </tbody></table>';

                 
          
              } else {
          
                  echo "<p>There are no invoices to display.</p>";
          
              }
  
  
  
              $a++;
  
                      }
   
  


}


if( ($Status == 'open' || $Status == 'paid' ) && $Company != 'All' )
{





                        $General_Total=0;
                          
                          $company_name = $rsdepartment['name'];
                          $data_table = 'data-table';
    
  
        // the query
       $query = "SELECT  *  FROM invoices i  
           JOIN customers c  ON c.invoice = i.invoice
   
      WHERE  ( i.invoice = c.invoice and i.invoice_type = 'invoice' )  
          and   (c.company_name = '$Company') 
          and    ( i.invoice_date between '$From' and '$To')
          and (i.status = '$Status')
      

          ORDER BY i.invoice DESC ";
          
        
  
  
    // mysqli select query
    $results = $mysqli->query($query);
    // mysqli select query
    if($results) {
          print '
          <h4><b>  <span style="color:orange;"> '.$From_style.'  -  '.$To_style.' </span> -  </b> <b style="color:red; font-size:25px;width:32px;padding: 5px;border: 2px solid gray;margin: 0;"> '.$Company.' </b>  </h4>
          <table class="table table-striped table-hover table-bordered" id="'.$data_table.'" cellspacing="0"  class="display" cellspacing="0" width="100%"><thead>
          <tr>
          
                          <th>Invoice</th>
                          <th>Patient</th>
                          <th>Issue Date</th>
                          <th>Company Name</th>
                          <th>Type</th>
                          <th>Status</th>
                          <th>Total Sum</th>

                        
                          
                      
          
                        </tr></thead><tbody>';
          
                  while($row = $results->fetch_assoc()) {
                    $Total_sum = 0;
                    $inv = $row["invoice"];
                    $check_quantity = "select *,(qty * price) as p  from invoice_items where invoice = '$inv'  ";
                    $quantity_price = $mysqli->query( $check_quantity);
                    while($mow = $quantity_price->fetch_assoc()) {
                      $Total_sum += $mow['p'];
                    }
                    
                  $search = '/';
                  $replace = '_';
                  $subject = $row["invoice"];
          
                  $invoice_number = str_replace($search, $replace, $subject);
          
                  $date=date_create($row["invoice_date"]);
                  $date_invoice  = date_format($date,"d-m-Y");
          
                  $date=date_create($row["invoice_date"]);
                  $date_due  = date_format($date,"d-m-Y");
          
          
                      print '
                          <tr>
                              <td>'.$row["invoice"].'</td>
                              <td>'.$row["name"].'</td>
                              <td>'.$date_invoice .'</td>
                              <td>'.$row["company_name"].'</td>
                              <td>'.$row["invoice_type"].'</td>
                           ';
          
                          if($row['status'] == "open"){
                              print '<td><span class="label label-primary">'.$row['status'].'</span></td>';
                          } elseif ($row['status'] == "paid"){
                              print '<td><span class="label label-success">'.$row['status'].'</span></td>';
                          }

                          print '<td><b>'.number_format($Total_sum)."&nbsp;".'</b></td>';
                       
                          $user_permission = array(); 
                          $explode_comma_separated = explode(",", $_SESSION['User_Permission']);
                          
                          for($i =0; $i <= count($explode_comma_separated); $i++)
                          {
                          @array_push($user_permission,$explode_comma_separated[$i]);
                          }
          
                      
                      
          
                  
                          $General_Total += $Total_sum;
                  }
                  
                  print '</tr>
                  
                  
                  
                  
                  
                  <tr>
          
                  <th rowspan="5" >Total Sum </th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th></th>
                  <th> '.number_format($General_Total)."&nbsp;".CURRENCY.' ';
                 
                  if($General_Total >0){ 
                     print '
                  
                     <div class="input-group col-xs-4 float-right"> <button type="submit"  name="submit" class="btn btn-success">Proceed Payments</button>
                    </div> ';}
                    
                   
                 print ' </th> </tr>  </tbody></table>';
          
              } else {
          
                  echo "<p>There are no invoices to display.</p>";
          
              }
  
  
  
       


// Frees the memory associated with a result
@$results->free();

// close connection 
@$mysqli->close();

}



}
else
{


  //header("Location: invoice-list.php",TRUE,307); 
  echo "
  <script>
      setTimeout(function() {
          window.location = 'invoice-list.php';
      }, 1);
  </script>
";

}


 ?>
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