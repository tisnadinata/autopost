<?php
    include '../config/config_db.php';
    $sql = "update getrich_notifications set notification_status=1 where notification_id=".$_GET['notif'];
    $mysqli->query($sql);
    header('Location: ./?p=dashboard');
?>