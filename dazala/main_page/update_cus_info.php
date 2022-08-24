<?php

require_once '../login_page/db.php';

session_start();

$id = $_SESSION['cus_id'];

$sql_old = "SELECT * FROM customer WHERE id = '$id'";
$stmt_old = $customer->query($sql_old);
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

    $sql = "UPDATE customer SET name = '$name', address = '$address', latitude = '$latitude', longtitude = '$longtitude', password = '$password' WHERE id = '$id';";
    $stmt = $customer->query($sql);
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($stmt->rowCount() > 0) {
        echo "<script>
            alert('Information Editted Successful');
            window.location.href='homepage.php';
        </script>";
    } else {
        echo "<script>
            alert('Information Editted Failed');
            window.location.href='homepage.php';
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

<body class="hold-transition login-page">
    <form id="baseform" method="post"  role="form">
        <div class="login-box">
            <div class="login-logo">
                Edit Vendor Information
            </div>
            <div class="login-box-body">
                <div class="alert alert-danger" style="display: none;"></div>
                <div class="form-group has-feedback">
                    <input name="name" type="text" class="form-control" placeholder="Name">                    
                </div>
                <div class="form-group has-feedback">
                    <input name="address" type="text" class="form-control" placeholder="Address">                    
                </div>
                <div class="form-group has-feedback">
                    <input name="latitude" type="decimal" class="form-control" placeholder="Latitude">                    
                </div>
                <div class="form-group has-feedback">
                    <input name="longtitude" type="decimal" class="form-control" placeholder="Longtitude">                    
                </div>
                <div class="form-group has-feedback">
                    <input name="password" type="text" class="form-control" placeholder="Password">                    
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <button type="submit" name="act" value="UPDATE" class="btn btn-primary btn-block btn-flat" style="background-color: maroon;">Edit Information</button>
                    </div>
                    <div class="col-xs-6">
                        <button onclick='window.location.href="homepage.php";' class="btn btn-primary btn-block btn-flat" style="background-color: blue;">Back To Main Page</button>  
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
</body>
</html>