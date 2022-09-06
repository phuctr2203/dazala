<?php
    session_start();

    require_once '../login_page/db.php';
    $ven_id = $_SESSION['ven_id'];
    $prod_id = $_GET['prod_id'];

    $sql_display = "SELECT * FROM product WHERE id = '$prod_id'";
    $stmt_display = $customer->query($sql_display);
    $rows_display = $stmt_display->fetch(PDO::FETCH_ASSOC);

    $ven_id = $_SESSION['ven_id'];
    $sql = "SELECT * FROM vendor WHERE id = '$ven_id'";
    $stmt = $vendor->query($sql);
    $row = $stmt->fetch(PDO::FETCH_ASSOC);

    $name_prod_display = $rows_display['name'];
    $quantity_display = $rows_display['quantity'];
    $price_display = $rows_display['price'];
    $venid_display = $rows_display['ven_id'];
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
                        </li>
                        <br>
                        <button onclick='window.location.href="vendor_product.php";' class="btn btn-primary btn-block btn-flat" style="background-color: #3c8dbc;">Back To Main Page</button>
                    </ul>
                    <br>
                    <button onclick='window.location.href="add_product.php";' class="form-control btn btn-primary" style="background-color: #5941A9">Add Product</button> 
                </section>
            </aside>

            <div class="content-wrapper" style="min-height: 696px;">
                <section class="content-header">
                    <h1 class="title">Product Detail</h1>
                </section>
                <section class="content">
                    <div class="row">
                        <div class="panel panel-bd">
                            <div class="panel-heading">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="col-sm-6">
                                            <?php
                                                echo "<h2>$name_prod_display</h2>"
                                            ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="panel-body">
                                <div class="box">
                                    <div class="box-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="col-sm-4">
                                                    <?php
                                                        $document = $collection->findOne(
                                                            ['_id' => $prod_id]
                                                        );

                                                        echo
                                                        "Quantity: $quantity_display<br>
                                                        Price: $price_display<br>
                                                        Product ID: $prod_id<br>";

                                                        echo '<a href="edit_product.php?prod_id='.$prod_id.'" class="btn btn-md btn-default" style="background-color: #3c8dbc; color: White">Edit Product</a>';
                                                    ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?php
                                                        echo "Category: ", $document->category, "<br>";
                                                        echo "Brand: ", $document->brand, "<br>";
                                                        echo  "Condition: ", $document->condition, "<br>";
                                                        echo "Made In: ", $document->made_in, "<br>";
                                                    ?>
                                                </div>
                                                <div class="col-sm-4">
                                                    <?php
                                                        echo "Description: ",$document->description;
                                                    ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div>
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

<div class="col-xs-6">
    <button onclick='window.location.href="vendor_product.php";' class="btn btn-primary btn-block btn-flat" style="background-color: #3c8dbc;">Back To Main Page</button>  
</div>  