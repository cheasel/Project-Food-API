<?php
session_start();
include '../main/connectAPI.php';
if (isset($_SESSION['id'])) {
    $session_login_id = $_SESSION['id'];
    $session_login_email = $_SESSION['email'];
    $session_login_username = $_SESSION['username'];
    $url = 'user/user-id?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&id='.$session_login_id;
    $result = json_decode(getAPI($url),true);
    if ( isset($result[0]['email']) ) {
        $email = $result[0]['email'];
        $fileimage = $result[0]["image"];
        $firstname = $result[0]["name"];
        $lastname = $result[0]["surname"];
        $age = $result[0]["age"];
        $gender = $result[0]["gender"];
        $height = $result[0]["height"];
        $weight = $result[0]["weight"];
        $allergens = $result[0]['food_allergy'];
    }
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
    <!--<link href="../assets/node_modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/node_modules/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">-->
    <!-- This page CSS -->
    <!-- chartist CSS -->
    <!--<link href="../assets/node_modules/morrisjs/morris.css" rel="stylesheet">-->
    <!--c3 CSS -->
    <!--<link href="../assets/node_modules/c3-master/c3.min.css" rel="stylesheet">-->

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="css/pages/dashboard1.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/default.css" id="theme" rel="stylesheet">
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
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
                        <h3 class="text-themecolor">Profile </h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Profile</li>
                        </ol>
                    </div>
                </div>

                <form action="../main/update-profile.php" enctype="multipart/form-data" class="form-horizontal form-material" method="POST" onsubmit="return Validate()" name="vform">
                    <div class="row">
                        <div class="col-lg-4 col-xlg-3 col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <center class="m-t-30">
                                        <label for="news_filename">
                                            <?php  if ($fileimage == "") { ?>
                                                <img src="../img/testimonials-2.jpg" id="blah" alt="your image" class="img-circle" width="250" height="250" />
                                            <?php }elseif ($fileimage != "") { ?>
                                                <img src="<?php echo $fileimage; ?>" id="blah" alt="your image" class="img-circle" width="250" height="250" />
                                            <?php } ?>
                                            <div class="btn btn-block btn-success mt-3">Upload image. <i class="fas fa-upload" aria-hidden="true"></i></div>
                                        </label>
                                        <input id="news_filename" name="news_filename" type="file" style="display: none;" />
                                        <h4 class="card-title m-t-10"> <?php echo $firstname .' '. $lastname ?> </h4>
                                        <h6 class="card-subtitle text-danger">After uploading images, please click "Update" below</h6>
                                        <!--<div class="row text-center justify-content-md-center">
                                            <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i>
                                                    <font class="font-medium">254</font>
                                                </a></div>
                                            <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i>
                                                    <font class="font-medium">54</font>
                                                </a></div>
                                        </div>-->
                                    </center>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <!-- Column -->
                        <div class="col-lg-8 col-xlg-9 col-md-7">
                            <div class="card">
                                <!-- Tab panes -->
                                <div class="card-body">
                                    <input name="image" type="hidden" value="<?php echo $fileimage ?>">
                                    <input name="iduser" type="hidden" value="<?php echo $session_login_id ?>">
                                    <div class="form-group">
                                        <label class="col-md-12">Name</label>
                                        <div class="col-md-12">
                                            <input name="firstname" value="<?php echo $firstname;  ?>" type="text" placeholder="<?php $firstname ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Surname</label>
                                        <div class="col-md-12">
                                            <input name="lastname" value="<?php echo $lastname;  ?>" type="text" placeholder="<?php $lastname ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="email" id="email" name="email" value="<?php echo $email;  ?>" class="form-control form-control-line" name="example-email" id="example-email">
                                        </div>
                                    </div>
                                    <!--<div class="form-group">
                                        <label class="col-md-12">Password</label>
                                        <div class="col-md-12">
                                            <input type="password" id="password" name="password" value="<?php #echo $session_login_password;  ?>" class="form-control form-control-line">
                                        </div>
                                    </div>-->
                                    <!--<div class="form-group">
                                        <label class="col-md-12">Confirm password</label>
                                        <div class="col-md-12">
                                            <input type="password" id="confirm_password" name="confirm_password" value="<?php echo $session_login_password;  ?>" class="form-control form-control-line">
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <label class="col-md-12">Age</label>
                                        <div class="col-md-12">
                                            <input name="age" value="<?php if ($age!=0) {echo $age;}  ?>" type="text" placeholder="<?php $age ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">gender</label>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="radio" name="gender" value="1" id="male" <?php if ($gender == "1") { ?>checked <?php } ?>> 
                                                    <label class="col-md-12" for="male">ชาย</label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="radio" name="gender" value="2" id="female" <?php if ($gender == "2") { ?>checked <?php } ?>>
                                                    <label class="col-md-12" for="female">หญิง</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Height</label>
                                        <div class="col-md-12">
                                            <input name="height" value="<?php if ($height!=0) {echo $height;}  ?>" type="text" placeholder="<?php $height ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Weight</label>
                                        <div class="col-md-12">
                                            <input name="weight" value="<?php if ($weight!=0) {echo $weight;}  ?>" type="text" placeholder="<?php $weight ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <!--<div class="form-group">
                                        <label class="col-md-12">Medical problems</label>
                                        <div class="row ml-1 mr-1">
                                            <div class="col-md-7" id="Medicalproblems">
                                                <input name="medicalproblems" type="text" placeholder="โรคหัวใจ" class="form-control form-control-line">
                                            </div>
                                            <button onclick="addMedicalproblems()" id="get" type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                        </div>
                                    </div>-->
                                    <!--<label class="col-md-12">Food allergies</label>
                                    <div class="form-group col-md-12">
                                        <div id="Foodallergies">
                                                <?php 
                                                    if ( count($allergens) != 0 ){
                                                        for ( $i = 0; $i < count($allergens); $i++ ){
                                                            echo '<div>';
                                                            echo '<select name="Foodallergens[]" class="form-control form-control-line col-md-7">'; ?>
                                                                <option value='' selected> Food Allergens </option>
                                                                <option <?php if ($allergens[$i] == "Crustacean Shellfish") { ?>selected <?php } ?>>Shellfish</option>
                                                                <option <?php if ($allergens[$i] == "Egg") { ?>selected <?php } ?>>Egg</option>
                                                                <option <?php if ($allergens[$i] == "Fish") { ?>selected <?php } ?>>Fish</option>
                                                                <option <?php if ($allergens[$i] == "Milk") { ?>selected <?php } ?>>Milk</option>
                                                                <option <?php if ($allergens[$i] == "Peanut") { ?>selected <?php } ?>>Peanut</option>
                                                                <option <?php if ($allergens[$i] == "Soy") { ?>selected <?php } ?>>Soy</option>
                                                                <option <?php if ($allergens[$i] == "Tree Nuts") { ?>selected <?php } ?>>Tree Nuts</option>
                                                                <option <?php if ($allergens[$i] == "Wheat") { ?>selected <?php } ?>>Wheat</option>
                                                                <option <?php if ($allergens[$i] == "Gluten") { ?>selected <?php } ?>>Gluten</option>
                                                                <option <?php if ($allergens[$i] == "Buckwheat") { ?>selected <?php } ?>>Buckwheat</option>
                                                                <option <?php if ($allergens[$i] == "Celery") { ?>selected <?php } ?>>Celery</option>
                                                                <option <?php if ($allergens[$i] == "Lupin") { ?>selected <?php } ?>>Lupin</option>
                                                                <option <?php if ($allergens[$i] == "Molluscan Shellfish") { ?>selected <?php } ?>>Molluscan Shellfish</option>
                                                                <option <?php if ($allergens[$i] == "Mustard") { ?>selected <?php } ?>>Mustard</option>
                                                                <option <?php if ($allergens[$i] == "Sesame") { ?>selected <?php } ?>>Sesame</option>
                                                                <option <?php if ($allergens[$i] == "Sulfites") { ?>selected <?php } ?>>Sulfites</option>
                                                                <option <?php if ($allergens[$i] == "Bee Pollen") { ?>selected <?php } ?>>Bee Pollen</option>
                                                                <option <?php if ($allergens[$i] == "Royal Jelly") { ?>selected <?php } ?>>Royal Jelly</option>
                                                                <option <?php if ($allergens[$i] == "Mango") { ?>selected <?php } ?>>Mango</option>
                                                                <option <?php if ($allergens[$i] == "Peach") { ?>selected <?php } ?>>Peach</option>
                                                                <option <?php if ($allergens[$i] == "Pork") { ?>selected <?php } ?>>Pork</option>
                                                                <option <?php if ($allergens[$i] == "Tomato") { ?>selected <?php } ?>>Tomato</option>
                                                                <option <?php if ($allergens[$i] == "Beef") { ?>selected <?php } ?>>Beef</option>
                                                                <option <?php if ($allergens[$i] == "Chicken") { ?>selected <?php } ?>>Chicken</option>
                                                            </select>
                                                            <?php echo '</div>'; ?>
                                                <?php    
                                                        }
                                                    }else { ?>
                                                        <div>
                                                        <select name="Foodallergens[]" class="form-control form-control-line col-md-7">
                                                            <option value='' selected> Food Allergens </option>
                                                            <option>Shellfish</option>
                                                            <option>Egg</option>
                                                            <option>Fish</option>
                                                            <option>Milk</option>
                                                            <option>Peanut</option>
                                                            <option>Soy</option>
                                                            <option>Tree Nuts</option>
                                                            <option>Wheat</option>
                                                            <option>Gluten</option>
                                                            <option>Buckwheat</option>
                                                            <option>Celery</option>
                                                            <option>Lupin</option>
                                                            <option>Molluscan Shellfish</option>
                                                            <option>Mustard</option>
                                                            <option>Sesame</option>
                                                            <option>Sulfites</option>
                                                            <option>Bee Pollen</option>
                                                            <option>Royal Jelly</option>
                                                            <option>Mango</option>
                                                            <option>Peach</option>
                                                            <option>Pork</option>
                                                            <option>Tomato</option>
                                                            <option>Beef</option>
                                                            <option>Chicken</option>
                                                        </select>
                                                    </div>
                                                <?php
                                                    }
                                                ?>
                                            </div>
                                            <a href="javascript:void(0);" class="add_allergies" title="Add field"><button type="button" class="btn btn-danger btn-block"><i class="fa fa-plus-circle" aria-hidden="true"></i></button></a>
                                        </div>
                                    </div>-->
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button type="submit" name="submit" value="update" class="btn btn-success">Update</button>
                                        </div>
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
    <!--<script src="../assets/node_modules/raphael/raphael-min.js"></script>
    <script src="../assets/node_modules/morrisjs/morris.min.js"></script>-->
    <!--c3 JavaScript -->
    <!--<script src="../assets/node_modules/d3/d3.min.js"></script>
    <script src="../assets/node_modules/c3-master/c3.min.js"></script>-->
    <!-- Chart JS -->
    <!--<script src="js/dashboard1.js"></script>-->

    <script>
        /*<var numAllergens = 0;*/

        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        /*function addMedicalproblems() {
            var Medipro = '';
            Medipro += '<input name="medicalproblems" type="text" placeholder="Medical problems" class="form-control form-control-line">';
            $("#Medicalproblems").append(Medipro);
        }

        function addFoodallergies() {
            numAllergens++;
            var Foodaller = '';
            Foodaller += '<select name="Foodallergens['+ numAllergens +']" id="Foodallergens['+ numAllergens +']" class="form-control form-control-line">';
            Foodaller += '<option selected> Food Allergens </option>';
            Foodaller += '<option> Shellfish </option>';
            Foodaller += '<option> Egg </option>';
            Foodaller += '<option> Fish </option>';
            Foodaller += '<option> Milk </option>';
            Foodaller += '<option> Peanut </option>';
            Foodaller += '<option> Soy </option>';
            Foodaller += '<option> Tree Nuts </option>';
            Foodaller += '<option> Wheat </option>';
            Foodaller += '<option> Gluten </option>';
            Foodaller += '<option> Buckwheat </option>';
            Foodaller += '<option> Celery </option>';
            Foodaller += '<option> Lupin </option>';
            Foodaller += '<option> Molluscan Shell </option>';
            Foodaller += '<option> Mustard </option>';
            Foodaller += '<option> Sesame </option>';
            Foodaller += '<option> Sulfites </option>';
            Foodaller += '<option> Bee Pollen </option>';
            Foodaller += '<option> Royal Jelly </option>';
            Foodaller += '<option> Mango </option>';
            Foodaller += '<option> Peach </option>';
            Foodaller += '<option> Pork </option>';
            Foodaller += '<option> Tomato </option>';
            Foodaller += '<option> Beef </option>';
            Foodaller += '<option> Chicken </option>';
            Foodaller += '</select>';
            $("#Foodallergies").append(Foodaller);
        }*/

        $(document).ready(function(){
            //var maxField = 10; //Input fields increment limitation
            var addAllergy = $('.add_allergies'); //Add button selector
            //var wrapper = $('.field_wrapper'); //Input field wrapper
            var Allergy_wrapper = $('#Foodallergies'); //Input field wrapper
            
            var fieldHTML = '<div><select name="Foodallergens[]" class="form-control form-control-line col-md-7"><option value="" selected> Food Allergens </option><option>Shellfish</option><option>Egg</option><option>Fish</option><option>Milk</option><option>Peanut</option><option>Soy</option><option>Tree Nuts</option><option>Wheat</option><option>Gluten</option><option>Buckwheat</option><option>Celery</option><option>Lupin</option><option>Molluscan Shellfish</option><option>Mustard</option><option>Sesame</option><option>Sulfites</option><option>Bee Pollen</option><option>Royal Jelly</option><option>Mango</option><option>Peach</option><option>Pork</option><option>Tomato</option><option>Beef</option><option>Chicken</option></select><a href="javascript:void(0);" class="remove_allergy col-md-1"><i class="fa fa-minus-circle" aria-hidden="true"></i></a></div>'; //New input field html
            //var x = 1; //Initial field counter is 1
                                                  
            //Once add button is clicked
            $(addAllergy).click(function(){
                //Check maximum number of input fields
                //if(x < maxField){ 
                //x++; //Increment field counter
                $(Allergy_wrapper).append(fieldHTML); //Add field html
                //}
            });
            
            //Once remove button is clicked
            $(Allergy_wrapper).on('click', '.remove_allergy', function(e){
                e.preventDefault();
                $(this).parent('div').remove(); //Remove field html
                //x--; //Decrement field counter
            });
        });

        $("#news_filename").change(function() {
            readURL(this);
        });

        // On top
        $("a[href='#top']").click(function() {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            return false;
        });
    </script>

    <script type="text/javascript">
        //GETTING ALL INPUT TEXT OPJECTS
        var password = document.forms["vform"]["password"];
        var confirm_password = document.forms["vform"]["confirm_password"];

        //SETTING ALL EVENT LISTENER
        email.addEventListener("click", emailVerify);
        password.addEventListener("click", passwordVerify);
        confirm_password.addEventListener("click", confirm_passwordVerify);

        function Validate() {
            if (password.value == "") {
                password.style.border = "1px solid red";
                return false;
            }
            if (confirm_password.value == "") {
                confirm_password.style.border = "1px solid red";
                return false;
            }

            if (password.value != confirm_password.value) {
                alert("Password does not match!!");
                return false;

            }
        }

        function passwordVerify() {
            if (password.value == "") {
                password.style.border = "";
                return true;
            }

        }

        function confirm_passwordVerify() {
            if (confirm_password.value == "") {
                confirm_password.style.border = "";
                return true;
            }

        }
    </script>

</body>

</html>