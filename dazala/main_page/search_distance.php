<?php

require_once '../login_page/db.php';

session_start();

$username = $_SESSION['username'];

if(!isset($username)){
    header('location:login.php');
};

?>


<h1>Search Vendor by Distance in Kilometer Page</h1>

<section class="search-form">
   <form action="" method="post">
      <input type="text" name="search_distance" placeholder="Input Distance" class="box" required>
      <input type="submit" name="submit" value="search" class="btn">
   </form>
</section>
<button onclick='window.location.href="homepage.php";' class="btn btn-primary btn-block btn-flat" style="background-color: blue;">Back To Main Page</button> 

<?php
    if(isset($_POST['submit'])) {
        $search_distance = $_POST['search_distance'];
        $latitude = $_SESSION['latitude'];
        $longtitude = $_SESSION['longtitude'];

        $sql_search_distance = "CALL search_vendor_based_on_distance($search_distance, $latitude, $longtitude);";
        $rows_search_distance = $customer->query($sql_search_distance);

        if($rows_search_distance->rowCount() == 0) {
            echo "<br>" . "No Results Found";
        }

        foreach($rows_search_distance as $row) {
            $id = $row['id'];
            $name = $row['name'];
            $address = $row['address'];
            $latitude = $row['latitude'];
            $longtitude = $row['longtitude'];
            $distance = $row['distance'];

            echo "<br><br>ID: " . $row['id']. "<br>name: " . $row['name']. "<br>address: " . $row['address']. "<br>latitude: " . $row['latitude']. "<br>longtitude: " . $row['longtitude']. "<br>distance: " .$row['distance'] . " km";
        }
    }
?>
