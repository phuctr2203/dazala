<?php

require_once '../login_page/db.php';

session_start();

$prod_id = $_GET['prod_id'];

if (isset($_POST['act'])) {

    $quantity = $_POST['quantity'];
    $price = $_POST['price'];

    $sql = "CALL ven_edit_product($price, $quantity, '$prod_id');";
    $stmt = $vendor->query($sql);
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

   
    echo "<script>
        alert('Product Editted Successful');
        window.location.href='vendor_product.php';
    </script>";

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
                Edit Product
            </div>
            <div class="login-box-body">
                <div class="alert alert-danger" style="display: none;"></div>
                <div class="form-group has-feedback">
                    <input name="quantity" type="integer" class="form-control" placeholder="Quantity" required>                    
                </div>
                <div class="form-group has-feedback">
                    <input name="price" type="decimal" class="form-control" placeholder="Price" required>                    
                </div>
                <div class="row">
                    <div class="col-xs-6">
                        <button type="submit" name="act" value="UPDATE" class="btn btn-primary btn-block btn-flat" style="background-color: maroon;">Edit Product</button>
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
</body>
</html>