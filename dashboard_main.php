<!-- Small boxes (Stat box) -->
<div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
            <div class="inner">
              <h3><?php

                    $result = mysqli_query($mysqli, 'SELECT SUM(subtotal) AS value_sum FROM invoices WHERE status = "paid"   ') ;
    $row = mysqli_fetch_assoc($result);
    $sum = $row['value_sum'];
    echo number_format($sum)."\n";
    ?></h3>

              <p>Sales Amount</p>
            </div>
            <div class="icon">
              <i class="ion ion-social-usd"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3><?php

    $sql = "SELECT * FROM invoices";
    $query = $mysqli->query($sql);

    echo "$query->num_rows";
    ?></h3>

              <p>Total Invoices</p>
            </div>
            <div class="icon">
              <i class="ion ion-printer"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
            <h3><?php

    $sql = "SELECT * FROM invoices WHERE status = 'open'";
    $query = $mysqli->query($sql);

    echo "$query->num_rows";
    ?></h3>

              <p>Pending Bills</p>
            </div>
            <div class="icon">
              <i class="ion ion-load-a"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
            <h3><?php

    $result = mysqli_query($mysqli, 'SELECT SUM(subtotal) AS value_sum FROM invoices WHERE status = "open"');
    $row = mysqli_fetch_assoc($result);
    $sum = $row['value_sum'];
    echo $sum;
    ?></h3>

              <p>Due Amount</p>
            </div>
            <div class="icon">
              <i class="ion ion-alert-circled"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->


      <!-- 2nd row -->
      <div class="row">
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-primary">
            <div class="inner">
              <h3><?php

    $sql = "SELECT * FROM products";
    $query = $mysqli->query($sql);

    echo "$query->num_rows";
    ?></h3>

              <p>Total Products</p>
            </div>
            <div class="icon">
              <i class="ion ion-social-dropbox"></i>
            </div>
            
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-maroon">
            <div class="inner">
              <h3><?php

    $sql = "SELECT * FROM store_customers";
    $query = $mysqli->query($sql);

    echo "$query->num_rows";
    ?></h3>

              <p>Total Patients</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-people"></i>
            </div>
            
          </div>
        </div>

        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner">
            <h3><?php

    $sql = "SELECT * FROM invoices WHERE status = 'paid'";
    $query = $mysqli->query($sql);

    echo "$query->num_rows";
    ?></h3>

              <p>Paid Bills</p>
            </div>
            <div class="icon">
              <i class="ion ion-ios-paper"></i>
            </div>
            
          </div>
        </div>


        <div class="col-lg-3 col-xs-6">

          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner">
            <h3><?php




       $Today = date('y/m/d');
       $new = date('Y', strtotime($Today));

    $currentDate = date('Y-m-d');

  //  $sql = "SELECT SUM(total) AS Total_sales FROM invoices where ( invoice_date = '".$currentDate."' ) ";
  //   $query = $mysqli->query($sql);

    $sql = "SELECT SUM(total) AS Total_sales FROM invoices where ( invoice_date = '".$currentDate."' and invoice_which <> 'Regular-Pharmacy')  ";
    $query = $mysqli->query($sql);

    @$row = mysqli_fetch_assoc($query);
    $sum = $row['Total_sales'];

    echo  number_format($sum)."\n";

    ?></h3>

              <p>Total Daily sales / Logged User</p>

            </div>
            <div class="icon">
              <i class="ion ion-android-apps"></i>
            </div>
            </div>


        </div>



        <div class="col-lg-3 col-xs-6">
          
          <!-- small box -->
          <div class="small-box bg-aqua-active">
            <div class="inner">
            <h3><?php




       $Today = date('y/m/d');
       $new = date('Y', strtotime($Today));

    $currentDate = date('Y-m-d');

  //  $sql = "SELECT SUM(total) AS Total_sales FROM invoices where ( invoice_date = '".$currentDate."' ) ";
  //   $query = $mysqli->query($sql);

    $sql = "SELECT SUM(total) AS Total_sales FROM invoices where ( invoice_date = '".$currentDate."' and invoice_which <> 'Regular-Pharmacy')  ";
    $query = $mysqli->query($sql);


    @$row = mysqli_fetch_assoc($query);
    $sum = $row['Total_sales'];

    echo  number_format($sum)."\n";

    ?></h3>

              <p>Total Medicines </p>

            </div>

            <div class="icon">
              <i class="ion ion-android-apps"></i>
            </div>
            </div>


        </div>




        

        <div class="col-lg-3 col-xs-6">
          
          <!-- small box -->
          <div class="small-box bg-blue-gradient">
            <div class="inner">
            <h3><?php




       $Today = date('y/m/d');
       $new = date('Y', strtotime($Today));

    $currentDate = date('Y-m-d');

   $sql = "SELECT SUM(total) AS Total_sales FROM invoices where ( invoice_date = '".$currentDate."' ) ";
    $query = $mysqli->query($sql);

    @$row = mysqli_fetch_assoc($query);
    $sum = $row['Total_sales'];

    echo  number_format($sum)."\n";

    ?></h3>

              <p>Total Manufactures </p>

            </div>
            <div class="icon">
              <i class="ion ion-android-apps"></i>
            </div>

            </div>


        </div>


        
        <div class="col-lg-3 col-xs-6">
          
          <!-- small box -->
          <div class="small-box bg-green-gradient">
            <div class="inner">
            <h3><?php




       $Today = date('y/m/d');
       $new = date('Y', strtotime($Today));

    $currentDate = date('Y-m-d');

   $sql = "SELECT  SUM(patient_paid) AS Total_sales , SUM(remained_balance) AS Remained_Balance
		from invoices i
         Join balance_invoices b
		ON b.invoice_id = i.invoice
        WHERE (b.invoice_type <> 'Laboratory' and invoice_date = '".$currentDate."')
        Group by b.invoice_id
		ORDER BY i.invoice ASC ";

    $query = $mysqli->query($sql);



    @$row = mysqli_fetch_assoc($query);
    @$Total_Sales = $row['Total_sales'];
    @$Partial_Paid = $row['Remained_Balance'];

    echo  number_format($Total_Sales)."\n";

    ?></h3>

              <p>Total Invoice - Pharmacy </p>

            </div>
            <div class="icon">
              <i class="ion ion-android-apps"></i>
            </div>

            </div>


        </div>










        <div class="col-lg-3 col-xs-6">
          
          <!-- small box -->
          <div class="small-box bg-green-gradient">
            <div class="inner">
            <h3><?php




       $Today = date('y/m/d');
       $new = date('Y', strtotime($Today));

    $currentDate = date('Y-m-d');
    $sql = "SELECT  SUM(patient_paid) AS Total_sales , SUM(remained_balance) AS Remained_Balance from invoices i Join balance_invoices b
		ON b.invoice_id = i.invoice WHERE (b.invoice_type <> 'Laboratory' and invoice_date = '".$currentDate."') Group by b.invoice_id ORDER BY i.invoice ASC ";
    $query = $mysqli->query($sql);
    @$row = mysqli_fetch_assoc($query);
    @$Total_Sales = $row['Total_sales'];
    @$Partial_Paid = $row['Remained_Balance'];
  //  echo  number_format($Partial_Paid)."\n";
    $invoice_array = array(); 
    $add_value =0;

    $select_distict_old_id = "select distinct old_invoice_id from balance_invoices where invoice_type='Pharmacy' order by  old_invoice_id ASC"; 
    $query_select_distict_old_id = $mysqli->query($select_distict_old_id);

    while($query_selection =$query_select_distict_old_id->fetch_assoc())
    {

      @array_push($invoice_array,$query_selection['old_invoice_id']);

    }

    $count_invoice = count($invoice_array);

    for($i=0; $i < $count_invoice ; $i++)
    {
      @$check= $invoice_array[$i];
      $select_distict_remained_balance = "select * from balance_invoices where (old_invoice_id = '$check' and invoice_type='Pharmacy') order by id DESC limit 1"; 
      $query_select_distict_remained_balance = $mysqli->query($select_distict_remained_balance);
      $balance_table = $query_select_distict_remained_balance->fetch_assoc();
      if($balance_table['remained_balance'] != 0 ) {
        $add_value += $balance_table['remained_balance'];
      }
    }

  echo  number_format($add_value)."\n";
?></h3>

              <p>Total Partial Payment Invoice - Pharmacy </p>

            </div>
            <div class="icon">
              <i class="ion ion-android-apps"></i>
            </div>

            </div>


        </div>








        <div class="col-lg-3 col-xs-6">
          
          <!-- small box -->
          <div class="small-box bg-purple-gradient">
            <div class="inner">
            <h3>
              <?php
       $Today = date('y/m/d');
       $new = date('Y', strtotime($Today));
       $currentDate = date('Y-m-d');
       $sql = "SELECT  SUM(patient_paid) AS Total_sales , SUM(remained_balance) AS Remained_Balance from invoices i Join balance_invoices b
		   ON b.invoice_id = i.invoice WHERE (b.invoice_type <> 'Laboratory' and invoice_date = '".$currentDate."') Group by b.invoice_id ORDER BY i.invoice ASC ";
       $query = $mysqli->query($sql);
       @$row = mysqli_fetch_assoc($query);
       @$Total_Sales = $row['Total_sales'];
       @$Partial_Paid = $row['Remained_Balance'];
  //  echo  number_format($Partial_Paid)."\n";
    $invoice_array = array(); 
    $add_value =0;

    $select_distict_old_id = "select distinct old_invoice_id from balance_invoices where ( invoice_type='Pharmacy' and Timestamp = '".$currentDate."')  order by  old_invoice_id ASC"; 
    @$query_select_distict_old_id = $mysqli->query($select_distict_old_id);

    while($query_selection = $query_select_distict_old_id->fetch_assoc())
    {

      @array_push($invoice_array,$query_selection['old_invoice_id']);

    }

    $count_invoice = count($invoice_array);

    for($i=0; $i < $count_invoice ; $i++)
    {
      @$check= $invoice_array[$i];
      $select_distict_remained_balance = "select * from balance_invoices where (old_invoice_id = '$check' and invoice_type='Pharmacy') order by id DESC limit 1"; 
      $query_select_distict_remained_balance = $mysqli->query($select_distict_remained_balance);
      $balance_table = $query_select_distict_remained_balance->fetch_assoc();
      if($balance_table['remained_balance'] != 0 ) {
        $add_value += $balance_table['remained_balance'];
      }
    }

  echo  number_format($add_value)."\n";
?></h3>

              <p>Today Partial Payment Invoice - Pharmacy </p>

            </div>
            <div class="icon">
              <i class="ion ion-android-apps"></i>
            </div>

            </div>


        </div>




        <div class="col-lg-3 col-xs-6">
          
          <!-- small box -->
          <div class="small-box bg-red-gradient">
            <div class="inner">
            <h3><?php




       $Today = date('y/m/d');
       $new = date('Y', strtotime($Today));

    $currentDate = date('Y-m-d');




$sqll = "SELECT SUM(total) AS Total_sales FROM invoices where ( invoice_date = '".$currentDate."' and invoice_which <> 'Regular-Pharmacy')  ";
$queryl = $mysqli->query($sqll);
@$rowl = mysqli_fetch_assoc($queryl);
$suml = $rowl['Total_sales'];


$sql = "SELECT  SUM(patient_paid) AS Total_sales , SUM(remained_balance) AS Remained_Balance from invoices i Join balance_invoices b ON b.invoice_id = i.invoice WHERE (b.invoice_type <> 'Laboratory' and invoice_date = '".$currentDate."') Group by b.invoice_id ORDER BY i.invoice ASC ";
$query = $mysqli->query($sql);
@$row = mysqli_fetch_assoc($query);
@$Total_Sales = $row['Total_sales'];
@$Partial_Paid = $row['Remained_Balance'];

echo  number_format($suml + $Total_Sales )."\n";

    ?></h3>

              <p>Total Payment Labaratory + Consultation + Pharmacy  </p>

            </div>
            <div class="icon">
              <i class="ion ion-android-apps"></i>
            </div>

            </div>


        </div>



        
      </div>
      
     