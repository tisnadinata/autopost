<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-12">
            <?php
                if(isset($_GET['test'])){
                    $sql = "select * from getrich_users_facebook where facebook_type = ".$_GET['test']." and facebook_user = '".$_SESSION['user_data']->user_id."' order by facebook_type ASC";
                    $fb = $mysqli->query($sql)->fetch_object();
                    $post = fbPostText(getUserFB($_SESSION['user_data']->user_id)->facebook_token,$_SESSION['user_data']->user_id,"Hello, my name is ".$_SESSION['user_data']->user_fname." ".$_SESSION['user_data']->user_lname);
                    echo '<div class="alert alert-info" role="alert">
                                '.$post.'
                        </div>
                    ';
                    echo '<meta http-equiv="refresh" content="3; url=?p=facebook" />  ';
                }

                //get liset account
                $sql = "select * from getrich_users_facebook where facebook_user = '".$_SESSION['user_data']->user_id."' order by facebook_type ASC";
                $fb = $mysqli->query($sql);
                $acc = array();
                $i=0;
                while($get = $fb->fetch_object()){
                    $acc[$i][0] = $get->facebook_name;
                    $acc[$i][1] = $get->facebook_expired;
                    if($get->facebook_status == 0){
                        $acc[$i][2] = "START";
                    }else{
                        $acc[$i][2] = "STOP";
                    }
                    $i++;
                }
                for($i;$i<5;$i++){
                    $acc[$i][0] = "Tidak Ada";
                    $acc[$i][1] = "Tidak ada";
                    $acc[$i][2] = "";
                }

            ?>
            <div class="card card-stats">
                <div class="card-header" data-background-color="blue">
                    <i class="fa fa-facebook-square"></i>
                </div>
                <div class="card-content">
                    <p class="category">FIRST ACCOUNT :</p>
                    <h3 class="title" >
                        <?php
                            echo $acc[0][0];
                        ?>
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats text-danger" style="width:100%">
                        <?php
                            if($acc[0][0] == "Tidak Ada" || $acc[0][0]=""){
                        ?>
                            <a href="fb-login-1.php" id="login" class="btn btn-xs pull-right btn-info col-md-12 col-xs-12"><h4><strong>LINK FACEBOOK ACCOUNT</strong></h4></a>
                        <?php
                            }else{
                        ?>
                            <i class="material-icons">watch_later</i> Your access token will expired on <?php echo $acc[0][1];?>. Get new access token to refresh it.
                            <!-- <a href="delete-account.php?acc=fb&type=1" class="btn btn-xs btn-danger col-md-5 col-xs-12"><h4><strong>UNLINK ACCOUNT</strong></h4></a> -->
                            <a href="stop-account.php?acc=fb&type=1" class="btn btn-xs btn-primary col-md-5 col-xs-12"><h4><strong><?php echo $acc[0][2]; ?> POSTING</strong></h4></a>
                            <a href="?p=facebook&test=1" id="login" class="btn btn-xs pull-right btn-info col-md-6 col-xs-12"><h4><strong>TEST POST TO THIS ACCOUNT</strong></h4></a>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="card card-stats" style="visibility: hidden;">
                <div class="card-header" data-background-color="blue">
                    <i class="fa fa-facebook-square"></i>
                </div>
                <div class="card-content">
                    <p class="category">SECOND ACCOUNT :</p>
                    <h3 class="title" >
                        <?php
                            echo $acc[1][0];
                        ?>
                    </h3>
                </div>
                <div class="card-footer">
                    <div class="stats text-danger" style="width:100%">
                    <?php
                        if($acc[1][0] == "Tidak Ada" || $acc[1][0]=""){
                        ?>
                            <a href="fb-login-2.php" id="login" class="btn btn-xs pull-right btn-info col-md-12 col-xs-12"><h4><strong>LINK FACEBOOK ACCOUNT</strong></h4></a>
                        <?php
                            }else{
                            ?>
                            <i class="material-icons">watch_later</i> Your access token will expired on <?php echo $acc[1][1];?>. Get new access token to refresh it.
                            <!-- <a href="delete-account.php?acc=fb&type=2" class="btn btn-xs btn-danger col-md-5 col-xs-12"><h4><strong>UNLINK ACCOUNT</strong></h4></a> -->
                            <a href="stop-account.php?acc=fb&type=2" class="btn btn-xs btn-primary col-md-5 col-xs-12"><h4><strong><?php echo $acc[1][2]; ?> POSTING</strong></h4></a>
                            <a href="?p=facebook&test=2" id="login" class="btn btn-xs pull-right btn-info col-md-6 col-xs-12"><h4><strong>TEST POST TO THIS ACCOUNT</strong></h4></a>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-12">
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <strong>FACEBOOK SETTINGS DOCUMENTATION</strong>
                </div>
                <div class="card-content">
                    <h4 class="title"><strong>HOW TO LINK FACEBOOK ACCOUNT ?</strong></h4>
                    <p class="category">
                        <ol>
                            <li>Make sure your facebook already in logout condition</li>
                            <li>Login at https://facebook.com with your new account to use</li>
                            <li>Go back to this page</li>
                            <li>Click <strong>"LINK FACEBOOK ACCOUNT"</strong> button below Facebook Information Card</li>
                            <li>If it's successfully the card beside will show your new facebook account name</li>
                        </ol>
                    </p>
                    <hr>
                    <h4 class="title"><strong>WHAT SHOULD I DO IF MY FACEBOOK ACCOUNT EXPIRED ?</strong></h4>
                    <p class="category">
                        <ol>
                            <li>Make sure your current facebook account in login condition</li>
                            <li>Click <strong>"LINK FACEBOOK ACCOUNT"</strong> button below Facebook Information Card</li>
                            <li>If it's successfully the card beside will show your facebook account name</li>
                        </ol>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
