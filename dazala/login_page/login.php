<?php

require_once 'db.php';

if (isset($_POST['act'])) {
    session_start();
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];
    $_SESSION['username'] = $username;

    $sql = "SELECT * FROM $role WHERE username = '$username'";

    if ($role == 'vendor') {
        $stmt = $vendor->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $row_password_hash = password_hash($row['password'], PASSWORD_DEFAULT);

        if ($row && password_verify($password, $row_password_hash)) {
            echo "<script>
               alert('Login Successfully!');
               window.location.href='../main_page/vendor_product.php';
            </script>";

            $_SESSION['ven_id'] = $row['id'];
       } else {
           echo '<script>
               alert("Login Failed");
               window.location.href="login.php";
           </script>';
       }
    } else if ($role == 'customer') {
        $stmt = $customer->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC); 
        $row_password_hash = password_hash($row['password'], PASSWORD_DEFAULT);

        if ($row && password_verify($password, $row_password_hash)) {
            echo "<script>
               alert('Login Successfully!');
               window.location.href='../main_page/homepage.php';
            </script>";

            $_SESSION['cus_latitude'] = $row['latitude'];
            $_SESSION['cus_longtitude'] = $row['longtitude'];
            $_SESSION['cus_id'] = $row['id'];
            
       } else {
           echo '<script>
               alert("Login Failed");
               window.location.href="login.php";
           </script>';
       }
    } else if ($role == 'shipper') {
        $stmt = $shipper->query($sql);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $row_password_hash = password_hash($row['password'], PASSWORD_DEFAULT);

        if ($row && password_verify($password, $row_password_hash)) {
            echo "<script>
               alert('Login Successfully!');
               window.location.href='../main_page/shipper_page.php';
            </script>";

            $_SESSION['ship_id'] = $row['id'];
       } else {
           echo '<script>
               alert("Login Failed");
               window.location.href="login.php";
           </script>';
       }
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
    <link href="../assets/font-awesome-4.7.0/css/font-awesome.css" rel="stylesheet" type="text/css" />    
    <link href="../assets/ionicons-2.0.1/css/ionicons.css" rel="stylesheet" type="text/css" />        
    <link href="../assets/css/plugins/bootstrap-dialog.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/plugins/bootstrapValidator.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />
    <link href="../assets/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <link href="../assets/css/style.css" rel="stylesheet" type="text/css" />
</head>

<body class="hold-transition login-page">
    <form id="baseform" method="post" role="form">
        <div class="login-box">
            <div class="login-logo">
                Sign In To Dazala
            </div>
            <div class="login-box-body">
                <div class="alert alert-danger" style="display: none;"></div>
                <div class="form-group has-feedback">
                    <input name="username" type="text" class="form-control" placeholder="Username" autofocus required>                    
                </div>
                <div class="form-group has-feedback">
                    <input name="password" type="password" class="form-control" placeholder="Password" required>                    
                </div>
                <div class="row">
                    <div class="col-xs-4">
                        <input type="radio" name="role" value="vendor" autofocus required>Vendor</input>
                    </div>
                    <div class="col-xs-4">
                        <input type="radio" name="role" value="customer" required>Customer</input>
                    </div>
                    <div class="col-xs-4">
                        <input type="radio" name="role" value="shipper" required>Shipper</input>
                    </div>
                </div>
                <br>
                <div class="row">
                    <div class="col-xs-6">
                        <button type="submit" name="act" value="Login" class="btn btn-primary btn-block btn-flat" style="background-color: maroon;">Login</button>
                    </div>
                    <div class="col-xs-6">
                        <button onclick='window.location.href="../login_page/register/pre_register.php";' class="btn btn-primary btn-block btn-flat" style="background-color: blue;">Register</button>  
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="../assets/jquery/jquery-2.2.3.min.js" type="text/javascript"></script>
    <script src="../assets/jquery/jquery-ui.min.js" type="text/javascript"></script>    
    <script src="../assets/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <script src="../assets/js/plugins/jquery.slimscroll.js" type="text/javascript"></script>
    <script src="../assets/js/plugins/bootstrap-dialog.js" type="text/javascript"></script>
    <script src="../assets/js/plugins/bootstrapValidator.js" type="text/javascript"></script>    
    <script src="../assets/js/exec/util.js" type="text/javascript"></script>
    <script src="../assets/iCheck/icheck.js" type="text/javascript"></script>
    <script src="../assets/js/exec/auth.js" type="text/javascript"></script>
</body>
</html>
