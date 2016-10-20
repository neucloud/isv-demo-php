<?php
class Api
{
    const CLIENT_ID = 'CLIENT_ID';
    const CLIENT_SECRET = 'CLIENT_SECRET';

    /**
    *开通示例
    **/
    public function open()
    {
        //处理具体业务逻辑
        //请不要阻塞此接口，若耗时较长，可使用队列做缓冲，设置status="executing"，然后立即返回。
        //..

        //返回结果
        $result = array();
        $result['app_id'] = 'abcde12';
        $result['status'] = 'opened';
        $result['outputs'] = ['url' => 'http://isv.com/sso.php'];
        return $this->generateCorrectResponse($result);
    }

    /**
    *关闭示例
    **/
    public function close()
    {
        //处理具体业务逻辑
        //..

        //返回结果
        $result = array();
        $result['status'] = 'closed';
        return $this->generateCorrectResponse($result);
    }

    /**
    *删除示例
    **/
    public function delete()
    {
        //处理具体业务逻辑
        //..

        //返回结果
        $result = array();
        $result['status'] = 'deleted';
        return $this->generateCorrectResponse($result);
    }

    /**
    *续费示例
    **/
    public function renew()
    {
        //处理具体业务逻辑
        //..

        //返回结果
        $result = array();
        $result['status'] = 'opened';
        return $this->generateCorrectResponse($result);
    }

    /**
    *升级示例
    **/
    public function change()
    {
        //处理具体业务逻辑
        //..

        //返回结果
        $result = array();
        $result['status'] = 'opened';
        return $this->generateCorrectResponse($result);
    }

    /**
    *校验签名
    **/
    public function validate($params, $method)
    {
        $signature = $params['signature'];
        unset($params['signature']);
        ksort($params);
        $uri = explode('?', $_SERVER['REQUEST_URI'])[0];
        $raw_param = "$method\n$uri\n".http_build_query($params);
        $sig = hash_hmac('sha256', $raw_param, self::CLIENT_SECRET, true);
        $sigb64 = base64_encode($sig);
        return $signature === urlencode($sigb64);
    }

    /**
    *返回错误结果
    **/
    public function generateErrorResponse($msg)
    {
        return json_encode(['ret' => 1, 'msg' => $msg]);
    }

    /**
    *返回正确结果
    **/
    public function generateCorrectResponse($result)
    {
        $result['ret'] = 0;
        return json_encode($result);
    }
}
