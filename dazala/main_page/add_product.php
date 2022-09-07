<?php

require_once '../login_page/db.php';

session_start();

$ven_id = $_SESSION['ven_id'];

if (isset($_POST['act'])) {

    $name = $_POST['name'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $category = $_POST['category'];
    $brand = $_POST['brand'];
    $condition = $_POST['condition'];
    $made_in = $_POST['made_in'];
    $description = $_POST['description'];

    $sql_insert = "INSERT INTO product (name, price, quantity, ven_id) VALUES ('$name', $price, $quantity, '$ven_id')";
    $stmt = $vendor->query($sql_insert);
    $rows = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql_get_id = "SELECT id FROM product WHERE ven_id = '$ven_id' ORDER BY id DESC LIMIT 1";
    $stmt_get_id = $vendor->query($sql_get_id);
    $rows_id = $stmt_get_id->fetch(PDO::FETCH_ASSOC);

    $prod_id = $rows_id['id'];

    $insertOneProduct = $collection->insertOne([
        "_id" => $prod_id,
        "category" => $category,
        "brand" => $brand,
        "condition" => $condition,
        "made_in" => $made_in,
        "description" => $description
    ]);

    if ($stmt->rowCount() > 0) {
        echo "<script>
            alert('Product Added Successful');
            window.location.href='vendor_product.php';
        </script>";
    } else {
        echo "<script>
            alert('Product Added Failed');
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
                Add New Product
            </div>
            <div class="login-box-body">
                <div class="alert alert-danger" style="display: none;"></div>
                <div class="form-group has-feedback">
                    <input name="name" type="text" class="form-control" placeholder="Product's Name" autofocus required>                    
                </div>
                <div class="form-group has-feedback">
                    <input name="price" type="decimal" class="form-control" placeholder="Price" required>                    
                </div>
                <div class="form-group has-feedback">
                    <input name="quantity" type="int" class="form-control" placeholder="Quantity" required>                    
                </div>
                <div class="form-group has-feedback">
                    <select name="category" class="form-control">
                        <option value="" disabled selected>Choose One Category</option>
                        <option value="Phone">Phone</option>
                        <option value="Laptop">Laptop</option>
                        <option value="Fruit">Fruit</option>
                        <option value="Beverage">Beverage</option>
                        <option value="Food">Food</option>
                        <option value="Shoes">Shoes</option>
                        <option value="Clothes">Clothes</option>
                        <option value="Hat">Hat</option>
                    </select>
                </div>
                <div class="form-group has-feedback">
                    <select name="brand" class="form-control">
                        <option value="" disabled selected>Choose One Brand/Option</option>
                        <option value="Apple">Apple</option>
                        <option value="Samsung">Samsung</option>
                        <option value="Vertu">Vertu</option>
                        <option value="Msi">MSI</option>
                        <option value="Acer">Acer</option>
                        <option value="Klever Fruit">Klever Fruit</option>
                        <option value="Vinamrt">Vinamrt</option>
                        <option value="Drinking&Chill">Drinking & Chill</option>
                        <option value="Starbucks">Starbucks</option>
                        <option value="Street Food Mall">Street Food Mall</option>
                        <option value="Nike">Nike</option>
                        <option value="Adidas">Adidas</option>
                        <option value="LV">Louis Vouton</option>
                    </select>
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
                        <button type="submit" name="act" value="INSERT" class="btn btn-primary btn-block btn-flat" style="background-color: #6C9D2F;">Add Product</button>
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
</body>
</html>
