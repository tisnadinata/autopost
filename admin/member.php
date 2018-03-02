<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
            <?php
                date_default_timezone_set('Asia/Jakarta');
                $nowFormat = date('Y-m-d H:i:s');
                $users_all = getDataByCondition("getrich_users","user_status != 'admin'","user_fname ASC");
                $users_trial = getDataByCondition("getrich_users","user_status = 'trial'","user_fname ASC");
                $users_premium = getDataByCondition("getrich_users","user_status = 'premium'","user_fname ASC");
                if(isset($_GET['delete'])){
                    $sql = "delete from getrich_users where user_id=".$_GET['delete'];
                    $stmt = $mysqli->query($sql);
                    if($stmt){
                        $sql = "delete from getrich_notifications where notification_to=".$_GET['delete'];
                        echo '<div class="alert alert-success" role="alert">
                                    Success delete user.
                            </div>
                            <meta http-equiv="refresh" content="1; url=?p=member" />                                
                            ';
                    }else{
                        echo '<div class="alert alert-danger" role="alert">
                                    Failed to delete data.
                            </div>
                        ';
                    }
                }
            ?>
			<div class="card card-nav-tabs">
				<div class="card-header" data-background-color="blue">
					<div class="nav-tabs-navigation">
						<div class="nav-tabs-wrapper">
							<span class="nav-tabs-title">Show member : </span>
							<ul class="nav nav-tabs" data-tabs="tabs">
								<li class="active">
									<a href="#all" data-toggle="tab">
									    <i class="material-icons">content_paste</i> All Users( <?php echo $users_all->num_rows; ?> )
									    <div class="ripple-container"></div>
									</a>
								</li>
								<li class="">
									<a href="#trial" data-toggle="tab">
									<i class="material-icons">star_border</i> Trial Users( <?php echo $users_trial->num_rows; ?> )
									<div class="ripple-container"></div>
									</a>
								</li>
								<li class="">
									<a href="#premium" data-toggle="tab">
									<i class="material-icons">stars</i> Permium Users( <?php echo $users_premium->num_rows; ?> )
									<div class="ripple-container"></div>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="card-content">
					<div class="tab-content" style="max-height: 750px;overflow-y: auto;">
						<div class="tab-pane active" id="all">
							<table class="table table-hover">
                                <thead class="text-warning">
                                    <th>NO</th>
                                    <th>Full Name</th>
                                    <th>Email/Phone Number</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                <?php
                                    $num = 1;
                                    while($get = $users_all->fetch_object()){
                                ?>
                                    <tr>
                                        <td><?php echo $num;?></td>
                                        <td><?php echo $get->user_fname." ".$get->user_lname;?><?php echo "<small>(".$get->user_username.")</small>";?></td>
                                        <td><?php echo $get->user_email;?><br><?php echo $get->user_phone;?></td>
                                        <td class="text-uppercase"><?php echo $get->user_status;?></td>
                                        <td><?php echo $get->created;?></td>
                                        <td class="td-actions text-right">
                                            <a href="?p=member&edit=<?php echo $get->user_id;?>" rel="tooltip" title="Edit Member" class="btn btn-info btn-simple btn-xs">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="?p=member&delete=<?php echo $get->user_id;?>" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    $num++;
                                    }
                                ?>
                                </tbody>
                            </table>
						</div>
						<div class="tab-pane" id="trial">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                    <th>NO</th>
                                    <th>Full Name</th>
                                    <th>Email/Phone Number</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                <?php
                                    $num = 1;
                                    while($get = $users_trial->fetch_object()){
                                ?>
                                    <tr>
                                        <td><?php echo $num;?></td>
                                        <td><?php echo $get->user_fname." ".$get->user_lname;?><?php echo "<small>(".$get->user_username.")</small>";?></td>
                                        <td><?php echo $get->user_email;?><br><?php echo $get->user_phone;?></td>
                                        <td class="text-uppercase"><?php echo $get->user_status;?></td>
                                        <td><?php echo $get->created;?></td>
                                        <td class="td-actions text-right">
                                            <a href="?p=member&edit=<?php echo $get->user_id;?>" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="?p=member&delete=<?php echo $get->user_id;?>" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    $num++;
                                    }
                                ?>
                                </tbody>
                            </table>
						</div>
						<div class="tab-pane" id="premium">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                    <th>NO</th>
                                    <th>Full Name</th>
                                    <th>Email/Phone Number</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                <?php
                                    $num = 1;
                                    while($get = $users_premium->fetch_object()){
                                ?>
                                    <tr>
                                        <td><?php echo $num;?></td>
                                        <td><?php echo $get->user_fname." ".$get->user_lname;?><?php echo "<small>(".$get->user_username.")</small>";?></td>
                                        <td><?php echo $get->user_email;?><br><?php echo $get->user_phone;?></td>
                                        <td class="text-uppercase"><?php echo $get->user_status;?></td>
                                        <td><?php echo $get->created;?></td>
                                        <td class="td-actions text-right">
                                            <a href="?p=member&edit=<?php echo $get->user_id;?>" rel="tooltip" title="Edit Task" class="btn btn-info btn-simple btn-xs">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="?p=member&delete=<?php echo $get->user_id;?>" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                <i class="material-icons">delete</i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php
                                    $num++;
                                    }
                                ?>
                                </tbody>
                            </table>
						</div>
					</div>
				</div>
			</div>
		</div>
        <div class="col-md-4">
         <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Create / Edit User Data</h4>                
            </div>
            <div class="card-content">
                <?php
                    $username = "";
                    $fname = "";
                    $lname = "";
                    $email = "";
                    $phone = "";
                    $address = "";
                    $status = "";
                    if(isset($_GET['edit'])){
                        $user = getDataByCollumn("getrich_users","user_id",$_GET['edit']);
                        if($user->num_rows != 0){
                            $user = $user->fetch_object();
                            $username =  $user->user_username;
                            $fname = $user->user_fname;
                            $lname = $user->user_lname;
                            $email = $user->user_email;
                            $phone = $user->user_phone;
                            $address = $user->user_address;
                            $status = $user->user_status;
                        }
                    }
                    if(isset($_POST['create'])){
                        $stmt = $mysqli->query("insert into getrich_users(user_username,user_password,user_fname,user_lname,user_email,user_phone,user_address,user_status,created)
                        VALUES('".$_POST['username']."','".md5($_POST['password'])."','".$_POST['fname']."','".$_POST['lname']."','".$_POST['email']."','".$_POST['phone']."','".$_POST['address']."','".$_POST['status']."','". $nowFormat."')");
                        if($stmt){
                            $users_new = getDataByCondition("getrich_users","user_username = '".$_POST['username']."'","user_fname ASC")->fetch_object();
                            for($i=1;$i<=2;$i++){
                                $sql_fb = "insert into getrich_users_facebook(facebook_user,facebook_type) values(".$users_new->user_id.",".$i.")";
                                $mysqli->query($sql_fb);
                            }
                            for($i=1;$i<=2;$i++){
                                $sql_tw = "insert into getrich_users_twitter(twitter_user,twitter_type) values(".$users_new->user_id.",".$i.")";
                                $mysqli->query($sql_tw);
                            }
                            // $arr = json_encode(array());
                            // for($i=1;$i<=4;$i++){
                            //     $sql_schedule = "insert into getrich_schedule_fb(schedule_user,schedule_phase,schedule_content) values(".$users_new->user_id.", ".$i.", '".$arr."')";
                            //     $mysqli->query($sql_schedule);
                            // }
                            echo '<div class="alert alert-success" role="alert">
                                        Success create new acount with username <b>'.$_POST['username'].'</b> and password <b>'.$_POST['password'].'</b>.
                                </div>
                                <meta http-equiv="refresh" content="1; url=?p=member" />                                
                            ';
                        }else{
                            echo '<div class="alert alert-danger" role="alert">
                                        Failed to create new account.
                                </div>
                            ';
                        }
                    }
                    if(isset($_POST['edit'])){
                        $sql = "update getrich_users set user_username='".$_POST['username']."',user_fname='".$_POST['fname']."',user_lname='".$_POST['lname']."',user_email='".$_POST['email']."',user_phone='".$_POST['phone']."',user_address='".$_POST['address']."',user_status='".$_POST['status']."' where user_id=".$_GET['edit'];
                        $stmt = $mysqli->query($sql);                        
                        if($stmt){
                            if($_POST['status'] == "permium"){
                                include_once '../library/emailLibrary/function.php';
								kirimEmail($_POST['email'],"Upgrade Account","Congratulations, your account upgraded to PREMIUM ACCOUNT in ".getPengaturan("url_web")->value_pengaturan);
                            }
                            echo '<div class="alert alert-success" role="alert">
                                        Success change acount data.
                                </div>
                                <meta http-equiv="refresh" content="1; url=?p=member" />                                
                                ';
                        }else{
                            echo '<div class="alert alert-danger" role="alert">
                                        Failed to change acount data.
                                </div>
                            ';
                        }
                    }
                ?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Username</label>
                                <input type="text" class="form-control" name="username" value="<?php echo $username;?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Password</label>
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group label-floating">
                                <label class="control-label">First Name</label>
                                <input type="text" class="form-control" name="fname" value="<?php echo $fname;?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Last Name</label>
                                <input type="text" class="form-control" name="lname" value="<?php echo $lname;?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Address</label>
                                <input type="text" class="form-control" name="address" value="<?php echo $address;?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Email</label>
                                <input type="email" class="form-control" name="email" value="<?php echo $email;?>">
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Phone Number</label>
                                <input type="number" class="form-control" name="phone" value="<?php echo $phone;?>">
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Status</label>
                                <select name="status" class="form-control">
                                    <?php
                                         if(isset($_GET['edit'])){
                                             echo'<option value="'.$status.'">'.strtoupper($status).'</option>';
                                         }
                                    ?>
                                    <option value="trial">TRIAL ACCOUNT (2 days)</option>
                                    <option value="premium">PREMIUM ACCOUNT</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <?php
                        if(isset($_GET['edit'])){
                            echo'
                                <button type="submit" name="edit" class="btn btn-info pull-right">Save Data</button>
                            ';                                
                        }else{
                            echo'
                                <button type="submit" name="create" class="btn btn-info pull-right">Create User</button>
                            ';                                
                        }
                    ?>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
	</div>
</div>