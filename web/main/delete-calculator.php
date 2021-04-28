<?php 
include 'conectDB.php';

$id = $_GET['id'];



$calories = "DELETE FROM calories WHERE id=$id";
$resultmenu = mysqli_query($conn,$calories);


header("Location: ../user/bmr-calculator.php");
?>