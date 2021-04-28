<?php

include 'conectDB.php';

$iduser = $_POST['iduser'];
$gender = $_POST['gender'];
$height = $_POST['height'];
$weight = $_POST['weight'];
$age = $_POST['age'];

if ($gender=="male"&&$height!=""&&$weight!=""&&$age!="") {
    $bmr = 66+(13.7*$weight) + (5*$height)-(6.8*$age);
    echo $bmr;
}elseif ($gender=="female"&&$height!=""&&$weight!=""&&$age!="") {
    $bmr = 665+(9.6*$weight) + (1.8*$height)-(4.7*$age);
    echo $bmr;
}


$sql = "INSERT INTO calories (user_id,calories,gender,time) VALUES ('$iduser','$bmr','$gender',CURRENT_TIMESTAMP)";
if ($conn->query($sql) === TRUE) {
    header("Location: ../user/bmr-calculator.php");
} else {
    echo "Error updating record: " . $conn->error;
}


?>