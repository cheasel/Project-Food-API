<?php
include 'conectDB.php';

$email = $_POST['email'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

if ($password != $confirm_password) {
    header("Location: ../admin/register.php");
    exit();
}


$sql = "INSERT INTO user (id,email,password) VALUES ('','$email', '$new_password')";

if ($conn->query($sql) === TRUE) {   
    $conn->close();
    header("Location: ../admin/login.php");
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}
