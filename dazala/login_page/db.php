<?php

$ven_user = 'vendor';
$ven_pass = 'vendor';

$cus_user = 'customer';
$cus_pass = 'customer';

global $vendor;
global $customer;

$vendor = new PDO('mysql:host=localhost;dbname=dazala', $ven_user, $ven_pass);
$customer = new PDO('mysql:host=localhost;dbname=dazala', $cus_user, $cus_pass);



