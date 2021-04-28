<?php 
include 'conectDB.php';

$id = $_GET['id'];



$medical_problems = "DELETE FROM medical_problems WHERE id=$id";
$resultmedical_problems = mysqli_query($conn,$medical_problems);


header("Location: ../admin/data-medical-problems.php");
?>