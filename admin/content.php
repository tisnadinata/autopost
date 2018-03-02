<div class="container-fluid">
	<div class="row">        
        <?php
            if(isset($_GET['add']) || isset($_GET['edit'])){
        ?>
        <div class="col-12">
            <div class="card">
                <div class="card-header" data-background-color="blue">
                    <h4 class="title">Create / Edit Content</h4>                
                </div>
                <div class="card-content">
                    <?php
                        $title = "";
                        $desc = "";
                        $medsos = "";
                        if(isset($_GET['edit'])){
                            $content = getDataByCollumn("getrich_contents","content_id",$_GET['edit']);
                            if($content->num_rows != 0){
                                $get = $content->fetch_object();
                                $title = $get->content_title;
                                $desc = $get->content_desc;
                                $medsos = $get->content_medsos;
                            }
                        }
                        if(isset($_POST['create'])){
                            $sql = "insert into getrich_contents(content_user,content_title,content_desc,content_desc,content_medsos)
                            VALUES('".$_SESSION['user_data']->user_id."','".$_POST['title']."','".$_POST['desc']."','text','".$_POST['medsos']."')";
                            $stmt = $mysqli->query($sql);
                            if($stmt){
                                echo '<div class="alert alert-success" role="alert">
                                        Success create new acount with title <b>'.$_POST['title'].'</b>.
                                    </div>
                                    <meta http-equiv="refresh" content="1; url=?p=content" />                                
                                ';
                            }else{
                                echo $sql;
                                echo '<div class="alert alert-danger" role="alert">
                                            Failed to create new content.
                                    </div>
                                ';
                            }
                        }
                        if(isset($_POST['edit'])){
                            $sql = "update getrich_contents set content_title='".$_POST['title']."',content_desc='".$_POST['desc']."',content_medsos='".$_POST['medsos']."' where content_id=".$_GET['edit'];
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
                            <div class="col-md-5">
                                <div class="form-group label-floating">
                                    <label class="control-label">Content Title</label>
                                    <input type="text" class="form-control" name="title" value="<?php echo $title;?>">
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group label-floating">
                                    <label class="control-label">Media Sosial :</label>
                                    <select name="medsos" class="form-control">
                                        <option value="<?php echo $medsos;?>"><?php echo $medsos;?></option>
                                        <option value="facebook">Facebook</option>
                                        <option value="twitter">Twitter</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-8">
                                <div class="form-group label-floating">
                                <label class="control-label">Content Description</label>
                                    <textarea class="form-control" name="desc" required rows="15"><?php echo $desc;?></textarea>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label class="control-label">Content Guide :</label>
                                <ul>
                                    <li>Write [first_name] to show user first name</li>
                                    <li>Write [last_name] to show user last name</li>
                                    <li>Write [phone] to show user phone number</li>
                                    <li>Write [address] to show user address</li>
                                    <li>Write [email] to show user email</li>
                                    <li>Write [username] to show user username</li>
                                    <li>Use  .(dot)\n if you want breakspace/newline more then 1 line</li>
                                </ul>
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
        <?php
            }else{
        ?>
		<div class="col-12">
            <?php
                $contents_all = getDataByCondition("getrich_contents","content_type != 'admin' and content_id != '0' and content_user=".$_SESSION['user_data']->user_id,"created DESC");
                if(isset($_GET['delete'])){
                    $sql = "delete from getrich_contents where content_id=".$_GET['delete'];
                    $stmt = $mysqli->query($sql);
                    if($stmt){
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
                                    <th width="25%">Content Title</th>
                                    <th>Content Description</th>
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
                                        <td><?php echo $get->content_title;?> </td>
                                        <td><?php echo substr($get->content_desc,0,375);?> ... ....</td>
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
					</div>
				</div>
			</div>
        </div>
        <?php
            }
        ?>
    </div>
</div>