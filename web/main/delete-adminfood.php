<?php 
include 'conectDB.php';

echo $id = $_GET['id'];

$sqlimg = "SELECT image FROM menu WHERE id=$id";
$resultimg = $conn->query($sqlimg);
$newimg = mysqli_fetch_row($resultimg);
$filename = $newimg[0];

unlink('../image_food/'.$filename);
    
$sqldeletemenu = "DELETE FROM menu WHERE id=$id";
$sqldeleteingredients = "DELETE FROM ingredients WHERE menu_id=$id";
$sqldeletepreparation = "DELETE FROM preparation WHERE menu_id=$id";
$resultmenu = mysqli_query($conn,$sqldeletemenu);
$resultingredients = mysqli_query($conn,$sqldeleteingredients);
$resultpreparation = mysqli_query($conn,$sqldeletepreparation);


header("Location: ../admin/allfood.php");
