<?php
	require_once "Facebook/autoload.php";
	$FB = new \Facebook\Facebook([
		'app_id' => '388986148472046',
		'app_secret' => '8657122d262f2e69e88e66414cbced18',
		'default_graph_version' => 'v2.10'
	]);
	$helper = $FB->getRedirectLoginHelper();
?>