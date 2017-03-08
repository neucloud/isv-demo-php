<?php
session_start();

include('./dependences/httpful.phar');
include('./Api.php');
$api = new Api();
$client_id = $api->client_id;
$client_secret = $api->client_secret;

if(isset($_GET['code'])) {
	$code = $_GET['code'];
	$source = $_SESSION['source'];
	$redirect_uri = $_SESSION['redirect_uri'];
	$uri = $source . '/oauth/access_token';
	$params = json_encode(array(
		'grant_type'=>'authorization_code',
		'client_id'=>$client_id,
		'client_secret'=>$client_secret,
		'redirect_uri'=>$redirect_uri,
		'code'=>$code
		));
	$result = \Httpful\Request::post($uri)->sendsJson()->body($params)->send();
	$result = json_decode($result, true);

	if(!isset($result['access_token'])) {
		echo "token错误";
		exit();
	}
	$access_token = $result['access_token'];
	$uri_user_show = $source . '/api/user/show';
	$params_user_show = json_encode(array(
		'client_id'=>$client_id,
		'access_token'=>$access_token
		));
	$userInfo = \Httpful\Request::post($uri_user_show)->sendsJson()->body($params_user_show)->send();
	echo '<h1>' . $userInfo->body->account . ',你好!</h1>';;
}else {
	echo "code错误";
}