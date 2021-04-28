<?php
  session_start();
  include 'main/connectAPI.php';
  if (isset($_SESSION['id'])) {
    $session_login_id = $_SESSION['id'];
    $session_login_email = $_SESSION['email'];
    $session_login_status = $_SESSION['status'];
    $session_login_username = $_SESSION['username'];
  }

    $url = 'menu-detail/menu-id?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&id='.$_GET['id'];
    $resultmenu = json_decode(getAPI($url),true);
    $url = 'menu-detail/view?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e';
    $resultmenu2 = json_decode(getAPI($url),true);
    $url = 'user/user-id?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&id='.$resultmenu[0]['user'];
    $author = json_decode(getAPI($url),true);

    $url = 'recipe/view?foodid='.$_GET['id'];
    if(!isset($_COOKIE['visit_'.$_GET['id']])){
        setcookie('visit_'.$_GET['id'],'yes',time()+(60*60*24));
        $updateview = json_decode(getAPI($url),true);
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
    <link href="mainstyle/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom fonts for this template -->
    <link href="mainstyle/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="mainstyle/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet"
        type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">

    <link href="css/show-food.css" rel="stylesheet">

    <style>
        body {
            background-image: url(img/bg/flat-lay-2583213.webp);
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <?php include("function/navigation.php"); ?>

    <!-- Masthead -->
    <?php #include("function/search.php"); ?>

    <section class="container" >
        <div class="row">
            <div class="col-8">
                <div class="card" style="margin-top: 20px; box-shadow: 0 4px 5px rgba(0, 0, 0, 0.6); min-height: 670px">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4 m">
                                <div class="card" style="box-shadow: 0 4px 5px rgba(0, 0, 0, 0.6);">
                                    <center>
                                        <?php
                                            if (substr($resultmenu[0]["image"], 0, 10) != "food_image") {
                                                echo '<img class="card-img-left mt-2 mb-2" style="box-shadow: 0 4px 5px rgba(0, 0, 0, 0.6);" src="image_food/'.$resultmenu[0]["image"].'"  width="190" height="190" alt="Card image cap">';
                                            }else{
                                                echo '<img class="card-img-left mt-2 mb-2" style="box-shadow: 0 4px 5px rgba(0, 0, 0, 0.6);" src="https://keedurar.sirv.com/'.$resultmenu[0]["image"].'?h=190&w=190"  width="190" height="190" alt="Card image cap">';
                                            }
                                        ?>
                                        <h4 style="font-size: 18px; font-weight: bold;" class="card-title "><br>คุณค่าอาหาร</h4>
                                    </center>
                                    <div id="nutrition" style="height:260px; width:100%;"></div>
                                    <ul class="list-inline m-t-30 ml-4 font-12">
                                        <li><i class="fa fa-circle" style="color: #f7c672;"></i> คาร์โบไฮเดรต</li>
                                        <li><i class="fa fa-circle" style="color: #2580e8;"></i> คอเลสเตอรอล</li>
                                        <li><i class="fa fa-circle" style="color: #ed3c28;"></i> ไขมัน</li>
                                        <li><i class="fa fa-circle" style="color: #4be026;"></i> โปรตีน</li>
                                    </ul>
                                </div>
                                <!-- <div class="card mt-2" style="box-shadow: 0 4px 5px rgba(0, 0, 0, 0.6);">
                                    <div class="d-flex m-b-30 no-block">
                                        <h4 class="card-title m-b-0 align-self-center">คุณค่าอาหาร</h4>
                                    </div>
                                    <h4 class="card-title m-b-0 align-self-center">คุณค่าอาหาร</h4>
                                    <div id="visitor" style="height:260px; width:100%;"></div>
                                    <ul class="list-inline m-t-30 text-center font-12">
                                        <li><i class="fa fa-circle text-purple"></i> Tablet</li>
                                        <li><i class="fa fa-circle text-success"></i> Desktops</li>
                                        <li><i class="fa fa-circle text-info"></i> Mobile</li>
                                    </ul>
                                </div> -->
                            </div>
                            <div class="col-8">
                                <br>
                                <h3 style="font-size: 24px; font-weight: bold; word-break: break-word;" class="card-title"><?php echo $resultmenu[0]['title']; ?></h3>
                                <p class="card-text"><?php 
                                    if( isset($resultmenu[0]["description"]) ){
                                        echo $resultmenu[0]["description"];
                                    }else{
                                        echo '';
                                    } 
                                ?></p>
                                <br>
                                <div class="row">
                                    <span class="col-8"><h4 style="font-size: 18px; font-weight: bold;" class="card-title">วัตถุดิบ</h4></span>
                                    <span class="col-4" style="text-align: right"><?php echo '<h5 style="font-size: 16px; color: rgb(118, 121, 122)">สำหรับ  '.$resultmenu[0]['serve'].'  จาน</h5>'; ?></span>
                                </div>
                                <?php 
                                    echo '<div class="row">';
                                    foreach($resultmenu[0]['ingredients'] as $ing){
                                        echo '<div class="pl-4 col-6">';
                                        echo '<p style="font-size: 14px;">'. $ing['name'] .'</p>';
                                        echo '</div>';
                                        echo '<div class="col-3" style="text-align:right;">';
                                        echo '<p class="ml-5" style="font-size: 14px;">'. $ing['value'] .'</p>';
                                        echo '</div>';
                                        echo '<div class="col-3" style="text-align:right;">';
                                        echo '<p style="font-size: 14px;">'. $ing['unit'] .'</p>';
                                        echo '</div>';
                                    }
                                    echo '</div>';
                                ?>

                                <br>
                                <h4 style="font-size: 18px; font-weight: bold;" class="card-title">ขั้นตอนการทำ</h4>

                                <?php 
                                    $num = 1;
                                    echo '<div class="row">';
                                    foreach($resultmenu[0]['preparations'] as $ing){
                                        echo '<div class="pl-4 col-2">';
                                        echo '<p style="font-size: 14px;">'. $num .'</p>';
                                        echo '</div>';
                                        echo '<div class="col-10" style="text-align:left;padding:0;margin-left:0;">';
                                        echo '<p style="margin-left:5px; padding:0; font-size: 14px;">'. $ing .'</p>';
                                        echo '</div>';
                                        $num++;
                                    }
                                    echo '</div>';
                                ?>
                                <br>
                                <h4 style="font-size: 18px; font-weight: bold;">ผู้เขียน</h4>
                                <div class="col pl-3">
                                    <?php 
                                        if($author != null){
                                            echo '<div style="margin-right: 5px; display: inline-block;"><img src="'.$author[0]['image'].'" id="blah" alt="your image" class="img-circle" width="40" height="40" /></div> 
                                            <div style="display: inline-block;"><p style="font-size: 16px; font-weight:bold;">'.$author[0]['username'].'</p></div>';
                                        }else{
                                            echo '<div style="margin-right: 5px; display: inline-block;"><img src="image_profile/default-profile.png" id="blah" alt="your image" class="img-circle" width="40" height="40" /></div> 
                                            <div style="display: inline-block;"><p style="font-size: 16px; font-weight:bold;">Admin</p></div>';
                                        }
                                    ?>
                                </div>
                                <!--<h4>อ้างอิง</h4>
                                <div class="col pl-3">
                                    https://www.wongnai.com/recipes/ugc/7b9ac2dcbf0d4a64b8bda6539ae75ba5</div>-->
                                <!-- <br>
                                <h5 class="">โภชนาการ</h5>
                                <p class="ml-4">คาร์โบไฮเดรต: 10 g ให้พลังงาน <?php #echo 10*4 ?> kcal</p>
                                <p class="ml-4">ไขมัน: 10 g ให้พลังงาน <?php #echo 10*9 ?> kcal</p>
                                <p class="ml-4">โปรตีน: 10 g ให้พลังงาน <?php #echo 10*4 ?> kcal</p>
                                <div class="card shadow mb-4">
                                    <div class="card-body">
                                        <div class="chart-bar">
                                            <canvas id="myBarChart"></canvas>
                                        </div>
                                        <hr>
                                        <p> คาร์โบไฮเดรต 1 กรัม ให้พลังงาน 4 กิโลแคลอรี</p>
                                        <p> ไขมัน 1 กรัม ให้พลังงาน 9 กิโลแคลอรี</p>
                                        <p> โปรตีน 1 กรัม ให้พลังงาน 4 กิโลแคลอรี</p>
                                        <p></p>
                                        <p></p>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-4">
                <div class="card" style="margin-top: 20px; box-shadow: 0 4px 5px rgba(0, 0, 0, 0.6); min-height: 670px">
                    <div class="card-body">
                        <center>
                            <h5 class="card-title">อาหารแนะนำ</h5>
                        </center>
                        <?php
                            foreach( $resultmenu2 as $rowmenu){
                        ?>
                        <div class="row mb-3">
                            <div class="col-4">
                                <?php
                                    if (substr($rowmenu["image"], 0, 10) != "food_image") {
                                        echo '<img class="card-img-left rounded-circle" src="image_food/'.$rowmenu["image"].'"  width="100" height="100" alt="Card image cap">';
                                    }else{
                                        echo '<img class="card-img-left rounded-circle" src="https://keedurar.sirv.com/'.$rowmenu["image"].'?h=100&w=100"  width="100" height="100" alt="Card image cap">';
                                    }
                                ?>
                                <!--<img class="card-img-left rounded-circle"
                                    src="<?php #if ($rowmenu["image"] != null) { echo $rowmenu["image"]; } else { echo "https://icons-for-free.com/iconfiles/png/512/food+icon-1320167995070278295.png"; }  ?>"
                                    width="100" height="100" alt="Card image cap">-->
                            </div>
                            <div class="col-8"> <?php echo $rowmenu["title"]; ?>
                                <?php echo '<a class="link" href=show-food.php?id='. (int)$rowmenu['_id'] .'>'. "<br>Read more"; ?></a>
                            </div>
                        </div>
                        <?php
                            }; 
                        ?>

                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- Footer -->
    <?php include("function/footer.php"); ?>

    <!-- Bootstrap core JavaScript -->
    <script src="mainstyle/jquery/jquery.min.js"></script>
    <script src="mainstyle/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!--Chart Pie -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/d3/3.5.5/d3.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/c3/0.4.10/c3.min.css" rel="stylesheet" />

    <!--<script src="admin/assets/node_modules/jquery/jquery.min.js"></script>
    <script src="admin/assets/node_modules/d3/d3.min.js"></script>
    <script src="admin/assets/node_modules/c3-master/c3.min.js"></script>
    <script src="admin/js/dashboard1.js"></script>-->

    <script>
        // On top
        $("a[href='#top']").click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            return false;
        });

        // chart
        var chart = c3.generate({
            bindto: '#nutrition',
            size: {
                height: 200,
                width: 200
            },
            data: {
                columns: [
                    ['carbohydrates', <?php echo number_format((float)$resultmenu[0]["nutrition"]["carbohydrates"]["quantity"], 2, '.', '')?>],
                    ['cholesterol', <?php echo number_format((float)$resultmenu[0]["nutrition"]["cholesterol"]["quantity"]/100, 2, '.', '')?>],
                    ['fat', <?php echo number_format((float)$resultmenu[0]["nutrition"]["fat"]["quantity"], 2, '.', '')?>],
                    ['protein', <?php echo number_format((float)$resultmenu[0]["nutrition"]["protein"]["quantity"], 2, '.', '')?>],
                ],
                type : 'donut'
            },
            donut: {
                title: "<?php echo number_format((float)$resultmenu[0]["nutrition"]["calories"]["quantity"]/$resultmenu[0]['serve'], 0, '.', '')?>",
                width: 15,
                label: {
                    show: false
                }
            },
            color: {
                pattern: ['#f7c672', '#2580e8', '#ed3c28','#4be026']
            },
            legend: {
                show: false
            }
        });

        d3.select(".c3-chart-arcs-title")
        .append("tspan")
        .attr("dy", 10)
        .attr("x", 0)
        .text(" ")
        
        d3.select(".c3-chart-arcs-title")
        .append("tspan")
        .attr("dy", 16)
        .attr("x", 0)
        .text("CALORIES")
        .style('font-size', '12px');

        d3.select(".c3-chart-arcs-title")
        .style('font-size', '35px');
    </script>
</body>

</html>