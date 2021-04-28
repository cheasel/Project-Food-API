<?php
session_start();
if (isset($_SESSION['id'])) {
    $session_login_id = $_SESSION['id'];
    $session_login_email = $_SESSION['email'];
    $session_login_username = $_SESSION['username'];
    $session_login_status = $_SESSION['status'];
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
    
    <!-- This page CSS -->
    <!-- Custom CSS -->
    <link href="../admin/css/style.css" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="../admin/css/pages/dashboard1.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="../admin/css/colors/default.css" id="theme" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    
    <!-- Bootstrap core JavaScript -->
    <script src="../mainstyle/jquery/jquery.min.js"></script>
    <script src="../mainstyle/bootstrap/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <script src="../assets/js/jquery.min.js"></script>

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
                        <h3 class="text-themecolor">Add Food</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">HOME</a></li>
                            <li class="breadcrumb-item">Main Food</li>
                            <li class="breadcrumb-item active">Add Food</li>
                        </ol>
                    </div>
                    <div class="col-md-7 align-self-center" >
                        <div id="excel_filter" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down">Excel File <i class="fa fa-plus-circle" aria-hidden="true"></i></div>
                        <div id="normal_filter" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down" style="display: none;">Add Menu <i class="fa fa-plus-circle" aria-hidden="true"></i></div>
                    </div>
                </div>
                <div class="row" id="excel_add" style="display: none;">
                        <!-- Upload image -->
                        <div class="col-lg-12 col-xlg-12 col-md-12" >
                            <div class="card">
                                <form action="http://127.0.0.1:5000/api/add-excel?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e" method="post" enctype="multipart/form-data">
                                <center class="m-t-30 m-b-30">
                                    <label for="excel_filename">
                                        <img style="display: block;" src="../img/excel icon.png" id="excel-img" alt="your image" class="img-circle" width="200" height="200" />
                                        <h5 id="excel_text" >  </h5>
                                        <div style="margin-right: 10px;" class="btn btn-primary mt-3">
                                            Choose File. 
                                        </div>
                                        <button type="submit" class="btn btn-success mt-3">
                                            <i class="fas fa-upload" aria-hidden="true"></i>
                                        </button>
                                    </label>
                                    <input id="excel_filename" name="excel_filename" type="file" accept=".xlsx,.xlsm,.xlsb,.xltx,.xltm,.xls,.xlt,.xla,.xlw" style="display: none;" />
                                    <!--<div class="card-body col-md-5">
                                        <form action="http://127.0.0.1:5000/api/add-excel?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e" method="post" enctype="multipart/form-data">
                                            <label class="form-label" for="customFile">Default file input example</label>
                                            <input type="file" class="form-control" id="customFile" />
                                            <div class="file-field">
                                                <div class="btn btn-primary btn-sm float-left waves-effect waves-light">
                                                    <span>Choose file</span>
                                                    <input type="file">
                                                </div>
                                                <div class="file-path-wrapper">
                                                    <input class="file-path validate" type="text" placeholder="Upload your file">
                                                </div>
                                            </div>
                                            <input class="btn btn-block btn-success mt-3 col-md-6" type="submit" value="Upload File" name="submit">
                                        </form>-->
                                        <!--<label for="news_filename">
                                            <img src="../img/Fried-rice.jpg" id="blah" alt="your image" class="img-circle" width="250" height="250" />
                                            <div class="btn btn-block btn-success mt-3">Upload image. <i class="fas fa-upload" aria-hidden="true"></i></div>
                                        </label>
                                        <input id="news_filename" name="news_filename" type="file" style="display: none;" />
                                        <h4 class="card-title m-t-10">Image</h4>
                                        <h6 class="card-subtitle">After uploading images, please click "ADD FOOD" below</h6>
                                    </div>-->
                                </center>
                                </form>
                            </div>
                        </div>
                    </div>
                <form action="addfood-user.php" method="POST" onsubmit="return Validate()" enctype="multipart/form-data" class="form-horizontal form-material" name="form1" runat="server">
                    <input name="iduser" type="hidden" value="<?php echo $session_login_id ?>">
                    <input name="status" type="hidden" value="<?php echo $session_login_status ?>">
                    <div class="row" id="normal_add">
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
                                    <div class="form-group col-md-12">
                                        <div id='Ingredient-Form'>
                                            <div>
                                                <input type="text" placeholder="Carrot" name="ingredient[]" value="" class="col-md-6 form-control form-control-line"/>
                                                <input type="text" placeholder="100" name="value[]" value="" class="col-md-3 form-control form-control-line"/>
                                                <input type="text" placeholder="กรัม" name="unit[]" value="" class="col-md-2 form-control form-control-line"/>
                                            </div>
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
                                        <a href="javascript:void(0);" class="add_ingre" title="Add field"> <button type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button> </a>
                                    </div>

                                    <!--<div class="form-group" id='Ingredient-Form'>
                                        <div class="row ml-1 mr-1" id='ingredients-list'>
                                            <div class="col-md-7" id="Ingredient">
                                                <input name="Ingredient[0]" id="Ingredient[0]" type="text" placeholder="Carrot" class="form-control form-control-line">
                                            </div>
                                            <div class="col-md-3" id="value">
                                                <input name="valueIngre[0]" id="valueIngre[0]" type="text" placeholder="100" class="form-control form-control-line">
                                            </div>
                                            <div class="col-md-2" id="unit">
                                                <input name="unitIngre[0]" id="unitIngre[0]" type="text" placeholder="กรัม" class="form-control form-control-line">
                                                
                                            </div>
                                        </div>
                                        <button onclick="addIngredient()" type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                    </div>-->
                                    <!--<div id='ingredients'>
                                    </div>
                                    <button onclick="addIngredients()" id="addIngredient" type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>-->
                                    <label class="col-md-12">Preparation</label>
                                    <div class="form-group col-md-12">
                                        <div id='Process-Form'>
                                            <div>
                                                <input name="numberProcess" type="text" value=">" disabled="True" class="form-control form-control-line col-md-1"/>
                                                <input name="process[]" type="text" value="" class="form-control form-control-line col-md-10"/>
                                            </div>
                                        </div>
                                        <a href="javascript:void(0);" class="add_process" title="Add field"> <button type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button> </a>
                                    </div>

                                    <!--<div class="form-group">
                                        <div class="row ml-1 mr-1">
                                            <div class="col-md-1" id="number">
                                                <input name="numberProcess" type="text" value="1" disabled="True" class="form-control form-control-line">
                                            </div>
                                            <div class="col-md-11" id="process">
                                                <input name="process[0]" id="process[0]" type="text" placeholder="bra bra bra bra " class="form-control form-control-line">
                                            </div>
                                            <button onclick="addProcess()" id="get" type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                        </div>
                                    </div>-->
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

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        function readexcelURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                var filename = document.getElementById("excel_filename");
                console.log('excel');
                reader.onload = function(e) {
                    //$('#excel_text').text(String(e.target.result));
                    $('#excel_text').text(filename.value);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#news_filename").change(function() {
            console.log('change');
            readURL(this);
        });

        $("#excel_filename").change(function() {
            console.log('change');
            readexcelURL(this);
        });

        $("#excel_filter").click(function(){
            console.log('toggle');
            $("#excel_add").toggle();
            $("#excel_filter").toggle();
            $("#normal_add").toggle();
            $("#normal_filter").toggle();
        });

        $("#normal_filter").click(function(){
            console.log('toggle');
            $("#excel_add").toggle();
            $("#excel_filter").toggle();
            $("#normal_add").toggle();
            $("#normal_filter").toggle();
        });

        /*function addIngredient() {
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
        }*/

        $(document).ready(function(){
            //var maxField = 10; //Input fields increment limitation
            var addIngre = $('.add_ingre'); //Add button selector
            var addProcess = $('.add_process');
            //var wrapper = $('.field_wrapper'); //Input field wrapper
            var Ingre_wrapper = $('#Ingredient-Form'); //Input field wrapper
            var Process_wrapper = $('#Process-Form'); //Input field wrapper
            
            var fieldHTML = '<div><input type="text" name="ingredient[]" placeholder="Carrot" value="" class="col-md-6 form-control form-control-line"/><input type="text" name="value[]" placeholder="100" value="" class="col-md-3 form-control form-control-line"/><input type="text" name="unit[]" placeholder="กรัม" value="" class="col-md-2 form-control form-control-line"/><a href="javascript:void(0);" class="remove_ingre col-md-1"><i class="fa fa-minus-circle" aria-hidden="true"></i></a></div>'; //New input field html 
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