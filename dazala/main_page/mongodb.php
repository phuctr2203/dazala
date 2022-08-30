<?php

include_once("../vendor/autoload.php");

echo "Check point 1 -- Before connection<br>";
$client = new MongoDB\Client("mongodb://localhost:27017");

echo "Check point 2 -- After connection<br>";

$collection = $client->dazala->dazala;

$document = $collection->findOne(
    ['_id' => 'PD001']
);

echo $document->category ;

?>