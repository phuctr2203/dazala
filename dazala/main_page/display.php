<?php

require_once '../login_page/db.php';

session_start();

$username = $_GET['username'];
$sql = "SELECT * FROM customer WHERE username = '$username'";
$stmt = $customer->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h1>Welcome " . $row['name']. "</h1>";

$sql = "SELECT * FROM product";
$rows = $customer->query($sql);

foreach($rows as $temp)
{
    echo "<br>ID: " . $temp['id']. "<br>name: " . $temp['name']. "<br>price: $" . $temp['price']. "<br>vendor id: " . $temp['ven_id']."";
    echo "<br>";
}

?>

<h1><a href="../login_page/logout.php">Logout here</a> </h1>