<style>
.user{
    float:left;width:19%;height:250px;margin:0.5%;
}
</style>
<?php
$run = false;
if($run){
    #!/usr/local/bin/php -q
    include '../config/config_main.php';
    date_default_timezone_set('Asia/Jakarta');
    $nowFormat = date('Y-m-d H:i:s');
    ini_set('display_errors', '1');
    
    echo date_default_timezone_get()."<br>";
    echo date("Y-m-d H:i:s");
    echo "<br>";
    $loop = 1;
    //AMBIL SEMUA USER
    $stmt_all_users = $mysqli->query("select * from getrich_users where user_status != 'admin'");
    echo "User Listed : ".$stmt_all_users->num_rows."<hr><br>";
    while($get_all_users = $stmt_all_users->fetch_object()){
        echo "<div class='user'>";
        echo "User : ".$loop."<br><hr>";
        echo "User : ".$get_all_users->user_fname."<br>";
        //CEK APAKAH USER TERSEBUT BOLEH POST ATAU TIDAK
        $user_id = $get_all_users->user_id;
        $schedule_content = 0;
        $schedule_status = "";
        $note = "";
        $post = "";
        if($get_all_users->user_status == "premium"){
            $access_post = true;
        }else{
            $access_post = userTrialActive($get_all_users->created);
        }
        if($access_post){
            echo "Access Posting : Yes <br>";
            //AMBIL LAST POST USER INI
            $stmt_history_users = $mysqli->query("select * from getrich_contents_post where post_user = ".$user_id." and post_status='success' and note LIKE '%twitter%' and note LIKE '%Phase".$_GET['phase']."%' order by post_id DESC LIMIT 0,1");
            if($stmt_history_users->num_rows > 0){
                $get_history_users = $stmt_history_users->fetch_object();
                echo "Last Posted Phase ".$_GET['phase']." : ID(".$get_history_users->post_id.") CONTENT(".$get_history_users->post_content.") <br>";
            }else{
                $get_history_users = null;
                echo "Last Posted Phase ".$_GET['phase']." : Not Found <br>";
            }
            //AMBIL SEMUA SCHEDULE USER INI
            $stmt_schedule_users = $mysqli->query("select * from getrich_schedule_tw where schedule_user=".$user_id." and schedule_phase=".$_GET['phase']);
            if($stmt_schedule_users->num_rows > 0){
                echo "Schedule Phase ".$_GET['phase']." : ".$stmt_schedule_users->num_rows." content listed <br>";
                //CARI KONTEN YANG SETELAH LAST POST CONTENT
                if($get_history_users == null){
                    $final_schedule_users = $stmt_schedule_users->fetch_object();
                }else if($get_history_users != null){
                    $found = false;
                    $cur_sch = 0;
                    while($get_schedule_users = $stmt_schedule_users->fetch_object()){
                        $cur_sch++;
                        if($get_schedule_users->schedule_content == $get_history_users->post_content){
                            if($cur_sch < $stmt_schedule_users->num_rows){
                                $final_schedule_users = $stmt_schedule_users->fetch_object();
                            }else{
                                $stmt_schedule_users = $mysqli->query("select * from getrich_schedule_tw where schedule_user=".$user_id." and schedule_phase=".$_GET['phase']);
                                $final_schedule_users = $stmt_schedule_users->fetch_object();
                            }
                            $found = true;
                            break;
                        }
                    }
                    if(!$found){
                        $stmt_schedule_users = $mysqli->query("select * from getrich_schedule_tw where schedule_user=".$user_id." and schedule_phase=".$_GET['phase']);
                        $final_schedule_users = $stmt_schedule_users->fetch_object();
                    }
                }
                echo "Final schedule : ID(".$final_schedule_users->schedule_id.") CONTENT(".$final_schedule_users->schedule_content.")<br>";                    
                //AMBIL KONTEN YANG SUDAH DIPILIH
                $schedule_content = $final_schedule_users->schedule_content;
                $get_content_users = $mysqli->query("select * from getrich_contents where content_id=".$schedule_content)->fetch_object();
                //AMBIL SEMUA AKUN MEDSOS USER
                $get_twitter = getDataByCondition("getrich_users_twitter","twitter_status = 1 and twitter_user = ".$user_id,"twitter_type ASC");
                if($get_twitter->num_rows > 0){
                    $acc = 1;
                    while($user_twitter = $get_twitter->fetch_object()){
                        echo "Account ".$acc." : ".$user_twitter->twitter_name."<br>";
                        if($get_content_users->content_type == "text"){
                            $post = twPostText($user_twitter->twitter_token,$user_twitter->twitter_secret,$user_id,$get_content_users->content_desc);
                            $note = $post.". | Phase".$_GET['phase']." | ".$user_twitter->twitter_name;
                        }else if($get_content_users->content_type == "photo"){
                            $post = twPostPhoto($user_twitter->twitter_token,$user_twitter->twitter_secret,$user_id,$get_content_users->content_desc,$get_content_users->content_url);
                            $note = $post.". | Phase".$_GET['phase']." | ".$user_twitter->twitter_name;
                        }else if($get_content_users->content_type == "video"){
                            $post = twPostVideo($user_twitter->twitter_token,$user_twitter->twitter_secret,$user_id,$get_content_users->content_desc,$get_content_users->content_url);
                            $note = $post.". | Phase".$_GET['phase']." | ".$user_twitter->twitter_name;
                        }else{
                            $note = "Content type undifened";
                        }
                        if (strpos($post, 'success') !== false) {
                            $schedule_status = 'success';
                        }else{
                            $schedule_status = 'fail';
                        }
                        echo "Post Status : ".$schedule_status."<br>";
                        $sql = "insert into getrich_contents_post(post_user,post_content,post_status,note,created) values(".$user_id.",'".$schedule_content."','".$schedule_status."','".$note."','".$nowFormat."')";
                        $mysqli->query($sql);
                        $acc++;
                    }
                }else{
                    echo "This user didnt have medsos account<br>";
                    $schedule_status = 'account not found';
                    $note = "No one twitter account linked";
                    $sql = "insert into getrich_contents_post(post_user,post_content,post_status,note,created) values(".$user_id.",'".$schedule_content."','".$schedule_status."','".$note."','".$nowFormat."')";
                    $mysqli->query($sql);
                }
            }else{
                echo "Schedule Phase ".$_GET['phase']." : Not Found <br>";
                $schedule_status = "content not found";
                $note = "No one twitter content listed in phase ".$_GET['phase'];
                $sql = "insert into getrich_contents_post(post_user,post_content,post_status,note,created) values(".$user_id.",'".$schedule_content."','".$schedule_status."','".$note."','".$nowFormat."')";
                $mysqli->query($sql);
            }
        }else{
            echo "Access Posting : No <br>";
            $schedule_status = "blocked";
            $note = "Feature blocked, expired account";
            $sql = "insert into getrich_contents_post(post_user,post_content,post_status,note,created) values(".$user_id.",'".$schedule_content."','".$schedule_status."','".$note."','".$nowFormat."')";
            $mysqli->query($sql);
        }
        $loop++;
        echo "</div>";
    }
}
?>