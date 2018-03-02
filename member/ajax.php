<?php
    include '../config/config_main.php';
    if(isset($_POST['con_temp'])){
        $contents = getDataByCondition("getrich_contents","content_id = ".$_POST['con_temp'],"created DESC");
        if($contents->num_rows >= 1){
            $get = $contents->fetch_object();
            echo $get->content_desc;
        }else{
            echo "copy it";
        }
    }
?>