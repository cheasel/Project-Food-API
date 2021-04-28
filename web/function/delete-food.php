<?php
include '../main/connectAPI.php';
$url = 'menu/delete?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&id='.$_POST['foodId'];

$data = deleteAPI($url);
//print_r(json_decode(postAPI($url, json_encode($data_array, true)), true));
#header("Location: ../admin/allfood.php");
if($_POST["status"] == "Admin")
    header("Location: ../admin/allfood.php");
elseif($_POST["status"] == "User")
    header("Location: ../user/main-food.php");
else
    header("Location: ../auth/login.php");