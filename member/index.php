<?php
    include '../config/config_main.php';
    if(!isset($_SESSION['user_data'])){
        echo '<meta http-equiv="refresh" content="0; url=../" />';
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
    $page_selected[6] = "";
    $page_selected[7] = "";
    $page_selected[8] = "";
    $page_current = "dashboard.php";
    $page_title = "Dashboard Overview";
    $page = @$_GET['p'];
    if($_SESSION['user_data']->user_status == "premium" || userTrialActive($_SESSION['user_data']->created)){
        switch($page){
            case "dashboard" : $page_current = 'dashboard.php';$page_title = "Dashboard Overview";$page_selected[0] = "active";break;
            case "profile" : $page_current = 'profile.php';$page_title = "My Profile";$page_selected[1] = "active";break;
            case "content" : $page_current = 'content.php';$page_title = "Manage Content";$page_selected[2] = "active";break;
            case "facebook" : $page_current = 'facebook.php';$page_title = "Facebook Account Settings";$page_selected[3] = "active";break;
            case "twitter" : $page_current = 'twitter.php';$page_title = "Twitter Account Settings";$page_selected[4] = "active";break;
            case "gallery" : $page_current = 'gallery.php';$page_title = "Gallery Photo/Video";$page_selected[5] = "active";break;
            case "fb-schedule" : $page_current = 'schedule.php';$page_title = "Facebook Scheduling Post";$page_selected[6] = "active";break;
            case "tw-schedule" : $page_current = 'schedule.php';$page_title = "Twitter Scheduling Post";$page_selected[7] = "active";break;
            case "support" : $page_current = 'support.php';$page_title = "Dukungan Support";$page_selected[8] = "active";break;
            default : $page_current = 'dashboard.php';$page_title = "Dashboard Overview";$page_selected[0] = "active";break;
        }
    }else{
        $page_current = 'dashboard.php';
        $page_title = "Dashboard Overview";
        $page_selected[0] = "active";
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
                        <a href="?p=profile">
                            <i class="material-icons">person</i>
                            <p>My Profile</p>
                        </a>
                    </li>
                    <li class="<?php echo $page_selected[2];?>">
                        <a href="?p=content">
                            <i class="material-icons">content_paste</i>
                            <p>Manage Content</p>
                        </a>
                    </li>
                    <li class="<?php echo $page_selected[3];?>">
                        <a href="?p=facebook">
                            <i class="fa fa-facebook"></i>
                            <p>Facebook Settings</p>
                        </a>
                    </li>
                    <li class="<?php echo $page_selected[4];?>">
                        <a href="?p=twitter">
                            <i class="fa fa-twitter"></i>
                            <p>Twitter Settings</p>
                        </a>
                    </li>
                    <li class="<?php echo $page_selected[5];?>">
                        <a href="?p=gallery">
                            <i class="material-icons">photo_library</i>
                            <p>Photo/Video Album</p>
                        </a>
                    </li>
                    <li class="<?php echo $page_selected[6];?>">
                        <a href="?p=fb-schedule&medsos=facebook">
                        <i class="material-icons">schedule</i>
                            <p>Facebook Scheduling</p>
                        </a>
                    </li>
                    <li class="<?php echo $page_selected[7];?>">
                        <a href="?p=tw-schedule&medsos=twitter">
                        <i class="material-icons">schedule</i>
                            <p>Twitter Scheduling</p>
                        </a>
                    </li>
                    <li class="<?php echo $page_selected[8];?>">
                        <a href="?p=support">
                        <i class="material-icons">help</i>
                            <p>Our Support</p>
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
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <i class="material-icons">notifications</i>
                                    <span class="notification">
                                    <?php
                                        $notifications_all = getDataByCondition("getrich_notifications","notification_to = 0","created DESC");
                                        $notifications = getDataByCondition("getrich_notifications","notification_status=0 AND notification_to = ".$_SESSION['user_data']->user_id,"created DESC");
                                        echo ($notifications_all->num_rows+$notifications->num_rows);
                                    ?>
                                    </span>
                                    <p class="hidden-lg hidden-md">Notifications</p>
                                </a>
                                <ul class="dropdown-menu">
                                    <?php
                                        if($notifications_all->num_rows > 0 || $notifications->num_rows > 0 ){
                                            while($get = $notifications->fetch_object()){
                                                echo'<li><a href="notifikasi.php?notif='.$get->notification_id.'">'.$get->notification_desc.'</a></li>';
                                            }
                                            while($get = $notifications_all->fetch_object()){
                                                echo'<li><a href="#">'.$get->notification_desc.'</a></li>';
                                            }
                                        }else{
                                            echo'<li><a href="#">Comeback later</a></li>';
                                        }
                                    ?>
                                </ul>
                            </li>
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