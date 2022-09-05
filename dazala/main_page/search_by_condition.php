<?php

require_once '../login_page/db.php';

session_start();

$cus_id = $_SESSION['cus_id'];
$sql = "SELECT * FROM customer WHERE id = '$cus_id'";
$stmt = $customer->query($sql);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$username = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
    <meta http-equiv="content-type" content="text/html;charset=UTF-8" />
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <link rel="icon" type="image/png" href="../assets/images/icon-title.png" />
        <title>Dazala E-Commerce</title>   
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />    
        <link href="../assets/bootstrap/css/bootstrap.css" rel="stylesheet" type="text/css" />        
        <link href="../assets/css/plugins/bootstrap-dialog.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/plugins/bootstrapValidator.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/skin-gray-light.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/select2.css" rel="stylesheet" type="text/css" />
        <link href="../assets/css/style.css" rel="stylesheet" type="text/css" />
    </head>

    <body class="skin-green-light sidebar-mini" data-new-gr-c-s-check-loaded="14.1013.0">
        <div class="wrapper">
            <header class="main-header">
                <a class="logo">
                    <img style="width:100px!important;" class="main-logo" src="../assets/images/logo.png">
                </a>
                <nav class="navbar navbar-static-top" role="navigation">
                    <div class="navbar-custom-menu">
                        <ul class="nav navbar-nav">
                            <li class="dropdown user-menu">
                                <a href="javascript:;" class="dropdown-toggle" style="height: 55px;" data-toggle="dropdown">     
                                    <?php
                                        echo "<span class='hidden-xs'>Welcome " . $row['name']. "</span>";
                                    ?>
                                    <br>
                                    <div style="text-align: center">
                                        <i class="fa-solid fa-caret-down"></i>
                                    </div>
                                </a>
                                <ul class="dropdown-menu" style="width: 55px; height: 25px; right: auto">
                                    <li><a href="logout.php" style="background-color: Maroon; color: white">Log Out<i class="fa-solid fa-right-from-bracket" style="padding-left: 10px"></i></a></li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </nav>
            </header>

            <aside class="main-sidebar">    
                <section class="sidebar" style="height: auto;">        
                    <ul class="sidebar-menu">
                        <h3 style="text-align: center"><i class="fa-solid fa-user"></i>Your Information</h3>
                        <li class="treeview active">
                            <ul class="treeview-menu menu-open" style="display: block;">
                                <?php
                                    echo "<span class='hidden-xs'>ID: " . $row['id']. "</span>". "<br>".
                                        "<span class='hidden-xs'>Name: " . $row['name']. "</span>". "<br>".
                                        "<span class='hidden-xs'>Address: " . $row['address']. "</span>". "<br>".
                                        "<span class='hidden-xs'>Latitude: " . $row['latitude']. "</span>". "<br>".
                                        "<span class='hidden-xs'>Longitude: " . $row['longtitude']. "</span>". "<br>".
                                        "<span class='hidden-xs'>Username: " . $row['username']. "</span>". "<br>".
                                        "<span class='hidden-xs'>Password: " . $row['password']. "</span>". "<br>";
                                ?>
                            </ul>
                            <br>
                            <button onclick='window.location.href="customer_order.php";' class="form-control btn btn-primary" style="background-color: #5941A9">Check Current Orders</button>
                        </li>
                        <br>
                        <button onclick='window.location.href="history_order.php";' class="form-control btn btn-primary" style="background-color: #5941A9">Check Orders History</button> 
                    </ul>
                    <br>
                    <button onclick='window.location.href="homepage.php";' class="form-control btn btn-primary" style="background-color: blue;">Back To Main Page</button> 
                </section>
            </aside>

            <div class="content-wrapper" style="min-height: 696px;">
                <section class="content-header">
                    <h1 class="title">Search by Condition</h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="col-sm-4">
                                <button onclick='window.location.href="search_name.php";' class="form-control btn btn-primary">Search Product by Name</button> 
                            </div>
                            <div class="col-sm-4">
                                <button onclick='window.location.href="search_price.php";' class="form-control btn btn-primary">Search Product by Price</button> 
                            </div>
                            <div class="col-sm-4">
                                <button onclick='window.location.href="search_distance.php";' class="form-control btn btn-primary">Search Vendor by Distance</button> 
                            </div>
                        </div>
                    </div>
                    <br>

                    <div class="row">
                        <div class="panel panel-bd">
                            <div class="panel-body">
                                <div class="col-md-11">
                                    <section class="search-form">
                                        <form action="" method="post">
                                            <div class="col-sm-3"></div>
                                            <div class="col-sm-3">
                                                <select name="category" class="form-control">
                                                    <option value="" disabled selected>Choose category</option>
                                                    <option value="Smart Phone">Smart Phone</option>
                                                    <option value="Laptop">Laptop</option>
                                                    <option value="Fruit">Fruit</option>
                                                    <option value="Beverage">Beverage</option>
                                                    <option value="Dried Food">Dried Food</option>
                                                    <option value="Shoes">Shoes</option>
                                                    <option value="Clothes">Clothes</option>
                                                    <option value="Hat">Hat</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-3">
                                                <select name="brand[]" class="form-control" name="select" multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="2">
                                                    <option value="Apple">Apple</option>
                                                    <option value="Acer">Acer</option>
                                                    <option value="Samsung">Samsung</option>
                                                    <option value="Vertu">Vertu</option>
                                                    <option value="MSI">MSI</option>
                                                    <option value="Klever Fruit">Klever Fruit</option>
                                                    <option value="Vinamrt">Vinamrt</option>
                                                    <option value="Drinking&Chill">Drinking & Chill</option>
                                                    <option value="Starbucks">Starbucks</option>
                                                    <option value="Street Food Mall">Street Food Mall</option>
                                                    <option value="Nike">Nike</option>
                                                    <option value="Adidas">Adidas</option>
                                                    <option value="LV">LV</option>
                                                </select>
                                            </div>
                                            <div class="col-sm-1">
                                                <button name="submit" value="search" class="form-control btn btn-primary" type="submit">
                                                    <span>Search</span>
                                                </button>
                                            </div>
                                        </form>
                                    </section>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Name</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col" class="text-center">Quantity</th>
                                                    <th scope="col" class="text-center">Vendor ID</th>
                                                    <th scope="col" class="text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            <?php 
                                                if(isset($_POST['submit'])) {
                                                    $category = $_POST['category'];
                                                    $brand_arr = $_POST['brand'];
                                                    foreach($brand_arr as $sub_brand) {
                                                        $document = $collection->find([
                                                            "category" => $category,
                                                            "brand" => $sub_brand
                                                        ]);
                                                        foreach($document as $sub_document) {
                                                            $sql = "SELECT * FROM product WHERE id = '$sub_document->_id';";
                                                            $stmt = $customer->query($sql);
                                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                            echo '<tr>
                                                            <th scope="row">'.$row['id'].'</th>
                                                            <td>'.$row['name'].'</td>
                                                            <td>$'.$row['price'].'</td>
                                                            <td class="text-center">'.$row['quantity'].'</td>
                                                            <td class="text-center">'.$row['ven_id'].'</td>
                                                            <td class="text-center">
                                                            <a href="display_product_detail_customer_page.php?prod_id='.$row['id'].'" class="btn btn-xs btn-default" style="background-color: #3c8dbc; color: White">View</a>
                                                            <a href="orders.php?prod_id='.$row['id'].'" class="btn btn-xs btn-default" style="background-color: #6C9D2F; color: White">Buy</a>
                                                            </td>
                                                            </tr>';
                                                            
                                                        }
                                                    }

                                                }
                                            ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>

        <script src="../assets/jquery/jquery-2.2.3.min.js" type="text/javascript"></script>
        <script src="../assets/jquery/jquery-ui.min.js" type="text/javascript"></script>    
        <script src="../assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../assets/js/plugins/jquery.slimscroll.js" type="text/javascript"></script>
        <script src="../assets/js/plugins/jquery.ui.touch-punch.js.download" type="text/javascript"></script>
        <script src="../assets/js/plugins/app.js.download" type="text/javascript"></script>
        <script src="../assets/js/exec/util.js" type="text/javascript"></script>
        <script src="../assets/js/plugins/bootstrap-dialog.js" type="text/javascript"></script>
        <script src="../assets/js/plugins/bootstrapValidator.js" type="text/javascript"></script>    
        <script src="../assets/js/plugins/select2.js.download" type="text/javascript"></script>
        <script src="../assets/js/plugins/album.js.download" type="text/javascript"></script>
        <script src="../assets/iCheck/icheck.js" type="text/javascript"></script>
        <script src="../assets/js/exec/auth.js" type="text/javascript"></script>
        <script src="https://kit.fontawesome.com/443903aef7.js" crossorigin="anonymous"></script>
        <script src="../assets/js/plugins/multiselect-dropdown.js" type="text/javascript"></script>
    </body>
</html>