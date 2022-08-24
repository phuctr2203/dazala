<?php

require_once '../login_page/db.php';

session_start();

?>


<h1>Search by Name Page</h1>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search_name" placeholder="search products..." class="box" required>
      <input type="submit" name="submit" value="search" class="btn">
   </form>
</section>
<button onclick='window.location.href="homepage.php";' class="btn btn-primary btn-block btn-flat" style="background-color: blue;">Back To Main Page</button> 

<?php
    if(isset($_POST['submit'])) {
        $search_name = $_POST['search_name'];
        $sql_search_name = "CALL search_product_based_on_name('$search_name');";
        $rows_search_name = $customer->query($sql_search_name);

        if($rows_search_name->rowCount() == 0) {
            echo "<br>" . "No Results Found";
        }

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
