<?php
include 'connectAPI.php';
$url = 'add-recipe?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e';

function randHash($len=32)
{
	return substr(md5(openssl_random_pseudo_bytes(20)),-$len);
}

$iduser = $_POST['iduser'];
$title = $_POST['namefood'];
$serve = $_POST['serve'];
$description = $_POST['Additional_explanation'];
$ingredients = array( ['name' => '', 'value' => '', 'unit' => ''] );
$process = array();

for($i=0; $i < count($_POST['ingredient']); $i++) {
    $ingredients[$i]['name'] = $_POST['ingredient'][$i];
    $ingredients[$i]['value'] = $_POST['value'][$i];
    $ingredients[$i]['unit'] = $_POST['unit'][$i];
}
for($i=0; $i < count($_POST['process']); $i++) {
    array_push($process, $_POST['process'][$i]);
}

$image_ext = pathinfo(basename($_FILES['news_filename']['name']), PATHINFO_EXTENSION);
$news_image_name = 'recipe_'.uniqid().".".$image_ext;
$image_path = "../image_food/";
$image_upload_path = $image_path.$news_image_name;
$success = move_uploaded_file($_FILES['news_filename']['tmp_name'],$image_upload_path);

$data_array =  array(
    "title" => $title,
    "serve" => $serve,
    "description" => $description,
    "ingredients" => $ingredients,
    "preparations" => $process,
    "image" => $news_image_name,
    "user" => $iduser
);

$data = json_decode(postAPI($url, json_encode($data_array, true)));

#print_r(json_decode(postAPI($url, json_encode($data_array, true)), true));

#header("Location: ../admin/addfood-admin.php");
if($_POST["status"] == "Admin")
    header("Location: ../admin/allfood.php");
elseif($_POST["status"] == "User")
    header("Location: ../user/main-food.php");
else
    header("Location: ../auth/login.php");
