<?php
	session_start();
	// $mysqli = new mysqli("localhost","root","","db_getrich");
	$mysqli = new mysqli("mysql.hostinger.co.id","u823173079_fb","mQ0wZfXEuKSacOK2C2","u823173079_fb");
		
	const FACEBOOK_ID = "1778087199163923";
	const FACEBOOK_SECRET = "ed3c54cb93d82178f00d72f917311fe7";
	const TWITTER_KEY = "5c0xQZe7xgHDG4hgDwDJY1DVn";
	const TWITTER_SECRET = "5qp1VTQCALZaD6MpHMiH4QRnmd1D2WZasu6fMsUC1AtIRTsOyp";

	if (mysqli_connect_errno()){
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	
	function getDataByCollumn($table_name,$field_name,$value){
		global $mysqli;
		$stmt = $mysqli->query("select * from $table_name where $field_name='$value'");
		return $stmt;		
	}
	function getDataCount($table_name,$field_name,$value){
		global $mysqli;
		$stmt = $mysqli->query("select * from $table_name where $field_name='$value'");
		if($stmt){
			return $stmt->num_rows;
		}else{
			return 0;
		}
	}
	function getDataByCondition($table_name,$condition,$order_by){		
		global $mysqli;
		$stmt = $mysqli->query("select * from $table_name where $condition order by $order_by");
		return $stmt;
	}
	function getDataTable($table_name,$order_by){		
		global $mysqli;
		$stmt = $mysqli->query("select * from $table_name order by $order_by");
		return $stmt;
	}	
	function getPengaturan($nama_pengaturan){
		global $mysqli;
		$stmt = getDataByCollumn("getrich_settings","nama_pengaturan",$nama_pengaturan);
		if($stmt->num_rows > 0){
			return $stmt->fetch_object();
		}else{
			return 0;
		}
	}
	function BASE_URL(){
		return getPengaturan("url_web")->value_pengaturan;
	}

	function enkripPassword($value){
		// return sha1(md5($value));	
		return md5($value);	
	}
	function login($username,$password){
		$password = enkripPassword($password);
		$login = getDataByCondition("getrich_users","user_username = '".$username."' AND user_password = '".$password."'","user_id");
		return $login;
	}

	// require_once 'facebook-sdk-v5/autoload.php';
	// define('FACEBOOK_SDK_V4_SRC_DIR', 'facebook-sdk-v5/');
	// require_once "twitter_sdk/autoload.php";
	// use Abraham\TwitterOAuth\TwitterOAuth;
	// $fb = new Facebook\Facebook([
	// 	'app_id' => FACEBOOK_ID,
	// 	'app_secret' => FACEBOOK_SECRET,
	// 	'default_graph_version' => 'v2.11',
	// ]);
	
?>