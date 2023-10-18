<?php



$created_at = "17/09/2023";
//echo date('F d,Y',strtotime($created_at));



$created_at = new DateTime("17/09/2023");
  echo date_format($created_at,'Y-m-d');


//echo $invoice_date = date_format('17-09-2023',"d-m-Y");





































?>