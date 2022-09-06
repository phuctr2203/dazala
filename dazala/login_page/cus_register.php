<?php

require_once 'db.php';

session_start();

if (isset($_POST['act'])) {

    $name = $_POST['name'];
    $address = $_POST['address'];
    $latitude = $_POST['latitude'];
    $longtitude = $_POST['longtitude'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "INSERT INTO customer(name, address, latitude, longtitude, username, password)
    VALUES ('$name', '$address', $latitude, $longtitude, '$username', '$password')";
    
    $stmt = $customer->query($sql);
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($stmt->rowCount() > 0) {
        echo '<script>
            alert("Register Successfully");
            window.location.href="login.php";
        </script>';
    } else {
        echo '<script>
            alert("Register Failed");
            window.location.href="login_page/cus_register.php";
        </script>';
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <link rel="icon" type="image/png" href="../../assets/images/icon-title.png" />
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
    <form id="baseform" method="post"  role="form">
        <div class="login-box">
            <div class="login-logo">
                Register To Dazala Customer
            </div>
            <div class="login-box-body">
                <div class="alert alert-danger" style="display: none;"></div>
                <div class="form-group has-feedback">
                    <input name="name" type="text" class="form-control" placeholder="Name" required>                    
                </div>
                <div class="form-group has-feedback">
                    <input name="address" type="text" class="form-control" placeholder="Address" required>                    
                </div>
                <div class="form-group has-feedback">
                    <input name="latitude" type="text" class="form-control" placeholder="Latitude" required>                    
                </div>
                <div class="form-group has-feedback">
                    <input name="longtitude" type="text" class="form-control" placeholder="Longtitude" required>                    
                </div>
                <div class="form-group has-feedback">
                    <input name="username" type="text" class="form-control" placeholder="Username" required>                    
                </div>
                <div class="form-group has-feedback">
                    <input name="password" type="text" class="form-control" placeholder="Password" required>                    
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <button type="submit" name="act" value="INSERT" class="btn btn-primary btn-block btn-flat" style="background-color: maroon;">Register</button>
                    </div>
                    <div class="col-xs-6">
                        <button onclick='window.location.href="login.php";' class="btn btn-primary btn-block btn-flat" style="background-color: blue;">Sign In</button>  
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