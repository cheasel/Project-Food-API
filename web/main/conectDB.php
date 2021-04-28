<?php
$servername = "localhost";
$username = "root";
$dbname = "api_thaifood";

$password = urlencode('L1verp@@l');

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
#$client = new MongoDB\Client('mongodb+srv://cheasel:$password@preproject.i1n8s.gcp.mongodb.net/test?retryWrites=true&w=majority');

#$db = $client->test;

#echo($db['Food'])


?>