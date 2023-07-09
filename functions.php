<?php


include_once("includes/config.php");

// get invoice list
function getInvoices() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
		die('Error : ('.$mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
    $query = "SELECT * 
		FROM invoices i
		JOIN customers c
		ON c.invoice = i.invoice
		WHERE i.invoice = c.invoice
		ORDER BY i.invoice";

	// mysqli select query
	$results = $mysqli->query($query);

	// mysqli select query
	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table" cellspacing="0"><thead><tr>

				<th>Invoice</th>
				<th>Patient</th>
				<th>Issue Date</th>
				<th>Due Date</th>
				<th>Type</th>
				<th>Status</th>
				<th>Actions</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		$search = '/';
		$replace = '_';
		$subject = $row["invoice"];

		$invoice_number = str_replace($search, $replace, $subject);

			print '
				<tr>
					<td>'.$row["invoice"].'</td>
					<td>'.$row["name"].'</td>
				    <td>'.$row["invoice_date"].'</td>
				    <td>'.$row["invoice_due_date"].'</td>
				    <td>'.$row["invoice_type"].'</td>
				';

				if($row['status'] == "open"){
					print '<td><span class="label label-primary">'.$row['status'].'</span></td>';
				} elseif ($row['status'] == "paid"){
					print '<td><span class="label label-success">'.$row['status'].'</span></td>';
				}

			print '
				    <td><a href="invoice-edit.php?id='.$row["invoice"].'" class="btn btn-primary btn-xs">
					<span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a>
					<a href="#" data-invoice-id="'.$row['invoice'].'" data-email="'.$row['email'].'" data-invoice-type="'.$row['invoice_type'].'" data-custom-email="'.$row['custom_email'].'" class="btn btn-success btn-xs email-invoice">
					<span class="glyphicon glyphicon-envelope" aria-hidden="true"></span></a> <a href="invoices/'.$invoice_number.'.pdf" class="btn btn-info btn-xs" target="_blank">
					<span class="glyphicon glyphicon-download-alt" aria-hidden="true"></span></a> <a data-invoice-id="'.$row['invoice'].'" class="btn btn-danger btn-xs delete-invoice">
					<span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
			    </tr>
			';

		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no invoices to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();

}

// Initial invoice number
function getInvoiceId() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	$query = "SELECT invoice FROM invoices ORDER BY invoice DESC LIMIT 1";

	if ($result = $mysqli->query($query)) {

		$row_cnt = $result->num_rows;

	    $row = mysqli_fetch_assoc($result);

	    //var_dump($row);
		$Today = date('y:m:d');
		$new = date(' Y', strtotime($Today));
	    if($row_cnt == 0){
			// echo INVOICE_INITIAL_VALUE;
		
           echo  "INV/".trim($new),"/0001";
		} else {
            $Get_the_number = explode('/',$row['invoice']);
			$count_squence = $Get_the_number[2] + 1;

		   $zero_filled_counter = sprintf('%04d',$count_squence);
			
			echo "INV/".trim($new),"/".$zero_filled_counter;

		}

	    // Frees the memory associated with a result
		$result->free();

		// close connection 
		$mysqli->close();
	}
	
}

// populate product dropdown for invoice creation
function popProductsList() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT * FROM products ORDER BY product_id ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {
		echo '<select id="products_insert" class="form-control item-select required">';
		

		while($row = $results->fetch_assoc()) {

		    print '<option value="'.$row['product_price'].'">'.$row["product_name"].'</option>';
		}
		echo '</select>';

	} else {

		echo "<p>There are no products, please add a product.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();

}

// populate product dropdown for invoice creation
function popCustomersList() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT * , s.town as patient_town FROM store_customers s join doctor d on d.doctorid = s.assigned_dr
	
	ORDER BY s.id ASC   ";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>

				<th>Full Name</th>
				<th>Town</th>
				<th>Age</th>
				<th>Sex</th>
				<th>Date of Reg.</th>
				<th>Action</th>

			  </tr></thead><tbody>';

			 

		while($row = $results->fetch_assoc()) {
			$date=date_create($row['date_of_reg']);
			$date= date_format($date,"d/m/Y");
		    print '
			    <tr>
					<td>'.$row["name"].'</td>
				    <td>'.$row["patient_town"].'</td>
				    <td>'.$row["age"].'</td>
					<td>'.$row["sex"].'</td>
					<td>'.$row["date_of_reg"].'</td>
				    <td><a href="#" class="btn btn-primary btn-xs customer-select" 
					data-customer-name="'.$row['name'].'"
					data-customer-town="'.$row['patient_town'].'"
					data-customer-age="'.$row['age'].'" 
					data-customer-sex="'.$row['sex'].'" 
					data-customer-date_of_reg="'.$date.'" 
					
					data-doctor-name="'.$row['doctorname'].'"
					data-doctor-title="'.$row['title'].'" 
					data-doctor-email="'.$row['email'].'"  >
					             Select
					</a></td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no customers to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();

}



// get products list
function getProcedure() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT * FROM procedure ORDER BY procedure_name ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>

				<th>Procedure</th>
				<th>Description</th>
				<th>Price</th>
				<th>Action</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		    print '
			    <tr>
					<td>'.$row["procedure_name"].'</td>
				    <td>'.$row["procedure_desc"].'</td>
				    <td>$'.$row["procedure_price"].'</td>
				    <td><a href="product-edit.php?id='.$row["procedure_id"].'" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <a data-product-id="'.$row['product_id'].'" class="btn btn-danger btn-xs delete-product"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are No Procecudre To Display.</p>";

	}

	// Frees the memory associated with a result
	@$results->free();

	// close connection 
	$mysqli->close();
}




// get products list
function getProducts() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT * FROM products ORDER BY product_name ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {
		$i=1;
		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
		<th>Procedure</th>
				<th>Procedure</th>
				<th>Description</th>
				<th>Price</th>
				<th>Action</th>
                 </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		    print '
			    <tr>
				<td>'.$i++.'</td>
					<td>'.$row["product_name"].'</td>
				    <td>'.$row["product_desc"].'</td>
				    <td>'.$row["product_price"]." ".CURRENCY.'</td>
				    <td><a href="procedure-edit.php?id='.$row["product_id"].'" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <a data-product-id="'.$row['product_id'].'" class="btn btn-danger btn-xs delete-product"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no products to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();
}

// get user list
function getUsers() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT * FROM users ORDER BY username ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {

		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>

				<th>Name</th>
				<th>Username</th>
				<th>Email</th>
				<th>Phone</th>
				<th>Action</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		    print '
			    <tr>
			    	<td>'.$row['name'].'</td>
					<td>'.$row["username"].'</td>
				    <td>'.$row["email"].'</td>
				    <td>'.$row["phone"].'</td>
				    <td><a href="user-edit.php?id='.$row["id"].'" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <a data-user-id="'.$row['id'].'" class="btn btn-danger btn-xs delete-user"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no users to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();
}

// get user list
function getCustomers() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT *, s.town as patient_town FROM store_customers s
	JOIN doctor c ON c.doctorid = s.assigned_dr
	
    
	ORDER BY s.id ASC";

	// mysqli select query
	$results = $mysqli->query($query);

	if($results) {
		$i=1;
		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
		<th>ID</th>
				<th>Name</th>
				<th>Town</th>
				<th>Age</th>
				<th>Gender</th>
				<th ">Assigned Dr</th>
				<th>Date Of Registration</th>
				<th>Action</th>

			  </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {
               
		    print '
			    <tr>
				    <td>'.$i++.'</td>
					<td>'.$row["name"].'</td>
				    <td>'.$row["patient_town"].'</td>
				    <td>'.$row["age"].'</td>
					<td>'.$row["sex"].'</td>
					<td style="color:green">'.$row["doctorname"].'</td>
					<td>'.date("d-m-Y",strtotime($row["date_of_reg"])).'</td>
				    <td><a href="patient-edit.php?id='.$row["id"].'" class="btn btn-primary btn-xs"><span class="glyphicon glyphicon-edit" aria-hidden="true"></span></a> <a data-customer-id="'.$row['id'].'" class="btn btn-danger btn-xs delete-customer"><span class="glyphicon glyphicon-trash" aria-hidden="true"></span></a></td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no customers to display.</p>";

	}

	// Frees the memory associated with a result
	@$results->free();

	// close connection 
	$mysqli->close();
}





// get doctors list
function getDoctors() {

	// Connect to the database
	$mysqli = new mysqli(DATABASE_HOST, DATABASE_USER, DATABASE_PASS, DATABASE_NAME);

	// output any connection error
	if ($mysqli->connect_error) {
	    die('Error : ('. $mysqli->connect_errno .') '. $mysqli->connect_error);
	}

	// the query
	$query = "SELECT * FROM doctor d JOIN countries c ON c.id = d.country_id JOIN department de ON de.departmentid = d.departmentid
              ORDER BY d.doctorid ASC ";

	// mysqli select query
 	$results = $mysqli->query($query);

	if($results)  {  $i=1;

		print '<table class="table table-striped table-hover table-bordered" id="data-table"><thead><tr>
		         <th>ID</th>
		        <th>Name</th>
				<th>Email</th>
				<th width="10%"> Department  Name    </th>
				<th width="10%">  Consu. Charge  </th>
				<!-- <th>Address-1</th>
				<th width="10%">Address-2</th>-->
				<th width="10%" >Phone</th>
				<th>Town</th>
				<!-- <th>Country Name</th> -- >
			<!--  <th width="10px" >Title</th>  -->
				<th width="10px" >Status</th>
				<th width="10px">Action</th>
				
                </tr></thead><tbody>';

		while($row = $results->fetch_assoc()) {

		    print '
			    <tr>
				<td width="10%" >'.$i++.'</td>
					<td width="10%" >'.$row["doctorname"].'</td>
				    <td width="10%">'.$row["email"].'</td>
					<td width="10%">'.$row["departmentname"].'</td>
					<td width="10%">'.$row["consultancy_charge"].'</td>
					<!-- <td width="10%">'.$row["address_one"].'</td>
					<td width="10%">'.$row["address_two"].'</td> -->
					<td width="10%">'.$row["mobileno"].'</td>
					<td width="10%">'.$row["town"].'</td>
				
					<td width="10%">'.$row["status"].'</td>
				    
				    <td><a href="doctor-edit.php?id='.$row["doctorid"].'"
					 class="btn btn-primary btn-xs">
					 <span class="glyphicon glyphicon-edit" aria-hidden="true">
					 </span></a> 

		<a data-doctor-id="'.$row['doctorid'].'"  class="btn btn-danger btn-xs delete-doctor"> <span class="glyphicon glyphicon-trash" aria-hidden="true"> </span></a>
					 </td>
			    </tr>
		    ';
		}

		print '</tr></tbody></table>';

	} else {

		echo "<p>There are no doctors to display.</p>";

	}

	// Frees the memory associated with a result
	$results->free();

	// close connection 
	$mysqli->close();
}
?>

