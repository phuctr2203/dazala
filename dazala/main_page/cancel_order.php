<?php

require_once '../login_page/db.php';

session_start();

$id = $_GET['id'];

$sql = "CALL cancel_orders('$id');";
$stmt = $shipper->query($sql);

?>

<a href="shipper_page.php">Back to Main Page</a><br><br>
<a href="processed_order.php">Check Processed Orders</a><br><br>