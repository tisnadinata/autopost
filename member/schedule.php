<div class="container-fluid">
	<div class="row">
    <div class="alert alert-primary col-md-12" role="alert">
        <div class="col-md-4 col-xs-12">
            <b>The posted content will be sorted out of the content below.</b>
        </div>
        <ul class="col-md-4 col-xs-12">
            <li>PHASE 1(will posted between 08.00 - 10.00 WIB )</li>
            <li>PHASE 2(will posted between 12.00 - 14.00 WIB )</li> 
        </ul>
        <ul class="col-md-4 col-xs-12">
            <li>PHASE 3(will posted between 16.00 - 18.00 WIB )</li>
            <li>PHASE 4(will posted between 20.00 - 22.00 WIB)</li>
        </ul>
    </div>
		<div class="col-md-8 col-xs-12">
            <?php
                $schedule_medsos = "";
                $schedule_url = "";
                if($_GET['medsos'] == "facebook"){
                    $schedule_medsos = "getrich_schedule_fb";
                    $schedule_url = "fb-schedule";
                    $schedule_log = getDataByCondition("getrich_contents_post","note LIKE '%facebook%' and post_user=".$_SESSION['user_data']->user_id,"created DESC LIMIT 0,50");
                }else if($_GET['medsos'] == "twitter"){
                    $schedule_medsos = "getrich_schedule_tw";
                    $schedule_url = "tw-schedule";
                    $schedule_log = getDataByCondition("getrich_contents_post","note LIKE '%twitter%' and post_user=".$_SESSION['user_data']->user_id,"created DESC LIMIT 0,50");
                }
                $schedule_1 = getDataByCondition($schedule_medsos,"schedule_phase = 1 and schedule_user=".$_SESSION['user_data']->user_id,"created ASC");
                $schedule_2 = getDataByCondition($schedule_medsos,"schedule_phase = 2 and schedule_user=".$_SESSION['user_data']->user_id,"created DESC");
                $schedule_3 = getDataByCondition($schedule_medsos,"schedule_phase = 3 and schedule_user=".$_SESSION['user_data']->user_id,"created DESC");
                $schedule_4 = getDataByCondition($schedule_medsos,"schedule_phase = 4 and schedule_user=".$_SESSION['user_data']->user_id,"created DESC");
                if(isset($_GET['delete'])){
                    $sql = "delete from ".$schedule_medsos." where schedule_id=".$_GET['delete'];
                    $stmt = $mysqli->query($sql);
                    if($stmt){
                        echo '<div class="alert alert-success" role="alert">
                                    Success delete schedule.
                            </div>
                            <meta http-equiv="refresh" content="1; url=?p='.$schedule_url.'&medsos='.$_GET['medsos'].'" />                                
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
							<span class="nav-tabs-title">Phase : </span>
							<ul class="nav nav-tabs" data-tabs="tabs">
								<li class="active">
									<a href="#one" data-toggle="tab">
									<i class="material-icons">looks_one</i> Phase 1
									<div class="ripple-container"></div>
									</a>
								</li>
								<li class="">
									<a href="#two" data-toggle="tab">
									<i class="material-icons">looks_two</i> Phase 2
									<div class="ripple-container"></div>
									</a>
								</li>
								<li class="">
									<a href="#three" data-toggle="tab">
									<i class="material-icons">looks_3</i> Phase 3
									<div class="ripple-container"></div>
									</a>
								</li>
								<li class="">
									<a href="#four" data-toggle="tab">
									<i class="material-icons">looks_4</i> Phase 4
									<div class="ripple-container"></div>
									</a>
								</li>
								<li class="">
									<a href="#log" data-toggle="tab">
									<i class="material-icons">history</i> Posting History
									<div class="ripple-container"></div>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="card-content">
					<div class="tab-content">
						<div class="tab-pane active" style="max-height:600px;overflow-y:auto" id="one">
							<table class="table table-hover">
                                <thead class="text-warning">
                                    <th width="60%">Content Title</th>
                                    <th>Photo/Video</th>
                                    <th>Type Post</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                <?php
                                    while($get = $schedule_1->fetch_object()){
                                        $content = getDataByCondition("getrich_contents","content_id = ".$get->schedule_content." and content_user=".$_SESSION['user_data']->user_id,"created DESC")->fetch_object();
                                ?>
                                    <tr>
                                        <td><?php echo $content->content_title;?></td>
                                        <td><a href='<?php echo getPengaturan("url_web")->value_pengaturan."/member/".$content->content_url;?>' target="_blank">LIHAT</a></td>
                                        <td><?php echo $content->content_type;?></td>
                                        <td class="td-actions text-right">
                                            <a href="?p=<?php echo $schedule_url."&medsos=".$_GET['medsos']."&delete=".$get->schedule_id;?>" rel="tooltip" title="Remove from this phase" class="btn btn-danger btn-simple btn-xs">
                                                <i class="material-icons">delete</i>
                                            </a><br>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
						</div>
						<div class="tab-pane" style="max-height:600px;overflow-y:auto" id="two">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                    <th width="60%">Content Title</th>
                                    <th>Photo/Video</th>
                                    <th>Type Post</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                <?php
                                    while($get = $schedule_2->fetch_object()){
                                        $content = getDataByCondition("getrich_contents","content_id = ".$get->schedule_content." and content_user=".$_SESSION['user_data']->user_id,"created DESC")->fetch_object();
                                ?>
                                    <tr>
                                        <td><?php echo $content->content_title;?></td>
                                        <td><a href='<?php echo getPengaturan("url_web")->value_pengaturan."/member/".$content->content_url;?>' target="_blank">LIHAT</a></td>
                                        <td><?php echo $content->content_type;?></td>
                                        <td class="td-actions text-right">
                                            <a href="?p=<?php echo $schedule_url."&medsos=".$_GET['medsos']."&delete=".$get->schedule_id;?>" rel="tooltip" title="Remove from this phase" class="btn btn-danger btn-simple btn-xs">
                                                <i class="material-icons">delete</i>
                                            </a><br>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
						</div>
						<div class="tab-pane" style="max-height:600px;overflow-y:auto" id="three">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                    <th width="60%">Content Title</th>
                                    <th>Photo/Video</th>
                                    <th>Type Post</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                <?php
                                    while($get = $schedule_3->fetch_object()){
                                        $content = getDataByCondition("getrich_contents","content_id = ".$get->schedule_content." and content_user=".$_SESSION['user_data']->user_id,"created DESC")->fetch_object();
                                ?>
                                    <tr>
                                        <td><?php echo $content->content_title;?></td>
                                        <td><a href='<?php echo getPengaturan("url_web")->value_pengaturan."/member/".$content->content_url;?>' target="_blank">LIHAT</a></td>
                                        <td><?php echo $content->content_type;?></td>
                                        <td class="td-actions text-right">
                                            <a href="?p=<?php echo $schedule_url."&medsos=".$_GET['medsos']."&delete=".$get->schedule_id;?>" rel="tooltip" title="Remove from this phase" class="btn btn-danger btn-simple btn-xs">
                                                <i class="material-icons">delete</i>
                                            </a><br>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
						</div>
						<div class="tab-pane" style="max-height:600px;overflow-y:auto" id="four">
                            <table class="table table-hover">
                                <thead class="text-warning">
                                    <th width="60%">Content Title</th>
                                    <th>Photo/Video</th>
                                    <th>Type Post</th>
                                    <th></th>
                                </thead>
                                <tbody>
                                <?php
                                    while($get = $schedule_4->fetch_object()){
                                        $content = getDataByCondition("getrich_contents","content_id = ".$get->schedule_content." and content_user=".$_SESSION['user_data']->user_id,"created DESC")->fetch_object();
                                ?>
                                    <tr>
                                        <td><?php echo $content->content_title;?></td>
                                        <td><a href='<?php echo getPengaturan("url_web")->value_pengaturan."/member/".$content->content_url;?>' target="_blank">LIHAT</a></td>
                                        <td><?php echo $content->content_type;?></td>
                                        <td class="td-actions text-right">
                                            <a href="?p=<?php echo $schedule_url."&medsos=".$_GET['medsos']."&delete=".$get->schedule_id;?>" rel="tooltip" title="Remove from this phase" class="btn btn-danger btn-simple btn-xs">
                                                <i class="material-icons">delete</i>
                                            </a><br>
                                        </td>
                                    </tr>
                                <?php
                                    }
                                ?>
                                </tbody>
                            </table>
                        
						</div>
						<div class="tab-pane" style="max-height:600px;overflow-y:auto" id="log">
                            
                            <div class="alert alert-info" role="alert">
                                Only 50 latest post log show here.
                            </div>
                            Note : <i class="text-success">Green means success</i> and <i class="text-danger">Red means fail</i>
                            <table class="table table-hover">
                                <thead>
                                    <th>Content Title</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                    <th>Time Posted</th>
                                </thead>
                                <tbody>
                                <?php
                                    while($get = $schedule_log->fetch_object()){
                                        $content = getDataByCondition("getrich_contents","content_id = ".$get->post_content,"created DESC")->fetch_object();
                                        if($get->post_status == "success"){
                                ?>
                                    <tr class="text-success">
                                        <td><?php echo $content->content_title;?></td>
                                        <td><?php echo $get->note;?></td>
                                        <td><?php echo $get->post_status;?></td>
                                        <td><?php echo $get->created;?></td>
                                    </tr>
                                <?php
                                        }else{
                                ?>
                                    <tr class="text-danger">
                                    <td><?php echo $content->content_title;?></td>
                                        <td><?php echo $get->note;?></td>
                                        <td><?php echo $get->post_status;?></td>
                                        <td><?php echo $get->created;?></td>
                                    </tr>
                                <?php
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>
						</div>
					</div>
				</div>
			</div>
        </div>
        <div class="col-md-4 col-xs-12">
            <?php
                if(isset($_POST['add'])){
                    $stmt = $mysqli->query("insert into ".$schedule_medsos."(schedule_user,schedule_phase,schedule_content)
                    VALUES('".$_SESSION['user_data']->user_id."','".$_POST['phase']."','".$_POST['content']."')");
                    if($stmt){
                        echo '<div class="alert alert-success" role="alert">
                                    Success to add this content.
                            </div>
                            <meta http-equiv="refresh" content="1; url=?p='.$schedule_url.'&medsos='.$_GET['medsos'].'" />                                
                        ';
                    }else{
                        echo '<div class="alert alert-danger" role="alert">
                                    Failed to add this content to this phase, try again later.
                            </div>
                        ';
                    }
                }
            
            ?>
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <h4 class="title">Add content to phase 1-4 schedule </h4>                
                </div>
                <div class="card-content">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Choose Content</label>
                                    <select name="content" class="form-control">
                                        <?php
                                            $contents_admin = getDataByCondition("getrich_contents","content_user = ".$_SESSION['user_data']->user_id." and content_medsos='".$_GET['medsos']."'","created DESC");
                                            while($get = $contents_admin->fetch_object()){
                                                echo'<option value="'.$get->content_id.'">'.$get->content_title.'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Type schedule</label>
                                    <select name="phase" class="form-control">
                                        <option value="1">Add to Phase 1</option>
                                        <option value="2">Add to Phase 2</option>
                                        <option value="3">Add to Phase 3</option>
                                        <option value="4">Add to Phase 4</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <button type="submit" name="add" class="btn btn-info pull-right">Add this content</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>