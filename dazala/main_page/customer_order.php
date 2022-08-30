<?php
    require_once '../login_page/db.php';

    session_start();

    $cus_id = $_SESSION['cus_id'];
    $sql = "SELECT * FROM customer WHERE id = '$cus_id'";
    $stmt = $customer->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
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
                            <button onclick='window.location.href="history_order.php";' class="form-control btn btn-primary" style="background-color: #5941A9">Check Orders History</button> 
                        </li>
                        <br>
                        <button onclick='window.location.href="homepage.php";' class="form-control btn btn-primary" style="background-color: blue;">Back To Main Page</button>  
                    </ul>
                </section>
            </aside>

            <div class="content-wrapper" style="min-height: 696px;">
                <section class="content-header">
                    <h1 class="title">Your Current Orders</h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="box">
                                <div class="box-body">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-hover">
                                            <thead>
                                                <tr>
                                                    <th scope="col">ID</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Bill</th>
                                                    <th scope="col">Receiver</th>
                                                    <th scope="col">Address</th>
                                                    <th scope="col">Distribute Hub</th>
                                                    <th scope="col">Product</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $sql_show_orders = "SELECT * FROM orders WHERE orders_status = 'Ready' AND cus_id = '$cus_id';";
                                                    $rows = $customer->query($sql_show_orders);

                                                    foreach($rows as $row) {
                                                        $id = $row['id'];
                                                        $status = $row['orders_status'];
                                                        $bill = $row['bill'];
                                                        $quantity = $row['quantity'];
                                                        $cus_id = $row['cus_id'];
                                                        $hub_id = $row['hub_id'];
                                                        $prod_id = $row['prod_id'];

                                                        $sql_get_cus_name = "SELECT name FROM customer WHERE id = '$cus_id';";
                                                        $stmt_cus_name = $customer->query($sql_get_cus_name);
                                                        $row_cus_name = $stmt_cus_name->fetch(PDO::FETCH_ASSOC);
                                                        $cus_name = $row_cus_name['name'];

                                                        $sql_get_cus_address = "SELECT * FROM customer WHERE id = '$cus_id';";
                                                        $stmt_cus_address = $customer->query($sql_get_cus_address);
                                                        $row_cus_address = $stmt_cus_address->fetch(PDO::FETCH_ASSOC);
                                                        $cus_address = $row_cus_address['address'];

                                                        $sql_get_hub_name = "SELECT * FROM hub WHERE id = '$hub_id';";
                                                        $stmt_hub_name = $shipper->query($sql_get_hub_name);
                                                        $row_hub_name = $stmt_hub_name->fetch(PDO::FETCH_ASSOC);
                                                        $hub_name = $row_hub_name['name'];

                                                        $sql_get_product_name = "SELECT name FROM product WHERE id = '$prod_id';";
                                                        $stmt_product_name = $customer->query($sql_get_product_name);
                                                        $row_product_name = $stmt_product_name->fetch(PDO::FETCH_ASSOC);
                                                        $prod_name = $row_product_name['name'];

                                                        echo '<tr>
                                                        <th scope="row">'.$id.'</th>
                                                        <td>'.$status.'</td>
                                                        <td>$'.$bill.'</td>
                                                        <td>'.$cus_name.'</td>
                                                        <td>'.$cus_address.'</td>
                                                        <td>'.$hub_name.'</td>
                                                        <td>'.$prod_name.'</td>
                                                        </tr>';
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
    </body>
</html>