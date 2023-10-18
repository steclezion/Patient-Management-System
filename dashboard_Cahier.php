<!-- Small boxes (Stat box) -->
<div class="row">
     

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



      </div>
      <!-- /.row -->


      <!-- 2nd row -->
      <div class="row">
       

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
$id =  $_SESSION['login_user_id'];
   $sql = "SELECT SUM(total) AS Total_sales FROM invoices where ( invoice_date = '".$currentDate."' ) where `invoice_intially_created_by` = $id ";
    $query = $mysqli->query($sql);

    @$row = mysqli_fetch_assoc($query);
    $sum = $row['Total_sales'];

    echo  number_format($sum)."\n";

    ?></h3>

              <p>Total Daily sales / Logged User  / <?php echo $_SESSION['login_username'] ; ?></p>

            </div>
            <div class="icon">
              <i class="ion ion-ios-paper"></i>
              <i class="ion ion-social-usd"></i>
            </div>
            
          </div>
        </div>

      </div>
      
     