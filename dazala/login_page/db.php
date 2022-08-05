<?php

$user = 'admin';
$pass = 'admin';

global $vendor;

$vendor = new PDO('mysql:host=localhost;dbname=dazala', $user, $pass);

