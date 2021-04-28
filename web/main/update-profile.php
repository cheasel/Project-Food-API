<?php
include '../main/connectAPI.php';

$url = 'user/update?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e';
$iduser = $_POST['iduser'];
$firstname = $_POST['firstname'];
$lastname = $_POST['lastname'];
$email = $_POST['email'];
#password = hash("md5", $_POST['password']);
#$confirm_password = $_POST['confirm_password'];
$age = $_POST['age'];
$gender = $_POST['gender'];
$height = $_POST['height'];
$weight = $_POST['weight'];
#$medicalproblems = $_POST['medicalproblems'];
$foodallergies = array();

foreach ( $_POST['Foodallergens'] as $data ){
    if ($data == ''){
        
    }else{
        array_push($foodallergies, $data);
    }
}


if( $_FILES['news_filename']['name'] != null){
    $image_ext = pathinfo(basename($_FILES['news_filename']['name']), PATHINFO_EXTENSION);
    $news_image_name = 'prod_'.uniqid().".".$image_ext;
    $image_path = "../image_profile/";
    $image_upload_path = $image_path.$news_image_name;
    $success = move_uploaded_file($_FILES['news_filename']['tmp_name'],$image_upload_path);
}else
    $image_upload_path = '';

/*if ( is_uploaded_file($_FILES['news_filename']['tmp_name']) ) {
    $image_ext = pathinfo(basename($_FILES['news_filename']['name']), PATHINFO_EXTENSION);
    $news_image_name = 'prod_' . uniqid() . "." . $image_ext;
    $image_path = "../image_profile/";
    $image_upload_path = $image_path . $news_image_name;
    $success = move_uploaded_file($_FILES['news_filename']['tmp_name'], $image_upload_path);
    $image = $image_upload_path;
}else{
    $image = $_POST['image'];
}*/

$data_array =  array(
    "id" => $iduser,
    "name" => $firstname,
    "surname" => $lastname,
    "email" => $email,
    "age" => $age,
    "gender" => $gender,
    "image" => $image_upload_path,
    "height" => $height,
    "weight" => $weight,
    "foodallergens" => $foodallergies
);

if ( postAPI($url, json_encode($data_array, true)) == 'true' ){
    header("Location: ../user/dashboard.php");
}else {
    header("Location: ../user/profile.php");
}