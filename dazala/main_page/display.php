<?php

require_once '../login_page/db.php';

session_start();

/* Paging Info */

$page = 1;

if (isset($_GET["page"])) {
    $page = filter_var($_GET['page'], FILTER_SANITIZE_NUMBER_INT);
}

$per_page = 3;

$sqlcount = "SELECT COUNT(*) AS total_products from product";
$stmt = $customer->prepare($sqlcount);
$stmt->execute();
$row = $stmt->fetch();
$total_products = $row['total_products'];

$total_pages = ceil($total_products / $per_page);

$offset = ($page-1) * $per_page;

/* End Paging Info */

$sql = "SELECT * FROM product LIMIT :offset, :perpage DESC";
$stmt = $customer->prepare($sql);
$stmt->execute(['offset'=>$offset, 'per_page'=>$per_page]);

while ( ($row = $stmt->fetch(PDO::FETCH_ASSOC) ) !== false) {
    echo "<br>ID: " . $temp['id']. "<br>name: " . $temp['name']. "<br>price: $" . $temp['price']. "<br>vendor id: " . $temp['ven_id']."";
    echo "<br>";
}
?>

<h1><a href="../login_page/logout.php">Logout here</a> </h1>  