<?php 
include 'conectDB.php';

$id = $_GET['id'];



$food_allergies = "DELETE FROM food_allergies WHERE id=$id";
$resultfood_allergies = mysqli_query($conn,$food_allergies);


header("Location: ../admin/data-food-allergies.php");
?>