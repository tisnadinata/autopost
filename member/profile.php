<div class="container-fluid">
<div class="row">
    <div class="col-md-8">
        <?php
            if(isset($_POST['edit'])){
                $sql = "update getrich_users set user_fname='".$_POST['fname']."',user_lname='".$_POST['lname']."',user_email='".$_POST['email']."',user_phone='".$_POST['phone']."',user_address='".$_POST['address']."' where user_id=".$_SESSION['user_data']->user_id;
                $stmt = $mysqli->query($sql);
                if($stmt){
                    $_SESSION['user_data'] = login($_SESSION['user_data']->user_username,$_SESSION['temp'])->fetch_object();
                    echo '<div class="alert alert-success" role="alert">
                                Success change acount data.
                        </div>
                        <meta http-equiv="refresh" content="1; url=?p=profile" />                                
                        ';
                }else{
                    echo '<div class="alert alert-danger" role="alert">
                                Failed to change acount data.
                        </div>
                    ';
                }
            }
        ?>
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Edit Profile</h4>
                <p class="category">Complete your profile</p>
            </div>
            <div class="card-content">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Username  (disabled, cannot be edited)</label>
                                <input type="text" class="form-control" value="<?php echo  $_SESSION['user_data']->user_username; ?>" disabled>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Email Address</label>
                                <input type="email" name="email" class="form-control" value="<?php echo $_SESSION['user_data']->user_email; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group label-floating">
                                <label class="control-label">Phone Number</label>
                                <input type="number" name="phone" class="form-control" value="<?php echo $_SESSION['user_data']->user_phone; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Fist Name</label>
                                <input type="text" name="fname" class="form-control" value="<?php echo $_SESSION['user_data']->user_fname; ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group label-floating">
                                <label class="control-label">Last Name</label>
                                <input type="text" name="lname" class="form-control" value="<?php echo $_SESSION['user_data']->user_lname; ?>" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Adress</label>
                                <input type="text" name="address" class="form-control" value="<?php echo $_SESSION['user_data']->user_address; ?>" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="edit" class="btn btn-info pull-right">Update Profile</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-4">
        <?php
            if(isset($_POST['editpass'])){
                if(md5($_POST['oldpass']) == $_SESSION['user_data']->user_password){
                    if($_POST['newpass'] == $_POST['newpassre']){
                        $sql = "update getrich_users set user_password='".md5($_POST['newpass'])."' where user_id=".$_SESSION['user_data']->user_id;
                        $stmt = $mysqli->query($sql);                        
                        if($stmt){
                            $_SESSION['user_data'] = login($_SESSION['user_data']->user_username,$_POST['newpass'])->fetch_object();
                            echo '<div class="alert alert-success" role="alert">
                                        Password has been changed to <b>'.$_POST['newpass'].'</b>.
                                </div>
                                <meta http-equiv="refresh" content="1; url=?p=profile" />                                
                                ';
                        }else{
                            echo '<div class="alert alert-danger" role="alert">
                                        Failed to change acount password.
                                </div>
                            ';
                        }
                    }else{
                        echo '<div class="alert alert-danger" role="alert">
                                    Your new password does not match.
                            </div>
                        ';
                    }
                }else{
                    echo '<div class="alert alert-danger" role="alert">
                                Your old password does not match.
                        </div>
                    ';
                }
        }
        ?>
         <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Change Password</h4>
                <p class="category">Change your password here</p>
            </div>
            <div class="card-content">
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Old Password</label>
                                <input type="password" name="oldpass" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-floating">
                                <label class="control-label">New Password</label>
                                <input type="password" name="newpass" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Re-type New Password</label>
                                <input type="password" name="newpassre" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="editpass" class="btn btn-info pull-right">Change Password</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
