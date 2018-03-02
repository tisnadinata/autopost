<?php
    include '../config/config_db.php';
    if($_GET['acc'] == "fb"){
        $sql = "update getrich_users_facebook set facebook_status=((facebook_status-1)*(-1))
        where facebook_user='".$_SESSION['user_data']->user_id."' and facebook_type='".$_GET['type']."'";
        $url = "facebook";
    }else if($_GET['acc'] == "tw"){
        $sql = "update getrich_users_twitter set twitter_status=((twitter_status-1)*(-1))
        where twitter_user='".$_SESSION['user_data']->user_id."' and twitter_type='".$_GET['type']."'";
        $url = "twitter";
    }
    $mysqli->query($sql);
    header('Location: ./?p='.$url);
?>