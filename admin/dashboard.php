<div class="container-fluid">
	<div class="row">		
		<div class="col-md-4 col-sm-6">
			<div class="card card-stats">
				<div class="card-header" data-background-color="blue">
				<i class="material-icons">assignment_ind</i>
				</div>
				<div class="card-content">
					<p class="category">Member regsitered</p>
					<h3 class="title text-danger">
					<?php
						$users_all = getDataByCondition("getrich_users","user_status != 'admin'","user_fname ASC");
						echo $users_all->num_rows;
					?>
					</h3>
				</div>
				<div class="card-footer">
					<div class="stats">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6">
			<div class="card card-stats">
				<div class="card-header" data-background-color="orange">
					<i class="material-icons">star_border</i>
				</div>
				<div class="card-content">
					<p class="category">Trial Member</p>
					<h3 class="title">
					<?php
						$users_all = getDataByCondition("getrich_users","user_status = 'trial'","user_fname ASC");
						echo $users_all->num_rows;
					?>
					</h3>
				</div>
				<div class="card-footer">
					<div class="stats">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-4 col-sm-6">
			<div class="card card-stats">
				<div class="card-header" data-background-color="green">
					<i class="material-icons">star</i>
				</div>
				<div class="card-content">
					<p class="category">Premium Member</p>
					<h3 class="title">
					<?php
						$users_all = getDataByCondition("getrich_users","user_status = 'premium'","user_fname ASC");
						echo $users_all->num_rows;
					?>
					</h3>
				</div>
				<div class="card-footer">
					<div class="stats">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-6">
			<div class="card card-stats">
				<div class="card-header" data-background-color="red">
					<i class="material-icons">content_copy</i>
				</div>
				<div class="card-content">
					<p class="category">All Content Created</p>
					<h3 class="title">
					<?php
						$contents_all = getDataByCondition("getrich_contents","content_id != '0'","created ASC");
						echo $contents_all->num_rows;
					?>
					</h3>
				</div>
				<div class="card-footer">
					<div class="stats">
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-6 col-sm-6">
			<div class="card card-stats">
				<div class="card-header" data-background-color="red">
					<i class="material-icons">content_copy</i>
				</div>
				<div class="card-content">
					<p class="category">Your Content Created</p>
					<h3 class="title">
					<?php
						$contents_all = getDataByCondition("getrich_contents","content_id != '0' and content_user = ".$_SESSION['user_data']->user_id,"created ASC");
						echo $contents_all->num_rows;
					?>
					</h3>
				</div>
				<div class="card-footer">
					<div class="stats">
					</div>
				</div>
			</div>
		</div>
	</div>
</div>