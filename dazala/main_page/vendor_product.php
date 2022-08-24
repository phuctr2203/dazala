<?php

require_once '../login_page/db.php';

session_start();

$ven_id = $_SESSION['ven_id'];
$sql = "SELECT * FROM vendor WHERE id = '$ven_id'";
$stmt = $vendor->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h1>Welcome " . $row['name']. "</h1>";

echo "ID: " . $row['id']. "<br>name: " . $row['name']. "<br>address: " . $row['address']. "<br>latitude: " . $row['latitude']. "<br>longtitude: " . $row['longtitude']. "<br>username: " . $row['username']. "<br>password: " . $row['password']. "<br>";

?>

<a href="update_ven_info.php">Update Information</a><br><br>

<?php

$sql_show_product_vendor = "SELECT * FROM product 
WHERE ven_id = (SELECT id FROM vendor WHERE id = '$ven_id')";

$stmt_show_product_vendor = $vendor->query($sql_show_product_vendor);

foreach($stmt_show_product_vendor as $row) {
    $id = $row['id'];
    $name = $row['name'];
    $price = $row['price'];
    $quantity = $row['quantity'];
    $ven_id = $row['ven_id'];

    echo "<br>ID: " . $id. "<br>name: " . $name. "<br>price: $" . $price. "<br>quantity: " . $quantity. "<br>vendor id: " . $ven_id."";
    echo "<br>";

    echo "<a href='edit_product.php?prod_id=$id' >Edit Product</a><br>";
}

?>

<h2><a href='add_product.php'>Add Product </a></h2>
<a href="logout.php" class="delete-btn">Logout</a>