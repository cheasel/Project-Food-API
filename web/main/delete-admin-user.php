<?php 
include 'conectDB.php';

$id = $_GET['id'];

$sqldeleteuser = "DELETE FROM user WHERE id=$id";
$sqldeletemenu = "DELETE FROM menu WHERE user_id=$id";
$sqldeleteingredients = "DELETE FROM ingredients WHERE user_id=$id";
$sqldeletepreparation = "DELETE FROM preparation WHERE user_id=$id";
$sqldeletemedical_problems = "DELETE FROM medical_problems WHERE user_id=$id";
$sqldeletefood_allergies = "DELETE FROM food_allergies WHERE user_id=$id";
$sqldeletecalories = "DELETE FROM calories WHERE user_id=$id";

$resultuser = mysqli_query($conn,$sqldeleteuser);
$resultmenu = mysqli_query($conn,$sqldeletemenu);
$resultingredients = mysqli_query($conn,$sqldeleteingredients);
$resultpreparation = mysqli_query($conn,$sqldeletepreparation);
$resultmedical_problems = mysqli_query($conn,$sqldeletemedical_problems);
$resultfood_allergies = mysqli_query($conn,$sqldeletefood_allergies);
$resultdeletecalories = mysqli_query($conn,$sqldeletecalories);


header("Location: ../admin/processuser.php");
?>