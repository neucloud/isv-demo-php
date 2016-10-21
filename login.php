<?php 
$client_id = 'CLIENT_ID';
$client_secret = 'CLIENT_SECRET';
$request_uri = 'http://' . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
$current_uri = explode('?', $request_uri)[0];
$redirect_uri = str_replace('login.php', 'sso.php', $current_uri);
session_start();

if(isset($_GET['source'])) {
	$source = $_GET['source'];
	$_SESSION['source'] = $source;
	$_SESSION['redirect_uri'] = $redirect_uri;
	$uri = $source . '/oauth/authorize?response_type=code&client_id=' . $client_id . '&redirect_uri=' . $redirect_uri;
	header("Location:$uri");
}else {
	echo "source错误";
}
