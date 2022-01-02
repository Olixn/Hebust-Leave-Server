<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: Ne-21
// +----------------------------------------------------------------------
// | Desc: 上传、删除图片处理操作
// +----------------------------------------------------------------------

namespace app\controller;

use think\facade\Filesystem;

class Upload
{
    /**
     * 上传图片
     */
    public function upload(){

        $file = request() -> file('file');

        if ($file == null) {
            return json(['code'=>0,'msg'=>"图片不能为空"]);
        }

        $temp = explode(".", $_FILES["file"]["name"]);
        $extension = end($temp);

        if(!in_array($extension, array("jpeg","jpg","png"))){
            return json(['code'=>0,'msg'=>"图片格式不正确"]);
        }
        $saveName = Filesystem::disk('photo') -> putFile('userPics', $file, 'md5');


        $picPath = str_replace('\\', '/', '/static/uploads/' . $saveName);
        return json(['code'=>1,"picPath"=>$picPath,"fileList"=>[$picPath]]);
    }

    /**
     * 删除图片
     */
    public function del(){
        if (request()->isDelete()) {
            $picPath = request()->post('picPath');
            $result = $this->delPic($picPath);
            return $result;
        }
    }

    /**
     * 删除图片及文件夹
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
