<?php

session_start();

require_once '../login_page/db.php';
$ven_id = $_SESSION['ven_id'];
$prod_id = $_GET['prod_id'];

$sql_display = "SELECT * FROM product WHERE id = '$prod_id'";
$stmt_display = $customer->query($sql_display);
$rows_display = $stmt_display->fetch(PDO::FETCH_ASSOC);

$name_prod_display = $rows_display['name'];
$quantity_display = $rows_display['quantity'];
$price_display = $rows_display['price'];
$venid_display = $rows_display['ven_id'];

echo "Product Name: $name_prod_display <br>Quantity: $quantity_display<br>Price: $price_display<br>Vendor ID: $venid_display<br>";

$document = $collection->findOne(
    ['_id' => $prod_id]
);

echo "Category: ", $document->category, "<br>";
echo "Brand: ", $document->brand, "<br>";
echo  "Condition: ", $document->condition, "<br>";
echo "Made In: ", $document->made_in, "<br>";
echo "Description: ",$document->description, "<br>";
?>