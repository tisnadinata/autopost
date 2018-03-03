<div class="container-fluid">
    <div class="row">
        <div class="col-md-6 col-12">
            <?php
                if(isset($_GET['test'])){
                    $sql = "select * from getrich_users_twitter where twitter_type = ".$_GET['test']." and twitter_user = '".$_SESSION['user_data']->user_id."' order by twitter_type ASC";
                    $tw = $mysqli->query($sql)->fetch_object();
                    $userTW = getUserTW($_SESSION['user_data']->user_id);
                    $post = twPostText($userTW->twitter_token,$userTW->twitter_secret,$_SESSION['user_data']->user_id,"Hello, my name is ".$_SESSION['user_data']->user_fname." ".$_SESSION['user_data']->user_lname);
                    echo '<div class="alert alert-info" role="alert">
                                '.$post.'
                        </div>
                    ';
                    echo'<meta http-equiv="refresh" content="5; url=?p=twitter" />  ';
                }

                //get liset account
                $sql = "select * from getrich_users_twitter where twitter_user = '".$_SESSION['user_data']->user_id."' order by twitter_type ASC";
                $tw = $mysqli->query($sql);
                $acc = array();
                $i=0;
                while($get = $tw->fetch_object()){
                    $acc[$i][0] = $get->twitter_name;
                    $acc[$i][1] = $get->twitter_expired;
                    if($get->twitter_status == 0){
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
                    <i class="fa fa-twitter-square"></i>
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
                            <a href="tw-login.php?user=<?php echo $_SESSION['user_data']->user_id.'&type=1&consumer_secret='.TWITTER_SECRET.'&consumer_key='.TWITTER_KEY; ?>"
                             id="login" class="btn btn-xs pull-right btn-info col-md-12 col-xs-12"><h4><strong>LINK TWITTER ACCOUNT</strong></h4></a>
                        <?php
                            }else{
                            ?>
                            <!-- <a href="delete-account.php?acc=tw&type=1" class="btn btn-xs btn-danger col-md-5 col-xs-12"><h4><strong>UNLINK ACCOUNT</strong></h4></a> -->
                            <a href="stop-account.php?acc=tw&type=1" class="btn btn-xs btn-primary col-md-5 col-xs-12"><h4><strong><?php echo $acc[0][2]; ?> POSTING</strong></h4></a>
                            <a href="?p=twitter&test=1" id="login" class="btn btn-xs pull-right btn-info col-md-6 col-xs-12"><h4><strong>TEST POST TO THIS ACCOUNT</strong></h4></a>
                        <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="card card-stats">
                <div class="card-header" data-background-color="blue">
                    <i class="fa fa-twitter-square"></i>
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
                            <a href="tw-login.php?user=<?php echo $_SESSION['user_data']->user_id.'&type=2&consumer_secret='.TWITTER_SECRET.'&consumer_key='.TWITTER_KEY; ?>"
                             id="login" class="btn btn-xs pull-right btn-info col-md-12 col-xs-12"><h4><strong>LINK TWITTER ACCOUNT</strong></h4></a>
                        <?php
                            }else{
                            ?>
                            <!-- <a href="delete-account.php?acc=tw&type=2" class="btn btn-xs btn-danger col-md-5 col-xs-12"><h4><strong>UNLINK ACCOUNT</strong></h4></a> -->
                            <a href="stop-account.php?acc=tw&type=2" class="btn btn-xs btn-primary col-md-5 col-xs-12"><h4><strong><?php echo $acc[1][2]; ?> POSTING</strong></h4></a>
                            <a href="?p=twitter&test=2" id="login" class="btn btn-xs pull-right btn-info col-md-6 col-xs-12"><h4><strong>TEST POST TO THIS ACCOUNT</strong></h4></a>
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
                    <strong>TWITTER SETTINGS DOCUMENTATION</strong>
                </div>
                <div class="card-content">
                    <h4 class="title"><strong>HOW TO LINK TWITTER ACCOUNT ?</strong></h4>
                    <p class="category">
                        <ol>
                            <li>Make sure your twitter already in logout condition</li>
                            <li>Login at https://twitter.com with your new account to use</li>
                            <li>Go back to this page</li>
                            <li>Click <strong>"LINK twitter ACCOUNT"</strong> button below twitter Information Card</li>
                            <li>If it's successfully the card beside will show your new twitter account name</li>
                        </ol>
                    </p>
                    <hr>
                    <h4 class="title"><strong>WHAT SHOULD I DO IF MY TWITTER ACCOUNT EXPIRED ?</strong></h4>
                    <p class="category">
                        <ol>
                            <li>Make sure your current twitter account in login condition</li>
                            <li>Click <strong>"LINK twitter ACCOUNT"</strong> button below twitter Information Card</li>
                            <li>If it's successfully the card beside will show your twitter account name</li>
                        </ol>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
