<?php
    include '../main/connectAPI.php';
    session_start();
    if (isset($_SESSION['id'])) {
        $session_login_id = $_SESSION['id'];
        $session_login_email = $_SESSION['email'];
        $session_login_username = $_SESSION['username'];
        $session_login_status = $_SESSION['status'];
    }
    $total_ing = 1;
    $url = 'menu-detail/menu-id?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&id='.$_GET['id'];
    $resultmenu = json_decode(getAPI($url),true);

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
    <!--<link href="../assets/node_modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/node_modules/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">-->
    <!-- This page CSS -->
    <!-- chartist CSS -->
    <!--<link href="../assets/node_modules/morrisjs/morris.css" rel="stylesheet">-->
    <!--c3 CSS -->
    <!--<link href="../assets/node_modules/c3-master/c3.min.css" rel="stylesheet">-->

    <!-- Custom CSS -->
    <link href="../admin/css/style.css" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="../admin/css/pages/dashboard1.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="../admin/css/colors/default.css" id="theme" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!--<div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Sharing Thai Food</p>
        </div>
    </div>-->
    <div id="main-wrapper">
        <?php
            if($session_login_status == 'Admin'){
                include("../function/header-admin.php");
                include("../function/list-admin.php");
            }elseif($session_login_status == 'User'){
                include("../function/header-user.php");
                include("../function/list-user.php");
            }else{
                header("Location: ../auth/login.php");
            }
        ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">Edit Recipe</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">HOME</a></li>
                            <li class="breadcrumb-item">Food Recipe</li>
                            <li class="breadcrumb-item active">Edit Recipe</li>
                        </ol>
                    </div>
                </div>
                <form action="update-food.php" method="POST" onsubmit="return Validate()" enctype="multipart/form-data" class="form-horizontal form-material" name="form1" runat="server">
                    <input name="foodid" type="hidden" value="<?php echo $_GET['id'] ?>">
                    <input name="iduser" type="hidden" value="<?php echo $resultmenu[0]['user'] ?>">
                    <input name="status" type="hidden" value="<?php echo $session_login_status ?>">
                    <div class="row">
                        <!-- Upload image -->
                        <div class="col-lg-4 col-xlg-3 col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <center class="m-t-30">
                                        <label for="news_filename">
                                            <?php
                                                if (substr($resultmenu[0]["image"], 0, 10) != "food_image") {
                                                    echo '<img class="card-img-left" src="../image_food/'.$resultmenu[0]["image"].'"  width="250" height="250" alt="Card image cap">';
                                                }else{
                                                    echo '<img class="card-img-left" src="https://keedurar.sirv.com/'.$resultmenu[0]["image"].'?h=250&w=250"  width="250" height="250" alt="Card image cap">';
                                                }
                                            ?>
                                            <!--<img src="../image_food/<?php //echo $resultmenu[0]['image'] ?>" id="blah" alt="your image" class="img-circle" width="250" height="250" />-->
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
                                            <input type="text" name="namefood" value="<?php echo $resultmenu[0]['title'] ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Description</label>
                                        <div class="col-md-12">
                                            <textarea rows="5" name="Additional_explanation" class="form-control form-control-line"><?php 
                                                if( isset($resultmenu[0]["description"]) ){
                                                    echo $resultmenu[0]["description"];
                                                }else{
                                                    echo '';
                                                }
                                            ?></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">serve</label>
                                        <div class="col-md-12">
                                            <input type="text" name="serve" value="<?php echo $resultmenu[0]['serve'] ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <label class="col-md-12">Ingredient</label>
                                    <div class="form-group col-md-12">
                                        <div id='Ingredient-Form'>
                                            <?php 
                                                $i = 0;
                                                foreach($resultmenu[0]['ingredients'] as $ing){
                                                    if( $i == 0 ){
                                                        echo '<div>';
                                                        echo '<input type="text" name="ingredient[]" value="'.$ing['name'].'" class="col-md-6 form-control form-control-line"/>';
                                                        echo '<input type="text" name="value[]" value="'.$ing['value'].'" class="col-md-3 form-control form-control-line"/>';
                                                        echo '<input type="text" name="unit[]" value="'.$ing['unit'].'" class="col-md-2 form-control form-control-line"/>';
                                                        echo '</div>';
                                                    }else{
                                                        echo '<div>';
                                                        echo '<input type="text" name="ingredient[]" value="'.$ing['name'].'" class="col-md-6 form-control form-control-line"/>';
                                                        echo '<input type="text" name="value[]" value="'.$ing['value'].'" class="col-md-3 form-control form-control-line"/>';
                                                        echo '<input type="text" name="unit[]" value="'.$ing['unit'].'" class="col-md-2 form-control form-control-line"/>';
                                                        echo '<a href="javascript:void(0);" class="remove_ingre col-md-1"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>';
                                                        echo '</div>';
                                                    }
                                                    $i++;
                                                }
                                            ?>
                                        </div>
                                        <a href="javascript:void(0);" class="add_ingre" title="Add field"> <button type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button> </a>
                                    </div>
                                    <label class="col-md-12">Preparation</label>
                                    <div class="form-group col-md-12">
                                    <div id='Process-Form'>
                                            <?php 
                                                $i = 0;
                                                foreach($resultmenu[0]['preparations'] as $ing){
                                                    if( $i == 0 ){
                                                        echo '<div>';
                                                        echo '<input name="numberProcess" type="text" value=">" disabled="True" class="form-control form-control-line col-md-2"/>';
                                                        echo '<input name="process[]" type="text" value="'.$ing.'" class="form-control form-control-line col-md-9"/>';
                                                        echo '</div>';
                                                    }else{
                                                        echo '<div>';
                                                        echo '<input name="numberProcess" type="text" value=">" disabled="True" class="form-control form-control-line col-md-2"/>';
                                                        echo '<input name="process[]" type="text" value="'.$ing.'" class="form-control form-control-line col-md-9"/>';
                                                        echo '<a href="javascript:void(0);" class="remove_process col-md-1"><i class="fa fa-minus-circle" aria-hidden="true"></i></a>';
                                                        echo '</div>';
                                                    }
                                                    $i++;
                                                }
                                            ?>
                                    </div>
                                    <a href="javascript:void(0);" class="add_process" title="Add field"> <button type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button> </a>
                                    </div>
                                    <div class="form-group">
                                        <center>
                                            <input class="btn btn-success btn-block" type="submit" value="Update" name="submit">
                                        </center>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <footer class="footer" style="padding-top:1rem !important;padding-bottom:1rem !important">
                <!--© 2020 Admin by sharing-thaifood.herokuapp.com-->
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
    <script src="../mainstyle/jquery/jquery.min.js"></script>
    <script src="../mainstyle/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!--<script src="../assets/node_modules/jquery/jquery.min.js"></script>-->
    <!-- Bootstrap popper Core JavaScript -->
    <!--<script src="../assets/node_modules/bootstrap/js/popper.min.js"></script>
    <script src="../assets/node_modules/bootstrap/js/bootstrap.min.js"></script>-->
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="../admin/js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="../admin/js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="../admin/js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="../admin/js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <!--<script src="../assets/node_modules/raphael/raphael-min.js"></script>
    <script src="../assets/node_modules/morrisjs/morris.min.js"></script>-->
    <!--c3 JavaScript -->
    <!--<script src="../assets/node_modules/d3/d3.min.js"></script>
    <script src="../assets/node_modules/c3-master/c3.min.js"></script>-->
    <!-- Chart JS -->
    <!--<script src="js/dashboard1.js"></script>-->

    <script>
        
        /*var numProcess = <?php //echo $numPro ?>;
        var numIngre = <?php //echo $numIng ?>;*/

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

        /*function addIngredient() {
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
            numIngre++;
        }

        function addProcess() {
            var number = '';
            var process = '';
            var ci = '';
            number += '<input type="text" name="numberProcess' + [numProcess] + '" value="' + [numProcess + 1] + '" class="form-control form-control-line">';
            $("#number").append(number);
            process += ' <input name="process[' + [numProcess] + ']" id="process[' + numProcess + ']" type="text" placeholder="bra bra bra bra " class="form-control form-control-line">';
            $("#process").append(process);
            ci += '<input name="countIngredient" type="hidden" value="' + [numIngre] + '" class="form-control form-control-line">';
            $("#COUNTTNGRE").append(ci);
            numProcess++;
        }

        function removeIngre() {
            console.log($(this).find("input.Ingredient[0]").val());
        }*/

        $(document).ready(function(){
            //var maxField = 10; //Input fields increment limitation
            var addIngre = $('.add_ingre'); //Add button selector
            var addProcess = $('.add_process');
            //var wrapper = $('.field_wrapper'); //Input field wrapper
            var Ingre_wrapper = $('#Ingredient-Form'); //Input field wrapper
            var Process_wrapper = $('#Process-Form'); //Input field wrapper
            
            var fieldHTML = '<div><input type="text" name="ingredient[]" value="" class="col-md-6 form-control form-control-line"/><input type="text" name="value[]" value="" class="col-md-3 form-control form-control-line"/><input type="text" name="unit[]" value="" class="col-md-2 form-control form-control-line"/><a href="javascript:void(0);" class="remove_ingre col-md-1"><i class="fa fa-minus-circle" aria-hidden="true"></i></a></div>'; //New input field html 
            var fieldHTML2 = '<div><input name="numberProcess" type="text" value=">" disabled="True" class="form-control form-control-line col-md-2"/><input name="process[]" type="text" value="" class="form-control form-control-line col-md-9"/><a href="javascript:void(0);" class="remove_process col-md-1"><i class="fa fa-minus-circle" aria-hidden="true"></i></a></div>'; //New input field html 
            //var x = 1; //Initial field counter is 1
            
            //Once add button is clicked
            $(addIngre).click(function(){
                //Check maximum number of input fields
                //if(x < maxField){ 
                //x++; //Increment field counter
                $(Ingre_wrapper).append(fieldHTML); //Add field html
                //}
            });

            $(addProcess).click(function(){
                //Check maximum number of input fields
                //if(x < maxField){ 
                //x++; //Increment field counter
                $(Process_wrapper).append(fieldHTML2); //Add field html
                //}
            });
            
            //Once remove button is clicked
            $(Ingre_wrapper).on('click', '.remove_ingre', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                //x--; //Decrement field counter
            });

            $(Process_wrapper).on('click', '.remove_process', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                //x--; //Decrement field counter
            });
        });

        // On top
        $("a[href='#top']").click(function() {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            return false;
        });

        /*function Validate() {
            if (news_filename.value == "") {
                alert("Please put food image!");
                $("html, body").animate({
                scrollTop: 0
            }, "slow");
                return false;
            }
        }*/
    </script>

</body>

</html>