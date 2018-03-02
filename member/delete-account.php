<?php
    include '../config/config_db.php';
    if($_GET['acc'] == "fb"){
        $sql = "update getrich_users_facebook set facebook_name='Tidak Ada',facebook_uid='',facebook_token='',facebook_expired='',facebook_status=0
        where facebook_user='".$_SESSION['user_data']->user_id."' and facebook_type='".$_GET['type']."'";
        $url = "facebook";
    }else if($_GET['acc'] == "tw"){
        $sql = "update getrich_users_twitter set twitter_name='Tidak Ada',twitter_uid='',twitter_token='',twitter_secret='',twitter_expired='',twitter_status=0
        where twitter_user='".$_SESSION['user_data']->user_id."' and twitter_type='".$_GET['type']."'";
        $url = "twitter";
    }
    $mysqli->query($sql);
    header('Location: ./?p='.$url);
?>