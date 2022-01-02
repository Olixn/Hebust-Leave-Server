<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: Ne-21
// +----------------------------------------------------------------------
// | Desc: JWT
// +----------------------------------------------------------------------

namespace app\common;

use Firebase\JWT\JWT as JWTUtil;
class Common
{

    //生成token
    public function createJwt($userId = 'zq')
    {
        $key = md5('Ne-21!@!'); //jwt的签发密钥，验证token的时候需要用到
        $time = time(); //签发时间
        $expire = $time + 7200; //过期时间
        $token = array(
            "user_id" => $userId,
            "iss" => "https://wx.gocos.cn/",//签发组织
            "aud" => "Ne-21", //签发作者
            "iat" => $time,
            "nbf" => $time,
            "exp" => $expire
        );
        $jwt = JWTUtil::encode($token, $key);
        return $jwt;
    }


    //校验jwt权限API
    public function verifyJwt($jwt = '')
    {
        $key = md5('Ne-21!@!');
        try {
            $jwtAuth = json_encode(JWTUtil::decode($jwt, $key, array('HS256')));
            $authInfo = json_decode($jwtAuth, true);
    
            $msg = [];
            if (!empty($authInfo['user_id'])) {
                $msg = [
                    'status' => 1001,
                    'msg' => 'Token验证通过'
                ];
            } else {
                $msg = [
                    'status' => 1002,
                    'msg' => 'Token验证不通过,用户不存在'
                ];
            }
            return $msg;
        }  catch (\Firebase\JWT\ExpiredException $e) {
            return [
                'status' => 1003,
                'msg' => 'Token过期'
            ];
            exit;
        } catch (\Exception $e) {
            return [
                'status' => 1002,
                'msg' => 'Token无效'
            ];
        }
}
}