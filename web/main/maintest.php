<?php

include 'conectDB.php';


$image_ext = pathinfo(basename($_FILES['news_filename']['name']), PATHINFO_EXTENSION);
$news_image_name = 'prod_'.uniqid().".".$image_ext;
$image_path = "../image_food/";
$image_upload_path = $image_path.$news_image_name;
$success = move_uploaded_file($_FILES['news_filename']['tmp_name'],$image_upload_path);
if ($success==false) {
        echo "ไม่สามรถอัพโหลดไฟล์ได้";
        exit();
}

$sql = "INSERT INTO menu (image,time_update) VALUES ('$news_image_name',CURRENT_TIMESTAMP)";
$result = mysqli_query($conn, $sql);

if ($result) {
        echo "บันทึกข้อมูลเรียบร้อย";
}else{
        echo "เกิดข้อผิดพลาด ". mysqli_error($conn);
}

// $path = "/img/food/";

// echo "Path : $path";

// require "$path";
// header("../image_food/fuck.php")


?>