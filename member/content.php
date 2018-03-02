<div class="container-fluid">
	<div class="row">
        <?php
            if(isset($_GET['test'])){
                $getContent = explode("-",$_GET['test']);
                $content = getDataByCondition("getrich_contents","content_id = ".$getContent[0]." and content_user=".$_SESSION['user_data']->user_id,"created DESC")->fetch_object();
                if($getContent[1] == "facebook"){
                    $sql = "select * from getrich_users_facebook where facebook_token != '' AND facebook_user = '".$_SESSION['user_data']->user_id."' order by facebook_type ASC";
                    $fb_acc = $mysqli->query($sql);
                    while($fb = $fb_acc->fetch_object()){
                        if($content->content_type == "text"){
                            $post = fbPostText(getUserFB($_SESSION['user_data']->user_id)->facebook_token,$_SESSION['user_data']->user_id,$content->content_desc);
                        }else if($content->content_type == "photo"){
                            $post = fbPostPhoto(getUserFB($_SESSION['user_data']->user_id)->facebook_token,$_SESSION['user_data']->user_id,$content->content_desc,$content->content_url);
                        }else if($content->content_type == "video"){
                            $post = fbPostVideo(getUserFB($_SESSION['user_data']->user_id)->facebook_token,$_SESSION['user_data']->user_id,$content->content_title,$content->content_desc,$content->content_url);
                        }else{
                            $post = "Content cannot be posted";
                        }
                        echo '<div class="alert alert-default" role="alert">
                                    '.$post.'
                            </div>
                        ';
                    }
                }else if($getContent[1] == "twitter"){
                    $sql = "select * from getrich_users_twitter where twitter_token != '' AND twitter_user = '".$_SESSION['user_data']->user_id."' order by twitter_type ASC";
                    $tw_acc = $mysqli->query($sql);
                    while($tw = $tw_acc->fetch_object()){
                        $userTW = getUserTW($_SESSION['user_data']->user_id);
                        if($content->content_type == "text"){
                            $post = twPostText($userTW->twitter_token,$userTW->twitter_secret,$_SESSION['user_data']->user_id,$content->content_desc);
                        }else if($content->content_type == "photo"){
                            $post = twPostPhoto($userTW->twitter_token,$userTW->twitter_secret,$_SESSION['user_data']->user_id,$content->content_desc,$content->content_url);
                        }else if($content->content_type == "video"){
                            $post = twPostVideo($userTW->twitter_token,$userTW->twitter_secret,$_SESSION['user_data']->user_id,$content->content_desc,$content->content_url);
                        }else{
                            $post = "Content cannot be posted";
                        }
                        echo '<div class="alert alert-default" role="alert">
                                    '.$post.'
                            </div>
                        ';
                    }
                }
                echo '
                    <meta http-equiv="refresh" content="5; url=?p=content" />  
                ';
            }
            if(isset($_GET['add']) || isset($_GET['edit'])){
        ?>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <h4 class="title">Create / Edit Content</h4>                
                </div>
                <div class="card-content">
                    <?php
                        $title = "";
                        $desc = "";
                        $type = "";
                        $medsos = "";
                        $url = "";
                        if(isset($_GET['edit'])){
                            $content = getDataByCollumn("getrich_contents","content_id",$_GET['edit']);
                            if($content->num_rows != 0){
                                $get = $content->fetch_object();
                                $title = $get->content_title;
                                $desc = $get->content_desc;
                                $medsos = $get->content_medsos;
                                $type = $get->content_type;
                                $url = $get->content_url;
                            }
                        }
                        if(isset($_POST['create'])){
                            if($_POST['type'] == ""){
                                $type = "text";
                            }else{
                                $type = $_POST['type'];
                            }
                            $stmt = $mysqli->query("insert into getrich_contents(content_user,content_title,content_desc,content_url,content_type,content_medsos)
                            VALUES('".$_SESSION['user_data']->user_id."','".$_POST['title']."','".$_POST['desc']."','".$_POST['url']."','".$type."','".$_POST['medsos']."')");
                            if($stmt){
                                echo '<div class="alert alert-success" role="alert">
                                        Success create new acount with title <b>'.$_POST['title'].'</b>.
                                    </div>
                                    <meta http-equiv="refresh" content="1; url=?p=content" />                                
                                ';
                            }else{
                                echo '<div class="alert alert-danger" role="alert">
                                            Failed to create new content.
                                    </div>
                                ';
                            }
                        }
                        if(isset($_POST['edit'])){
                            $sql = "update getrich_contents set content_title='".$_POST['title']."',content_desc='".$_POST['desc']."',content_url='".$_POST['url']."',content_type='".$_POST['type']."',content_medsos='".$_POST['medsos']."' where content_id=".$_GET['edit'];
                            $stmt = $mysqli->query($sql);
                            if($stmt){
                                echo '<div class="alert alert-success" role="alert">
                                            Success change content data.
                                    </div>
                                    <meta http-equiv="refresh" content="1; url=?p=content" />                                
                                    ';
                            }else{
                                echo '<div class="alert alert-danger" role="alert">
                                            Failed to change content data.
                                    </div>
                                ';
                            }
                        }
                    ?>
                    <form action="" method="post">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Content Title</label>
                                    <input type="text" class="form-control" name="title" value="<?php echo $title;?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Media Sosial :</label>
                                    <select name="medsos" class="form-control">
                                        <?php
                                            if(isset($_GET['edit'])){
                                        ?>
                                            <option value="<?php echo $medsos;?>"><?php echo $medsos;?></option>
                                        <?php
                                            }
                                        ?>
                                        <option value="facebook">Facebook</option>
                                        <option value="twitter">Twitter</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Type Content :</label>
                                    <select name="type" class="form-control">
                                        <?php
                                            if(isset($_GET['edit'])){
                                        ?>
                                        <option value="<?php echo $type;?>"><?php echo $type;?></option>
                                        <?php
                                            }
                                        ?>
                                        <option value="text">Text Only</option>
                                        <option value="photo">Text and Photo</option>
                                        <option value="video">Text and Video</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group label-floating">
                                    <label class="control-label">Url Photo/Video (from gallery)</label>
                                    <input type="text" class="form-control" name="url" value="<?php echo $url;?>">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                <label class="control-label">Content Description</label>
                                    <textarea class="form-control" name="desc" required rows="13"><?php echo $desc;?></textarea>
                                    <p class="text-warning" >*MAX CHARACTER FOR TWITTER CONTENT IS 225 CHARACTER</p>
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
                                    <button type="submit" name="create" class="btn btn-info pull-right">Create Content</button>
                                ';                                
                            }
                        ?>
                        <a href="?p=content" class="btn btn-warning pull-right">Cancel</a>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
        <div class="alert alert-info col-md-6">
    		<div class="col-md-6">
                <ul style="margin-bottom:0px;">
                    <li>Use [first_name] = user first name</li>
                    <li>Use [last_name] = user last name</li>
                    <li>Use [phone] = user phone number</li>
                    <li>Use [address] = user address</li>
                </ul>
            </div>
    		<div class="col-md-6">
                <ul style="margin-bottom:0px;">
                    <li>Use [email] = user email</li>
                    <li>Use [username] = user username</li>
                    <li>Use  .(dot)\n if you want newline more then 1 line</li>
                </ul>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <h4 class="title">You can use this template from admin</h4>                
                </div>
                <div class="card-content">
                    <script>
                        function getContentTemplate(value){
                            var dataString = "con_temp="+value;
                            $.ajax({
                                type: "POST",
                                url: "ajax.php",
                                data: dataString,
                                cache: false,
                                success: function(result) {
                                    $("#admin_desc").val(result);
                                }
                            });	
                        }
                    </script>
                    <form>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Choose Content</label>
                                    <select name="admin_content" class="form-control" onchange="getContentTemplate(this.value)">
                                        <option value="0">Choose content</option>
                                        <?php
                                            $contents_admin = getDataByCondition("getrich_contents","content_user = 1 and content_id != 0 ","created DESC");
                                            while($get = $contents_admin->fetch_object()){
                                                echo'<option value="'.$get->content_id.'">'.$get->content_title.' ('.$get->content_medsos.')</option>';
                                            }
                                        ?>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                <label class="control-label">Content Description</label>
                                    <textarea class="form-control" id="admin_desc" required rows="13">copy this desc</textarea>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <?php
            }else{
        ?>
		<div class="col-12">
            <?php
                $contents_all = getDataByCondition("getrich_contents","content_type != 'admin' and content_user=".$_SESSION['user_data']->user_id,"created DESC");
                $contents_text = getDataByCondition("getrich_contents","content_type = 'text' and content_user=".$_SESSION['user_data']->user_id,"created DESC");
                $contents_photo = getDataByCondition("getrich_contents","content_type = 'photo' and content_user=".$_SESSION['user_data']->user_id,"created DESC");
                $contents_video = getDataByCondition("getrich_contents","content_type = 'video' and content_user=".$_SESSION['user_data']->user_id,"created DESC");
                if(isset($_GET['delete'])){
                    $sql = "delete from getrich_contents where content_id=".$_GET['delete'];
                    $stmt = $mysqli->query($sql);
                    if($stmt){
                        $mysqli->query("delete from getrich_schedule_fb where schedule_content=".$_GET['delete']);
                        $mysqli->query("delete from getrich_schedule_tw where schedule_content=".$_GET['delete']);
                        $mysqli->query("update getrich_contents_post set post_content=0 where post_content=".$_GET['delete']);
                        echo '<div class="alert alert-success" role="alert">
                                Success delete content.
                        </div>
                        <meta http-equiv="refresh" content="1; url=?p=content" />                                
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
							<span class="nav-tabs-title">Category content : </span>
							<ul class="nav nav-tabs" data-tabs="tabs">
								<li class="active">
									<a href="#all" data-toggle="tab">
									<i class="material-icons">content_paste</i> All( <?php echo $contents_all->num_rows; ?> )
									<div class="ripple-container"></div>
									</a>
								</li>
								<li class="">
									<a href="#text" data-toggle="tab">
									<i class="material-icons">title</i> Text Only( <?php echo $contents_text->num_rows; ?> )
									<div class="ripple-container"></div>
									</a>
								</li>
								<li class="">
									<a href="#photo" data-toggle="tab">
									<i class="material-icons">perm_media</i> Text with Photo( <?php echo $contents_photo->num_rows; ?> )
									<div class="ripple-container"></div>
									</a>
								</li>
								<li class="">
									<a href="#video" data-toggle="tab">
									<i class="material-icons">video_library</i> Text with Video( <?php echo $contents_video->num_rows; ?> )
									<div class="ripple-container"></div>
									</a>
								</li>
								<li class="pull-right">
									<a href="?p=content&add=1">
	    								<i class="material-icons">note_add</i> ADD NEW CONTENT
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
                                    <th width="20%">Content Title</th>
                                    <th>Content Description</th>
                                    <th>URL Photo/Video</th>
                                    <th>Type Post</th>
                                    <th>Media Sosial</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                <?php
                                    $num = 1;
                                    while($get = $contents_all->fetch_object()){
                                ?>
                                    <tr>
                                        <td><?php echo $num;?></td>
                                        <td><?php echo $get->content_title;?><br>
                                            <a href="?p=content&test=<?php echo $get->content_id."-".$get->content_medsos;?>" title="Test Post Content" class="btn btn-primary btn-xs">
                                            <?php
                                                echo "TEST POST TO ".strtoupper($get->content_medsos);
                                            ?>
                                            </a>
                                        </td>
                                        <td><?php echo substr($get->content_desc,0,375);?> ... ....</td>
                                        <td><?php echo $get->content_url;?></td>
                                        <td><?php echo $get->content_type;?></td>
                                        <td><?php echo $get->content_medsos;?></td>
                                        <td class="td-actions text-right">
                                            <a href="?p=content&edit=<?php echo $get->content_id;?>" rel="tooltip" title="Edit Content" class="btn btn-info btn-simple btn-xs">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="?p=content&delete=<?php echo $get->content_id;?>" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
                                                <i class="material-icons">delete</i>
                                            </a><br>
                                        </td>
                                    </tr>
                                <?php
                                    $num++;
                                    }
                                ?>
                                </tbody>
                            </table>
						</div>
						<div class="tab-pane" style="max-height:500px;overflow-y:auto" id="text">
							<table class="table table-hover">
                                <thead class="text-warning">
                                    <th>NO</th>
                                    <th width="20%">Content Title</th>
                                    <th>Content Description</th>
                                    <th>URL Photo/Video</th>
                                    <th>Type Post</th>
                                    <th>Media Sosial</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                <?php
                                    $num = 1;
                                    while($get = $contents_text->fetch_object()){
                                ?>
                                    <tr>
                                        <td><?php echo $num;?></td>
                                        <td><?php echo $get->content_title;?><br>
                                            <a href="?p=content&test=<?php echo $get->content_id."-".$get->content_medsos;?>" title="Test Post Content" class="btn btn-primary btn-xs">
                                            <?php
                                                echo "TEST POST TO ".strtoupper($get->content_medsos);
                                            ?>
                                            </a>
                                        </td>
                                        <td><?php echo substr($get->content_desc,0,375);?> ... ....</td>
                                        <td><?php echo $get->content_url;?></td>
                                        <td><?php echo $get->content_type;?></td>
                                        <td><?php echo $get->content_medsos;?></td>
                                        <td class="td-actions text-right">
                                            <a href="?p=content&edit=<?php echo $get->content_id;?>" rel="tooltip" title="Edit Content" class="btn btn-info btn-simple btn-xs">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="?p=content&delete=<?php echo $get->content_id;?>" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
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
						<div class="tab-pane" style="max-height:500px;overflow-y:auto" id="photo">
							<table class="table table-hover">
                                <thead class="text-warning">
                                    <th>NO</th>
                                    <th width="20%">Content Title</th>
                                    <th>Content Description</th>
                                    <th>URL Photo/Video</th>
                                    <th>Type Post</th>
                                    <th>Media Sosial</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                <?php
                                    $num = 1;
                                    while($get = $contents_photo->fetch_object()){
                                ?>
                                    <tr>
                                        <td><?php echo $num;?></td>
                                        <td><?php echo $get->content_title;?><br>
                                            <a href="?p=content&test=<?php echo $get->content_id."-".$get->content_medsos;?>" title="Test Post Content" class="btn btn-primary btn-xs">
                                            <?php
                                                echo "TEST POST TO ".strtoupper($get->content_medsos);
                                            ?>
                                            </a>
                                        </td>
                                        <td><?php echo substr($get->content_desc,0,375);?> ... ....</td>
                                        <td><?php echo $get->content_url;?></td>
                                        <td><?php echo $get->content_type;?></td>
                                        <td><?php echo $get->content_medsos;?></td>
                                        <td class="td-actions text-right">
                                            <a href="?p=content&edit=<?php echo $get->content_id;?>" rel="tooltip" title="Edit Content" class="btn btn-info btn-simple btn-xs">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="?p=content&delete=<?php echo $get->content_id;?>" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
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
						<div class="tab-pane" style="max-height:500px;overflow-y:auto" id="video">
							<table class="table table-hover">
                                <thead class="text-warning">
                                    <th>NO</th>
                                    <th width="20%">Content Title</th>
                                    <th>Content Description</th>
                                    <th>URL Photo/Video</th>
                                    <th>Type Post</th>
                                    <th>Media Sosial</th>
                                    <th>Action</th>
                                </thead>
                                <tbody>
                                <?php
                                    $num = 1;
                                    while($get = $contents_video->fetch_object()){
                                ?>
                                    <tr>
                                        <td><?php echo $num;?></td>
                                        <td><?php echo $get->content_title;?></td><br>
                                            <a href="?p=content&test=<?php echo $get->content_id."-".$get->content_medsos;?>" title="Test Post Content" class="btn btn-primary btn-xs">
                                            <?php
                                                echo "TEST POST TO ".strtoupper($get->content_medsos);
                                            ?>
                                            </a>
                                        <td><?php echo substr($get->content_desc,0,375);?> ... ....</td>
                                        <td><?php echo $get->content_url;?></td>
                                        <td><?php echo $get->content_type;?></td>
                                        <td><?php echo $get->content_medsos;?></td>
                                        <td class="td-actions text-right">
                                            <a href="?p=content&edit=<?php echo $get->content_id;?>" rel="tooltip" title="Edit Content" class="btn btn-info btn-simple btn-xs">
                                                <i class="material-icons">edit</i>
                                            </a>
                                            <a href="?p=content&delete=<?php echo $get->content_id;?>" rel="tooltip" title="Remove" class="btn btn-danger btn-simple btn-xs">
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
        <?php
            }
        ?>
    </div>
</div>