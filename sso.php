<?php 

$client_id = 'CLIENT_ID';
$client_secret = 'CLIENT_SECRET';
$request_uri = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$redirect_uri = explode('?', $request_uri)[0];
session_start();

if(isset($_GET['source'])) {
	$source = $_GET['source'];
	$_SESSION['source'] = $source;
	$uri = $source . '/oauth/authorize?response_type=code&client_id=' . $client_id . '&redirect_uri=' . $redirect_uri;
	header("Location:$uri");
}

if(isset($_GET['code'])) {
	$code = $_GET['code'];
	require('./httpful.phar');
	$source = $_SESSION['source'];
	$uri = $source . '/oauth/access_token';
	$params = json_encode(array(
		'grant_type'=>'authorization_code',
		'client_id'=>$client_id,
		'client_secret'=>$client_secret,
		'redirect_uri'=>$redirect_uri,
		'code'=>$code
		));
	$result = \Httpful\Request::post($uri)->sendsJson()->body($params)->send();
	$result = (array)json_decode($result);

	if(!isset($result['access_token'])) {
		echo "错误";
		exit();
	}
	$access_token = $result['access_token'];
	$uri_user_show = $source . '/api/user/show';
	$params_user_show = json_encode(array(
		'client_id'=>$client_id,
		'access_token'=>$access_token
		));
	$userInfo = \Httpful\Request::post($uri_user_show)->sendsJson()->body($params_user_show)->send();
	echo '<h1>' . $userInfo->body->account . ',你好 !</h1>';;

}