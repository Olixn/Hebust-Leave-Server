<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: Ne-21
// +----------------------------------------------------------------------
// | Desc: 登录换取openID
// +----------------------------------------------------------------------

namespace app\controller;

use think\Request;
use think\response\Json;
use app\common\Request as myRequest;

class Login
{
    /**
     * code凭证换取openid
     *
     * @param string $code
     * @return Json
     */
    public function getOpenId(string $code)
    {
        $result = $this->code2Session($code);
        return json($result);
    }

    /**
     * 获取用户登录态信息
     *
     * appid=wx7fe5bb8793f20074
     * secret=d337e1376fcaea3cb605b6e46705a044
     * @param string $code
     * @return string
     */
    protected function code2Session(string $code)
    {
        $url = 'https://api.weixin.qq.com/sns/jscode2session?appid=wx4930c1c6c1079c85&secret=7700ec1f8f544bb01150ee54d23d0a82&js_code=' . $code .'&grant_type=authorization_code';
        $result = myRequest::https_request($url,[]);
        return json_decode($result);
    }
}
