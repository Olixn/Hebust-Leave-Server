<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: Ne-21
// +----------------------------------------------------------------------
// | Desc: 获取用户信息及审核进度
// +----------------------------------------------------------------------

namespace app\controller;

use think\Request;
use app\model\User as UserModel;
use app\model\Tasks as TasksModel;
use think\response\Json;

class User
{
    /**
     * 获取用户审核进度
     *
     * @param string $openid
     * @return Json
     */
    public function getRegStatus(string $openid)
    {
        $result = UserModel::where("openid",$openid)->find();
        // var_dump($openid,$result);
        if ($result) {
            if ($result["isOk"] == 1){
                return json(['code'=>1,'isReg'=>true,'isOk'=>true]);
            }
            return json(['code'=>1,'isReg'=>true,'isOk'=>false]);
        }
        return json(['code'=>1,'isReg'=>false,'isOk'=>false]);
    }


    /**
     * 获取用户信息
     *
     * @param string $openid
     * @return Json
     */
    public function getUserInfo(string $openid)
    {
        $result = UserModel::where("openid",$openid)->field(["stuName","stuNum","picUrl","stuUni","stuPro","stuClass"])->find();
        if ($result) {
            $hasTask = TasksModel::where('openid',$openid)->field(["status"])->order('create_time','DESC')->find();
            if ($hasTask) {
                $result['status'] = $hasTask['status'];
            } else {
                $result['status'] = 1;
            }
            return json($result);
        }
        return json(['code'=>1,'isReg'=>false, 'status'=>1]);
    }

    /**
     * 获取用户请假信息
     *
     * @param string $openid
     * @return Json
     */
    public function getTasksList(string $openid)
    {
        $result = TasksModel::where('openid',$openid)->field(['taskid','stuName','reason','type','startTime','endTime','create_time','status'])->order('create_time','DESC')->select();
        if ($result) {
            // 控制显示时间的位数
            foreach ($result as $key=>$value ) {
                $value['startTime'] = substr($value['startTime'],0,-3);
                $value['endTime'] = substr($value['endTime'],0,-3);
            }
            return json(['isHas'=>1,'tasks'=>$result]);
        }
        return json(['isHas'=>0,'tasks'=>[]]);
    }

    /**
     * 获取用户信息以及请假信息
     *
     * @param string $openid
     * @param string $taskid
     * @return Json
     */
    public function getTasksInfo(string $openid,string $taskId)
    {
        $userInfo = UserModel::where('openid',$openid)->field(['stuName','stuNum','stuClass','stuUni','stuPro','picUrl'])->find();
        if ($userInfo) {
            $taskInfo = TasksModel::where('taskid',$taskId)->json(['region','healthy'])->find();
            // 控制显示时间的位数
            $taskInfo['startTime'] = substr($taskInfo['startTime'],0,-3);
            $taskInfo['endTime'] = substr($taskInfo['endTime'],0,-3); 

            return json(['msg'=>'success','userInfo'=>$userInfo,'taskInfo'=>$taskInfo]);
        }
    }


}
