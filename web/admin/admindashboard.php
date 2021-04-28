<?php
session_start();
include '../main/connectAPI.php';
if (isset($_SESSION['id'])) {
    $session_login_id = $_SESSION['id'];
    $session_login_email = $_SESSION['email'];
    $session_login_status = $_SESSION['status'];
    $session_login_username = $_SESSION['username'];
    if ($session_login_status != "Admin") {
        header("Location: ../auth/login.php");
    }

    $url = 'user/all-user?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e';
    /*$result1 = mysqli_query($conn, $sql1);
    $resultuser = mysqli_query($conn, $sql1);*/
    $userdata = json_decode(getAPI($url),true);
    $usercount = count($userdata);

    $url = 'menu-detail/total-search-ingre?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&name=';
    $menucount = (int) getAPI($url);
    $url = 'menu-detail/ingre-name?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&name=&skip=0&limit=5';
    $menudata = json_decode(getAPI($url),true);
    
    //$url = 'user/user-id?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&id='.$session_login_id;
    //$food_allergiesdata = json_decode(getAPI($url),true);
    //$food_allergiescount = count($food_allergiesdata[0]['food_allergy']);
}else{
    header("Location: ../auth/login.php");
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
    <!--<div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Admin</p>
        </div>
    </div>-->
    <div id="main-wrapper">
        <?php include("../function/header-admin.php"); ?>
        <?php include("../function/list-admin.php"); ?>
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
                        <h3 class="text-themecolor">Dashboard</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Dashboard</li>
                        </ol>
                    </div>
                </div>
                <div class="row">
                    <!-- Column -->
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <center>
                                    <div class="row">
                                        <!-- user -->
                                        <div class="col">
                                            <i class="fa fa-user text-info" style="font-size: 5rem;" aria-hidden="true"></i>
                                            <h5 class=" card-title mt-2">User</h5>
                                            <h5 class=" card-title mt-2"><?php echo $usercount ?></h5>
                                        </div>
                                        <!-- Food -->
                                        <div class="col">
                                            <i class="fa fa-cutlery text-primary" style="font-size: 5rem;" aria-hidden="true"></i>
                                            <h5 class=" card-title mt-2">All Receipe</h5>
                                            <h5 class=" card-title mt-2"><?php echo $menucount ?></h5>
                                        </div>
                                        <!-- BMR Calculator -->
                                        <!--<din class="col">
                                            <i class="fa fa-calculator text-success" style="font-size: 5rem;" aria-hidden="true"></i>
                                            <h5 class=" card-title mt-2">BMR calulator</h5>
                                            <h5 class=" card-title mt-2"><?php #echo $caloriescount ?></h5>
                                        </din>-->
                                        <!-- Medical problems -->
                                        <!--<din class="col">
                                            <i class="fa fa-medkit text-danger" style="font-size: 5rem;" aria-hidden="true"></i>
                                            <h5 class=" card-title mt-2">Medical problems</h5>
                                            <h5 class=" card-title mt-2"><?php #echo $medical_problemscount ?></h5>
                                        </din>-->
                                        <!-- Food allergies -->
                                        <!--<din class="col">
                                            <i class="fa fa-ambulance text-warning" style="font-size: 5rem;" aria-hidden="true"></i>
                                            <h5 class=" card-title mt-2">Food allergies</h5>
                                            <h5 class=" card-title mt-2"><?php #echo $food_allergiescount ?></h5>
                                        </din>-->
                                    </div>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- Column -->
                    <div class="col-md-6">
                        <div class="card card-body mailbox">
                            <h5 class="card-title">Latest Update User</h5>
                            <div class="message-center ps ps--theme_default ps--active-y" style="min-height: 350px" data-ps-id="a045fe3c-cb6e-028e-3a70-8d6ff0d7f6bd">
                                <div class="table-responsive m-t-20 no-wrap">
                                    <table class="table vm no-th-brd pro-of-month">
                                        <thead>
                                            <tr>
                                                <th class="col-8" colspan="2">User Name</th>
                                                <th class="col-4">Last update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($userdata as $data){
                                                if( $data['admin'] != 'True' ){?>
                                                    <tr>
                                                        <td colspan="2"><?php echo $data["username"]; ?></td>
                                                        <td id="timeupdate"><?php 
                                                            echo date('m/d/Y H:i:s', (int) ((int)$data["update"]['$date'] / 1000));
                                                        ?></td>
                                                    </tr>
                                            <?php    }
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <!-- Column -->
                    <div class="col-md-6 ">
                        <div class="card card-body mailbox col-12">
                            <h5 class="card-title">Latest Update Food</h5>
                            <div class="message-center ps ps--theme_default ps--active-y col-12" style="min-height: 350px; " data-ps-id="a045fe3c-cb6e-028e-3a70-8d6ff0d7f6bd">
                                <div class="table-responsive m-t-20 no-wrap col-12" >
                                    <table class="table vm no-th-brd pro-of-month" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Food Name</th>
                                                <th>Last Update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach( $menudata as $data ) {?>
                                                <tr>
                                                    <td style="word-wrap: break-word; width: 50%;">
                                                        <?php echo $data["title"]; ?>
                                                    </td>
                                                    <td id="timeupdate" style="width: 50%;">
                                                        <?php if($data["update"] != ''){
                                                            echo date('m/d/Y H:i:s', (int) ((int)$data["update"]['$date'] / 1000)); 
                                                        }else{
                                                            echo "";
                                                        }?>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                </div>
                <!--<div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card card-body mailbox">
                            <h5 class="card-title">Latest Update BMR calulator</h5>
                            <div class="message-center ps ps--theme_default ps--active-y" style="height: 490px" data-ps-id="a045fe3c-cb6e-028e-3a70-8d6ff0d7f6bd">
                                <div class="table-responsive m-t-20 no-wrap">
                                    <table class="table vm no-th-brd pro-of-month">
                                        <thead>
                                            <tr>
                                                <th class="col-8" colspan="2">BMR calulator</th>
                                                <th class="col-4">time update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            #while ($rowcalories = mysqli_fetch_assoc($resultcalories)) { ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <h6><?php #echo $rowcalories["calories"]; ?></h6><small class="text-muted"><?php #echo $rowcalories["email"]; ?></small>
                                                    </td>

                                                    <td class="" id="timeupdate"><?php #echo $rowcalories["time_update"]; ?></td>
                                                </tr>
                                            <?php
                                            #} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <!-- Column -->
                    <!-- Column -->
                    <!--<div class="col-lg-6 col-md-12">
                        <div class="card card-body mailbox">
                            <h5 class="card-title">Latest Update Medical problems</h5>
                            <div class="message-center ps ps--theme_default ps--active-y" style="height: 490px" data-ps-id="a045fe3c-cb6e-028e-3a70-8d6ff0d7f6bd">
                                <div class="table-responsive m-t-20 no-wrap">
                                    <table class="table vm no-th-brd pro-of-month">
                                        <thead>
                                            <tr>
                                                <th class="col-8" colspan="2">Medical problems</th>
                                                <th class="col-4">time update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            #while ($rowmedical_problems = mysqli_fetch_assoc($resultmedical_problems)) { ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <h6><?php #echo $rowmedical_problems["tb_medical_problems"]; ?></h6><small class="text-muted"><?php #echo $rowmedical_problems["email"]; ?></small>
                                                    </td>

                                                    <td class="" id="timeupdate"><?php #echo $rowmedical_problems["time_update"]; ?></td>
                                                </tr>
                                            <?php
                                            #} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>-->
                    <!-- Column -->

                <!--</div> -->
                <!--<div class="row">
                    <div class="col-lg-6 col-md-12">
                        <div class="card card-body mailbox">
                            <h5 class="card-title">Latest Update Food allergies</h5>
                            <div class="message-center ps ps--theme_default ps--active-y" style="min-height: 350px" data-ps-id="a045fe3c-cb6e-028e-3a70-8d6ff0d7f6bd">
                                <div class="table-responsive m-t-20 no-wrap">
                                    <table class="table vm no-th-brd pro-of-month">
                                        <thead>
                                            <tr>
                                                <th class="col-8" colspan="2">Food allergies</th>
                                                <th class="col-4">time update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            #foreach($userdata[0]['food_allergy'] as $data){ ?>
                                                <tr>
                                                    <td colspan="2">
                                                        <h6><?php #echo $data; ?></h6>
                                                    </td>
                                                </tr>
                                            <?php #} ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>-->
                </div>
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
    <!--<script src="js/dashboard1.js"></script>->

    <script>
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