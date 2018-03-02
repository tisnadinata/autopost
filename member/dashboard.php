<div class="container-fluid">
	<div class="row">
		<?php
			if($_SESSION['user_data']->user_status == "trial" && !userTrialActive($_SESSION['user_data']->created)){
				echo '<div class="alert alert-danger" role="alert">
						<b>YOUR ACCOUNT IS EXPIRED. PLEASE CONTACT OUR SUPPORT TO BUY PREMIUM ACCOUNT. YOU CANNOT ACCESS ALL MENU IN MEMBER AREA</b>
					</div>
				';
			}
		?>
		<div class="col-md-4 col-xs-12">
			<div class="card card-stats">
				<div class="card-header" data-background-color="blue">
				<i class="material-icons">assignment_ind</i>
				</div>
				<div class="card-content">
					<p class="category">Your Account Type</p>
					<h3 class="title text-danger">						
					<?php
						echo strtoupper($_SESSION['user_data']->user_status);
					?>
					</h3>
				</div>
				<div class="card-footer">
					<div class="stats">
					<?php
						if($_SESSION['user_data']->user_status == "trial"){
							echo '<i class="material-icons">local_offer</i> Active until '.$_SESSION['user_data']->created;
						}
					?>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-12">
			<div class="card card-stats">
				<div class="card-header" data-background-color="orange">
					<i class="material-icons">content_copy</i>
				</div>
				<div class="card-content">
					<p class="category">My Content Listed</p>
					<h3 class="title">
					<?php
						$contents_all = getDataByCondition("getrich_contents","content_user = ".$_SESSION['user_data']->user_id,"created ASC");
						echo $contents_all->num_rows;
					?>
					</h3>
				</div>
				<div class="card-footer">
					<div class="stats">
						<i class="material-icons">local_offer</i> All posting content you have
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-xs-12">
			<div class="card card-stats">
				<div class="card-header" data-background-color="green">
					<i class="material-icons">done</i>
				</div>
				<div class="card-content">
					<p class="category">Success Posting</p>
					<h3 class="title">
					<?php
						$contents_all = getDataByCondition("getrich_contents_post","post_user = ".$_SESSION['user_data']->user_id." AND post_status = 'success'","created ASC");
						echo $contents_all->num_rows;
					?>
					</h3>
				</div>
				<div class="card-footer">
					<div class="stats">
						<i class="material-icons">local_offer</i> Content successed to posting 
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-xs-12">	
			<!-- BANNER 1 -->
			<img src="../images/banner1.png" style="width:100%;height:auto;">
		</div>
		<div class="col-md-6 col-xs-12">
			<div class="card">
				<div class="card-header" data-background-color="blue">
					<h4 class="title">Last Content Posted</h4>
					<p class="category">This is 5 last content we post for you </p>
				</div>
				<div class="card-content table-responsive">
				<table class="table table-hover">
						<thead>
							<th width="65%">Content We Post</th>
							<th>Time We Post</th>
						</thead>
						<tbody>
				<?php
					$schedule_log = getDataByCondition("getrich_contents_post","post_user=".$_SESSION['user_data']->user_id." and (post_status='success' or post_status='fail')","created DESC LIMIT 0,5");
					while($get = $schedule_log->fetch_object()){
						$content = getDataByCondition("getrich_contents","content_id = ".$get->post_content,"created DESC")->fetch_object();
						if($get->post_status == "success"){
						?>
							<tr class="text-success">
								<td><?php echo $content->content_title;?></td>
								<td><?php echo $get->created;?></td>
							</tr>
						<?php
						}else{
						?>
							<tr class="text-danger">
								<td><?php echo $content->content_title;?></td>
								<td><?php echo $get->created;?></td>
							</tr>
						<?php
						}
					}
				?>
						</tbody>
					</table>
					Note : <i class="text-success">Green means success</i> and <i class="text-danger">Red means fail</i>
				</div>
			</div>
		</div>
		<div class="col-md-3 col-xs-12">
			<!-- BANNER 2 -->
			<img src="../images/banner2.png" style="width:100%;height:auto;">
		</div>
	</div>
</div>