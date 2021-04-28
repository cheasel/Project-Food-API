<?php
include 'conectDB.php';

$idmenu = $_POST['idmenu'];
$iduser = $_POST['iduser'];
$namefood = $_POST['namefood'];
$Additional_explanation = $_POST['Additional_explanation'];
$region = $_POST['region'];
$serve = $_POST['serve'];

if (is_uploaded_file($_FILES['news_filename']['tmp_name'])) {
    // Delete old image
    $sql_select = "SELECT image FROM menu WHERE id=$idmenu";
    $resultimg = $conn->query($sql_select);
    $rowimg = mysqli_fetch_assoc($resultimg);
    $img_old = $rowimg['image'];
    unlink('../image_food/' . $img_old);
    // Upload new image
    $image_ext = pathinfo(basename($_FILES['news_filename']['name']), PATHINFO_EXTENSION);
    $news_image_name = 'prod_' . uniqid() . "." . $image_ext;
    $image_path = "../image_food/";
    $image_upload_path = $image_path . $news_image_name;
    $success = move_uploaded_file($_FILES['news_filename']['tmp_name'], $image_upload_path);
    $sqlimg = "UPDATE menu SET image='$news_image_name' WHERE id=$idmenu";
    $conn->query($sqlimg);
}

// ------- ค้นหา fristname lastname เพื่อเอาไปเก็บ reference -----------------
$sql = "SELECT * FROM user WHERE id=$iduser";
$result = $conn->query($sql);
while ($row = $result->fetch_assoc()) {
    $email = $row["email"];
    $fristname = $row["fristname"];
    $lastname = $row["lastname"];
    $status = $row["status"];
}
do {
    // -------- update profile เก็บ reference เป็น fristname lastname ------------------
    if (isset($fristname) && isset($lastname) && ($fristname != "") && ($lastname != "")) {
        $reference = $fristname . $lastname;
        $sql = "UPDATE menu SET user_id='$iduser',title='$namefood',Additional_explanation='$Additional_explanation',region='$region',
        serve='$serve',reference='$reference' WHERE id=$idmenu";
        $conn->query($sql);

        break;

        // -------- ยังไม่ได้ update profile เก็บ reference เป็น email ------------------
    } elseif (isset($email) && ($email != "")) {
        $reference = $email;
        $sql2 = "UPDATE menu SET user_id='$iduser',title='$namefood',Additional_explanation='$Additional_explanation',region='$region',
        serve='$serve',reference='$reference' WHERE id=$idmenu";
        $conn->query($sql2);

        break;
    }
} while (0);


// ----------- Ingredient -----------

$sql = "SELECT * FROM ingredients WHERE menu_id=$idmenu";
$result = $conn->query($sql);
$idArrayIngre = array();
$i = 1;
while ($row = $result->fetch_assoc()) {
    $idArrayIngre[$i] = $row["id"];
    $i++;
}

do {
    if (!isset($_POST['nameIngredient1'])) {
        break;
    } else if (isset($_POST['nameIngredient1'])) {
        $nameIngredient1 = $_POST['nameIngredient1'];
        $valueIngre1 = $_POST['valueIngre1'];
        $unit1 = $_POST['unit1'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient1',value='$valueIngre1',
        unit='$unit1' WHERE id=$idArrayIngre[1]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient2'])) {
        break;
    } else if (isset($_POST['nameIngredient2'])) {
        $nameIngredient2 = $_POST['nameIngredient2'];
        $valueIngre2 = $_POST['valueIngre2'];
        $unit2 = $_POST['unit2'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient2',value='$valueIngre2',
        unit='$unit2' WHERE id=$idArrayIngre[2]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient3'])) {
        break;
    } else if (isset($_POST['nameIngredient3'])) {
        $nameIngredient3 = $_POST['nameIngredient3'];
        $valueIngre3 = $_POST['valueIngre3'];
        $unit3 = $_POST['unit3'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient3',value='$valueIngre3',
        unit='$unit3' WHERE id=$idArrayIngre[3]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient4'])) {
        break;
    } else if (isset($_POST['nameIngredient4'])) {
        $nameIngredient4 = $_POST['nameIngredient4'];
        $valueIngre4 = $_POST['valueIngre4'];
        $unit4 = $_POST['unit4'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient4',value='$valueIngre4',
        unit='$unit4' WHERE id=$idArrayIngre[4]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient5'])) {
        break;
    } else if (isset($_POST['nameIngredient5'])) {
        $nameIngredient5 = $_POST['nameIngredient5'];
        $valueIngre5 = $_POST['valueIngre5'];
        $unit5 = $_POST['unit5'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient5',value='$valueIngre5',
        unit='$unit5' WHERE id=$idArrayIngre[5]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient6'])) {
        break;
    } else if (isset($_POST['nameIngredient6'])) {
        $nameIngredient6 = $_POST['nameIngredient6'];
        $valueIngre6 = $_POST['valueIngre6'];
        $unit6 = $_POST['unit6'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient6',value='$valueIngre6',
        unit='$unit6' WHERE id=$idArrayIngre[6]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient7'])) {
        break;
    } else if (isset($_POST['nameIngredient7'])) {
        $nameIngredient7 = $_POST['nameIngredient7'];
        $valueIngre7 = $_POST['valueIngre7'];
        $unit7 = $_POST['unit7'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient7',value='$valueIngre7',
        unit='$unit7' WHERE id=$idArrayIngre[7]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient8'])) {
        break;
    } else if (isset($_POST['nameIngredient8'])) {
        $nameIngredient8 = $_POST['nameIngredient8'];
        $valueIngre8 = $_POST['valueIngre8'];
        $unit8 = $_POST['unit8'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient8',value='$valueIngre8',
        unit='$unit8' WHERE id=$idArrayIngre[8]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient9'])) {
        break;
    } else if (isset($_POST['nameIngredient9'])) {
        $nameIngredient9 = $_POST['nameIngredient9'];
        $valueIngre9 = $_POST['valueIngre9'];
        $unit9 = $_POST['unit9'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient9',value='$valueIngre9',
        unit='$unit9' WHERE id=$idArrayIngre[9]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient10'])) {
        break;
    } else if (isset($_POST['nameIngredient10'])) {
        $nameIngredient10 = $_POST['nameIngredient10'];
        $valueIngre10 = $_POST['valueIngre10'];
        $unit10 = $_POST['unit10'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient10',value='$valueIngre10',
        unit='$unit10' WHERE id=$idArrayIngre[10]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient11'])) {
        break;
    } else if (isset($_POST['nameIngredient11'])) {
        $nameIngredient11 = $_POST['nameIngredient11'];
        $valueIngre11 = $_POST['valueIngre11'];
        $unit11 = $_POST['unit11'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient11',value='$valueIngre11',
        unit='$unit11' WHERE id=$idArrayIngre[11]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient12'])) {
        break;
    } else if (isset($_POST['nameIngredient12'])) {
        $nameIngredient12 = $_POST['nameIngredient12'];
        $valueIngre12 = $_POST['valueIngre12'];
        $unit12 = $_POST['unit12'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient12',value='$valueIngre12',
        unit='$unit12' WHERE id=$idArrayIngre[12]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient13'])) {
        break;
    } else if (isset($_POST['nameIngredient13'])) {
        $nameIngredient13 = $_POST['nameIngredient13'];
        $valueIngre13 = $_POST['valueIngre13'];
        $unit13 = $_POST['unit13'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient13',value='$valueIngre13',
        unit='$unit13' WHERE id=$idArrayIngre[13]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient14'])) {
        break;
    } else if (isset($_POST['nameIngredient14'])) {
        $nameIngredient14 = $_POST['nameIngredient14'];
        $valueIngre14 = $_POST['valueIngre14'];
        $unit14 = $_POST['unit14'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient14',value='$valueIngre14',
        unit='$unit14' WHERE id=$idArrayIngre[14]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient15'])) {
        break;
    } else if (isset($_POST['nameIngredient15'])) {
        $nameIngredient15 = $_POST['nameIngredient15'];
        $valueIngre15 = $_POST['valueIngre15'];
        $unit15 = $_POST['unit15'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient15',value='$valueIngre15',
        unit='$unit15' WHERE id=$idArrayIngre[15]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient16'])) {
        break;
    } else if (isset($_POST['nameIngredient16'])) {
        $nameIngredient16 = $_POST['nameIngredient16'];
        $valueIngre16 = $_POST['valueIngre16'];
        $unit16 = $_POST['unit16'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient16',value='$valueIngre16',
        unit='$unit16' WHERE id=$idArrayIngre[16]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient17'])) {
        break;
    } else if (isset($_POST['nameIngredient17'])) {
        $nameIngredient17 = $_POST['nameIngredient17'];
        $valueIngre17 = $_POST['valueIngre17'];
        $unit17 = $_POST['unit17'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient17',value='$valueIngre17',
        unit='$unit17' WHERE id=$idArrayIngre[17]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient18'])) {
        break;
    } else if (isset($_POST['nameIngredient18'])) {
        $nameIngredient18 = $_POST['nameIngredient18'];
        $valueIngre18 = $_POST['valueIngre18'];
        $unit18 = $_POST['unit18'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient18',value='$valueIngre18',
        unit='$unit18' WHERE id=$idArrayIngre[18]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient19'])) {
        break;
    } else if (isset($_POST['nameIngredient19'])) {
        $nameIngredient19 = $_POST['nameIngredient19'];
        $valueIngre19 = $_POST['valueIngre19'];
        $unit19 = $_POST['unit19'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient19',value='$valueIngre19',
        unit='$unit19' WHERE id=$idArrayIngre[19]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient20'])) {
        break;
    } else if (isset($_POST['nameIngredient20'])) {
        $nameIngredient20 = $_POST['nameIngredient20'];
        $valueIngre20 = $_POST['valueIngre20'];
        $unit20 = $_POST['unit20'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient20',value='$valueIngre20',
        unit='$unit20' WHERE id=$idArrayIngre[20]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient21'])) {
        break;
    } else if (isset($_POST['nameIngredient21'])) {
        $nameIngredient21 = $_POST['nameIngredient21'];
        $valueIngre21 = $_POST['valueIngre21'];
        $unit21 = $_POST['unit21'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient21',value='$valueIngre21',
        unit='$unit21' WHERE id=$idArrayIngre[21]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient22'])) {
        break;
    } else if (isset($_POST['nameIngredient22'])) {
        $nameIngredient22 = $_POST['nameIngredient22'];
        $valueIngre22 = $_POST['valueIngre22'];
        $unit22 = $_POST['unit22'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient22',value='$valueIngre22',
        unit='$unit22' WHERE id=$idArrayIngre[22]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient23'])) {
        break;
    } else if (isset($_POST['nameIngredient23'])) {
        $nameIngredient23 = $_POST['nameIngredient23'];
        $valueIngre23 = $_POST['valueIngre23'];
        $unit23 = $_POST['unit23'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient23',value='$valueIngre23',
        unit='$unit23' WHERE id=$idArrayIngre[23]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient24'])) {
        break;
    } else if (isset($_POST['nameIngredient24'])) {
        $nameIngredient24 = $_POST['nameIngredient24'];
        $valueIngre24 = $_POST['valueIngre24'];
        $unit24 = $_POST['unit24'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient24',value='$valueIngre24',
        unit='$unit24' WHERE id=$idArrayIngre[24]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient25'])) {
        break;
    } else if (isset($_POST['nameIngredient25'])) {
        $nameIngredient25 = $_POST['nameIngredient25'];
        $valueIngre25 = $_POST['valueIngre25'];
        $unit25 = $_POST['unit25'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient25',value='$valueIngre25',
        unit='$unit25' WHERE id=$idArrayIngre[25]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient26'])) {
        break;
    } else if (isset($_POST['nameIngredient26'])) {
        $nameIngredient26 = $_POST['nameIngredient26'];
        $valueIngre26 = $_POST['valueIngre26'];
        $unit26 = $_POST['unit26'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient26',value='$valueIngre26',
        unit='$unit26' WHERE id=$idArrayIngre[26]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient27'])) {
        break;
    } else if (isset($_POST['nameIngredient27'])) {
        $nameIngredient27 = $_POST['nameIngredient27'];
        $valueIngre27 = $_POST['valueIngre27'];
        $unit27 = $_POST['unit27'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient27',value='$valueIngre27',
        unit='$unit27' WHERE id=$idArrayIngre[27]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient28'])) {
        break;
    } else if (isset($_POST['nameIngredient28'])) {
        $nameIngredient28 = $_POST['nameIngredient28'];
        $valueIngre28 = $_POST['valueIngre28'];
        $unit28 = $_POST['unit28'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient28',value='$valueIngre28',
        unit='$unit28' WHERE id=$idArrayIngre[28]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient29'])) {
        break;
    } else if (isset($_POST['nameIngredient29'])) {
        $nameIngredient29 = $_POST['nameIngredient29'];
        $valueIngre29 = $_POST['valueIngre29'];
        $unit29 = $_POST['unit29'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient29',value='$valueIngre29',
        unit='$unit29' WHERE id=$idArrayIngre[29]";
        $conn->query($sqlIngre);
    }
    if (!isset($_POST['nameIngredient30'])) {
        break;
    } else if (isset($_POST['nameIngredient30'])) {
        $nameIngredient30 = $_POST['nameIngredient30'];
        $valueIngre30 = $_POST['valueIngre30'];
        $unit30 = $_POST['unit30'];
        $sqlIngre = "UPDATE ingredients SET user_id='$iduser',menu_id='$idmenu',name_ingredients='$nameIngredient30',value='$valueIngre30',
        unit='$unit30' WHERE id=$idArrayIngre[30]";
        $conn->query($sqlIngre);
    }
} while (0);

// --------------- Preparation --------------------

$sql = "SELECT * FROM ingredients WHERE menu_id=$idmenu";
$result = $conn->query($sql);
$idArrayPreparation = array();
$i = 1;
while ($row = $result->fetch_assoc()) {
    $idArrayPreparation[$i] = $row["id"];
    $i++;
}


do {
    if (!isset($_POST['process1'])) {
        break;
    } else if (isset($_POST['process1']) && ($_POST['process1'] != "")) {
        $process1 = $_POST['process1'];
        $numberProcess1 = $_POST['numberProcess1'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess1',preparation='$process1' WHERE id=$idArrayPreparation[1]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process2'])) {
        break;
    } else if (isset($_POST['process2']) && ($_POST['process2'] != "")) {
        $process2 = $_POST['process2'];
        $numberProcess2 = $_POST['numberProcess2'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess2',preparation='$process2' WHERE id=$idArrayPreparation[2]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process3'])) {
        break;
    } else if (isset($_POST['process3']) && ($_POST['process3'] != "")) {
        $process3 = $_POST['process3'];
        $numberProcess3 = $_POST['numberProcess3'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess3',preparation='$process3' WHERE id=$idArrayPreparation[3]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process4'])) {
        break;
    } else if (isset($_POST['process4']) && ($_POST['process4'] != "")) {
        $process4 = $_POST['process4'];
        $numberProcess4 = $_POST['numberProcess4'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess4',preparation='$process4' WHERE id=$idArrayPreparation[4]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process5'])) {
        break;
    } else if (isset($_POST['process5']) && ($_POST['process5'] != "")) {
        $process5 = $_POST['process5'];
        $numberProcess5 = $_POST['numberProcess5'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess5',preparation='$process5' WHERE id=$idArrayPreparation[5]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process6'])) {
        break;
    } else if (isset($_POST['process6']) && ($_POST['process6'] != "")) {
        $process6 = $_POST['process6'];
        $numberProcess6 = $_POST['numberProcess6'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess6',preparation='$process6' WHERE id=$idArrayPreparation[6]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process7'])) {
        break;
    } else if (isset($_POST['process7']) && ($_POST['process7'] != "")) {
        $process7 = $_POST['process7'];
        $numberProcess7 = $_POST['numberProcess7'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess7',preparation='$process7' WHERE id=$idArrayPreparation[7]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process8'])) {
        break;
    } else if (isset($_POST['process8']) && ($_POST['process8'] != "")) {
        $process8 = $_POST['process8'];
        $numberProcess8 = $_POST['numberProcess8'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess8',preparation='$process8' WHERE id=$idArrayPreparation[8]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process9'])) {
        break;
    } else if (isset($_POST['process9']) && ($_POST['process9'] != "")) {
        $process9 = $_POST['process9'];
        $numberProcess9 = $_POST['numberProcess9'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess9',preparation='$process9' WHERE id=$idArrayPreparation[9]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process10'])) {
        break;
    } else if (isset($_POST['process10']) && ($_POST['process10'] != "")) {
        $process10 = $_POST['process10'];
        $numberProcess10 = $_POST['numberProcess10'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess10',preparation='$process10' WHERE id=$idArrayPreparation[10]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process11'])) {
        break;
    } else if (isset($_POST['process11']) && ($_POST['process11'] != "")) {
        $process11 = $_POST['process11'];
        $numberProcess11 = $_POST['numberProcess11'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess11',preparation='$process11' WHERE id=$idArrayPreparation[11]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process12'])) {
        break;
    } else if (isset($_POST['process12']) && ($_POST['process12'] != "")) {
        $process12 = $_POST['process12'];
        $numberProcess12 = $_POST['numberProcess12'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess12',preparation='$process12' WHERE id=$idArrayPreparation[12]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process13'])) {
        break;
    } else if (isset($_POST['process13']) && ($_POST['process13'] != "")) {
        $process13 = $_POST['process13'];
        $numberProcess13 = $_POST['numberProcess13'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess13',preparation='$process13' WHERE id=$idArrayPreparation[13]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process14'])) {
        break;
    } else if (isset($_POST['process14']) && ($_POST['process14'] != "")) {
        $process14 = $_POST['process14'];
        $numberProcess14 = $_POST['numberProcess14'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess14',preparation='$process14' WHERE id=$idArrayPreparation[14]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process15'])) {
        break;
    } else if (isset($_POST['process15']) && ($_POST['process15'] != "")) {
        $process15 = $_POST['process15'];
        $numberProcess15 = $_POST['numberProcess15'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess15',preparation='$process15' WHERE id=$idArrayPreparation[15]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process16'])) {
        break;
    } else if (isset($_POST['process16']) && ($_POST['process16'] != "")) {
        $process16 = $_POST['process16'];
        $numberProcess16 = $_POST['numberProcess16'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess16',preparation='$process16' WHERE id=$idArrayPreparation[16]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process17'])) {
        break;
    } else if (isset($_POST['process17']) && ($_POST['process17'] != "")) {
        $process17 = $_POST['process17'];
        $numberProcess17 = $_POST['numberProcess17'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess17',preparation='$process17' WHERE id=$idArrayPreparation[17]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process18'])) {
        break;
    } else if (isset($_POST['process18']) && ($_POST['process18'] != "")) {
        $process18 = $_POST['process18'];
        $numberProcess18 = $_POST['numberProcess18'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess18',preparation='$process18' WHERE id=$idArrayPreparation[18]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process19'])) {
        break;
    } else if (isset($_POST['process19']) && ($_POST['process19'] != "")) {
        $process19 = $_POST['process19'];
        $numberProcess19 = $_POST['numberProcess19'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess19',preparation='$process19' WHERE id=$idArrayPreparation[19]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process20'])) {
        break;
    } else if (isset($_POST['process20']) && ($_POST['process20'] != "")) {
        $process20 = $_POST['process20'];
        $numberProcess20 = $_POST['numberProcess20'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess20',preparation='$process20' WHERE id=$idArrayPreparation[20]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process21'])) {
        break;
    } else if (isset($_POST['process21']) && ($_POST['process21'] != "")) {
        $process21 = $_POST['process21'];
        $numberProcess21 = $_POST['numberProcess21'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess21',preparation='$process21' WHERE id=$idArrayPreparation[21]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process22'])) {
        break;
    } else if (isset($_POST['process22']) && ($_POST['process22'] != "")) {
        $process22 = $_POST['process22'];
        $numberProcess22 = $_POST['numberProcess22'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess22',preparation='$process22' WHERE id=$idArrayPreparation[22]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process23'])) {
        break;
    } else if (isset($_POST['process23']) && ($_POST['process23'] != "")) {
        $process23 = $_POST['process23'];
        $numberProcess23 = $_POST['numberProcess23'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess23',preparation='$process23' WHERE id=$idArrayPreparation[23]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process24'])) {
        break;
    } else if (isset($_POST['process24']) && ($_POST['process24'] != "")) {
        $process24 = $_POST['process24'];
        $numberProcess24 = $_POST['numberProcess24'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess24',preparation='$process24' WHERE id=$idArrayPreparation[24]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process25'])) {
        break;
    } else if (isset($_POST['process25']) && ($_POST['process25'] != "")) {
        $process25 = $_POST['process25'];
        $numberProcess25 = $_POST['numberProcess25'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess25',preparation='$process25' WHERE id=$idArrayPreparation[25]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process26'])) {
        break;
    } else if (isset($_POST['process26']) && ($_POST['process26'] != "")) {
        $process26 = $_POST['process26'];
        $numberProcess26 = $_POST['numberProcess26'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess26',preparation='$process26' WHERE id=$idArrayPreparation[26]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process27'])) {
        break;
    } else if (isset($_POST['process27']) && ($_POST['process27'] != "")) {
        $process27 = $_POST['process27'];
        $numberProcess27 = $_POST['numberProcess27'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess27',preparation='$process27' WHERE id=$idArrayPreparation[27]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process28'])) {
        break;
    } else if (isset($_POST['process28']) && ($_POST['process28'] != "")) {
        $process28 = $_POST['process28'];
        $numberProcess28 = $_POST['numberProcess28'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess28',preparation='$process28' WHERE id=$idArrayPreparation[28]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process29'])) {
        break;
    } else if (isset($_POST['process29']) && ($_POST['process29'] != "")) {
        $process29 = $_POST['process29'];
        $numberProcess29 = $_POST['numberProcess29'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess29',preparation='$process29' WHERE id=$idArrayPreparation[29]";
        $conn->query($sqlPre);
    }
    if (!isset($_POST['process30'])) {
        break;
    } else if (isset($_POST['process30']) && ($_POST['process30'] != "")) {
        $process30 = $_POST['process30'];
        $numberProcess30 = $_POST['numberProcess30'];
        $sqlPre = "UPDATE preparation SET user_id='$iduser',menu_id='$idmenu',num_preparation='$numberProcess30',preparation='$process30' WHERE id=$idArrayPreparation[30]";
        $conn->query($sqlPre);
    }
} while (0);

if ($status == "user") {
    header("Location: ../user/main-food.php");
} else {
    header("Location: ../admin/addfood-admin.php");
}
