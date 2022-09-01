<?php

require_once '../login_page/db.php';

session_start();

$prod_id = $_GET['prod_id'];

if (isset($_POST['act'])) {

    $quantity = $_POST['quantity'];
    $price = $_POST['price'];
    $category = $_POST['category'];
    $made_in = $_POST['made_in'];
    $description = $_POST['description'];

    $sql = "CALL ven_edit_product($price, $quantity, '$prod_id');";
    $stmt = $vendor->query($sql);
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

    $update_result = $collection->updateOne(
        ['_id' => $prod_id],
        [
            '$set' => [
                'category'=> $category,
                'made_in' => $made_in,
                'description'=> $description
            ]
        ]
    );

   
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
                    <div class="form-group has-feedback">
                        <input name="condition" type="text" class="form-control" placeholder="Condition" required>                    
                    </div>                    
                    <div class="form-group has-feedback">
                        <input name="made_in" type="text" class="form-control" placeholder="Made In" required>                    
                    </div>                    
                    <div class="form-group has-feedback">
                        <textarea name="description" type="text" class="form-control" placeholder="Description" rows="4" cols="50" required></textarea>                    
                    </div>

                    <div class="row">
                        <div class="col-xs-6">
                            <button type="submit" name="act" value="UPDATE" class="btn btn-primary btn-block btn-flat" style="background-color: #6C9D2F;">Edit Product</button>
                        </div>
                        <div class="col-xs-6">
                            <button onclick='window.location.href="vendor_product.php";' class="btn btn-primary btn-block btn-flat" style="background-color: #3c8dbc;">Back To Main Page</button>  
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
