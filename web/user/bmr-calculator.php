<?php
session_start();
include '../main/connectAPI.php';
if (isset($_SESSION['id'])) {
    $session_login_id = $_SESSION['id'];
    $session_login_email = $_SESSION['email'];
    $session_login_username = $_SESSION['username'];
    $session_status = $_SESSION['status'];

    $url = 'user/user-id?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&id='.$session_login_id;
    $result = json_decode(getAPI($url),true);
    if ( isset($result[0]['email']) ) {
        $email = $result[0]['email'];
        $fileimage = $result[0]["image"];
        $firstname = $result[0]["name"];
        $lastname = $result[0]["surname"];
        $age = $result[0]["age"];
        $gender = $result[0]["gender"];     // male = 1 , female = 2
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
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">BMR Calculator</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">BMR Calculator</li>
                        </ol>
                    </div>
                </div><!-- ../main/processCal.php -->
                <!--<form action="javascript:void(0);" method="POST" class="form-horizontal form-material " onsubmit="return Validate()" name="vform">-->
                    <input name="iduser" type="hidden" value="<?php echo $session_login_id ?>">
                    <div class="row">
                        <!-- Column -->
                        <div class="col-lg-7">
                            <div class="card">
                                <!-- Tab panes -->
                                <div class="card-body" style="min-height: 470px">
                                    <div class="form-group">
                                        <label class="col-md-12">gender</label>
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <input type="radio" name="gender" value="male" id="male" <?php if ($gender == "1") { ?>checked <?php } ?>> <!-- male = 1 -->
                                                    <label class="col-md-12" for="male">ชาย</label>
                                                </div>
                                                <div class="col-6">
                                                    <input type="radio" name="gender" value="female" id="female" <?php if ($gender == "2") { ?>checked <?php } ?>> <!-- female = 2 -->
                                                    <label class="col-md-12" for="female">หญิง</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">ส่วนสูง : เซนติเมตร</label>
                                        <div class="col-md-12">
                                            <input type="text" id="height" value="<?php echo $height;  ?>" placeholder="200" class="form-control form-control-line">
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-md-12">น้ำหนัก : กิโลกรัม</label>
                                        <div class="col-md-12">
                                            <input type="text" id="weight" value="<?php echo $weight;  ?>" placeholder="60" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">อายุ</label>
                                        <div class="col-md-12">
                                            <input type="text" id="age" value="<?php echo $age;  ?>" placeholder="20" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button name='process' onclick="calculate()" class="btn btn-success">Process</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-5">
                            <div class="card" style="min-height: 470px">
                                <div class="card-body">
                                    <center>
                                        <div class="m-b-30 no-block">
                                            <h6 class="card-title m-b-0 align-self-center">Minimum calories needed in daily life.</h6>
                                        </div>
                                    </center>
                                    <div style="height:290px; width:100%;">
                                        <center class="m-t-30">
                                            <span style="height: 250px; width: 250px; background-color: rgb(36, 210, 181); border-radius: 50%; display: inline-block;">

                                                <span style="margin-top: 12.5px; height: 225px; width: 225px; background-color: #FFFFFF; border-radius: 50%; display: inline-block;">
                                                    <br><br><br><br>
                                                    <h1 id='bmr' class="mt-2" style="font-size: 60px"><?php echo '1000';  ?></h1>
                                                    <h4>Kilo calories</h4>
                                                </span>
                                            </span>
                                        </center>
                                    </div>
                                    <center>
                                        <div class="m-b-30 no-block">
                                            <h6 class="card-title m-b-0 align-self-center text-danger">Latest calorie information.</h6>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                    </div>
                <!--</form>-->

                <!--<div class="row col-5">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Calories</h4>
                                <h6 class="card-subtitle">Show calories</h6>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Calories</th>
                                                <th>Latest time</th>
                                                <th>Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            /*$i = 1;
                                            while ($row2 = $result2->fetch_assoc()) {*/ ?>
                                                <tr>
                                                    <td><?php //echo $i ?></td>
                                                    <td><?php #echo $row2["calories"]; ?></td>
                                                    <td><?php #echo $row2["time_update"]; ?></td>
                                                    <td>
                                                        <a href="../main/delete-calculator.php?id=<?php //$row2["id"]; ?>"><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a></td>
                                                    </td>
                                                </tr>
                                            <?php /*$i++;
                                            }*/ ?>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->
            </div>
            <footer class="footer" style="padding-top:1rem !important;padding-bottom:1rem !important">
                <!--© 2020 Admin by sharing-thaifood.herokuapp.com-->
            </footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
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
        // On top
        $("a[href='#top']").click(function() {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            return false;
        });
    </script>

    <script>

        function genderVerify(gender) {
            if (gender.val() == "") {
                gender.css({'border':'1px solid red'});
                return 1;
            }
            gender.css({'border':'1px solid #ced4da'});
            return 0;
        }

        function heightVerify(height) {
            if (height.val() == "") {
                height.css({'border':'1px solid red'});
                return 1;
            }
            height.css({'border':'1px solid #ced4da'});
            return 0;
        }

        function weightVerify(weight) {
            if (weight.val() == "") {
                weight.css({'border':'1px solid red'});
                return 1;
            }
            weight.css({'border':'1px solid #ced4da'});
            return 0;
        }

        function ageVerify(age) {
            if (age.val() == "") {
                age.css({'border':'1px solid red'});
                return 1;
            }
            age.css({'border':'1px solid #ced4da'});
            return 0;
        }

        function calculate() {
            var gender = $('input[name=gender]:checked');
            var height = $('#height');
            var weight = $('#weight');
            var age = $('#age');
            var bmr = $('#bmr');
            var chk = 0;
        
            chk += genderVerify(gender);
            chk += heightVerify(height);
            chk += weightVerify(weight);
            chk += ageVerify(age);
            if( chk != 0){
                console.log('false');
                return false;
            }

            if ( gender.val() == 'male' ){
                var html = 66.47 + (13.75 * weight.val()) + (5.003 * height.val()) - (6.755 * age.val());
                bmr.html(html.toFixed(2));
            }else if ( gender.val() == 'female' ){
                var html = 655.1 + (9.563 * weight.val()) + (1.85 * height.val()) - (4.676 * age.val());
                bmr.html(html.toFixed(2));
            }
        }
    </script>

</body>

</html>