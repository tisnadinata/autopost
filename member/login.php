<?php
	define('FACEBOOK_SDK_V4_SRC_DIR', '../library/facebook-sdk-v5/');
	require_once '../library/facebook-sdk-v5/autoload.php';
	$fb = new Facebook\Facebook([
		'app_id' => FACEBOOK_ID,
		'app_secret' => FACEBOOK_SECRET,
		'default_graph_version' => 'v2.11',
		]);

	$helper = $fb->getRedirectLoginHelper();

	$permissions = ['user_friends','public_profile','email',' publish_actions','user_posts','publish_pages','user_managed_groups','manage_pages']; // Optional permissions
	$_SESSION['loginUrl'] = $helper->getLoginUrl('https://fb.appstudio.id/fb-callback.php', $permissions);

	echo '<a href="'.$_SESSION['loginUrl'].'" id="login" ><img id="login_img" src="loginfacebook.png" width="100%" class="btn-fb img-responsive"></a>';
		
?>