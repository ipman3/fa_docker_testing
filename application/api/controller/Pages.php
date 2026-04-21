<?php

namespace app\api\controller;
use app\common\controller\Api;
use think\Db;
use think\Config;
use think\Exception;

/**
*Created by KH, Lihong
*/
class Pages extends Api
{
    protected $noNeedLogin = ['*'];
    protected $noNeedRight = ['*'];

    /**
    * Index function
    */
    public function index(){
        try {
            $parent_id = $this->request->post('id');
            $parent_data = Db::name('pages')->where('status', 1)->where('id', $parent_id)->find();
            $child_data = Db::name('pages')->where('status', 1)->where('parent_id',$parent_id)->select();
            $parent_data['child'] = $child_data;
            $this->success(__('success'),  $parent_data);
        } catch (Exception $e) {
            $this->error(__('error'), $e->getMessage());
        }
    }

    public function pages(){
        try {
            $parent_id = $this->request->post('id');
            $parent_data = Db::name('pages')->where('status', 1)->where('id', $parent_id)->find();
            $child_data = Db::name('pages')->where('status', 1)->where('parent_id',$parent_id)->select();
            foreach ($child_data as $key => $value) {
                # code...
                $ch[][$value['title']] = $value['content'];
            }
            $parent_data['child_data'] = $ch;
            $this->success(__('success'),  $parent_data);
        } catch (Exception $e) {
            $this->error(__('error'), $e->getMessage());
        }
    }
}