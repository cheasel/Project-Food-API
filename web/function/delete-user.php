<?php
include '../main/connectAPI.php';
$url = 'user/delete?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&id='.$_POST['userId'];

$data = deleteAPI($url);
//print_r(json_decode(postAPI($url, json_encode($data_array, true)), true));
header("Location: ../admin/processuser.php");
