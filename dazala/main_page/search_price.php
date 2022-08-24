<?php

require_once '../login_page/db.php';

session_start();

?>

<h1>Search by Price Page</h1>

<section class="search-form">
   <form action="" method="post">
      <input type="float" name="start_price" placeholder="Start price" class="box" required>
      <input type="float" name="end_price" placeholder="End price" class="box" required>
      <input type="submit" name="submit" value="search" class="btn">
   </form>
</section>
<button onclick='window.location.href="homepage.php";' class="btn btn-primary btn-block btn-flat" style="background-color: blue;">Back To Main Page</button> 

<?php 
    if(isset($_POST['submit'])) {
        $start_price = $_POST['start_price'];
        $end_price = $_POST['end_price'];   
        $sql_search_price = "CALL search_product_based_on_price($start_price, $end_price);";
        $rows_search_price = $customer->query($sql_search_price);

        if($rows_search_price->rowCount() == 0) {
            echo "<br>" . "No Results Found";
        }

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