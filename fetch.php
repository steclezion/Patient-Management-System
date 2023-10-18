<?php
//include('connect.php');
if(isset($_POST['view'])){
$con = mysqli_connect("localhost", "root", "", "invoicemgsys");

session_start();
$user_id = $_SESSION['login_user_id'];

if($_POST["view"] != '')
{
   $update_query = "UPDATE notification  SET status = 1 WHERE user_id = $user_id";
   mysqli_query($con, $update_query);
}
$query = "SELECT * FROM notification where  user_id = $user_id ORDER BY  id DESC LIMIT 10  ";
$result = mysqli_query($con, $query);
$output = '';
if(mysqli_num_rows($result) > 0)
{
while($row = mysqli_fetch_array($result))
{

   if($row["subject"] == 'Lab Request') {$link = 'request_from_dr_for_lab.php';} 
   if($row["subject"] == 'Lab Request submission to Dr') {$link = 'posted-list.php';} 
  $output .= '
  <li>
  <a href="'.$link.'">
  <strong>'.$row["subject"].'</strong><br />
  <small><em>'.$row["message"].'</em></small>
  </a>
  </li>
  ';
}
}
else{
    $output .= '<li><a href="#" class="text-bold text-italic">No Notification  Found</a></li>';
}
$status_query = "SELECT * FROM notification WHERE status=0 and user_id = $user_id";
$result_query = mysqli_query($con, $status_query);
$count = mysqli_num_rows($result_query);
$data = array(
   'notification' => $output,
   'unseen_notification'  => $count
);
echo json_encode($data);
}
?>