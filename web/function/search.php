<?php
include 'main/conectDB.php';
// --------------------------- food_allergies ---------------------
$sql_food_allergies = "SELECT tb_food_allergies FROM food_allergies";
$result_food_allergies = $conn->query($sql_food_allergies);

$Array_Food_allergies = array();
while ($row_food_allergies = $result_food_allergies->fetch_assoc()) {
    $Array_Food_allergies[] = $row_food_allergies["tb_food_allergies"];
}
// foreach ($Array_Food_allergies as &$value_Food_allergies) {
//     $value_Food_allergies = $value_Food_allergies;
// }
$Array_Food_allergies2 = array_unique($Array_Food_allergies);

// --------------------------- medical_problems ---------------------
// $sql_Medical_problems = "SELECT tb_medical_problems FROM medical_problems";
// $result_Medical_problems = $conn->query($sql_Medical_problems);

// $Array_Medical_problems = array();
// while ($row_Medical_problems = $result_Medical_problems->fetch_assoc()) {
//     $Array_Medical_problems[] = $row_Medical_problems["tb_medical_problems"];
// }
// foreach ($Array_Medical_problems as &$value_medical_problems) {
//     $value_medical_problems = $value_medical_problems;
// }
// $Array_Medical_problems2 = array_unique($Array_Medical_problems);


?>

</style>
<header class="masthead text-white text-center" style="background-image: url('img/img-index.jpg') ;">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 mx-auto">
                <h1 class="mb-5">Find your favorite food</h1>
            </div>
            <div class="col-md-10 col-lg-8 col-xl-7 mx-auto">
                <div class="form-row input-group">
                    <!-- Button trigger modal -->
                    <div class="col-12 col-md-9 mb-2 mb-md-0">
                        <div type="text" name="search" class="form-control form-control-lg text-left" data-toggle="modal" data-target="#exampleModal" placeholder="Searching for...">Searching for...</div>
                    </div>
                    <div class="col-12 col-md-3">
                        <div type="button" class="btn btn-block btn-lg btn-primary" data-toggle="modal" data-target="#exampleModal">Searching</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade " id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content ">
                    <div class="modal-header ">
                        <div class="text-muted">
                            Featured
                        </div>
                    </div>
                    <div class="modal-body">
                        <form action="show-search-manu.php" method="POST" enctype="multipart/form-data">
                            <div class="row mySlides">
                                <div class="col">
                                    <div class="text-muted text-left mb-2">Menu or Ingredients</div>
                                    <input type="text" name="namefood" class="form-control" placeholder="กระเพาไก่ / หมูสับ">
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Searching</button>
                                </div>
                            </div>
                        </form>
                        <form action="main/show-search-manu.php" method="POST" enctype="multipart/form-data">
                            <div class="row mySlides">
                                <div class="col">
                                    <div class="text-muted text-left mb-2">Congenital disease</div>
                                    <input type="text" name="medical_problems" class="form-control" placeholder="โรคหัวใจ">
                                    <!-- <select class="form-control form-control-line" name="namemedical_problems">
                                        <?php
                                        foreach ($Array_Medical_problems2 as $key1 => $value1) { ?>
                                            <option value="<?php echo $value1; ?>"><?php echo $value1; ?></option>
                                        <?php
                                        } ?>
                                    </select> -->
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Searching</button>
                                </div>
                            </div>

                        </form>
                        <form action="show-search-manu.php" method="POST" enctype="multipart/form-data">
                            <div class="row mySlides">
                                <div class="col" id="searchfood_allergies">
                                    <div class="text-muted text-left mb-2">Food allergies</div>
                                    <input type="hidden"  name="checkfood_allergies" value="1" id="">
                                    <select name="namefood_allergies1" class="form-control form-control-line mb-3">
                                        <option value="">Selcet food allergies</option>
                                        <?php
                                        foreach ($Array_Food_allergies2 as $key2 => $value2) { ?>
                                            <option value="<?php echo $value2; ?>"><?php echo $value2; ?></option>
                                        <?php
                                        } ?>
                                    </select>
                                </div>
                                <!-- <div class="col">
                                    <button onclick="addfood_allergies()" id="get" type="button" class="btn btn-danger btn-block mt-3"><i class="fa fa-plus-circle" aria-hidden="true"></i></button>
                                </div> -->

                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Searching</button>
                                </div>
                            </div>
                        </form>
                        <div class="row">
                            <div class="col">
                                <a href="#" type="button" class="myButton">
                                    <i class="fa fa-angle-left btn btn-block btn-lg " style="width: 50px; height: 43px;" aria-hidden="true" onclick="plusDivs(-1)"></i>
                                </a>
                                <a href="#" type="button" class="myButton">
                                    <i class="fa fa-angle-right btn btn-block btn-lg " style="width: 50px; height: 43px;" aria-hidden="true" onclick="plusDivs(1)"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<script src="assets/js/sildsearch.js"></script>
<script>
    var numfoodaller = 1;

    function addfood_allergies() {
        numfoodaller++;
        var foodaller = '';
        foodaller += '<select name="namefood_allergies' + [numfoodaller] + '" class="form-control form-control-line mt-3"><option value="">Selcet food allergies</option> <?php foreach ($Array_Food_allergies2 as $key2 => $value2) { ?><option value="<?php echo $value2; ?>"><?php echo $value2; ?></option><?php } ?></select>';
        $("#searchfood_allergies").append(foodaller);

    }
</script>