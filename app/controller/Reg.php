<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: Ne-21
// +----------------------------------------------------------------------
// | Desc: 注册方法
// +----------------------------------------------------------------------

namespace app\controller;

use think\Request;
use think\response\Json;
use app\model\User as UserModel;

class Reg
{
    /**
     * 获取审核结果
     *
     * @param string $openid
     * @return Json
     */
    public function getRegStatus(string $openid)
    {
        $result = UserModel::where('openid',$openid)->find();
        if ($result) {
            return json(['code'=>1,'info'=>$result]);
        } else {
            return json(['code'=>0,'msg'=>'']);
        }
    }

    /**
     * 保存注册信息
     *
     * @param  \think\Request  $request
     * @return \think\Response
     */
    public function save(Request $request)
    {
        $arr = $request->param();
        $openid = $arr['openid'];
        
        foreach ($arr as $key=>$value) {
            if ($value == "") {
                return json(['code'=>0, 'msg'=>'填入信息不全']);
            }
        }
        
        $udb = new UserModel();
        $person = $udb->where('openid',$openid)->field("openid")->find();
        if ($person) {
            // 用户存在，执行更新操作
            unset($arr["openid"]);
            $arr['isOk'] = 0;
            $udb->where('openid',$openid)->update($arr);
            $msg = 'update';
        } else {
            $udb->save($arr);
            $msg = 'create';
        }
        return json(['code'=>1, 'msg'=>$msg]);
    }

}
