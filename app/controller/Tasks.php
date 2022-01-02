<?php
declare (strict_types = 1);

namespace app\controller;

use think\Request;
use app\model\Tasks as TasksModel;
use app\model\User as UserModel;
use think\response\Json;

class Tasks
{
    /**
     * 保存请假信息
     *
     * @param  \think\Request  $request
     * @return Json
     */
    public function save(Request $request)
    {
        $data = $request->param();
        $data['taskid'] = $this->generateTaskID();

        $region = $data['region'];
        $regionText = "";
        foreach ($region as $key => $value) {
            $regionText = $regionText.$value;
        }
        $data['regionText'] = $regionText;

        $date =  date('Y-m-d H:m:s',time());
        $data['create_time'] = $date;

        $db = new TasksModel();
        $result = $db->json(['region','healthy'])->save($data);
        return json(['msg'=>'申请提交成功']);
    }
    
    
    /**
     * 删除请假信息
     *
     * @param  \think\Request  $request
     * @return Json
     */
    public function deleteTask(Request $request)
    {
        $taskid = $request->param('taskid');
        
        $db = new TasksModel();
        $result = $db->where('taskid',$taskid)->delete();
        return json(['msg'=>'delete success']);
    }
    

    protected function generateTaskID(){
        $date =  date('Ymd',time());
        $rand = rand(176384,567393);
        return $date.'04'.$rand;
    }

}
