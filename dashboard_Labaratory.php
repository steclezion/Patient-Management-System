<!-- Small boxes (Stat box) -->
<div class="row">
<div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-olive">
            <div class="inner">
            <h3><?php




       $Today = date('y/m/d');
       $new = date('Y', strtotime($Today));

    $currentDate = date('Y-m-d');


    $id =  $_SESSION['login_user_id'];
    $sql = "SELECT *,  invoices.invoice as inv, task_tracker.Timestamp as tam,    customers.id as cid, customers.name as cname,  task_tracker.id as transaction_id  FROM 
    invoices JOIN task_tracker 
	ON  invoices.invoice = task_tracker.task_tracker_related_id 
	JOIN customers 
	ON customers.invoice  = task_tracker.task_tracker_related_id 
	LEFT JOIN labaratory_test
	ON labaratory_test.invoice  = task_tracker.cashier_task_invoice_id 

  where invoices.assigned_lab_technicians = $id  and invoices. invoice_date = '".$currentDate."'
    ORDER BY task_tracker.Timestamp ASC";

    $query = $mysqli->query($sql);

    @$row = mysqli_fetch_assoc($query);
    $sum = $row['Total_sales'];

    echo  number_format($sum)."\n";

    ?></h3>

              <p>Today Total Number of Tests</p>

            </div>
           
        </div>

      </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
            <div class="inner">
              <h3><?php
$id =  $_SESSION['login_user_id'];

   $sql = "SELECT *,  invoices.invoice as inv, task_tracker.Timestamp as tam,    customers.id as cid, customers.name as cname,  task_tracker.id as transaction_id  FROM 
    invoices JOIN task_tracker 
	ON  invoices.invoice = task_tracker.task_tracker_related_id 
	JOIN customers 
	ON customers.invoice  = task_tracker.task_tracker_related_id 
	LEFT JOIN labaratory_test
	ON labaratory_test.invoice  = task_tracker.cashier_task_invoice_id 

  where invoices.assigned_lab_technicians = $id 
    ORDER BY task_tracker.Timestamp ASC";
    $query = $mysqli->query($sql);

    echo "$query->num_rows";
    ?></h3>

        <p> Total Number of Exams</p>
            </div>
            <div class="icon">
              <i class="ion ion-printer"></i>
            </div>
            
          </div>
        </div>
        <!-- ./col -->
       
        </div>
        <!-- ./col -->
     
        <!-- ./col -->
      </div>
      <!-- /.row -->


   
       

   




       
      
     