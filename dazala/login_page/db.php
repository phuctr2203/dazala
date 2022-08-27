<?php

$ven_user = 'vendor';
$ven_pass = 'vendor';

$cus_user = 'customer';
$cus_pass = 'customer';

$ship_user = 'shipper';
$ship_pass = 'shipper';

global $vendor;
global $customer;
global $shipper;

$vendor = new PDO('mysql:host=localhost;dbname=dazala', $ven_user, $ven_pass);
$customer = new PDO('mysql:host=localhost;dbname=dazala', $cus_user, $cus_pass);
$shipper = new PDO('mysql:host=localhost;dbname=dazala', $ship_user, $ship_pass);

$sql_vendor = "SET DEFAULT ROLE vendor TO vendor@localhost;";
$stmt_vendor = $vendor->query($sql_vendor);

$sql_customer = "SET DEFAULT ROLE customer TO customer@localhost;";
$stmt_customer = $customer->query($sql_customer);

$sql_shipper= "SET DEFAULT ROLE shipper TO shipper@localhost;";
$stmt_shipper = $shipper->query($sql_shipper);

?>
