<?php
include 'conectDB.php';

$namefood = $_POST['namefood'];
$medical_problems = $_POST['medical_problems'];
$namefood_allergies1 = $_POST['namefood_allergies1'];

if (isset($_POST['namefood'])) {
    $namefood = $_POST['namefood'];
    $sqlmenu = "SELECT * FROM menu WHERE title LIKE '$namefood%'";
    $resultmenu = $conn->query($sqlmenu);
    header("Location: ../user/profile.php");
}

// $sqlmenu = "SELECT * FROM menu JOIN ingredients ON menu.id=ingredients.menu_id WHERE title LIKE '$namefood%'";
// $resultmenu = $conn->query($sqlmenu);

// $sqlmenu2 = "SELECT * FROM menu WHERE title LIKE '$namefood%'";
// $resultmenu2 = $conn->query($sqlmenu2);


// $selectcheack = array();
// while ($rowmenu = $resultmenu->fetch_assoc()) {
//     if (strpos($rowmenu['name_ingredients'], $namefood_allergies1) !== false) {
//         echo "id = " . $rowid = $rowmenu['id'];
//         echo '<br>';
//         echo "menu_id = " . $rowmenu_id = $rowmenu['menu_id'];
//         echo '<br>';
//         $sqlmenuselect1 = "SELECT * FROM menu JOIN ingredients ON menu.id=ingredients.menu_id WHERE menu_id=$rowmenu_id";
//         $resultmenuselect1 = $conn->query($sqlmenuselect1);
//         $selectcheack[] = $rowmenu["menu_id"];
//     }
// }

// $USEselectcheack = array_unique($selectcheack);
// echo '<br>';
// while ($rowmenuaa = $resultmenuselect1->fetch_assoc()) {

//     echo $rowmenuaa['menu_id'];
//     echo $rowmenuaa['title'];
//     echo '<br>';
//     echo $rowmenuaa['id'];
//     echo $rowmenuaa['name_ingredients'];
//     echo '<br>';
// }
// echo '<br>';
// print_r($selectcheack);
// echo '<br>';
// foreach ($USEselectcheack as $key1 => $value1) {
//     echo '<br>';
//     echo $key1;
//     echo $value1;
// }
// echo '<br>';
// foreach ($USEselectcheack as $key1 => $value1) {
//     echo '<br>';
//     echo $key1;
//     echo $value1;
// }
// echo '<br>';
// echo '<br>';
// while ($rowmenu = $resultmenu2->fetch_assoc()) {

//     echo $rowmenu['id'];
//     echo $rowmenu['title'];
//     echo '<br>';
// }








// while ($rowmenu = $resultmenu->fetch_assoc()) {
//     if (strpos($rowmenu['title'], '$namefood') !== false) {
//         $selectmenu = $rowmenu['title'];

//         $sql_selectmenu = "SELECT * FROM menu WHERE title=$selectmenu";
//         $result_selectmenu = $conn->query($sql_selectmenu);
//         break;
//     }
// }
// echo $result_selectmenu;

// while ($rowselectmenu = $result_selectmenu->fetch_assoc()) {
//     $id = $rowselectmenu['id'];
//     $title = $rowselectmenu['title']; 
//     $rowselectmenu['Additional_explanation'];
//     $rowselectmenu['time_update'];
// }

// $sql = "SELECT * FROM ingredients WHERE menu_id=$idmenu";
// $resultt = $conn->query($sql);

// $a = 'Howareyouแกงเขียวหวานaaaaaaaaaa?';

// if (strpos($a, 'แกงเขียวหวาน') !== false) {
//     echo 'true';
// }
