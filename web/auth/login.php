<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/images/logo-icon-api.png">
  <title>Login</title>

  <!-- Auth css -->
  <link href="../css/auth.css" rel="stylesheet">

  <!-- Custom fonts for this template -->
  <link href="../mainstyle/fontawesome-free/css/all.min.css" rel="stylesheet">
  <link href="../mainstyle/simple-line-icons/css/simple-line-icons.css" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

  <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">

  <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
</head>

<body>
  <!------ Include the above in your HEAD tag ---------->

  <div class="wrapper fadeInDown">
    <div id="formContent">
      <!-- Tabs Titles -->

      <div class="d-flex flex-row-reverse">
        <div class="p-2"><a href="../index.php"><i class="fa fa-times" aria-hidden="true"></i></a></div>
      </div>

      <!-- Icon -->
      <div class="fadeIn first">
        <img class="rounded-circle" src="data:image/png;base64,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" id="icon" alt="User Icon" />
      </div>

      <!-- Login Form -->
      <form action="../main/login.php" method="POST" onsubmit="return Validate()" name="vformlogin">
        <input type="text" id="email" class="fadeIn second" name="email" placeholder="Email address">
        <input type="password" id="password" class="fadeIn third" name="password" placeholder="Password">
        <input type="submit" class="fadeIn fourth" value="Sign in">
      </form>

      <!-- Remind Passowrd -->
      <div id="formFooter">
        Don't have an account? <a class="underlineHover" href="register.php">Sign Up</a><br>
        <!-- <a class="underlineHover" href="forgot-password.php">Forgot Password?</a> -->
      </div>
    </div>
  </div>
</body>

<script type="text/javascript">
  //GETTING ALL INPUT TEXT OPJECTS
  var email = document.forms["vformlogin"]["email"];
  var password = document.forms["vformlogin"]["password"];

  //SETTING ALL EVENT LISTENER
  email.addEventListener("click", emailVerify);
  password.addEventListener("click", passwordVerify);

  function Validate() {
    if (email.value == "") {
      email.style.border = "1px solid red";
      return false;
    }
    if (password.value == "") {
      password.style.border = "1px solid red";
      return false;
    }

    // if (password.value != "" && email.value != "") {
    //   var emailCheck = document.forms["vformlogin"]["email"].value;
    //   var passwordCheck = document.forms["vformlogin"]["password"].value;
    //   alert(emailCheck);
    //   return false;
    // }
  }

  function emailVerify() {
    if (email.value == "") {
      email.style.border = "";
      return true;
    }

  }

  function passwordVerify() {
    if (password.value == "") {
      password.style.border = "";
      return true;
    }

  }



  // var mysql = require('mysql');

  // var con = mysql.createConnection({
  //   host: "localhost",
  //   user: "root",
  //   password: "",
  //   database: "api_thaifood"
  // });

  // con.connect(function(err) {
  //   if (err) throw err;
  //   con.query("SELECT * FROM user", function(err, result, fields) {
  //     if (err) throw err;
  //     console.log(result);
  //   });
  // });
  // var email = document.getElementById("email").value
  // var password = document.getElementById("password").value
</script>





</html>