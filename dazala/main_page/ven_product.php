<?php

require_once '../login_page/db.php';

session_start();

$id = $_GET['id'];

$sql = "SELECT * FROM vendor WHERE id = '$id'";
$stmt = $vendor->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h1>Vendor: " . $row['name']. "</h1>";

$sql_show_product_vendor = "SELECT * FROM product 
WHERE ven_id = (SELECT id FROM vendor WHERE id = '$id')";

$stmt_show_product_vendor = $vendor->query($sql_show_product_vendor);

foreach($stmt_show_product_vendor as $row) {
    $id = $row['id'];
    $name = $row['name'];
    $price = $row['price'];
    $quantity = $row['quantity'];
    $ven_id = $row['ven_id'];

    echo "<br>ID: " . $id. "<br>name: " . $name. "<br>price: $" . $price. "<br>quantity: " . $quantity. "<br>vendor id: " . $ven_id."";
    echo "<br>";

    echo "<a href='orders.php?prod_id=$id' >Buy Product</a><br>";   
}

?>

<button onclick='window.location.href="homepage.php";' class="btn btn-primary btn-block btn-flat" style="background-color: blue;">Back To Main Page</button> 
