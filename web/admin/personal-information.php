<?php
session_start();
if (isset($_SESSION['id'])) {
    $session_login_id = $_SESSION['id'];
    $session_login_email = $_SESSION['email'];
    $session_login_password = $_SESSION['password'];
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
    <link href="../assets/node_modules/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/node_modules/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <!-- This page CSS -->
    <!-- chartist CSS -->
    <link href="../assets/node_modules/morrisjs/morris.css" rel="stylesheet">
    <!--c3 CSS -->
    <link href="../assets/node_modules/c3-master/c3.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <!-- Dashboard 1 Page CSS -->
    <link href="css/pages/dashboard1.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/default.css" id="theme" rel="stylesheet">
</head>

<body class="fix-header fix-sidebar card-no-border">
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">Sharing Thai Food</p>
        </div>
    </div>
    <div id="main-wrapper">
        <?php include("../function/header-admin.php"); ?>
        <?php include("../function/list-admin.php"); ?>
        <div class="page-wrapper">
            <div class="container-fluid">
                <div class="row page-titles">
                    <div class="col-md-5 align-self-center">
                        <h3 class="text-themecolor">Personal information</h3>
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                            <li class="breadcrumb-item active">Personal information</li>
                        </ol>
                    </div>
                </div>

                <form class="form-horizontal form-material" method="POST" onsubmit="return Validate()" name="vform">
                    <div class="row">
                        <div class="col-lg-4 col-xlg-3 col-md-5">
                            <div class="card">
                                <div class="card-body">
                                    <center class="m-t-30">>
                                        <label for="file-input">
                                            <img src="../img/testimonials-2.jpg" id="blah" alt="your image" class="img-circle" width="250" height="250" />
                                            <div class="btn btn-block btn-success mt-3">Up load image. <i class="fas fa-upload" aria-hidden="true"></i></div>
                                        </label>
                                        <input id="file-input" type="file" style="display: none;" />
                                        <h4 class="card-title m-t-10">Dicky pakinson</h4>
                                        <h6 class="card-subtitle">After uploading images, please click "Update" below</h6>
                                        <div class="row text-center justify-content-md-center">
                                            <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-people"></i>
                                                    <font class="font-medium">254</font>
                                                </a></div>
                                            <div class="col-4"><a href="javascript:void(0)" class="link"><i class="icon-picture"></i>
                                                    <font class="font-medium">54</font>
                                                </a></div>
                                        </div>
                                    </center>
                                </div>
                            </div>
                        </div>
                        <!-- Column -->
                        <!-- Column -->
                        <div class="col-lg-8 col-xlg-9 col-md-7">
                            <div class="card">
                                <!-- Tab panes -->
                                <div class="card-body">
                                    <div class="form-group">
                                        <label class="col-md-12">Frist Name</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Dicky" class="form-control form-control-line">
                                        </div>
                                        <label class="col-md-12">Last Name</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="Pakinson" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="example-email" class="col-md-12">Email</label>
                                        <div class="col-md-12">
                                            <input type="email" id="email" name="email" value="<?php echo $session_login_email;  ?>" class="form-control form-control-line" name="example-email" id="example-email">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Password</label>
                                        <div class="col-md-12">
                                            <input type="password" id="password" name="password" value="<?php echo $session_login_password;  ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Confirm password</label>
                                        <div class="col-md-12">
                                            <input type="password" id="confirm_password" name="confirm_password" value="<?php echo $session_login_password;  ?>" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Phone No</label>
                                        <div class="col-md-12">
                                            <input type="text" placeholder="123 456 7890" class="form-control form-control-line">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-md-12">Message</label>
                                        <div class="col-md-12">
                                            <textarea rows="5" class="form-control form-control-line"></textarea>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-sm-12">Select Country</label>
                                        <div class="col-sm-12">
                                            <select class="form-control form-control-line">
                                                <option>London</option>
                                                <option>India</option>
                                                <option>Usa</option>
                                                <option>Canada</option>
                                                <option>Thailand</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-sm-12">
                                            <button class="btn btn-success">Edit Profile</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="row">
                    <!-- Column Food -->
                    <div class="col-lg-4 col-md-12">
                        <div class="card card-body mailbox">
                            <h5 class="card-title">Latest Update Food</h5>
                            <div class="message-center ps ps--theme_default ps--active-y" style="height: 490px" data-ps-id="a045fe3c-cb6e-028e-3a70-8d6ff0d7f6bd">
                                <div class="table-responsive m-t-20 no-wrap">
                                    <table class="table vm no-th-brd pro-of-month">
                                        <thead>
                                            <tr>
                                                <th class="col-8" colspan="2">Food Name</th>
                                                <th class="col-4">Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>กระเพาไก่ ไข่ดาว</h6>
                                                </td>
                                                
                                                <td>
                                                    <a href=""><i class="fa fa-eye text-success mr-3" style="font-size: 1.25rem;"></a></i>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>กระเพาไก่ ไข่ดาว</h6>
                                                </td>
                                                
                                                <td>
                                                    <a href=""><i class="fa fa-eye text-success mr-3" style="font-size: 1.25rem;"></a></i>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>กระเพาไก่ ไข่ดาว</h6>
                                                </td>
                                                
                                                <td>
                                                    <a href=""><i class="fa fa-eye text-success mr-3" style="font-size: 1.25rem;"></a></i>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>กระเพาไก่ ไข่ดาว</h6>
                                                </td>
                                                
                                                <td>
                                                    <a href=""><i class="fa fa-eye text-success mr-3" style="font-size: 1.25rem;"></a></i>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>กระเพาไก่ ไข่ดาว</h6>
                                                </td>
                                                
                                                <td>
                                                    <a href=""><i class="fa fa-eye text-success mr-3" style="font-size: 1.25rem;"></a></i>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>กระเพาไก่ ไข่ดาว</h6>
                                                </td>
                                                
                                                <td>
                                                    <a href=""><i class="fa fa-eye text-success mr-3" style="font-size: 1.25rem;"></a></i>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>กระเพาไก่ ไข่ดาว</h6>
                                                </td>
                                                
                                                <td>
                                                    <a href=""><i class="fa fa-eye text-success mr-3" style="font-size: 1.25rem;"></a></i>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>กระเพาไก่ ไข่ดาว</h6>
                                                </td>
                                                
                                                <td>
                                                    <a href=""><i class="fa fa-eye text-success mr-3" style="font-size: 1.25rem;"></a></i>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>กระเพาไก่ ไข่ดาว</h6>
                                                </td>
                                                
                                                <td>
                                                    <a href=""><i class="fa fa-eye text-success mr-3" style="font-size: 1.25rem;"></a></i>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>กระเพาไก่ ไข่ดาว</h6>
                                                </td>
                                                
                                                <td>
                                                    <a href=""><i class="fa fa-eye text-success mr-3" style="font-size: 1.25rem;"></a></i>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>กระเพาไก่ ไข่ดาว</h6>
                                                </td>
                                                
                                                <td>
                                                    <a href=""><i class="fa fa-eye text-success mr-3" style="font-size: 1.25rem;"></a></i>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>กระเพาไก่ ไข่ดาว</h6>
                                                </td>
                                                
                                                <td>
                                                    <a href=""><i class="fa fa-eye text-success mr-3" style="font-size: 1.25rem;"></a></i>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>กระเพาไก่ ไข่ดาว</h6>
                                                </td>
                                                
                                                <td>
                                                    <a href=""><i class="fa fa-eye text-success mr-3" style="font-size: 1.25rem;"></a></i>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column Food -->
                    <!-- Column Congenital disease -->
                    <div class="col-lg-4 col-md-12">
                        <div class="card card-body mailbox">
                            <h5 class="card-title">Latest Update Congenital disease</h5>
                            <div class="message-center ps ps--theme_default ps--active-y" style="height: 490px" data-ps-id="a045fe3c-cb6e-028e-3a70-8d6ff0d7f6bd">
                                <div class="table-responsive m-t-20 no-wrap">
                                    <table class="table vm no-th-brd pro-of-month">
                                        <thead>
                                            <tr>
                                                <th class="col-8" colspan="2">Congenital disease Name</th>
                                                <th class="col-4">time update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>โรคหัวใจ</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>โรคหัวใจ</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>โรคหัวใจ</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>โรคหัวใจ</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>โรคหัวใจ</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>โรคหัวใจ</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>โรคหัวใจ</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>โรคหัวใจ</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>โรคหัวใจ</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>โรคหัวใจ</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>โรคหัวใจ</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>โรคหัวใจ</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>โรคหัวใจ</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column Congenital disease -->
                    <!-- Column Food allergies -->
                    <div class="col-lg-4 col-md-12">
                        <div class="card card-body mailbox">
                            <h5 class="card-title">Latest Update Food</h5>
                            <div class="message-center ps ps--theme_default ps--active-y" style="height: 490px" data-ps-id="a045fe3c-cb6e-028e-3a70-8d6ff0d7f6bd">
                                <div class="table-responsive m-t-20 no-wrap">
                                    <table class="table vm no-th-brd pro-of-month">
                                        <thead>
                                            <tr>
                                                <th class="col-8" colspan="2">Food Name</th>
                                                <th class="col-4">time update</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>นม</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>นม</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>นม</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>นม</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>นม</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>นม</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>นม</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>นม</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>นม</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>นม</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>นม</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>นม</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td></td>
                                                <td class="col-8">
                                                    <h6>นม</h6>
                                                </td>
                                                <td>
                                                    <a href=""><i class="fa fa-trash-o text-danger" style="font-size: 1.25rem;"></i></a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Column Food allergies -->
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
    <script src="mainstyle/jquery/jquery.min.js"></script>
    <script src="mainstyle/bootstrap/js/bootstrap.bundle.min.js"></script>

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
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--morris JavaScript -->
    <script src="../assets/node_modules/raphael/raphael-min.js"></script>
    <script src="../assets/node_modules/morrisjs/morris.min.js"></script>
    <!--c3 JavaScript -->
    <script src="../assets/node_modules/d3/d3.min.js"></script>
    <script src="../assets/node_modules/c3-master/c3.min.js"></script>
    <!-- Chart JS -->
    <script src="js/dashboard1.js"></script>

    <script>
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();

                reader.onload = function(e) {
                    $('#blah').attr('src', e.target.result);
                }

                reader.readAsDataURL(input.files[0]);
            }
        }

        $("#file-input").change(function() {
            readURL(this);
        });
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