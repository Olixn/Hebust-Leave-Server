<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: Ne-21
// +----------------------------------------------------------------------
// | Desc: 后台管理登录
// +----------------------------------------------------------------------

namespace app\controller;

use app\common\Common as TokenServer;
use think\Request;
use think\response\Json;
use app\model\Admin as AdminModel;

class AdminLogin
{
    /**
     * 后台登录验证
     *
     * @param Request $request
     * @return Json
     */
    public function login(Request $request)
    {
        $data = $request->param();
        $username = $data['username'];
        $password = sha1($data['password']);
        $request = AdminModel::where('username',$username)->where("password",$password)->find();
        if ($request) {
            $token = (new TokenServer())->createJwt($username);
            return json(['status'=>200,'token'=>$token]);
        }
        return json(['status'=>0,'msg'=>'账号密码错误']);
    }
}