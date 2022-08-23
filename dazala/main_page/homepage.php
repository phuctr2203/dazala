<?php

require_once '../login_page/db.php';

session_start();

$username = $_SESSION['username']; 
$sql = "SELECT * FROM customer WHERE username = '$username'";
$stmt = $customer->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

echo "<h1>Welcome " . $row['name']. "</h1>";

?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" type="image/png" href="" />
    <title>Dazala E-Commerce</title>   
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />    
    <link href="../../assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />    
    <link href="../../assets/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css" />    
    <link href="../../assets/ionicons-2.0.1/css/ionicons.css" rel="stylesheet" type="text/css" />        
    <link href="../../assets/css/plugins/bootstrap-dialog.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/plugins/bootstrapValidator.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <link href="../../assets/css/style.css" rel="stylesheet" type="text/css" />
</head>
<body>

<section class="products">
    <h1 class="title">Latest Products</h1>

    <a href="logout.php" class="delete-btn">Logout</a><br><br>

    <a href="customer_order.php">Check current orders</a><br><br>

    <a href="search_name.php" class="delete-btn">Search Product by Name</a><br><br>
    <a href="search_price.php" class="delete-btn">Search Product by Price</a><br><br>
    <a href="search_distance.php" class="delete-btn">Search Vendor by Distance</a><br><br>
    
    <div class="box-container">
        <?php

        $sql = "SELECT * FROM product ORDER BY id DESC"; 
        $rows = $customer->query($sql);
        
        foreach($rows as $row) {
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

    </div>       

</section>

</body>