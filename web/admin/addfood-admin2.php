<?php
session_start();
if (isset($_SESSION['id'])) {
    $session_login_id = $_SESSION['id'];
    $session_login_email = $_SESSION['email'];
    $session_login_username = $_SESSION['username'];
    $session_status = $_SESSION['status'];
}
$total_ing = 1;
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!--<div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Sharing Thai Food</p>
        </div>
    </div>-->
    <div id="main-wrapper">
        <?php include("../function/header-admin.php"); ?>
        <?php include("../function/list-admin.php"); ?>
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
                <form action="../main/addfood-user.php" method="POST" onsubmit="return Validate()" enctype="multipart/form-data" class="form-horizontal form-material" name="form1" runat="server">
                    <input name="iduser" type="hidden" value="<?php echo $session_login_id ?>">
                    <div class="row">
                        <!-- Upload image -->
                        <div class="col-lg-4 col-xlg-3 col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <center class="m-t-30">
                                        <label for="news_filename">
                                            <img src="../img/Fried-rice.jpg" id="blah" alt="your image" class="img-circle" width="250" height="250" />
                                            <div class="btn btn-block btn-success mt-3">Upload image. <i class="fas fa-upload" aria-hidden="true"></i></div>
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
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="col-md-12">Food Name</label>
                                        <div class="col-md-12">
                                            <input type="text" name="namefood" placeholder="Stir fried basil" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Description</label>
                                        <div class="col-md-12">
                                            <textarea rows="5" name="Additional_explanation" class="form-control form-control-line"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">serve</label>
                                        <div class="col-md-12">
                                            <input type="text" name="serve" placeholder="" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <!--<div class="form-group">
                                        <label class="col-sm-12">Select region</label>
                                        <div class="col-sm-12">
                                            <select name="region" class="form-control form-control-line">
                                                <option value="Other Food">Other Food</option>
                                                <option value="North Food">North Food</option>
                                                <option value="South Food">South Food</option>
                                                <option value="Northeast Food">Northeast Food</option>
                                                <option value="Central Region Food">Central Region Food</option>
                                            </select>
                                        </div>
                                    </div>-->
                                    <label class="col-md-12">Ingredient</label>
                                    <div class="form-group" id='Ingredient-Form'>
                                        <div class="row ml-1 mr-1" id='ingredients-list'>
                                            <div class="col-md-7" id="Ingredient">
                                                <input name="Ingredient[0]" id="Ingredient[0]" type="text" placeholder="Carrot" class="form-control form-control-line">
                                            </div>
                                            <div class="col-md-3" id="value">
                                                <input name="valueIngre[0]" id="valueIngre[0]" type="text" placeholder="100" class="form-control form-control-line">
                                            </div>
                                            <div class="col-md-2" id="unit">
                                                <input name="unitIngre[0]" id="unitIngre[0]" type="text" placeholder="กรัม" class="form-control form-control-line">
                                                <!--<select name="unitIngre[0]" id="unitIngre[0]" class="form-control form-control-line">
                                                    <option value="mg">mg</option>
                                                    <option value="g">g</option>
                                                    <option value="kg">kg</option>
                                                    <option value="tsp">tsp</option>
                                                    <option value="tbsp">tbsp</option>
                                                    <option value="cup">cup</option>
                                                    <option value="ml">ml</option>
                                                    <option value="liter">liter</option>
                                                </select>-->
                                            </div>
                                        </div>
                                        <button onclick="addIngredient()" type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                    </div>
                                    <!--<div id='ingredients'>
                                    </div>
                                    <button onclick="addIngredients()" id="addIngredient" type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>-->
                                    <div class="form-group">
                                        <label class="col-md-12">Preparation</label>
                                        <div class="row ml-1 mr-1">
                                            <div class="col-md-1" id="number">
                                                <input name="numberProcess" type="text" value="1" class="form-control form-control-line">
                                            </div>
                                            <div class="col-md-11" id="process">
                                                <input name="process[0]" id="process[0]" type="text" placeholder="bra bra bra bra " class="form-control form-control-line">
                                            </div>
                                            <button onclick="addProcess()" id="get" type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <center>
                                            <input class="btn btn-success btn-block" type="submit" value="Add Food" name="submit">
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
        var numProcess = 0;
        var numIngre = 0;

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
            Ingre += '<input name="Ingredient[' + numIngre + ']" id="Ingredient[' + numIngre + ']" type="text" placeholder="Carrot" class="form-control form-control-line">';
            $("#Ingredient").append(Ingre);
            value += '<input name="valueIngre[' + numIngre + ']" id="valueIngre[' + numIngre + ']" type="text" placeholder="100" class="form-control form-control-line">';
            $("#value").append(value);
            unit += '<input name="unitIngre[' + numIngre + ']" id="unitIngre[' + numIngre + ']" type="text" placeholder="กรัม" class="form-control form-control-line">';
            $("#unit").append(unit);
            ci += '<input name="countPreparation" type="hidden" value="' + [numIngre] + '" class="form-control form-control-line">';
            $("#COUNTTNGRE").append(ci);
        }

        function addProcess() {
            numProcess++;
            var number = '';
            var process = '';
            var ci = '';
            number += '<input type="text" name="numberProcess' + [numProcess] + '" value="' + [numProcess + 1] + '" class="form-control form-control-line">';
            $("#number").append(number);
            process += ' <input name="process[' + [numProcess] + ']" id="process[' + numProcess + ']" type="text" placeholder="bra bra bra bra " class="form-control form-control-line">';
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

        function Validate() {
            if (news_filename.value == "") {
                alert("Please put food image!");
                $("html, body").animate({
                scrollTop: 0
            }, "slow");
                return false;
            }
        }
    </script>

</body>

</html>