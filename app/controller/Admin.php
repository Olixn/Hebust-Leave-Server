<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: Ne-21
// +----------------------------------------------------------------------
// | Desc: 后台管理接口
// +----------------------------------------------------------------------

namespace app\controller;

use think\Request;
use app\model\User as UserModel;
use app\model\Tasks as TasksModel;
use think\response\Json;

class Admin 
{
    /**
     * 获取侧边栏菜单
     *
     * @return Json
     */
     public function getMenus()
     {
        $menuList = [
            ['id'=>0, 'name'=>'用户管理', 'path'=>'/users'],
            ['id'=>1, 'name'=>'申请审核', 'path'=>'/tasks']
        ];
        return json(['status'=>200,'data'=>$menuList]);
     }
     
     
    //  ----------------------------------------------------------------------  // 
    // ----------------------------------  Users ----------------------------   //
    //  ----------------------------------------------------------------------  //
     /**
     * 获取用户列表
     *
     * @param Request $request
     * @return Json
     */
     public function getUsersList(Request $request)
     {
        $stuName = $request->param('stuName');
        $currentPage = $request->param('currentPage') -1;
        $pageSize = $request->param('pageSize');
        if ($stuName) {
            $request = UserModel::where('stuName',$stuName)->order('id',"Desc")->limit($currentPage*$pageSize,$pageSize)->select();
            $total = $request->count();
            return json(['status'=>200, 'data'=>$request, 'total'=>$total]);
        }
        $request = UserModel::order('id',"Desc")->limit($currentPage*$pageSize,$pageSize)->select();
        $total = $request->count();
        return json(['status'=>200, 'data'=>$request, 'total'=>$total]);
     }
     
     /**
     * 获取单个用户信息
     *
     * @param Request $request
     * @return Json
     */
    public function getUserInfo(Request $request)
    {
        $id = $request->param('id');
        if ($id) {
            $request = UserModel::where('id',$id)->field(["id","stuName","stuNum","stuUni","stuPro","stuClass"])->find();
            return json(['status'=>200, 'data'=>$request]);
        }
        return json(['status'=>0, 'data'=>[]]);
    }
    
    /**
     * 更新单个用户信息
     *
     * @param Request $request
     * @return Json
     */
    public function updateUserInfo(Request $request)
    {
        $data = $request->post();
        $id = $data['id'];
        if ($id) {
            $UserDB = new UserModel();
            $result = $UserDB->update($data);
            return json(['status'=>201, 'data'=>$result]);
        }
        return json(['status'=>0, 'data'=>[]]);
        
    }
    
    /**
     * 删除单个用户
     *
     * @param string $id
     * @return Json
     */
    public function deleteUser(string $id)
    {
        if ($id) {
            $UserDB = new UserModel();
            $User = $UserDB->where('id',$id)->field(['picUrl'])->find();
            $msg = $this->delPic($User['picUrl']);
            $result = $User->delete();
            return json(['status'=>200, 'data'=>$result, 'msg'=>$msg]);
        }
        return json(['status'=>0, 'data'=>[]]);
    }
    
    /**
     * 更新用户通过状态
     *
     * @param Request $request
     * @param string $id
     * @return Json
     */
    public function updateIsOk(Request $request, string $id)
    {
        $data = $request->param();
        if ($data['id']) {
            $UserDB = new UserModel();
            $result = $UserDB->where('id',$data['id'])->update(['isOk'=>$data['isOk']]);
            return json(['status'=>200, 'data'=>$result]);
        }
        return json(['status'=>0, 'data'=>[]]);
    }
    
    
    //  ----------------------------------------------------------------------  // 
    // ----------------------------------  Tasks  ----------------------------  //
    //  ----------------------------------------------------------------------  //
    /**
     * 获取申请列表
     *
     * @param Request $request
     * @return Json
     */
    public function getTasksList(Request $request)
    {
        $taskid = $request->param('taskid');
        $currentPage = $request->param('currentPage') -1;
        $pageSize = $request->param('pageSize');
        if ($taskid) {
            $request = TasksModel::where('taskid',$taskid)->order('id',"Desc")->limit($currentPage*$pageSize,$pageSize)->select();
            $total = $request->count();
            return json(['status'=>200, 'data'=>$request, 'total'=>$total]);
        }
        $request = TasksModel::order('id',"Desc")->limit($currentPage*$pageSize,$pageSize)->select();
        $total = $request->count();
        return json(['status'=>200, 'data'=>$request, 'total'=>$total]);
    }
    
    /**
     * 获取一个申请信息
     *
     * @param Request $request
     * @return Json
     */
    public function getTaskInfo(Request $request)
    {
        $id = $request->param('id');
        if ($id) {
            $request = TasksModel::where('id',$id)->find();
            return json(['status'=>200, 'data'=>$request]);
        }
        return json(['status'=>0, 'data'=>[]]);
    }
    
     /**
     * 更新单个申请信息
     *
     * @param Request $request
     * @return Json
     */
     public function updateTaskInfo(Request $request)
    {
        $data = $request->post();
        $id = $data['id'];
        if ($id) {
            $TaskDB = new TasksModel();
            $result = $TaskDB->update($data);
            return json(['status'=>201, 'data'=>$result]);
        }
        return json(['status'=>0, 'data'=>[]]);
    }
    
    /**
     * 删除单个用户
     *
     * @param string $id
     * @return Json
     */
    public function deleteTask(string $id)
    {
        if ($id) {
            $TaskDB = new TasksModel();
            $result = $TaskDB->where('id',$id)->delete();
            return json(['status'=>200, 'data'=>$result]);
        }
        return json(['status'=>0, 'data'=>[]]);
    }
    
    //  ----------------------------------------------------------------------  // 
    // ------------------------------  protected  ----------------------------  //
    //  ----------------------------------------------------------------------  //
    /**
     * 删除图片及文件夹
     * 
     * @param string $picPath
     */
    protected function delPic($picPath){
        $path = __FILE__;
        $paths = substr($path,0,strpos($path,'app'));
        $picParent = $paths."public" . substr(substr($picPath,0,strrpos($picPath,"/")),0);
        $pic1 = $paths."public" . $picPath;
        if(file_exists($pic1)){
            @unlink($pic1);
            rmdir($picParent);
            return json(['code'=>1,'msg'=>'success']);
        }
        return json(['code'=>0,'msg'=>'false']);
    }
    
    
}