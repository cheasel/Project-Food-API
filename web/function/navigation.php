<nav class="navbar navbar-light bg-light static-top">
    <div class="top-nav">
        <ul>
            <li>
                <a class="navbar-brand" href="index.php"><i class="fas fa-utensils"></i> Sharing Thai Food</a>
            </li>
            <li style='float: right;'>
            <?php
                if (isset($session_login_status)) {
                    if ($session_login_status == "Admin") { ?>
                        <!-- Admin -->
                        <div class="features-icons-icon ">
                            <a class="" style="color: rgba(0,0,0,.9); text-decoration: none; " href="admin/admindashboard.php"><?php echo $session_login_username; ?>&nbsp;&nbsp;
                                <i class="fa fa-user text-primary" style="font-size: 1.25rem;" aria-hidden="true"></i> </a>&nbsp;&nbsp;
                            <a class="" href="main/logout.php"><i class="fa fa-sign-out-alt text-danger" style="font-size: 1.25rem;" aria-hidden="true"></i></a>
                        </div>
                    <?php }
                    if ($session_login_status == "User") { ?>
                        <!-- User -->
                        <div class="features-icons-icon ">
                            <a class="" style="color: rgba(0,0,0,.9); text-decoration: none; " href="user/dashboard.php"><?php echo $session_login_username; ?>&nbsp;&nbsp;
                                <i class="fa fa-user text-primary" style="font-size: 1.25rem;" aria-hidden="true"></i> </a>&nbsp;&nbsp;
                            <a class="" href="main/logout.php"><i class="fa fa-sign-out-alt text-danger" style="font-size: 1.25rem;" aria-hidden="true"></i></a>
                        </div>
                    <?php } 
                } else if (!isset($session_login_status)) { ?>
                    <a class="btn btn-primary" href="auth/login.php" disable>Sign In</a>
                <?php } ?>
            </li>
        </ul>
    </div>
    <div class='menu-bar'>
        <ul>
            <li>
                <a href='index.php'> สูตรอาหาร </a>
            </li>
            <li class="drpdown">
                <a href='#'> API </a>  
                <div class="drpdown-content">
                    <a href='api-doc.php?page=1' style="text-align:left;"> Recipe Search API </a>
                    <a href='api-doc.php?page=2' style="text-align:left;"> Calories Limit Search API </a>
                </div>
            </li>
        </ul> 
    </div>
</nav>