<?php 
/**
 * users gets redirected here from twitter (if user allowed you app)
 * you can specify this url in https://dev.twitter.com/ and in the previous script
 */ 
include_once '../config/config_main.php';
require "../library/twitter_sdk/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;
//TWITTER APP KEYS
$consumer_key = TWITTER_KEY;
$consumer_secret = TWITTER_SECRET;

//GETTING ALL THE TOKEN NEEDED
$oauth_verifier = $_GET['oauth_verifier'];
$token_secret = $_COOKIE['token_secret'];
$oauth_token = $_COOKIE['oauth_token'];

//EXCHANGING THE TOKENS FOR OAUTH TOKEN AND TOKEN SECRET
$connection = new TwitterOAuth($consumer_key, $consumer_secret, $oauth_token, $token_secret);
$access_token = $connection->oauth("oauth/access_token", array("oauth_verifier" => $oauth_verifier));

$accessToken=$access_token['oauth_token'];
$secretToken=$access_token['oauth_token_secret'];
$screenName=$access_token['screen_name'];
$userId=$access_token['user_id'];
// var_dump($access_token);
//DISPLAY THE TOKENS
	$sql = "update getrich_users_twitter set twitter_token='".$accessToken."',twitter_secret='".$secretToken."',twitter_uid='".$userId."',twitter_name='".$screenName."',twitter_status=1 WHERE twitter_user=".$_GET['user_id']." and twitter_type=".$_GET['type'];
	$mysqli->query($sql);
	header('Location: ./?p=twitter');

?>
