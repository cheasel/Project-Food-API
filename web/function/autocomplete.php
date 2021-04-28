<?php
    include '../main/connectAPI.php';

    $autocomplete = [];

    if(isset($_POST['name'])){
        $url = 'menu-detail/autocomplete?name='.urlencode($_POST['name']);
        $result = getAPI($url);

        /*foreach( json_decode($result,true) as $temp ){
            #print $autocomplete;
            $autocomplete[] = $temp["title"];
            #array_push($autocomplete, $temp["title"]);
        }*/

        #print_r($autocomplete);
        print $result;
    }
    
?>