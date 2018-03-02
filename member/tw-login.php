<?php

//LOADING LIBRARY
require_once("../config/config_main.php");
require "../library/twitter_sdk/autoload.php";
use Abraham\TwitterOAuth\TwitterOAuth;

//TWITTER APP KEYS
$consumer_key = $_GET['consumer_key'];
$consumer_secret = $_GET['consumer_secret'];

//CONNECTION TO THE TWITTER APP TO ASK FOR A REQUEST TOKEN
$connection = new TwitterOAuth($consumer_key, $consumer_secret);
$request_token = $connection->oauth("oauth/request_token", array("oauth_callback" => BASE_URL()."/member/tw-callback.php?user_id=".$_GET['user']."&type=".$_GET['type']));
//callback is set to where the rest of the script is

//TAKING THE OAUTH TOKEN AND THE TOKEN SECRET AND PUTTING THEM IN COOKIES (NEEDED IN THE NEXT SCRIPT)
$oauth_token=$request_token['oauth_token'];
$token_secret=$request_token['oauth_token_secret'];
setcookie("token_secret", " ", time()-3600);
setcookie("token_secret", $token_secret, time()+60*10);
setcookie("oauth_token", " ", time()-3600);
setcookie("oauth_token", $oauth_token, time()+60*10);

//GETTING THE URL FOR ASKING TWITTER TO AUTHORIZE THE APP WITH THE OAUTH TOKEN
$url = $connection->url("oauth/authorize", array("oauth_token" => $oauth_token));

//REDIRECTING TO THE URL
header('Location: ' . $url);

?>
