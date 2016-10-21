<?php

include('./Api.php');
$api = new Api();

$method = strtoupper($_SERVER['REQUEST_METHOD']);
if($method == 'POST') {
    $params = json_decode(file_get_contents('php://input'), true);
}elseif ($method == 'GET') {
    $params = $_GET;
}

//1. 校验参数（必传参数，参数格式...）
if(!isset($params['type']) || !isset($params['signature'])) {
    echo $api->generateErrorResponse('缺少参数');
    exit();
}

//2. 校验签名
if(!$api->validate($params, $method)) {
    echo $api->generateErrorResponse('签名无效');
    exit();
}

//3. 处理具体业务逻辑，返回结果
switch ($params['type']) {
    case 'OPEN':
        echo $api->open();
        break;
    case 'CLOSE':
        echo $api->close();
        break;
    case 'DELETE':
        echo $api->delete();
        break;
    case 'RENEW':
        echo $api->renew();
        break;
    case 'CHANGE':
        echo $api->change();
        break;
    case 'DEPT_CREATE':
        echo $api->deptCreate();
        break;
    case 'DEPT_REMOVE':
        echo $api->deptRemove();
        break;
    case 'USER_ASSIGN':
        echo $api->userAssign();
        break;
    case 'USER_UNASSIGN':
        echo $api->userUnassign();
        break;

    default:
        echo $api->generateErrorResponse('未知操作');
        break;
}
