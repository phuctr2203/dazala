<?php

include_once("../vendor/autoload.php");

$ven_user = 'vendor';
$ven_pass = 'vendor';


$cus_user = 'customer';
$cus_pass = 'customer';



$ship_user = 'shipper';
$ship_pass = 'shipper';

global $vendor;
global $customer;
global $shipper;
global $collection;

$vendor = new PDO('mysql:host=localhost;dbname=dazala', $ven_user, $ven_pass);
$customer = new PDO('mysql:host=localhost;dbname=dazala', $cus_user, $cus_pass);
$shipper = new PDO('mysql:host=localhost;dbname=dazala', $ship_user, $ship_pass);

$link_cus = mysqli_connect('localhost', 'customer', 'customer', 'dazala');

$link_ven = mysqli_connect('localhost', 'vendor', 'vendor', 'dazala');

$link_ship = mysqli_connect('localhost', 'shipper', 'shipper', 'dazala');

$sql_vendor = "SET DEFAULT ROLE vendor TO vendor@localhost";
$stmt_vendor = $vendor->query($sql_vendor);

$sql_customer = "SET DEFAULT ROLE customer TO customer@localhost";
$stmt_customer = $customer->query($sql_customer);

$sql_shipper= "SET DEFAULT ROLE shipper TO shipper@localhost";
$stmt_shipper = $shipper->query($sql_shipper);

$client = new MongoDB\Client("mongodb://localhost:27017");
$collection = $client->dazala->dazala;

?>
