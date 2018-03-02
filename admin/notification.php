<div class="container-fluid">
	<div class="row">
		<div class="col-md-8">
        <?php
            if(isset($_GET['delete'])){
                $sql = "delete from getrich_notifications where notification_id=".$_GET['delete'];
                $stmt = $mysqli->query($sql);
                if($stmt){
                    echo '<div class="alert alert-success" role="alert">
                                Success delete notification.
                        </div>
                        <meta http-equiv="refresh" content="1; url=?p=notification" />                                
                        ';
                }else{
                    echo '<div class="alert alert-danger" role="alert">
                                Failed to delete notification.
                        </div>
                    ';
                }
            }
        ?>
        <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Last notification you create</h4>                
            </div>
            <div class="card-content">
                <table class="table table-hover">
                    <thead class="text-warning">
                        <th>NO</th>
                        <th>Description</th>
                        <th>Send To</th>
                        <th>Status</th>
                        <th>Created</th>
                        <th>Action</th>
                    </thead>
                    <tbody>
                    <?php
                        $notifications = getDataByCondition("getrich_notifications","notification_id != 0","created DESC");
                        $num = 1;
                        while($get = $notifications->fetch_object()){
                            if($get->notification_to == 0){
                                $notif_to = "All Member";
                            }else{
                                $user = getDataByCondition("getrich_users","user_id = ".$get->notification_to,"created ASC")->fetch_object();
                                $notif_to = $user->user_fname." ".$user->user_lname;
                            }
                            if($get->notification_status == 0){
                                $notif_status = "Delivered";
                            }else{
                                $notif_status = "Read By User";
                            }
                    ?>
                        <tr>
                            <td><?php echo $num;?></td>
                            <td><?php echo $get->notification_desc;?></td>
                            <td><?php echo $notif_to;?></td>
                            <td><?php echo $notif_status;?></td>
                            <td class="text-uppercase"><?php echo $get->created;?></td>
                            <td class="td-actions text-right">
                                <a href="?p=notification&delete=<?php echo $get->notification_id;?>" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
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
        <div class="col-md-4">
         <div class="card">
            <div class="card-header" data-background-color="blue">
                <h4 class="title">Create new notification</h4>                
            </div>
            <div class="card-content">
                <?php
                    if(isset($_POST['create'])){
                        $to = explode("-",$_POST['to']);
                        $stmt = $mysqli->query("insert into getrich_notifications(notification_to,notification_desc,notification_status)
                        VALUES('".$to[0]."','".$_POST['desc']."',0)");
                        if($stmt){
                            echo '<div class="alert alert-success" role="alert">
                                        Success create new notification to <b>'.$to[1].'</b>.
                                </div>
                                <meta http-equiv="refresh" content="1; url=?p=notification" />                                
                            ';
                        }else{
                            echo '<div class="alert alert-danger" role="alert">
                                        Failed to create new notification.
                                </div>
                            ';
                        }
                    }
                ?>
                <form action="" method="post">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-floating">
                                <label class="control-label">Send this notification to :</label>
                                <select name="to" class="form-control">
                                    <option value="0-All Member">All Member</option>
                                    <?php
                                        $users = getDataByCondition("getrich_users","user_status != 'admin'","user_fname ASC");
                                        while($get = $users->fetch_object()){
                                            echo "<option value='".$get->user_id."-".$get->user_fname." ".$get->user_lname."'>".$get->user_fname." ".$get->user_lname."</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group label-floating">
                                <textarea class="form-control" name="desc" required placeholder="Description for your notification" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="create" class="btn btn-info pull-right">Send Notification</button>
                    <div class="clearfix"></div>
                </form>
            </div>
        </div>
    </div>
	</div>
</div>