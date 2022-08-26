<?php

require_once '../login_page/db.php';

session_start();

$id = $_SESSION['ven_id'];

$sql_old = "SELECT * FROM vendor WHERE id = '$id'";
$stmt_old = $vendor->query($sql_old);
$rows_old = $stmt_old->fetch(PDO::FETCH_ASSOC);

$old_name = $rows_old['name'];
$old_address = $rows_old['address'];
$old_latitude = $rows_old['latitude'];
$old_longtitude = $rows_old['longtitude'];
$old_password = $rows_old['password'];

if (isset($_POST['act'])) {

    $name = $_POST['name'];
    $address = $_POST['address'];
    $latitude = $_POST['latitude'];
    $longtitude = $_POST['longtitude'];
    $password = $_POST['password'];

    if ($name == NULL) {
        $name = $old_name;
    }
    if ($address == NULL) {
        $address = $old_address;
    }
    if ($latitude == NULL) {
        $latitude = $old_latitude;
    }
    if ($longtitude == NULL) {
        $longtitude = $old_longtitude;
    }
    if ($password == NULL) {
        $password = $old_password;
    }

    $sql = "UPDATE vendor SET name = '$name', address = '$address', latitude = '$latitude', longtitude = '$longtitude', password = '$password' WHERE id = '$id';";
    $stmt = $vendor->query($sql);
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        echo "<script>
            alert('Information Editted Successful');
            window.location.href='vendor_product.php';
        </script>";
    } else {
        echo "<script>
            alert('Information Editted Failed');
            window.location.href='vendor_product.php';
        </script>";
    }
}

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

    <body class="hold-transition login-page">
        <form id="baseform" method="post"  role="form">
            <div class="login-box">
                <div class="login-logo">
                    Edit Vendor's Information
                </div>
                <div class="login-box-body">
                    <div class="alert alert-danger" style="display: none;"></div>
                    <div class="form-group has-feedback">
                        <input name="name" type="text" class="form-control" placeholder="Name" autofocus required>                    
                    </div>
                    <div class="form-group has-feedback">
                        <input name="address" type="text" class="form-control" placeholder="Address" required>                    
                    </div>
                    <div class="form-group has-feedback">
                        <input name="latitude" type="decimal" class="form-control" placeholder="Latitude" required>                    
                    </div>
                    <div class="form-group has-feedback">
                        <input name="longtitude" type="decimal" class="form-control" placeholder="Longtitude" required>                    
                    </div>
                    <div class="form-group has-feedback">
                        <input name="password" type="text" class="form-control" placeholder="Password" required>                    
                    </div>
                    <div class="row">
                        <div class="col-xs-6">
                            <button type="submit" name="act" value="UPDATE" class="btn btn-primary btn-block btn-flat" style="background-color: Green;">Edit Information</button>
                        </div>
                        <div class="col-xs-6">
                            <button onclick='window.location.href="vendor_product.php";' class="btn btn-primary btn-block btn-flat" style="background-color: blue;">Back To Main Page</button>  
                        </div>
                    </div>
                </div>
            </div>
        </form>
        <script src="../../assets/jquery/jquery-2.2.3.min.js" type="text/javascript"></script>
        <script src="../../assets/jquery/jquery-ui.min.js" type="text/javascript"></script>    
        <script src="../../assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
        <script src="../../assets/js/plugins/jquery.slimscroll.js" type="text/javascript"></script>
        <script src="../../assets/js/plugins/bootstrap-dialog.js" type="text/javascript"></script>
        <script src="../../assets/js/plugins/bootstrapValidator.js" type="text/javascript"></script>    
        <script src="../../assets/js/exec/util.js" type="text/javascript"></script>
        <script src="../../assets/iCheck/icheck.js" type="text/javascript"></script>
        <script src="../../assets/js/exec/auth.js" type="text/javascript"></script>
        <script src="https://kit.fontawesome.com/443903aef7.js" crossorigin="anonymous"></script>
    </body>
</html>