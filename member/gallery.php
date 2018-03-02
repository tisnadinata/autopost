<div class="container-fluid">
	<div class="row">
    <div class="col-md-8 col-xs-12">
            <?php
                $files_photo = getDataByCondition("getrich_files","file_type = 'photo' and file_user=".$_SESSION['user_data']->user_id,"created DESC");
                $files_video = getDataByCondition("getrich_files","file_type = 'video' and file_user=".$_SESSION['user_data']->user_id,"created DESC");
                if(isset($_GET['delete'])){
                    $files_delete = getDataByCondition("getrich_files","file_id = ".$_GET['delete']." and file_user=".$_SESSION['user_data']->user_id,"created DESC")->fetch_object();
                    $sql = "delete from getrich_files where file_id=".$_GET['delete']." and file_user=".$_SESSION['user_data']->user_id;
                    $stmt = $mysqli->query($sql);
                    if($stmt){
                        unlink($files_delete->file_url);
                        echo '<div class="alert alert-success" role="alert">
                                    Success delete content.
                            </div>
                            <meta http-equiv="refresh" content="1; url=?p=gallery" />                                
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
							<span class="nav-tabs-title">Show Files : </span>
							<ul class="nav nav-tabs" data-tabs="tabs">
								<li class="active">
									<a href="#photo" data-toggle="tab">
									<i class="material-icons">perm_media</i> Only Photo( <?php echo $files_photo->num_rows; ?> )
									<div class="ripple-container"></div>
									</a>
								</li>
								<li class="">
									<a href="#video" data-toggle="tab">
									<i class="material-icons">video_library</i> Only Video( <?php echo $files_video->num_rows; ?> )
									<div class="ripple-container"></div>
									</a>
								</li>
							</ul>
						</div>
					</div>
				</div>
				<div class="card-content">
					<div class="tab-content">
						<div class="tab-pane active" style="max-height:500px;overflow-y:auto" id="photo">
                            <?php
                                while($get =  $files_photo->fetch_object()){
                            ?>
                            <div class="col-md-4">
                                <div class="card">
                                    <div class="card-footer">
                                        <img class="img img-raised" src="<?php echo $get->file_url;?>" />
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats col-md-12" style="overflow-x:auto;">
                                            <?php 
                                                echo $get->file_url;
                                            ?>
                                        </div>
                                        <?php 
                                            echo "<a href='?p=gallery&delete=".$get->file_id."' class='btn btn-danger btn-xs col-md-12'>DELETE THIS PHOTO/VIDEO</a>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
						</div>
						<div class="tab-pane" style="max-height:500px;overflow-y:auto" id="video">
                            <?php
                                while($get =  $files_video->fetch_object()){
                            ?>
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-footer">
                                    <video width="100%" height="100%" controls autoplay>
                                        <source src="<?php echo $get->file_url;?>" type="video/mp4">
                                        Sorry, your browser doesn't support the video element.
                                    </video>
                                    </div>
                                    <div class="card-footer">
                                        <div class="stats col-md-12" style="overflow-x:auto;">
                                            <?php 
                                                echo $get->file_url;
                                            ?>
                                        </div>
                                        <?php 
                                            echo "<a href='?p=gallery&delete=".$get->file_id."' class='btn btn-danger btn-xs col-md-12'>DELETE THIS PHOTO/VIDEO</a>";
                                        ?>
                                    </div>
                                </div>
                            </div>
                            <?php
                                }
                            ?>
						</div>
					</div>
				</div>
			</div>
        </div>
        <div class="col-md-4 col-xs-12">
            <?php
                if(isset($_POST['upload'])){
                    if($_POST['type'] == "photo"){
                        $destination = "gallery/photo/";
                    }else{
                        $destination = "gallery/video/";
                    }
                    $count =  getDataCount("getrich_files","file_user",$_SESSION['user_data']->user_id);
					$nama_unik = "_".$_SESSION['user_data']->user_id."_".$count;
                    $upload_foto = upload_foto($destination,$_FILES['file'],$_POST['name'],$nama_unik);
                    $upload_status = explode("-",$upload_foto);
                    if($upload_status[0] == "true"){
                        $stmt = $mysqli->query("insert into getrich_files(file_user,file_name,file_type,file_url)
                        VALUES('".$_SESSION['user_data']->user_id."','".$_POST['name']."','".$_POST['type']."','".$upload_status[1]."')");
                        if($stmt){
                            echo '<div class="alert alert-success" role="alert">
                                        Success upload photo/video.
                                </div>
                                <meta http-equiv="refresh" content="1; url=?p=gallery" />                                
                            ';
                        }else{
                            echo '<div class="alert alert-danger" role="alert">
                                        Failed to upload file.
                                </div>
                            ';
                        }
                    }else{
                        echo '<div class="alert alert-danger" role="alert">
                                    '.$upload_status[1].'
                            </div>
                        ';
                    }
                }
            
            ?>
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <h4 class="title">Upload New Photo or Video</h4>                
                </div>
                <div class="card-content">
                    <form action="" method="post" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Photo/Video Title</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group label-floating">
                                    <label class="control-label">Type File</label>
                                    <select name="type" class="form-control">
                                        <option value="photo">Photo</option>
                                        <option value="video">Video</option>
                                    </select>
                                </div>
                                <div class="col-md-12">
                                    <input type="file" name="file" multiple=""> 
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <ul>
                                <li>Maximum size is 4MB (1MB for PNG)</li>
                                <li>Photo supported format (JPEG,BMP,PNG,GIF,TIFF)
                                <li>Video supported format (mp4)
                            </ul>
                        </div>
                        <button type="submit" name="upload" class="btn btn-info pull-right">Upload File</button>
                        <div class="clearfix"></div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>