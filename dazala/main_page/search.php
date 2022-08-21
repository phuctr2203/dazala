<?php

require_once '../login_page/db.php';

session_start();

$username = $_SESSION['username'];

if(!isset($username)){
    header('location:login.php');
};

?>


<h2>Search Page</h2>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search_name" placeholder="search products..." class="box">
      <input type="submit" name="submit_name" value="search" class="btn">
   </form>
</section>

<?php
    if(isset($_POST['submit_name'])) {
        $search_name = $_POST['search_name'];
        $sql_search_name = "SELECT * FROM product
                            WHERE name LIKE '{$search_name}%';";
        $rows_search_name = $customer->query($sql_search_name);

        foreach($rows_search_name as $row) {
            $id = $row['id'];
            $name = $row['name'];
            $price = $row['price'];
            $quantity = $row['quantity'];
            $ven_id = $row['ven_id'];

            echo "<br>ID: " . $id. "<br>name: " . $name. "<br>price: $" . $price. "<br>quantity: " . $quantity. "<br>vendor id: " . $ven_id."";
            echo "<br>";

            
        }
    }
?>

<section class="search-form">
   <form action="" method="post">
      <input type="float" name="start_price" placeholder="Start price" class="box">
      <input type="float" name="end_price" placeholder="End price" class="box">
      <input type="submit" name="submit_price" value="search" class="btn">
   </form>
</section>

<?php 
    if(isset($_POST['submit_price'])) {
        $start_price = $_POST['start_price'];
        $end_price = $_POST['end_price'];
        $sql_search_price = "SELECT * FROM product WHERE price BETWEEN '$start_price' AND '$end_price';";
        $rows_search_price = $customer->query($sql_search_price);

        foreach($rows_search_price as $row) {
            $id = $row['id'];
            $name = $row['name'];
            $price = $row['price'];
            $quantity = $row['quantity'];
            $ven_id = $row['ven_id'];

            echo "<br>ID: " . $id. "<br>name: " . $name. "<br>price: $" . $price. "<br>quantity: " . $quantity. "<br>vendor id: " . $ven_id."";
            echo "<br>";
        }

    }