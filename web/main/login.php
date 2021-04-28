<?php
include 'connectAPI.php';

$email = $_POST['email'];
$password = $_POST['password'];
$data_array =  array(
    "email" => $email,
    "password" => $password
);
$url = 'user/sign-in';
$result = json_decode(postAPI($url, json_encode($data_array)),true);

if (isset($result[0]['email'])) {
    if($result[0]['admin'] == 'False') {
        session_start();
        $_SESSION['id'] = $result[0]["_id"];
        $_SESSION['email'] = $result[0]["email"];
        $_SESSION['username'] = $result[0]['username'];
        $_SESSION['status'] = 'User';
        header("Location: ../user/dashboard.php");
    }else{
        session_start();
        $_SESSION['id'] = $result[0]["_id"];
        $_SESSION['email'] = $result[0]["email"];
        $_SESSION['username'] = $result[0]['username'];
        $_SESSION['status'] = 'Admin';
        header("Location: ../admin/admindashboard.php");
    }
    // output data of each row
    /*while ($row = $result->fetch_assoc()) {
        if ($row["email"] == $email) {
            //user
            if (hash("md5", $_POST['password']) == $row["password"] && $row['status'] == "user") {
                session_start();
                $data = "SELECT * FROM user WHERE email = $email";
                $_SESSION['id'] = $row["id"];
                $_SESSION['email'] = $row["email"];
                $_SESSION['password'] = $_POST['password'];
                $_SESSION['status'] = $row['status'];
                header("Location: ../user/dashboard.php");
                break;
            }
            // admin
            elseif (hash("md5", $_POST['password']) == $row["password"] && $row['status'] == "admin") {
                session_start();
                $data = "SELECT * FROM user WHERE email = $email";
                $_SESSION['id'] = $row["id"];
                $_SESSION['email'] = $row["email"];
                $_SESSION['password'] = $_POST['password'];
                $_SESSION['status'] = $row['status'];
                header("Location: ../admin/admindashboard.php");
                break;
            }

            if (hash("md5", $_POST['password']) != $row["password"]) {
                header("Location: ../auth/login.php");
            }
        }
        if ($row["email"] != $email) {
            header("Location: ../auth/login.php");
        }
    }*/
}else{
    header("Location: ../auth/login.php");
}
