<?php
session_start();
include '../main/conectDB.php';
if (isset($_SESSION['id'])) {
    $session_login_id = $_SESSION['id'];
    $session_login_email = $_SESSION['email'];
}


$id = $_GET['id'];

$menu = "SELECT * FROM menu WHERE id=$id";

$ingredients1 = "SELECT * FROM ingredients WHERE menu_id=$id";
$ingredients2 = "SELECT * FROM ingredients WHERE menu_id=$id";
$ingredients3 = "SELECT * FROM ingredients WHERE menu_id=$id";

$preparation1 = "SELECT * FROM preparation WHERE menu_id=$id";
$preparation2 = "SELECT * FROM preparation WHERE menu_id=$id";


$resultmenu = mysqli_query($conn, $menu);

$resultingredients1 = mysqli_query($conn, $ingredients1); // ingredients
$resultingredients2 = mysqli_query($conn, $ingredients2); // value
$resultingredients3 = mysqli_query($conn, $ingredients3); // unit

$resultpreparation1 = mysqli_query($conn, $preparation1); // number preparation
$resultpreparation2 = mysqli_query($conn, $preparation2); // preparation

while ($rowmenu = $resultmenu->fetch_assoc()) {
    $idmenu = $rowmenu["id"];
    $user_id = $rowmenu["user_id"];
    $title = $rowmenu["title"];
    $Additional_explanation = $rowmenu["Additional_explanation"];
    $region = $rowmenu["region"];
    $serve = $rowmenu["serve"];
    $image = $rowmenu["image"];
    $reference = $rowmenu["reference"];
    $nutrition = $rowmenu["nutrition"];
}

?>


<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/logo-icon-api.png">

    <title>Sharing Thai Food</title>

    <!-- Bootstrap core CSS -->
    <link href="../mainstyle/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="../mainstyle/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="../mainstyle/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="../css/landing-page.min.css" rel="stylesheet">

    <link href="../css/all.min.css" rel="stylesheet">

    <!-- Bootstrap Core CSS -->
    <link href="../assets/node_modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/node_modules/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <!-- This page CSS -->
    <!-- chartist CSS -->
    <link href="../assets/node_modules/morrisjs/morris.css" rel="stylesheet">
    <!--c3 CSS -->
    <link href="../assets/node_modules/c3-master/c3.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="css/pages/dashboard1.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/default.css" id="theme" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Sharing Thai Food</p>
        </div>
    </div>
    <div id="main-wrapper">
        <?php include("../function/header-user.php"); ?>
        <?php include("../function/list-user.php"); ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">Add Food</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">HOME</a></li>
                            <li class="breadcrumb-item">Main Food</li>
                            <li class="breadcrumb-item active">Add Food</li>
                        </ol>
                    </div>
                </div>
                <form action="../main/updatefood-user.php" enctype="multipart/form-data" method="POST" class="form-horizontal form-material" name="form1" runat="server">
                    <input name="iduser" type="hidden" value="<?php echo $session_login_id ?>">
                    <input name="idmenu" type="hidden" value="<?php echo $idmenu ?>">
                    <div class="row">
                        <!-- Upload image -->
                        <div class="col-lg-4 col-xlg-3 col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <center class="m-t-30">
                                        <label for="news_filename">
                                            <?php if ($image == "") { ?>
                                                <img src="../img/Fried-rice.jpg" id="blah" alt="your image" class="img-circle" width="250" height="250" />
                                            <?php } elseif ($image != "") { ?>
                                                <img src="../image_food/<?php echo $image; ?>" id="blah" alt="your image" class="img-circle" width="250" height="250" />
                                            <?php } ?>
                                            <div class="btn btn-block btn-success mt-3">Up load image. <i class="fas fa-upload" aria-hidden="true"></i></div>
                                        </label>
                                        <input id="news_filename" name="news_filename" type="file" style="display: none;" />
                                        <h4 class="card-title m-t-10">Image</h4>
                                        <h6 class="card-subtitle">After uploading images, please click "ADD FOOD" below</h6>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8 col-xlg-9 col-md-7">
                            <div class="card">
                                <!-- Tab panes -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="col-md-12">Food Name</label>
                                        <div class="col-md-12">
                                            <input type="text" name="namefood" value="<?php echo $title; ?>" placeholder="Stir fried basil" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Additional explanation</label>
                                        <div class="col-md-12">
                                            <textarea rows="5" name="Additional_explanation" class="form-control form-control-line"><?php echo $Additional_explanation;  ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">serve</label>
                                        <div class="col-md-12">
                                            <input type="text" name="serve" value="<?php echo $serve; ?>" placeholder="" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Select region</label>
                                        <div class="col-sm-12">
                                            <select name="region" class="form-control form-control-line">
                                                <option <?php if ($region == "Other Food") { ?>selected <?php } ?>>Other Food</option>
                                                <option <?php if ($region == "North Food") { ?>selected <?php } ?>>North Food</option>
                                                <option <?php if ($region == "South Food") { ?>selected <?php } ?>>South Food</option>
                                                <option <?php if ($region == "Northeast Food") { ?>selected <?php } ?>>Northeast Food</option>
                                                <option <?php if ($region == "Central Region Food") { ?>selected <?php } ?>>Central Region Food</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Ingredient</label>

                                        <div class="row ml-1 mr-1">

                                            <div class="col-md-7" id="Ingredient">
                                                <?php
                                                $i = 1;
                                                while ($rowingredients = $resultingredients1->fetch_assoc()) { ?>
                                                    <input name="nameIngredient<?php echo $i; ?>" type="text" value="<?php echo $rowingredients["name_ingredients"]; ?>" class="form-control form-control-line">
                                                <?php
                                                    $i++;
                                                } ?>
                                            </div>
                                            <div class="col-md-3" id="value">
                                                <?php
                                                $i = 1;
                                                while ($rowvalue = $resultingredients2->fetch_assoc()) { ?>
                                                    <input name="valueIngre<?php echo $i; ?>" type="text" value="<?php echo $rowvalue["value"]; ?>" class="form-control form-control-line">
                                                <?php
                                                    $i++;
                                                } ?>
                                            </div>
                                            <div class="col-md-2" id="unit">
                                                <?php
                                                $i = 1;
                                                while ($rowunit = $resultingredients3->fetch_assoc()) { ?>
                                                    <select name="unit<?php echo $i; ?>" class="form-control form-control-line">
                                                        <option <?php if ($rowunit["unit"] == "g") { ?>selected <?php } ?>>g</option>
                                                        <option <?php if ($rowunit["unit"] == "gk") { ?>selected <?php } ?>>gk</option>
                                                    </select>
                                                <?php
                                                    $i++;
                                                } ?>
                                            </div>
                                            <!-- <button onclick="addIngredient()" id="get" type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Preparation</label>
                                        <div class="row ml-1 mr-1">
                                            <div class="col-md-1" id="number">
                                                <?php
                                                $i = 1;
                                                while ($rownumber = $resultpreparation1->fetch_assoc()) { ?>
                                                    <input name="numberProcess<?php echo $i; ?>" type="text" value="<?php echo $rownumber["num_preparation"]; ?>" class="form-control form-control-line">
                                                <?php
                                                    $i++;
                                                } ?>
                                            </div>
                                            <div class="col-md-11" id="process">
                                                <?php
                                                $i = 1;
                                                while ($rowprocess = $resultpreparation2->fetch_assoc()) { ?>
                                                    <input name="process<?php echo $i; ?>" type="text" value="<?php echo $rowprocess["preparation"]; ?>" class="form-control form-control-line">
                                                <?php
                                                    $i++;
                                                } ?>
                                            </div>
                                            <!-- <button onclick="addProcess()" id="get" type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button> -->
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <center>
                                            <button type="submit" class="btn btn-success btn-block">Update Food</button>
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <footer class="footer" style="padding-top:1rem !important;padding-bottom:1rem !important">
                © 2020 Admin by sharing-thaifood.herokuapp.com
            </footer>
        </div>
    </div>

    <!-- On top -->
    <div class="secondmenu text-right">
        <a href='#top' id="">
            <i class="fa fa-angle-up btn btn-block btn-lg " style="width: 50px; height: 43px;" aria-hidden="true"></i>
        </a>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="mainstyle/jquery/jquery.min.js"></script>
    <script src="mainstyle/bootstrap/js/bootstrap.bundle.min.js"></script>

    <script src="../assets/node_modules/jquery/jquery.min.js"></script>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="../assets/node_modules/bootstrap/js/popper.min.js"></script>
    <script src="../assets/node_modules/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="../assets/node_modules/raphael/raphael-min.js"></script>
    <script src="../assets/node_modules/morrisjs/morris.min.js"></script>
    <!--c3 JavaScript -->
    <script src="../assets/node_modules/d3/d3.min.js"></script>
    <script src="../assets/node_modules/c3-master/c3.min.js"></script>
    <!-- Chart JS -->
    <script src="js/dashboard1.js"></script>

    <script>
        var newvalue = 3;
        var numIngre = 3;

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#news_filename").change(function() {
            readURL(this);
        });

        function addIngredient() {
            numIngre++;
            var Ingre = '';
            var value = '';
            var unit = '';
            var ci = '';
            Ingre += '<input name="nameIngredient' + [numIngre] + '" type="text" placeholder="Carrot" class="form-control form-control-line">';
            $("#Ingredient").append(Ingre);
            value += '<input name="valueIngre' + [numIngre] + '" type="text" placeholder="100" class="form-control form-control-line">';
            $("#value").append(value);
            unit += '<select name="unit' + [numIngre] + '" class="form-control form-control-line"><option value="g">g</option><option value="gk">gk</option></select>';
            $("#unit").append(unit);

            ci += '<input name="countPreparation" type="hidden" value="' + [numIngre] + '" class="form-control form-control-line">';
            $("#COUNTTNGRE").append(ci);

        }




        function addProcess() {
            newvalue++;
            var number = '';
            var process = '';
            var ci = '';
            number += '<input type="text" name="numberProcess' + [newvalue] + '" value="' + newvalue + '" class="form-control form-control-line">';
            $("#number").append(number);
            process += ' <input name="process' + [newvalue] + '" type="text" placeholder="bra bra bra bra " class="form-control form-control-line">';
            $("#process").append(process);
            ci += '<input name="countIngredient" type="hidden" value="' + [numIngre] + '" class="form-control form-control-line">';
            $("#COUNTTNGRE").append(ci);
        }
        // On top
        $("a[href='#top']").click(function() {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            return false;
        });
    </script>


</body>

</html>