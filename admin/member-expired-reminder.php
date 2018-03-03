<?php
    include '../config/config_main.php';
    $sql = "select * from getrich_users where user_status='trial' and created >= NOW() - INTERVAL 4 DAY";
    $stmt = $mysqli->query($sql);
    if($stmt && @$stmt->num_rows != 0){
        while($user = $stmt->fetch_object()){
            echo "<hr>User : ".$user->user_fname."<br>";
            echo "Active : ".userTrialActive($user->created)."<br>";
            echo "Day from registered : ".userTrial($user->created)."<br>";
            if(!userTrialActive($user->created)){
                $send = false;
                if(userTrial($user->created) == 2){
                    $subject = "Reminder Expired Account Day 1";
                    $message = getPengaturan("email_reminder1")->value_pengaturan;
                    $send = true;
                    echo "Day 1 reminder<br>";
                }
                if(userTrial($user->created) == 3){
                    $subject = "Reminder Expired Account Day 2";
                    $message = getPengaturan("email_reminder2")->value_pengaturan;
                    $send = true;
                    echo "Day 2 reminder<br>";
                }
                if($send){
                    include_once '../library/emailLibrary/function.php';
                    kirimEmail($user->user_email,$subject,$message);
                    echo "send to ".$user->user_email;
                }
            }
        }
    }
?>