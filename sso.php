<?php 
session_start();

include('./Api.php');
$api = new Api();
$client_id = $api->client_id;
$redirect_uri = $api->getUrl('callback.php');

if(isset($_GET['source'])) {
	$source = $_GET['source'];
	$_SESSION['source'] = $source;
	$_SESSION['redirect_uri'] = $redirect_uri;
	$uri = $source . '/oauth/authorize?response_type=code&client_id=' . $client_id . '&redirect_uri=' . $redirect_uri;
	header("Location: $uri");
}else {
	echo "source错误";
}
