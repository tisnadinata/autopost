<div class="container-fluid">
	<div class="row"> 
		<div class="col-md-8">
				<?php
				if(isset($_POST['simpan_data'])){
					$nama_pengaturan = $_POST['nama_pengaturan'];
					$value_pengaturan = $_POST['value_pengaturan'];
					$sql = "UPDATE getrich_settings set nama_pengaturan='$nama_pengaturan',value_pengaturan='$value_pengaturan' where nama_pengaturan='".$nama_pengaturan."' ";
					$stmt = $mysqli->query($sql);
					if($stmt){
						echo'
							<div class="alert alert-success alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data berhasil disimpan!</strong> .
							</div>
						';						
					}else{
						echo'
							<div class="alert alert-danger alert-dismissible fade in" role="alert">
								<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
								</button>
								<strong>Data gagal disimpan!</strong> .
							</div>
						';
					}
				}				
			  ?>
				<div class="card">
        	<div class="card-header" data-background-color="blue">
            <h4 class="title">Website settings</h4>                
          </div>
          <div class="card-content">
					<table class="table table-hover">
							<thead class="text-warning">
									<th>NO</th>
									<th>SETTING NAME</th>
									<th>CURRENT VALUE</th>
							</thead>
							<tbody>
							<?php
							$stmt=getDataTable("getrich_settings","id_pengaturan ASC");
							if($stmt->num_rows>0){
								$i=1;
								while($data_pengaturan = $stmt->fetch_object()){
									echo'
										<tr>
										  <td>'.$i.'</td>
										  <td>'.$data_pengaturan->nama_pengaturan.'</td>
										  <td>'.$data_pengaturan->value_pengaturan.'</td>
										</tr>								
									';
									$i++;
								}
							}else{
								echo"<tr><td colspan='4'>Belum ada data yang tersedia</td></tr>";
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
            <h4 class="title">Website settings</h4>                
          </div>
          <div class="card-content">
					<form action="" method="post">
						<div class="row">
								<div class="col-md-12">
										<div class="form-group label-floating">
												<label class="control-label">Send this notification to :</label>
												<select name="nama_pengaturan" class="form-control">
												<?php
													$stmt = getDataTable("getrich_settings","id_pengaturan ASC");
													if($stmt->num_rows>0){
														while($data_pengaturan = $stmt->fetch_object()){
															echo"<option value='".$data_pengaturan->nama_pengaturan."'>".$data_pengaturan->nama_pengaturan."</option>";
														}
													}else{
														echo"<option>Belum ada data tersedia</option>";
													}
												?>
											</select>
										</div>
								</div>
						</div>
						<div class="row">
								<div class="col-md-12">
										<div class="form-group label-floating">
												<textarea class="form-control" name="value_pengaturan" required placeholder="New value" rows="3"></textarea>
										</div>
								</div>
						</div>
						<button type="submit" name="simpan_data" class="btn btn-info pull-right">Save New Data</button>
						<div class="clearfix"></div>
          </div>
				</div>
		</div>
	</div>
</div>
