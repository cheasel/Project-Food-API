<?php
include '../main/connectAPI.php';

$url = 'user/sign-up';

if (isset($_POST['email'])) {
    $username = $_POST['username']? $_POST['username'] : '';
    $email = $_POST['email'];
    #$password = hash("md5", $_POST['password']);
    $password = $_POST['password'];
    #$confirm_password = $_POST['confirm_password'];
    $status = $_POST['status'];

    $data_array =  array(
        "username" => $username,
        "email" => $email,
        "password" => $password,
        "admin" => $status
    );
    $result = json_decode(postAPI($url, json_encode($data_array)),true);

    echo $result[0]['email'];

    if (isset($result[0]['email'])) {
        session_start();
        echo $_SESSION['id'];
        if( $_SESSION['id'] != Null ){
            $_SESSION['id'] = $result[0]["_id"];
            $_SESSION['email'] = $result[0]["email"];
            $_SESSION['username'] = $result[0]['username'];
            $_SESSION['status'] = 'User';
        }
        
        header("Location: ../user/dashboard.php");
    }else {
        header("Location: ../auth/register.php");
    }
}else {
    header("Location: ../auth/register.php");
}

/*if ($conn->query($sql) === TRUE) {
    $sqldata = "SELECT * FROM user";
    $result = $conn->query($sqldata);
    if ($result->num_rows > 0) {
        // output data of each row
        while ($row = $result->fetch_assoc()) {
            if ($row["email"] == $email) {
                if (hash("md5", $_POST['password']) == $row["password"]) {
                    session_start();
                    $data = "SELECT * FROM user WHERE email = $email";
                    $_SESSION['id'] = $row["id"];
                    $_SESSION['email'] = $row["email"];
                    $_SESSION['password'] = $_POST['password'];
                    $_SESSION['status'] = $_POST['status'];
                    header("Location: ../index.php");
                }
            }
        }
    }
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}*/
