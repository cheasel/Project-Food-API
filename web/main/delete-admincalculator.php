<?php 
include 'conectDB.php';

echo $id = $_GET['id'];



$calories = "DELETE FROM calories WHERE id=$id";
$resultmenu = mysqli_query($conn,$calories);


header("Location: ../admin/data-bmr-calculator.php");
?>