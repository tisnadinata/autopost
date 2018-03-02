<?php
	require 'config_db.php';
	require "../library/twitter_sdk/autoload.php";
	use Abraham\TwitterOAuth\TwitterOAuth;
	define('FACEBOOK_SDK_V4_SRC_DIR', '../library/facebook-sdk-v5/');

	date_default_timezone_set('Asia/Jakarta');
	function getIpCustomer(){
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'IP Tidak Dikenali';
	 
		return $ipaddress;
	}
	function userTrialActive($tanggal){
		if(userTrial($tanggal) < 2){
			return true;
		}else{
			return false;
		}
	}
	function userTrial($tanggal){
		$tanggal = new DateTime($tanggal); 
		$sekarang = new DateTime();
		$perbedaan = $tanggal->diff($sekarang);
		return $perbedaan->d;
	}

	function upload_foto($destination_foto,$file_foto,$nama_foto,$nama_unik){
		
			$ok_ext = array('jpg','png','jpeg','bmp','gif','tiff','mp4'); // allow only these types of files
			$destination = $destination_foto; // where our files will be stored
			$file = $file_foto;
			$filename = explode(".", $file["name"]); 
			$file_name = $file['name']; // file original name
			$file_name_no_ext = isset($filename[0]) ? $filename[0] : null; // File name without the extension
			$file_extension = $filename[count($filename)-1];
			$file_weight = $file['size'];
			$file_type = $file['type'];
			// If there is no error
			if( $file['error'] == 0 ){
				// check if the extension is accepted
				if( in_array(strtolower($file_extension), $ok_ext)){
					// check if the size is not beyond expected size
					// rename the file
					$nama_foto = str_replace(" ","_",strtolower($nama_foto));
					$nama_foto = str_replace("-","_",strtolower($nama_foto));
					$nama_foto = str_replace("'","_",strtolower($nama_foto));
					$fileNewName = $nama_foto.''.$nama_unik.'.'.$file_extension ;
					// and move it to the destination folder
					if( move_uploaded_file($file['tmp_name'], $destination.$fileNewName) ){
						$foto_path = $destination.$fileNewName;
						return "true-".$foto_path;
					}else{
						return "false-gagal menyimpan file yang anda upload, terjadi kesalahan saat upload";					
					}
				}else{
					return "false-eksentsi file yang anda pakai tidak didukung, silahkan upload dengan ekstensi jpg,png,jpeg";
				}
			}else{
				return "false-Batas maksimal upload 2MB";
			}

	}
	function kirimEmail($to,$subject,$message){
		smtp_mail($to, $subject, $message, '', '', 0, 0, true);
	}
	function getUserFB($user){
		global $mysqli;
		$sql = "select * from getrich_users_facebook where facebook_user = '".$user."' order by facebook_type ASC";
		$fb = $mysqli->query($sql)->fetch_object();
		return $fb;
	}
	function getUserTW($user){
		global $mysqli;
		$sql = "select * from getrich_users_twitter where twitter_user = '".$user."' order by twitter_type ASC";
		$tw = $mysqli->query($sql)->fetch_object();
		return $tw;
	}
	function ContentPostParser($user_id,$value){
		global $mysqli;
		$sql = "select * from getrich_users where user_id=".$user_id;
		$user = $mysqli->query($sql)->fetch_object();
		$result = $value;
		$result = str_replace("[first_name]",$user->user_fname,$result);
		$result = str_replace("[last_name]",$user->user_lname,$result);
		$result = str_replace("[phone]",$user->user_phone,$result);
		$result = str_replace("[address]",$user->user_address,$result);
		$result = str_replace("[email]",$user->user_email,$result);
		$result = str_replace("[username]",$user->user_username,$result);
		$result = $result.".\n.\n Tanggal : ".date("d-m-Y H:i:s");
		return $result;
	}
	function fbPostText($token,$user_id,$message){
		//$token = getUserFB($user_id)->facebook_token;
		$message = ContentPostParser($user_id,$message);
		require_once '../library/facebook-sdk-v5/autoload.php';
		$fb = new Facebook\Facebook([
		'app_id' => FACEBOOK_ID,
		'app_secret' => FACEBOOK_SECRET,
		'default_graph_version' => 'v2.11',
		]);

		$data = [
		'message' => $message,
		];
		try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->post('/me/feed', $data, $token );
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		return 'Graph returned an error: ' . $e->getMessage();
		exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		return 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
		}
		$graphNode = $response->getGraphNode();
		// echo 'Photo ID: ' . $graphNode['id'];
		return "Your post success with id [".$graphNode['id']."] (facebook)";
	}
	function fbPostPhoto($token,$user_id,$message,$path){
		//$token = getUserFB($user_id)->facebook_token;
		$message = ContentPostParser($user_id,$message);
		require_once '../library/facebook-sdk-v5/autoload.php';
		$fb = new Facebook\Facebook([
		'app_id' => FACEBOOK_ID,
		'app_secret' => FACEBOOK_SECRET,
		'default_graph_version' => 'v2.11',
		]);

		$data = [
			'message' => $message,
			'source' => $fb->fileToUpload($path),
		];
		
		try {
		// Returns a `Facebook\FacebookResponse` object
		$response = $fb->post('/me/photos', $data, $token );
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
		}
		$graphNode = $response->getGraphNode();
		// echo 'Photo ID: ' . $graphNode['id'];
		return "Your post success with id [".$graphNode['id']."] (facebook)";
	}
	function fbPostVideo($token,$user_id,$title,$message,$path){
		//$token = getUserFB($user_id)->facebook_token;
		$message = ContentPostParser($user_id,$message);
		require_once '../library/facebook-sdk-v5/autoload.php';
		$fb = new Facebook\Facebook([
		'app_id' => FACEBOOK_ID,
		'app_secret' => FACEBOOK_SECRET,
		'default_graph_version' => 'v2.11',
		]);

		$data = [
			'title' => $title,
			'description' => $message,
			'source' => $fb->videoToUpload($path),
		];
		
		try {
		$response = $fb->post('/me/videos', $data, $token);
		} catch(Facebook\Exceptions\FacebookResponseException $e) {
		// When Graph returns an error
		echo 'Graph returned an error: ' . $e->getMessage();
		exit;
		} catch(Facebook\Exceptions\FacebookSDKException $e) {
		// When validation fails or other local issues
		echo 'Facebook SDK returned an error: ' . $e->getMessage();
		exit;
		}
		  
		$graphNode = $response->getGraphNode();
		// echo 'Photo ID: ' . $graphNode['id'];
		return "Your post success with id [".$graphNode['id']."] (facebook)";
	}
	function twPostText($token,$secret,$user_id,$message){
		$message = ContentPostParser($user_id,$message);

		$connection = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET, $token, $secret);
		$connection->setTimeouts(15, 30);
		$content = $connection->get("account/verify_credentials");

		$response = $connection->post("statuses/update", ["status" => $message]);
		if ($connection->getLastHttpCode() == 200) {
			return "Your post success with id [".$response->id_str."] (twitter)";
		} else {
			return "Sory, we cannot post with this account";
		}
	}
	function twPostPhoto($token,$secret,$user_id,$message,$path){
		$message = ContentPostParser($user_id,$message);

		$connection = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET, $token, $secret);
		$connection->setTimeouts(15, 30);
		$content = $connection->get("account/verify_credentials");
		$media = $connection->upload('media/upload', ['media' => $path]);
		$parameters = [
			'status' => substr($message,0,250),
			'media_ids' => implode(',', [$media->media_id_string])
		];
		$response = $connection->post('statuses/update', $parameters);
		if ($connection->getLastHttpCode() == 200) {
			return "Your post success with id [".$response->id_str."] (twitter)";
		} else {
			return "Sory, we cannot post this content";
		}
	}
	function twPostVideo($token,$secret,$user_id,$message,$path){
		$message = ContentPostParser($user_id,$message);
		try{
			$connection = new TwitterOAuth(TWITTER_KEY, TWITTER_SECRET, $token, $secret);
			$connection->setTimeouts(15, 300);
			$content = $connection->get("account/verify_credentials");
			$media = $connection->upload('media/upload', ['media' => $path]);
			if ($connection->getLastHttpCode() != 200) {
				return "Sory, we cannot post yet";
			}
			$parameters = [
				'status' => substr($message,0,250),
				'media_ids' => implode(',', [$media->media_id_string])
			];
			$response = $connection->post('statuses/update', $parameters);
			if ($connection->getLastHttpCode() == 200) {
				return "Your post success with id [".$response->id_str."] (twitter)";
			} else {
				return "Sory, we cannot post this content";
			}
		}catch(Exception $e){
			return "Sory, we cannot post yet. Fail to upload media";
		}
	}
	
?>