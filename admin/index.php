<?php
    include '../config/config_main.php';
    if(!isset($_SESSION['user_data'])){
        if($_SESSION['user_data']->user_status != "admin"){
            echo '<meta http-equiv="refresh" content="0; url=../" />';
        }
    }
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../<?php echo getPengaturan("icon_web")->value_pengaturan; ?>" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title><?php echo getPengaturan("judul_web")->value_pengaturan; ?></title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
    <meta name="viewport" content="width=device-width" />
    <!-- Bootstrap core CSS     -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
    <!--  Material Dashboard CSS    -->
    <link href="../assets/css/material-dashboard.css?v=1.2.0" rel="stylesheet" />
    <!--  CSS for Demo Purpose, don't include it in your project     -->
    <link href="../assets/css/demo.css" rel="stylesheet" />
    <!--     Fonts and icons     -->
    <!-- <link href="../assets/css/font-awesome.min.css" rel="stylesheet" />
    <link href="../assets/css/material-icons.css" rel="stylesheet" /> -->
    <link href="http://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link href='http://fonts.googleapis.com/css?family=Roboto:400,700,300|Material+Icons' rel='stylesheet' type='text/css'>
</head>
<?php
    $page_selected[0] = "";
    $page_selected[1] = "";
    $page_selected[2] = "";
    $page_selected[3] = "";
    $page_selected[4] = "";
    $page_selected[5] = "";
    $page_current = "dashboard.php";
    $page_title = "Dashboard Overview";
    $page = @$_GET['p'];
    switch($page){
        case "dashboard" : $page_current = 'dashboard.php';$page_title = "Dashboard Overview";$page_selected[0] = "active";break;
        case "member" : $page_current = 'member.php';$page_title = "Manage Member";$page_selected[1] = "active";break;
        case "notification" : $page_current = 'notification.php';$page_title = "Manage Notifications";$page_selected[2] = "active";break;
        case "content" : $page_current = 'content.php';$page_title = "Template Content";$page_selected[3] = "active";break;
        case "setting" : $page_current = 'setting.php';$page_title = "Website Settings";$page_selected[4] = "active";break;
        case "profile" : $page_current = 'profile.php';$page_title = "My Profile";$page_selected[6] = "active";break;
        default : $page_current = 'dashboard.php';$page_title = "Dashboard Overview";$page_selected[0] = "active";break;
    }
?>
<body>
    <div class="wrapper">
        <div class="sidebar" data-color="blue" data-image="../assets/img/sidebar-1.jpg">
            <div class="logo">
                <a href="<?php echo getPengaturan("url_web")->value_pengaturan; ?>" class="simple-text">
                    <?php echo getPengaturan("nama_web")->value_pengaturan; ?>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <li class="<?php echo $page_selected[0];?>">
                        <a href="?p=dashboard">
                            <i class="material-icons">dashboard</i>
                            <p>Dashboard</p>
                        </a>
                    </li>
                    <li class="<?php echo $page_selected[1];?>">
                        <a href="?p=member">
                            <i class="material-icons">group</i>
                            <p>Manage Member</p>
                        </a>
                    </li>
                    <li class="<?php echo $page_selected[2];?>">
                        <a href="?p=notification">
                            <i class="material-icons">notifications</i>
                            <p>Notifications</p>
                        </a>
                    </li>
                    <li class="<?php echo $page_selected[3];?>">
                        <a href="?p=content">
                            <i class="material-icons">content_paste</i>
                            <p>Content Template</p>
                        </a>
                    </li>
                    <li class="<?php echo $page_selected[4];?>">
                        <a href="?p=setting">
                            <i class="fa fa-gears"></i>
                            <p>Website Settings</p>
                        </a>
                    </li>
                    <li class="<?php echo $page_selected[5];?>">
                        <a href="?p=profile">
                            <i class="material-icons">person</i>
                            <p>My Profile</p>
                        </a>
                    </li>
                    <li class="visible-xs">
                        <a href="../logout.php">
                            <i class="material-icons">power_settings_new</i>
                            <p>Log Out</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel">
            <nav class="navbar navbar-transparent navbar-absolute">
                <div class="container-fluid">
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a class="navbar-brand" href="#"> <?php echo $page_title;?> </a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li>
                                <a href="../logout.php" >
                                    <i class="material-icons"><i class="material-icons">power_settings_new</i></i>
                                    <p class="hidden-lg hidden-md">Log Out</p>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </nav>
            <div class="content">
                <?php
                    include $page_current;
                ?>
            </div>
            <footer class="footer">
                <div class="container-fluid">
                    <p class="copyright pull-right">
                        &copy;
                        2018 Lampu Web Teknologi, made with Love for a Future Young Business
                    </p>
                </div>
            </footer>
        </div>
    </div>
</body>
<!--   Core JS Files   -->
<script src="../assets/js/jquery-3.2.1.min.js" type="text/javascript"></script>
<script src="../assets/js/bootstrap.min.js" type="text/javascript"></script>
<script src="../assets/js/material.min.js" type="text/javascript"></script>
<!--  Charts Plugin -->
<script src="../assets/js/chartist.min.js"></script>
<!--  Dynamic Elements plugin -->
<script src="../assets/js/arrive.min.js"></script>
<!--  PerfectScrollbar Library -->
<script src="../assets/js/perfect-scrollbar.jquery.min.js"></script>
<!--  Notifications Plugin    -->
<script src="../assets/js/bootstrap-notify.js"></script>
<!--  Google Maps Plugin    -->
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
<!-- Material Dashboard javascript methods -->
<script src="../assets/js/material-dashboard.js?v=1.2.0"></script>
<!-- Material Dashboard DEMO methods, don't include it in your project! -->
<script src="../assets/js/demo.js"></script>
<script type="text/javascript">
    $(document).ready(function() {

        // Javascript method's body can be found in ../assets/js/demos.js
        demo.initDashboardPageCharts();

    });
</script>

</html>