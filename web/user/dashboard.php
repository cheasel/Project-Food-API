<?php
session_start();
include '../main/connectAPI.php';
if (isset($_SESSION['id'])) {
    $session_login_id = $_SESSION['id'];
    $session_login_email = $_SESSION['email'];
    $session_login_username = $_SESSION['username'];
    $session_login_status = $_SESSION['status'];
    if ($session_login_status != "User") {
        header("Location: ../auth/login.php");
    }

    $url = 'menu-detail/user-id?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&id='.$session_login_id;
    $menudata = json_decode(getAPI($url),true);
    
    $url = 'user/user-id?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&id='.$session_login_id;
    $result = json_decode(getAPI($url),true);
    $age = $result[0]["age"];
    $gender = $result[0]["gender"];     // male = 1 , female = 2
    $height = $result[0]["height"];
    $weight = $result[0]["weight"];
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
            <p class="loader__label">Sharing Thai Food</p>
        </div>
    </div>-->
    <div id="main-wrapper">
        <?php include("../function/header-user.php"); ?>
        <?php include("../function/list-user.php"); ?>
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
                    <div class="col-lg-7" >
                        <div class="card card-body mailbox" style="min-height: 470px">
                            <h5 class="card-title">Latest Update Food</h5>
                            <div class="message-center ps ps--theme_default ps--active-y" data-ps-id="a045fe3c-cb6e-028e-3a70-8d6ff0d7f6bd">
                                <div class="table-responsive m-t-20 no-wrap">
                                    <table class="table vm no-th-brd pro-of-month">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Food Name</th>
                                                <th>Latest Update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            if ( $menudata != '' ) {
                                                foreach( $menudata as $result ){
                                                    #while ($row = mysqli_fetch_assoc($result)) { ?>
                                                    <tr>
                                                        <td><?php echo $i; ?></td>
                                                        <td><?php echo $result["title"]; ?></td>
                                                        <td><?php echo date('m/d/Y H:i:s', (int) ((int)$result["update"]['$date'] / 1000)); ?></td>
                                                    </tr>
                                                <?php $i++;
                                                } 
                                            }?>
                                            <!--foreach($menudata as $row){?>
                                                <tr>
                                                    <td><span class="round"><img src="../assets/images/users/2.jpg" alt="user" width="50"></span></td>
                                                    <td class="col-8">
                                                        <h6><?php #echo $row["title"]; ?></h6><small class="text-muted">Project Manager</small>
                                                    </td>
                                                    <td id="timeupdate"><?php #echo $row["update"]; ?></td>
                                                </tr>
                                            <?php #} ?>-->
                                        </tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column -->
                    <div class="col-lg-5" >
                        <div class="card" style="min-height: 470px">
                            <div class="card-body">
                                <center>
                                    <div class="m-b-30 no-block">
                                        <h6 class="card-title m-b-0 align-self-center">Minimum calories needed in daily life.</h6>
                                    </div>
                                </center>
                                <div style="height:290px; width:100%;">
                                    <center class="m-t-30">
                                        <span style="height: 260px; width: 260px; background-color: rgb(36, 210, 181); border-radius: 50%; display: inline-block;">
                                            <span style="margin-top: 10px; height: 240px; width: 240px; background-color: #FFFFFF; border-radius: 50%; display: inline-block;">
                                                <br><br><br><br>
                                                <h1 id='bmr' class="mt-2" style="font-size: 60px">
                                                <?php 
                                                    if ( $height != '' and $weight != '' and $age != '' ){
                                                        if ( $gender == '1' ){
                                                            $bmr = 66.47 + (13.75 * $weight) + (5.003 * $height) - (6.755 * $age);
                                                            echo number_format((float)$bmr, 2, '.', '');
                                                        }else{
                                                            $bmr = 655.1 + (9.563 * $weight) + (1.85 * $height) - (4.676 * $age);
                                                            echo number_format((float)$bmr, 2, '.', '');
                                                        }
                                                    }else{
                                                        echo '0';
                                                    };  
                                                ?>
                                                </h1>
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
                    <!-- Column -->
                    <!--<div class="col-lg-4">
                        <div class="card">
                            <div class="up-img" style="background-image:url(../img/Fried-rice.jpg)"></div>
                            <div class="card-body">
                                <h5 class=" card-title">Latest update</h5>
                                <span class="label label-info label-rounded"><?php //echo $title ?></span>
                                <p class="m-b-0 m-t-20"><?php //echo $Additional_explanation ?>
                                </p>
                            </div>
                        </div>
                    </div>-->
                </div>
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

</body>

</html>