<?php
    session_start();
    include '../main/connectAPI.php';
    if (isset($_SESSION['id'])) {
        $session_login_id = $_SESSION['id'];
        $session_login_email = $_SESSION['email'];
        $session_login_username = $_SESSION['username'];
        $session_login_status = $_SESSION['status'];
    }

    $page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
    $limit = 20;
    $skip = ($page - 1) * $limit;
    if( ( isset($_POST['min-cal']) or isset($_POST['ingredient']) ) ){
        $check = 1;

        $ingredients = explode(",", $_POST['ingredient']);
        $exingredients = explode(",", $_POST['ex_ingredient']);
        /*$ingredients = array();
        if(isset($_POST['ingredient'])){
            for($i=0; $i < count($_POST['ingredient']); $i++) {
                array_push($ingredients, $_POST['ingredient'][$i]);
            }
        }*/
        /*$data_array =  array(
            "title" => !empty($_POST['search'])? $_POST['search'] : '',
            "mincal" => !empty($_POST['min-cal'])? $_POST['min-cal'] : 0,
            "maxcal" => !empty($_POST['max-cal'])? $_POST['max-cal'] : 9999,
            "name" => $ingredients
        );*/
        $data_array =  array(
            "title" => !empty($_POST['search'])? $_POST['search'] : '',
            "mincal" => !empty($_POST['min-cal'])? $_POST['min-cal'] : 0,
            "maxcal" => !empty($_POST['max-cal'])? $_POST['max-cal'] : 9999,
            "minchol" => !empty($_POST['min-chol'])? $_POST['min-chol'] : 0,
            "maxchol" => !empty($_POST['max-chol'])? $_POST['max-chol'] : 9999,
            "mincarb" => !empty($_POST['min-carb'])? $_POST['min-carb'] : 0,
            "maxcarb" => !empty($_POST['max-carb'])? $_POST['max-carb'] : 9999,
            "minfat" => !empty($_POST['min-fat'])? $_POST['min-fat'] : 0,
            "maxfat" => !empty($_POST['max-fat'])? $_POST['max-fat'] : 9999,
            "minprotein" => !empty($_POST['min-protein'])? $_POST['min-protein'] : 0,
            "maxprotein" => !empty($_POST['max-protein'])? $_POST['max-protein'] : 9999,
            "name" => $ingredients,
            "exname" => $exingredients
        );
        $url = 'menu-detail/advance-search?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e';
        $resultmenu = json_decode(postAPI($url,json_encode($data_array, true)));
        //$total = postAPI('menu-detail/total-advance-search?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e',json_encode($data_array, true));
    }else{
        $check = 0;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $url = 'menu-detail/ingre-name?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&name='.urlencode($search);
        $resultmenu = json_decode(getAPI($url),true);
        //$total = getAPI('menu-detail/total-search-ingre?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&name='.urlencode($search));
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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>

    <!-- Tags Input -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput-angular.min.js" integrity="sha512-KT0oYlhnDf0XQfjuCS/QIw4sjTHdkefv8rOJY5HHdNEZ6AmOh1DW/ZdSqpipe+2AEXym5D0khNu95Mtmw9VNKg==" crossorigin="anonymous"></script>

    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="css/pages/dashboard1.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/default.css" id="theme" rel="stylesheet">

    <!-- Bootstrap core JavaScript -->
    <script src="../mainstyle/jquery/jquery.min.js"></script>
    <script src="../mainstyle/bootstrap/js/bootstrap.bundle.min.js"></script>

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

    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <link href="../css/show-food.css" rel="stylesheet">
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
                        <h3 class="text-themecolor">Recipe</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">All Recipe</li>
                        </ol>
                    </div>
                    <div class="col-md-7 align-self-center">
                        <a href="../main/add-menu.php" class="btn waves-effect waves-light btn btn-info pull-right hidden-sm-down">Add Food <i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                    </div>
                </div>
                <div class="row">
                    <!-- column -->
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body row">
                                <div class="col-8">
                                    <h4 class="card-title">Recipe</h4>
                                    <h6 class="card-subtitle">Manage Recipe</h6>
                                </div>
                                <div class="col-4 admin-search-container">
                                    <div class='admin-search'>
                                        <i class="fa fa-search"></i>
                                        <input style="width: 75%;" type="text" placeholder="ค้นหาจากชื่อเมนู, วัตถุดิบ" name="search">
                                        <button type="button" id="filter-but"><i class="fa fa-filter"></i></button>
                                    </div>
                                </div>
                                <form action="allfood.php" method="POST" >
                                    <div class="col-12 table-responsive" style="margin: 5px 10px 5px 10px; display:none;" id="filter-box">
                                    <div class="col-12">
                                        <h6>ADVANCE SEARCH</h6>
                                    </div>
                                    <div class="row">
                                        <label class="col-12" style="padding-left: 28px;">Nutrition</label>
                                        <div class="row col-6">
                                            <label class="col-12" style="padding-left: 56px;">Calories</label>
                                            <div class="col-1">
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="min-cal" placeholder="0" value="0" class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                                            </div>
                                            <div class="col-1">
                                                <i class="fa fa-minus" style="width: 40px; font-size: 10px; padding-left: auto;" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="max-cal" placeholder="9999" value="9999" class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                                            </div>
                                        </div>
                                        <div class="row col-6">
                                            <label class="col-12" style="padding-left: 56px;">Cholesterol</label>
                                            <div class="col-1">
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="min-chol" placeholder="0" value="0" class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                                            </div>
                                            <div class="col-1">
                                                <i class="fa fa-minus" style="width: 40px; font-size: 10px; padding-left: auto;" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="max-chol" placeholder="9999" value="9999" class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                                            </div>
                                        </div>
                                        <div class="row col-6">
                                            <label class="col-12" style="padding-left: 56px; margin-top: 5px;">Carbohydrate</label>
                                            <div class="col-1">
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="min-carb" placeholder="0" value="0" class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                                            </div>
                                            <div class="col-1">
                                                <i class="fa fa-minus" style="width: 40px; font-size: 10px; padding-left: auto;" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="max-carb" placeholder="9999" value="9999" class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                                            </div>
                                        </div>
                                        <div class="row col-6" style="margin-top: 5px;">
                                            <label class="col-12" style="padding-left: 56px;">Protein</label>
                                            <div class="col-1">
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="min-protein" placeholder="0" value="0" class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                                            </div>
                                            <div class="col-1">
                                                <i class="fa fa-minus" style="width: 40px; font-size: 10px; padding-left: auto;" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="max-protein" placeholder="9999" value="9999" class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                                            </div>
                                        </div>
                                        <div class="row col-6" style="margin-top: 5px; margin-bottom: 15px;">
                                            <label class="col-12" style="padding-left: 56px;">Fat</label>
                                            <div class="col-1">
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="min-fat" placeholder="0" value="0" class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                                            </div>
                                            <div class="col-1">
                                                <i class="fa fa-minus" style="width: 40px; font-size: 10px; padding-left: auto;" aria-hidden="true"></i>
                                            </div>
                                            <div class="col-5">
                                                <input type="text" name="max-fat" placeholder="9999" value="9999" class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                                            </div>
                                        </div>
                                        <label class="col-12" style="padding-left:28px;">Ingredients</label>
                                        <label class="col-12" style="padding-left:56px;">include &nbsp : </label>
                                        <div class="col-12" style="padding-left:76px; padding-right:76px; margin-bottom: .5rem;">
                                            <input type="text" data-role="tagsinput" name="ingredient" class="form-control" >
                                        </div>
                                        <label class="col-12" style="padding-left:56px;">exclude &nbsp : </label>
                                        <div class="col-12" style="padding-left:76px; padding-right:76px;">
                                            <input type="text" data-role="tagsinput" name="ex_ingredient" class="form-control">
                                        </div>
                                        <div class="col-12" style="margin: 10px 0 10px 0;">
                                            <div class="row">
                                                <div class="col-4"></div>
                                                <div class="col">
                                                    <input type="reset" class="form-control btn btn-danger text-white" placeholder="Search & enter">
                                                </div>
                                                <div class="col">
                                                    <input type="submit" class="form-control bg-success text-white" placeholder="Search & enter">
                                                </div>
                                                <div class="col-4"></div>
                                            </div>
                                        </div>
                                    </div>  
                                        <!-- <div class="col-12" style="padding-left: 0; font-size: 1.1rem;">
                                            <i class="fa fa-times pull-right" id="close-filter"></i>
                                        </div> -->
                                        <!--<div class="col-12">
                                            <h6>ADVANCE SEARCH</h6>
                                        </div>
                                            <div class="row">
                                                <div class="col-6 form-group">
                                                    <label class="col-12">min calories</label>
                                                    <div class="col-8">
                                                        <input type="text" name="min-cal" placeholder="0" value="0"
                                                            class="form-control form-control-line"
                                                            style="min-height: 20px; font-size: 14px;">
                                                    </div>
                                                </div>
                                                <div class="col-6 form-group">
                                                    <label class="col-12">max calories</label>
                                                    <div class="col-8">
                                                        <input type="text" name="max-cal" placeholder="9999" value="9999"
                                                            class="form-control form-control-line"
                                                            style="min-height: 20px; font-size: 14px;">
                                                    </div>
                                                </div>
                                                <label class="col-12" style="padding-left:28px;">ingredients</label>
                                                <div id="checkbox-container" class="row col-12">
                                                <div class="col-1">
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="ingredient1" name='ingredient[]' value="หมู">
                                                    <label for="ingredient1"> หมู</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="ingredient2" name="ingredient[]" value="ไก่">
                                                    <label for="ingredient2"> ไก่</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="ingredient3" name="ingredient[]"
                                                        value="กุ้ง">
                                                    <label for="ingredient3"> กุ้ง</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="ingredient4" name="ingredient[]"
                                                        value="ปลาหมึก">
                                                    <label for="ingredient4"> ปลาหมึก</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="ingredient5" name="ingredient[]" value="ปลา">
                                                    <label for="ingredient5"> ปลา</label>
                                                </div>
                                                <div class="col-1">
                                                </div>
                                                <div class="col-1">
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="ingredient6" name="ingredient[]" value="ไข่">
                                                    <label for="ingredient6"> ไข่</label>
                                                </div>
                                                </div>
                                                <div class="col-12">
                                                    <div class="row">
                                                        <div class="col-4"></div>
                                                        <div class="col">
                                                            <input type="reset"
                                                                class="form-control btn btn-danger text-white"
                                                                placeholder="Search & enter">
                                                        </div>
                                                        <div class="col">
                                                            <input type="submit" class="form-control bg-success text-white"
                                                                placeholder="Search & enter">
                                                        </div>
                                                        <div class="col-4"></div>
                                                    </div>
                                                </div>
                                            </div>-->
                                    </div>
                                </form>
                                
                                <!--<div class="col-12 table-responsive" style="margin: 5px 10px 5px 10px; display:none;" id="filter-box">
                                    <div class="col-12" style="padding-left: 0; font-size: 1.1rem;">
                                        <i class="fa fa-times" id="close-filter"></i>
                                    </div>
                                    <div class="col-12">
                                        <h6>ADVANCE SEARCH</h6>
                                    </div>
                                    <form id="advance-search-form" action="allfood.php" method="POST">
                                        <div class="row">
                                            <div class="col-6 form-group">
                                                <label class="col-12">min calories</label>
                                                <div class="col-8">
                                                    <input type="text" name="min-cal" placeholder="0" value="<?php echo isset($_POST['min-cal']) ? $_POST['min-cal'] : '' ?>" class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                                                </div>
                                            </div>
                                            <div class="col-6 form-group">
                                                <label class="col-12">max calories</label>
                                                <div class="col-8">
                                                    <input type="text" name="max-cal" placeholder="9999" value="<?php echo isset($_POST['max-cal']) ? $_POST['max-cal'] : '' ?>" class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                                                </div>
                                            </div>
                                            <label class="col-12" style="padding-left:28px;">ingredients (maximum 3)</label>
                                            <div id="checkbox-container" class="row col-12">
                                                <div class="col-1">
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="ingredient1" name='ingredient[]' value="หมู">
                                                    <label for="ingredient1"> หมู</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="ingredient2" name="ingredient[]" value="ไก่">
                                                    <label for="ingredient2"> ไก่</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="ingredient3" name="ingredient[]" value="กุ้ง">
                                                    <label for="ingredient3"> กุ้ง</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="ingredient4" name="ingredient[]" value="ปลาหมึก">
                                                    <label for="ingredient4"> ปลาหมึก</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="ingredient5" name="ingredient[]" value="ปลา">
                                                    <label for="ingredient5"> ปลา</label>
                                                </div>
                                                <div class="col-1">
                                                </div>
                                                <div class="col-1">
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="ingredient6" name="ingredient[]" value="ไข่">
                                                    <label for="ingredient6"> ไข่</label>
                                                </div>
                                                <div class="col-2">
                                                    <input type="checkbox" id="ingredient7" name="ingredient[]" value="ข้าว">
                                                    <label for="ingredient7"> ข้าว</label>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <center>
                                                    <input type="reset"></input>
                                                    <input type="submit"></input>
                                                </center>
                                            </div>
                                        </div>
                                    </form>
                                </div>-->
                                <div class="col-12 table-responsive">
                                    <table class="table" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th style="width: 5%;">#</th>
                                                <th style="width: 45%;">Name</th>
                                                <th style="width: 20%;">Calories (kcal)</th>
                                                <th style="width: 20%;">Date Add</th>
                                                <th style="width: 10%;">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">

                                        </tbody>
                                        <!--<tbody>
                                            <?php
                                            #$i = (($page - 1) * $limit) + 1;
                                            #foreach($resultmenu as $row){ ?>
                                                <tr>
                                                    <td><?php #echo $i ?></td>
                                                    <td>
                                                        <h6><?php #echo $row["title"]; ?></h6>
                                                    </td>
                                                    <td><?php #echo number_format((float)$row['nutrition']['calories']['quantity'], 2, '.', ''); ?></td>
                                                    <td><?php #echo date('m/d/Y H:i:s', (int) ((int)$row["date_add"]['$date'] / 1000)); ?></td>
                                                    <td>
                                                        <a href="<?php #echo '../main/edit-food.php?id='. $row["_id"] ?>"><i class="fa fa-pencil-square-o text-success mr-3" style="font-size: 1.25rem;"></i></a>
                                                        <a href="#exampleModal" data-toggle="modal" data-id="<?php #echo $row["_id"] ?>" class="open-modal"><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                    </td>
                                                </tr>
                                                <?php# $i++;
                                            #} ?>
                                        </tbody>-->
                                    </table>
                                    <div>
                                        <center><div id="pagination-wrapper"></div></center>
                                    </div>
                                    <?php #include('../function/pagination.php');?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End PAge Content -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
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
    
    <script>
        // On top
        $("a[href='#top']").click(function() {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            return false;
        });

        $(document).on("click", ".open-modal", function () {
            var foodId = $(this).data('id');
            $("#foodId").val( foodId );
        });

        // filter-box toggle
        $("#filter-but").click(function(){
            $("#filter-box").toggle();
        });

        // close-filter button 
        $("#close-filter").click(function(){
            $("#filter-box").hide();
        });

        // remain checkbox checked
        var checkboxValues = JSON.parse(localStorage.getItem('checkboxValues')) || {},$checkboxes = $("#checkbox-container :checkbox");

        $checkboxes.on("change", function(){
            $checkboxes.each(function(){
                checkboxValues[this.id] = this.checked;
            });
            
            localStorage.setItem("checkboxValues", JSON.stringify(checkboxValues));
        });

        $( document ).ready(function() {
            // limit checkbox
            var max_limit = 3; // Max Limit
            $("input:checkbox").each(function (index){
                this.checked = ("input:checkbox" < max_limit);
            }).change(function (){
                if ($("input:checkbox:checked").length > max_limit){
                    this.checked = false;
                }
            });

            if( <?php echo $check ?> == 1 ){
                $.each(checkboxValues, function(key, value) {
                    $("#" + key).prop('checked', value);
                });
            }else {
                localStorage.removeItem("checkboxValues");
            }
        });

    </script>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h3 class="modal-title" id="exampleModalLabel">Delete</h3>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <h5>You want to delete a receipe ?</h5>
        </div>
        <div class="modal-footer">
            <form action="../function/delete-food.php" method="POST">
                <input type="hidden" name="foodId" id="foodId" value=""/>
                <input type="hidden" name="status" id="status" value="<?php echo $session_login_status ?>"/>
                <button type="button" class="btn btn-info" data-dismiss="modal">Cancle</button>
                <button type="submit" class="btn btn-danger">Delete</button>
            </form>
        </div>
        </div>
    </div>
    </div>

    <script>
    var tableData = <?php print json_encode($resultmenu) ?>;
    console.log(tableData)

    /*
        1 - Loop Through Array & Access each value
    2 - Create Table Rows & append to table
    */


    var state = {
        'querySet': tableData,

        'page': 1,
        'rows': 20,
        'window': 5,
    }

    buildTable()

    function pagination(querySet, page, rows) {

        var trimStart = (page - 1) * rows
        var trimEnd = trimStart + rows

        var trimmedData = querySet.slice(trimStart, trimEnd)

        var pages = Math.round(querySet.length / rows);

        return {
            'querySet': trimmedData,
            'pages': pages,
        }
    }

    function pageButtons(pages) {
        var wrapper = document.getElementById('pagination-wrapper')

        wrapper.innerHTML = ``
        console.log('Pages:', pages)

        var maxLeft = (state.page - Math.floor(state.window / 2))
        var maxRight = (state.page + Math.floor(state.window / 2))

        if (maxLeft < 1) {
            maxLeft = 1
            maxRight = state.window
        }

        if (maxRight > pages) {
            maxLeft = pages - (state.window - 1)

            if (maxLeft < 1) {
                maxLeft = 1
            }
            maxRight = pages
        }



        for (var page = maxLeft; page <= maxRight; page++) {
            wrapper.innerHTML += `<button value=${page} class="page btn btn-sm btn-info" style="margin-right:5px;">${page}</button>`
        }

        if (state.page != 1) {
            wrapper.innerHTML = `<button value=${1} class="page btn btn-sm btn-info" style="margin-right:5px;">&#171; First</button>` + wrapper.innerHTML
        }

        if (state.page != pages) {
            wrapper.innerHTML += `<button value=${pages} class="page btn btn-sm btn-info" style="margin-right:5px;">Last &#187;</button>`
        }

        $('.page').on('click', function() {
            $('#table-body').empty()

            state.page = Number($(this).val())

            buildTable()
        })

    }


    function buildTable() {
        var table = $('#table-body')

        var data = pagination(state.querySet, state.page, state.rows)
        var myList = data.querySet

        for (var i = 1 in myList) {
            //Keep in mind we are using "Template Litterals to create rows"
            var date = new Date((myList[i].date_add.$date));
            var datevalues = ("0" + (date.getUTCMonth() + 1)).slice(-2)+'/'+("0" + date.getUTCDate()).slice(-2)+'/'+date.getUTCFullYear()+' '+("0" + date.getUTCHours()).slice(-2)+':'+("0" + date.getUTCMinutes()).slice(-2)+':'+("0" + date.getUTCSeconds()).slice(-2);

            var row = `<tr>
                        <td style="width: 5%;">${(Number(i)+1)+((state.page-1)*state.rows)} </td>
                        <td style="width: 45%;">${myList[i].title}</td>
                        <td style="width: 20%;">${(myList[i].nutrition.calories.quantity).toFixed(2)}</td>
                        <td style="width: 20%;">${datevalues}</td>
                        <td style="width: 10%;">
                            <a href="../main/edit-food.php?id=${myList[i]._id}"><i class="fa fa-pencil-square-o text-success mr-3" style="font-size: 1.25rem;"></i></a>
                            <a href="#exampleModal" data-toggle="modal" data-id="${myList[i]._id}" class="open-modal"><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                        </td>
                    `
            table.append(row)
        }

        pageButtons(data.pages)
    }
</script>
</body>

</html>
    <td><?php #echo number_format((float)$row['nutrition']['calories']['quantity'], 2, '.', ''); ?></td>
    <td><?php #echo date('m/d/Y H:i:s', (int) ((int)$row["date_add"]['$date'] / 1000)); ?></td>
                                                    