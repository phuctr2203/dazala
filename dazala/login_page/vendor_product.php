<?php

require_once '../login_page/db.php';

session_start();

$username_used = $_GET['username'];
$sql = "SELECT * FROM vendor WHERE username = '$username_used'";
$stmt = $vendor->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo "ID: " . $row['id']. "<br>name: " . $row['name']. "<br>address: " . $row['address']. "<br>latitude: " . $row['latitude']. "<br>longtitude: " . $row['longtitude']. "<br>username: " . $row['username']. "<br>password: " . $row['password']. "<br>";

$sql_show_product_vendor = "SELECT * FROM product 
WHERE ven_id = (SELECT id FROM vendor WHERE username = '$username_used')";

$stmt_show_product_vendor = $vendor->query($sql_show_product_vendor);

foreach($stmt_show_product_vendor as $temp)
{
    echo "<br>ID: " . $temp['id']. "<br>name: " . $temp['name']. "<br>price: $" . $temp['price']. "<br>vendor id: " . $temp['ven_id']."";
    echo "<br>";
}
