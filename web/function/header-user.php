<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header">
            <a class="navbar-brand" href="../index.php">
                <!-- Logo icon --><b>
                    <!-- Dark Logo icon -->
                    <img src="../assets/images/logo-icon-api.png" alt="homepage" class="dark-logo" />
                    <!-- Light Logo icon -->
                    <img src="../assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                </b>
                <!--End Logo icon -->
                <!-- Logo text --><span>
                    <!-- dark Logo text -->
                    <img src="../assets/images/logo-api-text.png" alt="homepage" class="dark-logo" />
                    <!-- Light Logo text -->
                    <img src="../assets/images/logo-light-text.png" class="light-logo" alt="homepage" /></span> </a>
        </div>
        <div class="navbar-collapse">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item hidden-xs-down search-box">
                    <a class="nav-link hidden-sm-down waves-effect waves-dark" href="">
                        <img src="../assets/images/logo-light-icon.png" alt="homepage" class="light-logo" />
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav my-lg-0">
                <li class="nav-item dropdown u-pro">
                    <?php
                    if (isset($session_login_id)) {
                    ?>
                        <div class="features-icons-icon mr-3">
                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" style="color: rgba(0,0,0,.9); text-decoration: none; " href="../user/dashboard.php"><?php echo $session_login_username; ?>&nbsp;&nbsp;
                                <i class="fa fa-user text-primary" style="font-size: 1.25rem;" aria-hidden="true"></i> </a>
                            <a class="nav-link dropdown-toggle waves-effect waves-dark " href="../main/logout.php"><i class="fa fa-sign-out text-danger" style="font-size: 1.25rem;" aria-hidden="true"></i></a>
                        </div>

                    <?php } else if (!isset($session_login_id)) { ?>
                        <a class="btn btn-primary" href="auth/login.php" disable>Sign In</a>
                    <?php }  ?>
                </li>
            </ul>
        </div>
    </nav>
</header>