<?php
    include '../config/config_main.php';
    require_once '../library/facebook-sdk-v5/autoload.php';
    $fb = new Facebook\Facebook([
		'app_id' => FACEBOOK_ID,
		'app_secret' => FACEBOOK_SECRET,
		'default_graph_version' => 'v2.11',
	]);
    $helper = $fb->getRedirectLoginHelper();
    $permissions = ['user_friends','public_profile','email',' publish_actions','user_posts','publish_pages','user_managed_groups','manage_pages']; // Optional permissions
    $loginUrl = $helper->getLoginUrl(BASE_URL().'/member/fb-callback-2.php', $permissions);
    header('Location: ' . $loginUrl);
?>