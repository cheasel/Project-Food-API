<?php
    //include 'cache/top-cache.php';
    session_start();
    include 'main/connectAPI.php';
    if (isset($_SESSION['id'])) {
        $session_login_id = $_SESSION['id'];
        $session_login_email = $_SESSION['email'];
        $session_login_status = $_SESSION['status'];
        $session_login_username = $_SESSION['username'];
    }

    $search = isset($_GET['search']) ? $_GET['search'] : '';

    if( ( isset($_POST['min-cal']) or isset($_POST['ingredient']) ) ){
        $check = 1;
        //$ingredients = array();
        //$exingredients = array();
        $ingredients = explode(",", $_POST['ingredient']);
        $exingredients = explode(",", $_POST['ex_ingredient']);
        /*if(isset($_POST['ingredient'])){
            for($i=0; $i < count($_POST['ingredient']); $i++) {
                array_push($ingredients, $_POST['ingredient'][$i]);
            }
        }
        if(isset($_POST['ex_ingredient'])){
            for($i=0; $i < count($_POST['ex_ingredient']); $i++) {
                array_push($exingredients, $_POST['ex_ingredient'][$i]);
            }
        }*/
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
        $resultmenu = postAPI($url,json_encode($data_array, true));
    }else{
        $check = 0;
        $url = 'menu-detail/ingre-name?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&name='.urlencode($search);
        $resultmenu = getAPI($url);
    }
    //$total = getAPI('menu-detail/total-search-ingre?username=cheasel&api_key=fe1913c8bddda7fbf1b050c92949ef887c97369bb965bc866bcbc9c15d65154e&name='.urlencode($search));
    //print json_encode($resultmenu);
    //$check = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Language" content="th" />
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
    <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic&display=swap" rel="stylesheet" type="text/css">

    <!-- Custom styles for this template -->
    <link href="css/landing-page.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">

    <!-- Tags Input -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css" integrity="sha512-xmGTNt20S0t62wHLmQec2DauG9T+owP9e6VU8GigI0anN7OXLip9i7IwEhelasml2osdxX71XcYm6BQunTQeQg==" crossorigin="anonymous" />
    
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link href="css/show-food.css" rel="stylesheet">

    <style>
        body {
            background-image: url(img/bg/flat-lay-2583213.webp);
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
        }
        .show-menu a {
            color: black;
            font-size: 16px;
            font-weight: bold;
            white-space: nowrap;
        }
        .half-circle {
            width: 46px;
            height: 23px; /* as the half of the width */
            background-color: white;
            border-bottom-left-radius: 110px;  /* 100px of height + 10px of border */
            border-bottom-right-radius: 110px; /* 100px of height + 10px of border */
            box-shadow: 0 4px 5px rgba(0, 0, 0, 0.2);
            border-top: 0;
            margin-bottom: 20px;
            position: relative;
            z-index: 3;
        }

        .bootstrap-tagsinput{
            width: 100%;
        }
        .label-info{
            background-color: #17a2b8;

        }
        .label {
            display: inline-block;
            padding: .25em .4em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,
            border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }

        .ui-corner-all
        {
            -moz-border-radius: 4px 4px 4px 4px;
        }
        .ui-widget-content
        {
            border: 10px solid black;
            color: #222222;
            background-color: white;
        }
        .ui-widget
        {
            font-family: Verdana,Arial,sans-serif;
            font-size: 15px;
        }
        .ui-menu
        {
            display: block;
            float: left;
            list-style: none outside none;
            margin: 0;
            padding: 2px;
            width: 400px;
            height: fit-content;
        }
        .ui-autocomplete
        {
            cursor: default;
            position: absolute;
        }
        .ui-menu .ui-menu-item
        {
            clear: left;
            float: left;
            margin: 0;
            padding: 0;
            width: 100%;
        }
        .ui-menu .ui-menu-item a
        {
            display: block;
            padding: 3px 3px 3px 3px;
            text-decoration: none;
            cursor: pointer;
            background-color: Green;
        }
        .ui-menu .ui-menu-item a:hover
        {
            display: block;
            padding: 3px 3px 3px 3px;
            text-decoration: none;
            color: White;
            cursor: pointer;
            background-color: ButtonText;
        }
        .ui-widget-content a
        {
            color: #222222;
        }
    </style>
</head>

<body>
    <!-- loading -->
    <!--<div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Sharing Thai Food</p>
        </div>
    </div>-->

    <!-- Navigation -->
    <?php include("function/navigation.php"); ?>

    <!-- Masthead -->
    <form action="index.php" method="POST" style="padding: 8px;">
        <div class='search-container'>
            <div class='search'>
                <!--<form action="index.php">-->
                    <i class="fa fa-search"></i>
                    <input type="text" placeholder="ค้นหาจากชื่อเมนู, วัตถุดิบ" id="search" name="search">
                    <input type="submit" value="ค้นหา" name="sumbmit">
                <!--</form>-->
            </div>
        </div>
        <div class="half-circle" id="filter-div" style="margin: 0 auto 0 auto;">
            <center>
                <i class="fa fa-caret-down" id="filter-but" style="width: 40px; height: 50px;" aria-hidden="true"></i>
            </center>
        </div>
        <div class="col-12 table-responsive" style="margin: 1.5px auto 15px auto; display: none; background-color: white; border-radius: 8px; min-width: 565px; width: 70%; height: fit-content; box-shadow: 0 4px 5px rgba(0, 0, 0, 0.2);" id="filter-box">
            <div class="col-12" style="text-align: right; font-size: 1.1rem; margin-top: 8px; margin-bottom: 8px;">
                <i class="fa fa-times pull-right" id="close-filter"></i>
            </div> 
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
                        <input type="text" name="min-cal" placeholder="0"  class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                    </div>
                    <div class="col-1">
                        <i class="fa fa-minus" style="width: 40px; font-size: 10px; padding-left: auto;" aria-hidden="true"></i>
                    </div>
                    <div class="col-5">
                        <input type="text" name="max-cal" placeholder="9999"  class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                    </div>
                </div>
                <div class="row col-6">
                    <label class="col-12" style="padding-left: 56px;">Cholesterol</label>
                    <div class="col-1">
                    </div>
                    <div class="col-5">
                        <input type="text" name="min-chol" placeholder="0"  class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                    </div>
                    <div class="col-1">
                        <i class="fa fa-minus" style="width: 40px; font-size: 10px; padding-left: auto;" aria-hidden="true"></i>
                    </div>
                    <div class="col-5">
                        <input type="text" name="max-chol" placeholder="9999"  class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                    </div>
                </div>
                <div class="row col-6">
                    <label class="col-12" style="padding-left: 56px; margin-top: 5px;">Carbohydrate</label>
                    <div class="col-1">
                    </div>
                    <div class="col-5">
                        <input type="text" name="min-carb" placeholder="0"  class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                    </div>
                    <div class="col-1">
                        <i class="fa fa-minus" style="width: 40px; font-size: 10px; padding-left: auto;" aria-hidden="true"></i>
                    </div>
                    <div class="col-5">
                        <input type="text" name="max-carb" placeholder="9999"  class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                    </div>
                </div>
                <div class="row col-6" style="margin-top: 5px;">
                    <label class="col-12" style="padding-left: 56px;">Protein</label>
                    <div class="col-1">
                    </div>
                    <div class="col-5">
                        <input type="text" name="min-protein" placeholder="0"  class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                    </div>
                    <div class="col-1">
                        <i class="fa fa-minus" style="width: 40px; font-size: 10px; padding-left: auto;" aria-hidden="true"></i>
                    </div>
                    <div class="col-5">
                        <input type="text" name="max-protein" placeholder="9999"  class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                    </div>
                </div>
                <div class="row col-6" style="margin-top: 5px; margin-bottom: 15px;">
                    <label class="col-12" style="padding-left: 56px;">Fat</label>
                    <div class="col-1">
                    </div>
                    <div class="col-5">
                        <input type="text" name="min-fat" placeholder="0"  class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                    </div>
                    <div class="col-1">
                        <i class="fa fa-minus" style="width: 40px; font-size: 10px; padding-left: auto;" aria-hidden="true"></i>
                    </div>
                    <div class="col-5">
                        <input type="text" name="max-fat" placeholder="9999"  class="form-control form-control-line" style="min-height: 20px; font-size: 14px;">
                    </div>
                </div>
                <label class="col-12" style="padding-left:28px;">Ingredients</label>
                <label class="col-12" style="padding-left:56px;">include &nbsp : </label>
                <div class="col-12" style="padding-left:76px; padding-right:76px; margin-bottom: .5rem;">
                    <input type="text" data-role="tagsinput" name="ingredient" class="form-control">
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
        </div>
    </form>   
    <section class="container" style="min-height: 350px;">
        <div class='show-menu-title' >
            <?php
                if( $search != "" ){
                    echo '<h4 style="text-align: center;"> ค้นหา เมนู'. $search .'</h4>';
                }else if( count(json_decode($resultmenu)) == 0 ){
                    echo '<h4 style="text-align: center;"> ไม่พบข้อมูลอาหาร </h4>';
                }
                else{
                    echo '<h4 style="text-align: center;"> เมนูอาหารทั้งหมด </h4>';
                }
            ?>
        </div>
        <div id="table-body" class="show-menu" style="min-height: 300px;">
            
        </div>
        <center><div id="pagination-wrapper" style="margin-bottom: 30px;"></div></center>
    </section>

    <!-- Footer -->
    <?php #include("function/footer.php"); ?>
    <?php //include 'cache/bottom-cache.php'; ?>
    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous" ></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous" ></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha256-OFRAJNoaD8L3Br5lglV7VyLRf0itmoBzWUoM+Sji4/8=" crossorigin="anonymous" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.js" integrity="sha512-VvWznBcyBJK71YKEKDMpZ0pCVxjNuKwApp4zLF3ul+CiflQi6aIJR+aZCP/qWsoFBA28avL5T5HA+RE+zrGQYg==" crossorigin="anonymous" ></script>
    
    <!-- Bootstrap core JavaScript -->
    <script src="mainstyle/jquery/jquery.min.js" ></script>
    <script src="mainstyle/bootstrap/js/bootstrap.bundle.min.js" ></script>
    <script src="https://code.jquery.com/jquery-1.12.4.js" ></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js" ></script>

    <script>
        // On top
        $("a[href='#top']").click(function () {
            $("html, body").animate({
                scrollTop: 0
            }, "slow");
            return false;
        });

        // filter-box toggle
        $("#filter-but").click(function(){
            $("#filter-box").fadeIn(700);
            $("#filter-div").toggle();
        });

        // close-filter button 
        $("#close-filter").click(function(){
            $("#filter-box").hide();
            $("#filter-div").show();
        });

        $("#search").autocomplete({
            source: async function(request, response) {
                
                $.post( "function/autocomplete.php", { name: $("#search").val() }, function (data){

                    let autocomplete = [];
                    for( var i = 0; i < Object.keys(JSON.parse(data)).length; i++ ){
                    //for( var i = 0; i < 5; i++ ){
                        
                        for (let value of Object.values(JSON.parse(data)[i])) {
                            autocomplete[i] = value;
                        }
                        
                        
                    }
                    response(autocomplete);
                });
            }
        });

    </script>

    <script>
        var tableData = <?php print $resultmenu ?>
        //console.log(tableData)

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
        //var data = pagination(state.querySet, state.page, state.rows)
        //pageButtons(data.pages)

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
            //console.log(myList)
            for (var i = 1 in myList) {
                //Keep in mind we are using "Template Litterals to create rows"
                //var date = new Date((myList[i].date_add.$date));
                //var datevalues = ("0" + (date.getUTCMonth() + 1)).slice(-2)+'/'+("0" + date.getUTCDate()).slice(-2)+'/'+date.getUTCFullYear()+' '+("0" + date.getUTCHours()).slice(-2)+':'+("0" + date.getUTCMinutes()).slice(-2)+':'+("0" + date.getUTCSeconds()).slice(-2);
                if (myList[i].image.substr(0,10) != "food_image") {
                    var img = '<img class="card-img-left rounded-circle mt-3" src="image_food/'+myList[i].image+'" alt="Card image cap">'
                }else{
                    var img = '<img class="card-img-left rounded-circle mt-3" src="https://keedurar.sirv.com/'+myList[i].image+'?h=173&w=168" alt="Card image cap">'
                }
                //console.log(img)
                var row = ` <a href="show-food.php?id=${myList[i]._id}">
                                <div id="wb_element_instance2" class="wb_element hvr-grow menu-box mb-4">
                                    <center>
                                        ${img}
                                    </center>
                                    <div class='menu-name'>
                                        <h5 class="card-title name-title text-center">
                                            ${myList[i].title}</a>
                                        </h5>
                                    </div>
                                </div>
                            </a>
                        `
                table.append(row)
            }
            if ( myList.length != 0){
                pageButtons(data.pages)
            }
            
        }
    </script>

</body>

</html>