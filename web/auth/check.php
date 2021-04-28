<?php
    include '../main/connectAPI.php';

    if(isset($_POST['user'])){
        if($_POST['user'] == ''){
            echo 1;
        }
        $url = 'user/signupcheck?username='.$_POST['user'];
        $result = getAPI($url);

        echo $result;
    }

    if(isset($_POST['email'])){
        if($_POST['email'] == ''){
            echo 1;
        }
        $url = 'user/signupcheck?email='.$_POST['email'];
        $result = getAPI($url);

        echo $result;
    }
    
?>